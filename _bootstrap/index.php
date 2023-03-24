<?php
/* Get the core config */
if (!file_exists(dirname(dirname(__FILE__)).'/config.core.php')) {
    die('ERROR: missing '.dirname(dirname(__FILE__)).'/config.core.php file defining the MODX core path.');
}

echo "<pre>";
/* Boot up MODX */
echo "Loading modX...\n";
require_once dirname(dirname(__FILE__)).'/config.core.php';
require_once MODX_CORE_PATH.'model/modx/modx.class.php';
$modx = new modX();
echo "Initializing manager...\n";
$modx->initialize('mgr');
$modx->getService('error','error.modError', '', '');

$componentPath = dirname(dirname(__FILE__));
$SimpleAB = $modx->getService('simpleab','SimpleAB', $componentPath.'/core/components/simpleab/model/simpleab/', array(
    'simpleab.core_path' => $componentPath.'/core/components/simpleab/',
));


/* Namespace */
if (!createObject('modNamespace',array(
    'name' => 'simpleab',
    'path' => $componentPath.'/core/components/simpleab/',
    'assets_path' => $componentPath.'/assets/components/simpleab/',
),'name', false)) {
    echo "Error creating namespace simpleab.\n";
}

/* Path settings */
if (!createObject('modSystemSetting', array(
    'key' => 'simpleab.core_path',
    'value' => $componentPath.'/core/components/simpleab/',
    'xtype' => 'textfield',
    'namespace' => 'simpleab',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating simpleab.core_path setting.\n";
}

if (!createObject('modSystemSetting', array(
    'key' => 'simpleab.assets_path',
    'value' => $componentPath.'/assets/components/simpleab/',
    'xtype' => 'textfield',
    'namespace' => 'simpleab',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating simpleab.assets_path setting.\n";
}

/* Fetch assets url */
$url = 'http';
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) {
    $url .= 's';
}
$url .= '://'.$_SERVER["SERVER_NAME"];
if ($_SERVER['SERVER_PORT'] != '80') {
    $url .= ':'.$_SERVER['SERVER_PORT'];
}
$requestUri = $_SERVER['REQUEST_URI'];
$bootstrapPos = strpos($requestUri, '_bootstrap/');
$requestUri = rtrim(substr($requestUri, 0, $bootstrapPos), '/').'/';
$assetsUrl = "{$url}{$requestUri}assets/components/simpleab/";

if (!createObject('modSystemSetting', array(
    'key' => 'simpleab.assets_url',
    'value' => $assetsUrl,
    'xtype' => 'textfield',
    'namespace' => 'simpleab',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating simpleab.assets_url setting.\n";
}

$s = array(
    'use_previous_picks' => true,
    'hide_logo' => false,
    'admin_groups' => 'Administrator',
    'ga_custom_var_index' => 1,
    'ga_custom_var_name' => 'SAB',
    'ga_custom_var_scope' => 2,
);

foreach ($s as $key => $value) {

    if (is_string($value) || is_int($value)) { $type = 'textfield'; }
    elseif (is_bool($value)) { $type = 'combo-boolean'; }
    else { $type = 'textfield'; }

    $parts = explode('.',$key);
    if (count($parts) == 1) { $area = 'Default'; }
    else { $area = $parts[0]; }

    if (!createObject('modSystemSetting', array(
        'key' => 'simpleab.'.$key,
        'value' => $value,
        'xtype' => $type,
        'namespace' => 'simpleab',
        'area' => $area,
        'editedon' => time(),
    ), 'key', false)) {
        echo "Error creating simpleab.".$key." setting.\n";
    }
}

/**
 * Menu
 */
if (!createObject('modMenu', array(
    'text' => 'simpleab',
    'parent' => 'components',
    'description' => 'simpleab.menu_desc',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => 0,
    'namespace' => 'simpleab',
    'action' => 'home',
), 'text', false)) {
    echo "Error creating menu.\n";
}

/**
 * Category
 * @var modCategory $category
 */
if (!createObject('modCategory', array(
    'category' => 'SimpleAB',
    'parent' => 0,
), 'category', false)) {
    echo "Error creating Category.\n";
}

$categoryId = 0;
$category = $modx->getObject('modCategory', array('category' => 'SimpleAB'));
if ($category) {
    $categoryId = $category->get('id');
}

/**
 * Snippets
 * @var modSnippet $snippet
 */
echo "Snippets create or update...\n";

$snips = array(
    'sabConversion' => 'Stand-alone snippet to register a conversion to SimpleAB.',
    'sabConversionHook' => 'Hook for use with FormIt to register a conversion to SimpleAB.',
    'sabConversionUrl' => 'Snippet that properly generates the URL to load via AJAX to register a conversion.',
    'SimpleAB' => 'SimpleAB snippet to run Chunk A/B tests. Specify the &test property.',
);

foreach ($snips as $name => $description) {
    if (!createObject('modSnippet', array(
        'name' => $name,
        'description' => $description . ' (Part of SimpleAB)',
        'static' => true,
        'static_file' => '[[++simpleab.core_path]]elements/snippets/'.strtolower($name).'.snippet.php',
        'category' => $categoryId,
    ), 'name', true)) {
        echo "Error creating snippet.\n";
    }
}

/**
 * Plugins
 * @var modPlugin $simpleABPlugin
 */
if (!createObject('modPlugin', array(
    'name' => 'SimpleAB',
    'static' => true,
    'static_file' => '[[++simpleab.core_path]]elements/plugins/simpleab.plugin.php',
    'category' => $categoryId
), 'name', true)) {
    echo "Error creating modPlugin.\n";
}

$simpleABPlugin = $modx->getObject('modPlugin', array('name' => 'SimpleAB'));
if ($simpleABPlugin) {

    /*
    $existingProperties = $simpleABPlugin->getProperties();
    $properties = array(
        array(
            'name' => 'NAME',
            'desc' => '',
            'type' => 'integer',
            'options' => '',
            'value' => ((isset($existingProperties['NAME'])) ? $existingProperties['NAME'] : ''),
            'lexicon' => 'simpleab:properties',
        ),
    );
    $simpleABPlugin->setProperties($properties, true);
    $simpleABPlugin->save();
    */

    if (!createObject('modPluginEvent', array(
        'pluginid' => $simpleABPlugin->get('id'),
        'event' => 'OnLoadWebDocument',
        'priority' => 0,
    ), array('pluginid','event'), false)) {
        echo "Error creating modPluginEvent.\n";
    }
}


$manager = $modx->getManager();

// Increase severity level for logging.
$logLevel = $modx->setLogLevel(modX::LOG_LEVEL_FATAL);

/* Create the tables */
$objectContainers = array(
    'sabConversion',
    'sabPick',
    'sabTest',
    'sabVariation',
);
echo "Creating tables...\n";

foreach ($objectContainers as $oC) {
    $manager->createObjectContainer($oC);
}

// Restore log level
$modx->setLogLevel($logLevel);

echo "Done.";


/**
 * Creates an object.
 *
 * @param string $className
 * @param array $data
 * @param string $primaryField
 * @param bool $update
 * @return bool
 */
function createObject ($className = '', array $data = array(), $primaryField = '', $update = true) {
    global $modx;
    /* @var xPDOObject $object */
    $object = null;

    /* Attempt to get the existing object */
    if (!empty($primaryField)) {
        if (is_array($primaryField)) {
            $condition = array();
            foreach ($primaryField as $key) {
                $condition[$key] = $data[$key];
            }
        }
        else {
            $condition = array($primaryField => $data[$primaryField]);
        }
        $object = $modx->getObject($className, $condition);
        if ($object instanceof $className) {
            if ($update) {
                $object->fromArray($data);
                return $object->save();
            } else {
                $condition = $modx->toJSON($condition);
                echo "Skipping {$className} {$condition}: already exists.\n";
                return true;
            }
        }
    }

    /* Create new object if it doesn't exist */
    if (!$object) {
        $object = $modx->newObject($className);
        $object->fromArray($data, '', true);
        return $object->save();
    }

    return false;
}