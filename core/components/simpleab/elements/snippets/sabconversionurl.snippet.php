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

$params = array(
    'action' => 'web/conversion/log',
    'ctx' => $modx->context->get('key'),
    'tests' => $modx->getOption('tests', $scriptProperties, '*'),
    'resetPick' => (int)$modx->getOption('resetPick', $scriptProperties, 1),
);

return $simpleAB->config['connectorUrl'] . '?' . http_build_query($params);
