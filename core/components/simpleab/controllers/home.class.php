<?php

/**
 * The name of the controller is based on the path (home) and the
 * namespace (simpleab). This home controller is the main client view.
 */
class SimpleABHomeManagerController extends modExtraManagerController {
    /** @var SimpleAB $simpleab */
    public $simpleab = null;

    /**
     * Initializes the main manager controller. In this case we set up the
     * SimpleAB class and add the required javascript on all controllers.
     */
    public function initialize() {
        /* Instantiate the SimpleAB class in the controller */
        $path = $this->modx->getOption('simpleab.core_path', null, $this->modx->getOption('core_path').'components/simpleab/') . 'model/simpleab/';
        $this->simpleab = $this->modx->getService('simpleab', 'SimpleAB', $path);

        /* Add the main javascript class and our configuration */
        $this->addJavascript($this->simpleab->config['jsUrl'].'mgr/simpleab.class.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            SimpleAB.config = '.$this->modx->toJSON($this->simpleab->config).';
        });
        </script>');
    }

    /**
     * Defines the lexicon topics to load in our controller.
     * @return array
     */
    public function getLanguageTopics() {
        return array('simpleab:default');
    }

    /**
     * We can use this to check if the user has permission to see this
     * controller. We'll apply this in the admin section.
     * @return bool
     */
    public function checkPermissions() {
        return true;
    }

    /**
     * The name for the template file to load.
     * @return string
     */
    public function getTemplateFile() {
        return $this->simpleab->config['templatesPath'].'mgr.tpl';
    }

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
