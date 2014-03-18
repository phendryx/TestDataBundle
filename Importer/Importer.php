<?php

namespace Malwarebytes\TestDataBundle\Importer;

use Doctrine\ORM\EntityManager;

use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Reader\CsvReader;
use Malwarebytes\TestDataBundle\DataImport\Writer\DoctrineWriter;
use Ddeboer\DataImport\ValueConverter\DateTimeValueConverter;
use Malwarebytes\TestBundle\Event\ImportDataEvent;
use Malwarebytes\TestDataBundle\Data\Factory\DataFactory;
use Malwarebytes\TestDataBundle\Data\Data as TestData;
use Ddeboer\DataImport\ValueConverter\CallbackValueConverter;
use Ddeboer\DataImport\ValueConverter\ArrayValueConverterMap;
use Ddeboer\DataImport\ItemConverter\CallbackItemConverter;
use ReflectionClass;
use Ddeboer\DataImport\Filter\CallbackFilter;
use Malwarebytes\TestDataBundle\Data\Mapping;

class Importer
{
    public function onImportEvent(ImportDataEvent $event)
    {
        $config = $event->getContainer()->getParameter('malwarebytes_test_data.config');
        $rootDirectory = $event->getContainer()->get('kernel')->getRootDir();
        $testDataDirectory = $rootDirectory . $config['test_data_directory'];
        $eventManager = $event->getContainer()->get('doctrine')->getManager();

        $factory = new DataFactory();
        foreach($config['objects'] as $name => $objectConfig) {

            $testData = $factory->getNewData($objectConfig);
            $this->import($testDataDirectory, $eventManager, $name, $testData);
        }
    }

    private function import($testDataDirectory, EntityManager $entityManager, $name, TestData $testData)
    {
        $filePath = $testDataDirectory . DIRECTORY_SEPARATOR . $testData->getFile();

        // Create and configure the reader
        $file = new \SplFileObject($filePath);
//        $file->setCsvControl(",");
        $csvReader = new CsvReader($file);

        // Tell the reader that the first row in the CSV file contains column headers
        $csvReader->setHeaderRowNumber(0);

        // Create the workflow from the reader
        $workflow = new Workflow($csvReader);

        // Create a writer: you need Doctrine’s EntityManager.
        $doctrineWriter = new DoctrineWriter($entityManager, $testData->getEntity());
        $workflow->addWriter($doctrineWriter);

        // Add a converter to the workflow that will convert `beginDate` and `endDate`
        // to \DateTime objects
        if (count($testData->getFieldTypes()) > 0) {
            $dateTimeConverter = new DateTimeValueConverter('Y-m-d');

            foreach ($testData->getFieldTypes() as $fieldType) {
                if ($fieldType->getType() == "datetime") {
                    $workflow->addValueConverter('date', $dateTimeConverter);
                }
            }
        }

        // Create the item converter function that will associate an entity with this row of data
        $converter = new CallbackItemConverter(function ($item) use ($entityManager, $testData) {
            if (count($testData->getMappings()) > 0) {
                foreach ($testData->getMappings() as $mapping) {
                    // Get the repository for the entity
                    $repository = $entityManager->getRepository($mapping->getEntity());

                    // Get the entity from doctrine
                    $entity = $repository->find($item[$mapping->getDataField()]);

                    // Set the property to the found entity
                    $item[$mapping->getProperty()] = $entity;
                }
            }

            // Return data item
            return $item;
        });

        // Add the item converter to the workflow
        $workflow->addItemConverter($converter);


        // Process the workflow
        $workflow->process();

        echo $filePath . "\n";
    }
}