<?php
/**
 * @var modX $modx
 * @var array $scriptProperties
 * @var SimpleAB $simpleAB
 *
 * @event OnLoadWebDocument
 */

/** Load the SimpleAB service class */
$corePath = $modx->getOption('simpleab.core_path',null,$modx->getOption('core_path').'components/simpleab/');
if (!$simpleAB = $modx->getService('simpleab', 'SimpleAB', $corePath.'model/simpleab/')) {
    return 'SimpleAB not found in ' . $corePath;
}

if (!isset($test) || !is_numeric($test)) {
    return 'Please specify a &test property with a Test ID.';
}
$testId = (int)$test;

/** Grab the specified test from cache... */
$test = $modx->call('sabTest', 'getTest', array(&$modx, (int)$testId));
/** ... but only do stuff if it is a chunk test! */
if ($test instanceof sabTest && ($test->get('type') == 'modChunk')) {
    $isActive = $test->get('active');
    $isAdmin = $modx->user->isAuthenticated('mgr');
    $isPreview = isset($_GET['sabTest']) && isset($_GET['sabVariation']) && ($_GET['sabTest'] == $test->get('id'));
    $variations = $test->getVariations();

    /** If the user is an admin and we're in preview mode ... */
    if ($isAdmin && $isPreview) {
        // ... find the specified varioation ...
        $variation = $modx->getObject('sabVariation', array(
            'id' => (int)$_GET['sabVariation'],
            'test' => $test->get('id'),
        ));
        /** ... and if it exists, get its element, register the pick, and place the preview box in markup */
        if ($variation) {
            $chunkId = $variation->get('element');
            $simpleAB->registerPick($test->get('id'), $variation->get('id'));
            $simpleAB->registerAdminPreviewBox($test, $variations);
            $simpleAB->lastPickDetails = array(
                'test' => $testId,
                'mode' => 'preview',
                'pick' => $variation->get('id'),
                'variation' => $variation->toArray(),
                'variations' => $variations,
            );
        }
        /** If we're an admin in preview mode, but the variation doesn't exist, just grab one. */
        else {
            $picked = $simpleAB->pickOne($test, $variations, $simpleAB->getUserData());
            $chunkId = $picked['element'];
        }
    }

    /** Not an admin or not in preview? Then execute as normal if it is active. */
    elseif ($isActive) {
        $picked = $simpleAB->pickOne($test, $variations, $simpleAB->getUserData());
        $chunkId = $picked['element'];
    }

    else {
        return 'Inactive test #'.$testId;
    }

    $modx->toPlaceholders($simpleAB->lastPickDetails, 'simpleab.test_' . $testId);
    $scriptProperties['simpleab.test'] = $simpleAB->lastPickDetails;
    /**
     * Load and return the processed chunk.
     */
    $chunk = $modx->getObject('modChunk', $chunkId);
    if ($chunk instanceof modChunk) {
        return $chunk->process($scriptProperties);
    }

    $modx->log(modX::LOG_LEVEL_ERROR,'[SimpleAB] Chunk with ID ' . $chunkId . ' not found for test ' . $test->get('id') . ' on resource ' . $modx->resource->get('id'));
} else {
    return 'Invalid test #'.$testId;
}