<?php

namespace Malwarebytes\TestDataBundle\Importer;

use Doctrine\ORM\EntityManager;

use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Ddeboer\DataImport\ValueConverter\DateTimeValueConverter;
use Malwarebytes\TestBundle\Event\ImportDataEvent;
use Malwarebytes\TestDataBundle\Data\Factory\DataFactory;
use Malwarebytes\TestDataBundle\Data\Data as TestData;

class Importer
{
    public function onImportEvent(ImportDataEvent $event)
    {
        $dataConfig = $event->getContainer()->getParameter('malwarebytes_test_data.config');
        $rootDirectory = $event->getContainer()->get('kernel')->getRootDir();
        $testDataDirectory = $rootDirectory . $dataConfig['test_data_directory'];
        $eventManager = $event->getContainer()->get('doctrine')->getManager();

        $factory = new DataFactory();
        foreach($dataConfig['objects'] as $name => $config) {
            if ($name != 'user') {
                continue;
            }

            $testData = $factory->getNewData($config);
            $this->import($testDataDirectory, $eventManager, $name, $testData);
        }
    }

    private function import($testDataDirectory, EntityManager $entityManager, $name, TestData $testData)
    {
        $filePath = $testDataDirectory . DIRECTORY_SEPARATOR . $testData->getFile();

        // Create and configure the reader
        $file = new \SplFileObject($filePath);
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
//        $dateTimeConverter = new DateTimeValueConverter('Ymd');
//        $workflow
//            ->addValueConverter('beginDate', $dateTimeConverter)
//            ->addValueConverter('endDate', $dateTimeConverter);

        // Process the workflow
        $workflow->process();

        echo $filePath . "\n";
    }
}