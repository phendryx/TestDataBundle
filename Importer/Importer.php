<?php

namespace Malwarebytes\TestDataBundle\Importer;

use Malwarebytes\TestBundle\Event\ImportDataEvent;

class Importer
{

    public function onImportEvent(ImportDataEvent $event)
    {

        echo "here!";
    }
}