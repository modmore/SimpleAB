<?php
/* @var modX $modx */

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_UPGRADE:
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;

            $modelPath = $modx->getOption('simpleab.core_path',null,$modx->getOption('core_path').'components/simpleab/').'model/';
            $modx->addPackage('simpleab',$modelPath);
            $manager = $modx->getManager();
            $logLevel = $modx->setLogLevel(modX::LOG_LEVEL_ERROR);

            $objects = array(
                'sabConversion',
                'sabPick',
                'sabTest',
                'sabVariation',
            );
            foreach ($objects as $obj) {
                $manager->createObjectContainer($obj);
            }

            $manager->addField('sabTest', 'archived');

            $modx->setLogLevel($logLevel);
        break;
    }

}
return true;

