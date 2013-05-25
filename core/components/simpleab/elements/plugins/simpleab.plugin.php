<?php
/**
 * @var modX $modx
 * @var SimpleAB $simpleAB
 *
 * @event OnLoadWebDocument
 */

/* Load the SimpleAB service class */
$corePath = $modx->getOption('simpleab.core_path',null,$modx->getOption('core_path').'components/simpleab/');
if (!$simpleAB = $modx->getService('simpleab', 'SimpleAB', $corePath.'model/simpleab/')) {
    return 'SimpleAB not found in ' . $corePath;
}


/**
 * Handle tests
 */
$tests = $simpleAB->getTestsForResource($modx->resource);

foreach ($tests as $testId) {
    $test = $modx->call('sabTest', 'getTest', array(&$modx, $testId));

    if ($test instanceof sabTest && ($test->get('type') == 'modTemplate')) {
        $variations = $test->getVariations();
        $picked = $simpleAB->pickOne($test, $variations, $simpleAB->getUserData());
        $tpl = $picked['element'];

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
                    $tpl = $variation->get('element');
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


        /** Make sure the element (template) exists. */
        if ($modx->getCount('modTemplate', $tpl) < 1) {
            // Uh oh, looks like the template doesn't exist. Do nothing.
            $modx->log(modX::LOG_LEVEL_ERROR,'[SimpleAB] Template for AB test ' . $test->get('id') . 'not found: ' . $tpl);
            continue;
        }

        /**
         * Dynamically swap out the template.
         *
         * - Change the cacheKey to make sure the template isn't loaded from cache
         * - Imply the resource needs to be processed still
         * - Change the actual template
         * - Make sure the $modx._shutdown function generates the cache with the new cacheKey.
         *
         * @todo Make sure the template is loaded from cache!
         */
        $modx->resource->_cacheKey = "[contextKey]/resources/[id].tpl{$tpl}";
        $modx->resource->_content = false;
        $modx->resource->set('template', $tpl);
        $modx->resourceGenerated = true;
    }
}