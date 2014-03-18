<?php

namespace Malwarebytes\TestDataBundle\Data\Factory;

use Malwarebytes\TestDataBundle\Data\Data as TestData;
use Malwarebytes\TestDataBundle\Data\Mapping;

class DataFactory
{
    private $types = array('csv');

    public function getNewData($config)
    {
        if (!in_array($config['type'], $this->types)) {
            return false;
        }

        $data = new TestData();
        $data->setEntity($config['entity']);
        $data->setType($config['type']);
        $data->setFile($config['file']);

        if (count($config['mapping']) > 0) {
            foreach ($config['mapping'] as $mappingConfig) {
                $mapping = new Mapping();
                $mapping->setEntity($mappingConfig['entity']);
                $mapping->setDataField($mappingConfig['data_field']);
                $mapping->setProperty($mappingConfig['property']);

                $data->addMapping($mapping);
            }
        }

        return $data;
    }
}