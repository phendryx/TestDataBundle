<?php

namespace Malwarebytes\TestDataBundle\Data;

use Malwarebytes\TestDataBundle\Data\Mapping;

class Data
{
    /** @var string */
    private $entity;
    /** @var string */
    private $type;
    /** @var string */
    private $file;
    /** @var \Array */
    private $mappings;

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
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Mapping[] $mappings
    */
    public function setMappings($mappings)
    {
        $this->mappings = $mappings;
    }

    /**
     * @return Array
     */
    public function getMappings()
    {
        return $this->mappings;
    }

    public function addMapping(Mapping $mapping)
    {
        return $this->mappings[] = $mapping;
    }
}