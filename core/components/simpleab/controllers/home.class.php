<?php

/**
 * The name of the controller is based on the path (home) and the
 * namespace (simpleab). This home controller is the main client view.
 */
class SimpleABHomeManagerController extends SimpleABManagerController {
    /**
     * The pagetitle to put in the <title> attribute.
     * @return null|string
     */
    public function getPageTitle() {
        return $this->modx->lexicon('simpleab.home');
    }

    /**
     * Register all the needed javascript files. Using this method, it will automagically
     * combine and compress them if enabled in system settings.
     */
    public function loadCustomCssJs() {
        $this->addJavascript($this->simpleab->config['jsUrl'].'mgr/widgets/grid.tests.js');
        $this->addJavascript($this->simpleab->config['jsUrl'].'mgr/widgets/window.tests.js');

        $this->addJavascript($this->simpleab->config['jsUrl'].'mgr/panels/home.js');
        $this->addLastJavascript($this->simpleab->config['jsUrl'].'mgr/sections/home.js');
    }
}
