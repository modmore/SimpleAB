<?php
$plugins = array();

/** create the plugin object */
$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->set('id',1);
$plugins[0]->set('name','SimpleAB');
$plugins[0]->set('description','The plugin making the multivariate template testing a reality (Part of SimpleAB)');
$plugins[0]->set('plugincode', getSnippetContent($sources['plugins'] . 'simpleab.plugin.php'));
$plugins[0]->set('category', 0);

$events = include $sources['events'].'events.simpleab.php';
if (is_array($events) && !empty($events)) {
    $plugins[0]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events for SimpleAB.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events for SimpleAB!');
}
unset($events);

return $plugins;
