<?php

namespace Malwarebytes\TestDataBundle\Importer;

use Malwarebytes\TestBundle\Event\ImportDataEvent;

class Importer
{
    public function onImportEvent(ImportDataEvent $event)
    {
        $params = $event->getContainer()->getParameter('malwarebytes_test_data.config');
        \Doctrine\Common\Util\Debug::dump($params);

        echo "here!";
    }
}