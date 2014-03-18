<?php

namespace Malwarebytes\TestDataBundle\Data;

class Mapping
{
    /** @var string */
    private $entity;
    /** @var string */
    private $dataField;
    /** @var string */
    private $property;

    /**
     * @param string $dataField
     */
    public function setDataField($dataField)
    {
        $this->dataField = $dataField;
    }

    /**
     * @return string
     */
    public function getDataField()
    {
        return $this->dataField;
    }

    /**
     * @param string $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param string $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }



}