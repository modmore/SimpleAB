<?php

require_once __DIR__ . '/home.class.php';

/**
 * The name of the controller is based on the path (test) and the
 * namespace (simpleab).
 */
class SimpleABTestManagerController extends SimpleABHomeManagerController {
    /**
     * @param array $scriptProperties
     * @throws \xPDO\xPDOException
     */
    public function process(array $scriptProperties = []) {
        $id = (int)$this->modx->getOption('id', $scriptProperties, 0);
        if ($id < 1 || (!$test = $this->modx->getObject('sabTest', $id))) {
            $this->modx->sendRedirect($this->modx->config['manager_url'] . '?a=home&namespace=simpleab');
        }

        /** @var sabTest $test */
        $series = [];
        $fields = ['period'];

        $vars = $test->getMany('Variations');
        foreach ($vars as $variation) {
            /** @var sabVariation $variation */
            $series[] = [
                'type' => 'line',
                'displayName' => $variation->get('name'),
                'yField' => 'var_' . $variation->get('id'),
                'xField' => 'period',
            ];

            $fields[] = 'var_' . $variation->get('id');
        }

        $this->addHtml('<script type="text/javascript">
            SimpleAB.record = ' . $test->toJSON() . ';
            SimpleAB.chartSeries = ' . $this->modx->toJSON($series) . ';
            SimpleAB.chartFields = ' . $this->modx->toJSON($fields) . ';
        </script>');
    }

    /**
     * The pagetitle to put in the <title> attribute.
     * @return null|string
     */
    public function getPageTitle() {
        return $this->modx->lexicon('simpleab.manage_test');
    }

    /**
     * Register all the needed javascript files. Using this method, it will automagically
     * combine and compress them if enabled in system settings.
     */
    public function loadCustomCssJs() {
        $this->addJavascript($this->simpleab->config['assetsUrl'] . 'chartjs/chart.min.js');
        $this->addJavascript($this->simpleab->config['jsUrl'] . 'mgr/widgets/combos.js');
        $this->addJavascript($this->simpleab->config['jsUrl'] . 'mgr/widgets/grid.variations.js');
        $this->addJavascript($this->simpleab->config['jsUrl'] . 'mgr/widgets/window.variations.js');
        $this->addJavascript($this->simpleab->config['jsUrl'] . 'mgr/widgets/window.tests.js');

        $this->addJavascript($this->simpleab->config['jsUrl'] . 'mgr/panels/test.js');
        $this->addLastJavascript($this->simpleab->config['jsUrl'] . 'mgr/sections/test.js');
    }
}
