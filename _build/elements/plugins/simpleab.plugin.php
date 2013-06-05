<?php
/**
 * @var modX $modx
 * @var SimpleAB $simpleAB
 *
 * @event OnLoadWebDocument
 */

/** Load the SimpleAB service class */
$corePath = $modx->getOption('simpleab.core_path',null,$modx->getOption('core_path').'components/simpleab/');
if (!$simpleAB = $modx->getService('simpleab', 'SimpleAB', $corePath.'model/simpleab/')) {
    return 'SimpleAB not found in ' . $corePath;
}


/** Get the tests that could apply on this resource and loop over them. */
$tests = $simpleAB->getTestsForResource($modx->resource);
foreach ($tests as $testId) {
    /** Get the individual test object from cache, and continue it if it's a template test */
    $test = $modx->call('sabTest', 'getTest', array(&$modx, $testId));
    if ($test instanceof sabTest && ($test->get('type') == 'modTemplate')) {
        $isActive = $test->get('active');
        $isAdmin = $modx->user->isAuthenticated('mgr');
        $isPreview = isset($_GET['sabTest']) && isset($_GET['sabVariation']) && ($_GET['sabTest'] == $test->get('id'));
        $variations = $test->getVariations();

        $tpl = 0;
        /** Admin and in preview mode? Fetch the specified variation. */
        if ($isAdmin && $isPreview) {
            $variation = $modx->getObject('sabVariation', array(
                'id' => (int)$_GET['sabVariation'],
                'test' => $test->get('id'),
            ));
            /**  Variation found => get it, register the pick and add the admin preview box. */
            if ($variation) {
                $tpl = $variation->get('element');
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
            /** Variation not found? Pretend like our nose is bleeding and do like normal. */
            else {
                $picked = $simpleAB->pickOne($test, $variations, $simpleAB->getUserData());
                $tpl = $picked['element'];
            }
        }

        /** No admin/preview? Handle test if it is active. */
        elseif ($isActive) {
            $picked = $simpleAB->pickOne($test, $variations, $simpleAB->getUserData());
            $tpl = $picked['element'];
        }

        else {
            continue;
        }

        /** Make sure the element (template) exists. */
        if ($modx->getCount('modTemplate', $tpl) < 1) {
            // Uh oh, looks like the template doesn't exist. Do nothing.
            $modx->log(modX::LOG_LEVEL_ERROR,'[SimpleAB] Template for AB test ' . $test->get('id') . 'not found: ' . $tpl);
            continue;
        }

        $modx->toPlaceholders($simpleAB->lastPickDetails, 'simpleab.test_' . $testId);

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
