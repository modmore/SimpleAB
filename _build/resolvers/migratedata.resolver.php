<?php
/* @var modX $modx */

// For direct invocation (testing)
if (!isset($object)) {
    require_once dirname(dirname(dirname(__FILE__))) . '/config.core.php';
    require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
    $modx = new modX();
    $modx->initialize('mgr');
    $modx->loadClass('transport.xPDOTransport', XPDO_CORE_PATH, true, true);


    $object = new stdClass();
    $object->xpdo = $modx;

    $options = array(
        xPDOTransport::PACKAGE_ACTION => xPDOTransport::ACTION_UPGRADE,
    );
}

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_UPGRADE:
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;

            $modelPath = $modx->getOption('simpleab.core_path',null,$modx->getOption('core_path').'components/simpleab/').'model/';
            $modx->addPackage('simpleab',$modelPath);

            $c = $modx->newQuery('sabPick');
            $c->where(array(
                'amount' => 0,
            ));

            $picks = array();

            foreach ($modx->getIterator('sabPick', $c) as $p) {
                /** @var sabPick $p */
                $date = $p->get('date');
                $variation = $p->get('variation');
                $ref = $date . '_' . $variation;
                if (!isset($picks[$ref]))
                {
                    $picks[$ref] = $modx->newObject('sabPick');
                    $picks[$ref]->fromArray(array(
                        'test' => $p->get('test'),
                        'variation' => $variation,
                        'date' => $date,
                        'amount' => 0
                    ), '', true);
                }

                $picks[$ref]->set('amount', $picks[$ref]->get('amount') + 1);
                $p->remove();
            }

            foreach ($picks as $pick) {
                $pick->save();
            }


            /**
             * Migrate conversions
             */
            $c = $modx->newQuery('sabConversion');
            $c->where(array(
                'amount' => 0,
            ));

            $conversions = array();

            foreach ($modx->getIterator('sabConversion', $c) as $p) {
                /** @var sabConversion $p */
                $date = $p->get('date');
                $variation = $p->get('variation');
                $ref = $date . '_' . $variation;
                if (!isset($conversions[$ref]))
                {
                    $conversions[$ref] = $modx->newObject('sabConversion');
                    $conversions[$ref]->fromArray(array(
                        'test' => $p->get('test'),
                        'variation' => $variation,
                        'date' => $date,
                        'amount' => 0
                    ), '', true);
                }

                $conversions[$ref]->set('amount', $conversions[$ref]->get('amount') + 1);
                $p->remove();
            }

            foreach ($conversions as $conversion) {
                $conversion->save();
            }


        break;
    }

}
return true;

