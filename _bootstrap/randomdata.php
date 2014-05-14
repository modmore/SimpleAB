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

$test = 1;
$variationA = 1;
$variationB = 2;

$data = array(
    '0' => array(
        'picks' => 250,
        'conversions' => 9
    ),
    '1' => array(
        'picks' => 225,
        'conversions' => 8
    ),
    '2' => array(
        'picks' => 230,
        'conversions' => 9
    ),
    '3' => array(
        'picks' => 180,
        'conversions' => 4
    ),
    '4' => array(
        'picks' => 165,
        'conversions' => 5
    ),
    '5' => array(
        'picks' => 220,
        'conversions' => 7
    ),
    '6' => array(
        'picks' => 290,
        'conversions' => 20
    ),
    '7' => array(
        'picks' => 269,
        'conversions' => 15
    ),
    '8' => array(
        'picks' => 250,
        'conversions' => 9
    ),
    '9' => array(
        'picks' => 245,
        'conversions' => 9
    ),
    '10' => array(
        'picks' => 230,
        'conversions' => 7
    ),
    '11' => array(
        'picks' => 170,
        'conversions' => 3
    ),
    '12' => array(
        'picks' => 210,
        'conversions' => 9
    ),
    '13' => array(
        'picks' => 280,
        'conversions' => 14
    ),
    '14' => array(
        'picks' => 320,
        'conversions' => 20
    ),
    '15' => array(
        'picks' => 270,
        'conversions' => 9
    ),
    '16' => array(
        'picks' => 250,
        'conversions' => 9
    ),
    '17' => array(
        'picks' => 220,
        'conversions' => 6
    ),
    '18' => array(
        'picks' => 150,
        'conversions' => 7
    ),
    '19' => array(
        'picks' => 250,
        'conversions' => 9
    ),
);


foreach ($data as $day => $vals) {
    $date = date('Ymd', time() - ($day * 24 * 60 *60));
    $split = rand(40, 60);
    $splitPicks = $split / 100 * $vals['picks'];
    $splitConversions =  $split / 100 * $vals['conversions'];

    // A

    $pickA = $modx->getObject('sabPick', array(
        'test' => $test,
        'variation' => $variationA,
        'date' => $date,
    ));
    if (!$pickA) {
        $pickA = $modx->newObject('sabPick', array(
            'test' => $test,
            'variation' => $variationA,
            'date' => $date,
        ));
    }
    $pickA->set('amount', $splitPicks);
    $pickA->save();

    $conversionA = $modx->getObject('sabConversion', array(
        'test' => $test,
        'variation' => $variationA,
        'date' => $date,
    ));
    if (!$conversionA) {
        $conversionA = $modx->newObject('sabConversion', array(
            'test' => $test,
            'variation' => $variationA,
            'date' => $date,
        ));
    }
    $conversionA->set('amount', $splitConversions);
    $conversionA->save();


    // B

    $pickB = $modx->getObject('sabPick', array(
        'test' => $test,
        'variation' => $variationB,
        'date' => $date,
    ));
    if (!$pickB) {
        $pickB = $modx->newObject('sabPick', array(
            'test' => $test,
            'variation' => $variationB,
            'date' => $date,
        ));
    }
    $pickB->set('amount', $vals['picks'] - $splitPicks);
    $pickB->save();

    $conversionB = $modx->getObject('sabConversion', array(
        'test' => $test,
        'variation' => $variationB,
        'date' => $date,
    ));
    if (!$conversionB) {
        $conversionB = $modx->newObject('sabConversion', array(
            'test' => $test,
            'variation' => $variationB,
            'date' => $date,
        ));
    }
    $conversionB->set('amount', $vals['conversions'] - $splitConversions);
    $conversionB->save();
}

echo "Done.";