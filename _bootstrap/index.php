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
    'plugins' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/plugins/',
    'snippets' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/snippets/',
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

$settings = include dirname(dirname(__FILE__)) . '/_build/data/transport.settings.php';

foreach ($settings as $key => $setting) {
    /** @var modSystemSetting $setting */
    $exists = $modx->getCount('modSystemSetting', array('key' => $key));
    if ($exists < 1) {
        $setting->save();
    }
}

$snippets = include dirname(dirname(__FILE__)) . '/_build/data/transport.snippets.php';
foreach ($snippets as $snippet) {
    /** @var modSnippet $snippet */
    $exists = $modx->getCount('modSnippet', array('name' => $snippet->get('name')));
    if ($exists < 1) {
        $snippet->save();
    }
}

$plugins = include dirname(dirname(__FILE__)) . '/_build/data/transport.plugins.php';
foreach ($plugins as $plugin) {
    /** @var modPlugin $plugin */
    $exists = $modx->getCount('modPlugin', array('name' => $plugin->get('name')));
    if ($exists < 1) {
        $plugin->save();
    }
}
