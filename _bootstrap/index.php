<?php
/**
 * @param string $filename
 *
 * @return string
 */
function getSnippetContent($filename = '') {
    $o = file_get_contents($filename);
    $o = str_replace('<?php','',$o);
    $o = str_replace('?>','',$o);
    $o = trim($o);
    return $o;
}
define('PKG_NAME','SimpleAB');
define('PKG_NAME_LOWER',strtolower(PKG_NAME));
$root = dirname(dirname(__FILE__)).'/';
$sources= array (
    'root' => $root,
    'build' => $root .'_build/',
    'events' => $root . '_build/events/',
    'resolvers' => $root . '_build/resolvers/',
    'data' => $root . '_build/data/',
    'source_core' => $root.'core/components/'.PKG_NAME_LOWER,
    'source_assets' => $root.'assets/components/'.PKG_NAME_LOWER,
    'plugins' => $root.'_build/elements/plugins/',
    'snippets' => $root.'_build/elements/snippets/',
    'lexicon' => $root . 'core/components/'.PKG_NAME_LOWER.'/lexicon/',
    'docs' => $root.'core/components/'.PKG_NAME_LOWER.'/docs/',
    'model' => $root.'core/components/'.PKG_NAME_LOWER.'/model/',
);
unset($root);

require_once dirname(dirname(__FILE__)) . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$update = true;

$settings = include dirname(dirname(__FILE__)) . '/_build/data/transport.settings.php';

foreach ($settings as $key => $setting) {
    /** @var modSystemSetting $setting */
    $exists = $modx->getObject('modSystemSetting', array('key' => $key));
    if (!($exists instanceof modSystemSetting)) {
        $setting->save();
    }
    elseif ($update && ($exists instanceof modSystemSetting)) {
        $exists->fromArray($setting->toArray(), '', true);
        $exists->save();
    }
}

$snippets = include dirname(dirname(__FILE__)) . '/_build/data/transport.snippets.php';
foreach ($snippets as $snippet) {
    /** @var modSnippet $snippet */
    $exists = $modx->getObject('modSnippet', array('name' => $snippet->get('name')));
    if (!($exists instanceof modSnippet)) {
        $snippet->save();
    }
    elseif ($update && ($exists instanceof modSnippet)) {
        $exists->fromArray($snippet->toArray(), '', true);
        $exists->save();
    }
}

$plugins = include dirname(dirname(__FILE__)) . '/_build/data/transport.plugins.php';
foreach ($plugins as $plugin) {
    /** @var modPlugin $plugin */
    $exists = $modx->getObject('modPlugin', array('name' => $plugin->get('name')));
    if (!($exists instanceof modPlugin)) {
        $plugin->save();
    }
    elseif ($update && ($exists instanceof modPlugin)) {
        $exists->fromArray($plugin->toArray(), '', true);
        $exists->save();
    }
}

$modx->getService('simpleab', 'SimpleAB', dirname(dirname(__FILE__)).'/core/components/simpleab/model/simpleab/');

$manager = $modx->getManager();
$manager->createObjectContainer('sabConversion');
$manager->createObjectContainer('sabPick');
$manager->createObjectContainer('sabTest');
$manager->createObjectContainer('sabVariation');
