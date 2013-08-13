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


            $modx->setLogLevel(modX::LOG_LEVEL_FATAL);
            $manager->addField('sabTest', 'archived');
            $manager->addField('sabTest', 'smartoptimize');
            $manager->removeField('sabConversion', 'value');
            $manager->addField('sabConversion', 'amount');
            $manager->addField('sabPick', 'amount');

            $modx->setLogLevel($logLevel);
        break;
    }

}
return true;

