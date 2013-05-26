<?php
/**
 * @var modX $modx
 * @var SimpleAB $simpleAB
 * @var array $scriptProperties
 */

/** Load the SimpleAB service class */
$corePath = $modx->getOption('simpleab.core_path',null,$modx->getOption('core_path').'components/simpleab/');
if (!$simpleAB = $modx->getService('simpleab', 'SimpleAB', $corePath.'model/simpleab/')) {
    return 'SimpleAB not found in ' . $corePath;
}

$resetPick = (bool)$modx->getOption('resetPick', $scriptProperties, true);

$tests = $modx->getOption('tests', $scriptProperties, '*');
if (!$tests || empty($tests)) {
    /**
     * If we don't have any test ID(s), log it to the error log.
     */
    $modx->log(modX::LOG_LEVEL_ERROR,'[SimpleAB.sabConversion] Make sure to specify the &tests property to your sabConversion snippet call.');
    return;
}

$simpleAB->registerConversion($tests, $resetPick);
return;
