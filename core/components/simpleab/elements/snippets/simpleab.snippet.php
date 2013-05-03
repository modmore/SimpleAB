<?php
/**
 * @var modX $modx
 * @var array $scriptProperties
 * @var SimpleAB $simpleAB
 *
 * @event OnLoadWebDocument
 */

/* Load the SimpleAB service class */
$corePath = $modx->getOption('simpleab.core_path',null,$modx->getOption('core_path').'components/simpleab/');
if (!$simpleAB = $modx->getService('simpleab', 'SimpleAB', $corePath.'model/simpleab/')) {
    return 'SimpleAB not found in ' . $corePath;
}

if (!isset($test) || !is_numeric($test)) {
    return 'Please specify a &test property with a Test ID.';
}
$testId = (int)$test;

/**
 * Handle tests
 */
$test = $modx->call('sabTest', 'getTest', array(&$modx, (int)$testId));
if ($test instanceof sabTest && ($test->get('type') == 'modChunk')) {
    $variations = $test->getVariations();
    $picked = $simpleAB->pickOne($test, $variations, $simpleAB->getUserData());
    $chunkId = $picked['element'];

    /**
     * Override tpl for the preview functionality.
     */
    if (isset($_GET['sabTest']) && isset($_GET['sabVariation']) && ($_GET['sabTest'] == $test->get('id'))) {
        if ($modx->user->isAuthenticated('mgr')) {
            $variation = $modx->getObject('sabVariation', array(
                'id' => (int)$_GET['sabVariation'],
                'test' => $test->get('id'),
            ));
            if ($variation) {
                $chunkId = $variation->get('element');
                $modx->regClientHTMLBlock(<<<HTML
<div style="position: fixed; bottom: 0px; left: 0px; background: #1f4a7f; color: white; margin: 0; padding: 15px; -webkit-border-radius: 0px 10px 0px 0px; border-radius: 0px 10px 0px 0px; border-top: 1px solid #fff; border-right: 1px solid #fff;">
<p style="margin: 0 0 10px 0; padding: 0; width: 100%;font-size: 125%;">SimpleAB Admin Preview</p>
<p><strong>Test:</strong> {$test->name} <br />
<strong>Variation</strong> {$variation->name}
</p>
</div>
HTML
);
            }
        }
    }

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
