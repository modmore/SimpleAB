<?php
require_once dirname(dirname(__FILE__)) . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$modx->getService('simpleab', 'SimpleAB', dirname(dirname(__FILE__)).'/core/components/simpleab/model/simpleab/');

foreach ($modx->getIterator('sabPick') as $pick) {
    /** @var sabPick $pick */
    $date = $pick->get('date');
    $actualDate = date('Ymd', strtotime($date) + (10 * 24 * 60 * 60));

    if ($modx->getCount('sabPick', array('date' => $actualDate)) < 1) {
        $date
    }
}
