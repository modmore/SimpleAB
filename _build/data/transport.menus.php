<?php

/**
 * @var modMenu $menu
 * @var modX $modx
 */
$menu = $modx->newObject('modMenu');
$menu->fromArray([
    'text' => 'simpleab',
    'description' => 'simpleab.menu_desc',
    'parent' => 'components',
    'namespace' => 'simpleab',
    'action' => 'home',
], '', true, true);

$vehicle = $builder->createVehicle($menu, [
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'text',
]);
$builder->putVehicle($vehicle);
unset($vehicle, $childActions, $action, $menu);
