<?php

namespace Malwarebytes\TestDataBundle\Data\Factory;

use Malwarebytes\TestDataBundle\Data\Data as TestData;

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

        return $data;
    }
}