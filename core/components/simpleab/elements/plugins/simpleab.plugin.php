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

$tests = $simpleAB->getTestsForResource($modx->resource);

foreach ($tests as $testId) {
    $test = $modx->call('sabTest', 'getTest', array(&$modx, $testId));

    if ($test instanceof sabTest && ($test->get('type') == 'modTemplate')) {
        $variations = $test->getVariations();

        $picked = $simpleAB->pickOne($test, $variations, $simpleAB->getUserData());

        /** Make sure the element (template) exists. */
        $tpl = $picked['element'];
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
        $modx->resource->_content =false;
        $modx->resource->set('template', $tpl);
        $modx->resourceGenerated = true;
    }
}

