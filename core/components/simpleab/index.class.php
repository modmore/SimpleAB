<?php

/**
 * The main SimpleAB Manager Controller.
 * In this class, we define stuff we want on all of our controllers.
 */
abstract class SimpleABManagerController extends modExtraManagerController {
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
}

/**
 * The Index Manager Controller is the default one that gets called when no
 * action is present. It's most commonly used to define the default controller
 * which then hands over processing to the other controller ("home").
 */
class IndexManagerController extends SimpleABManagerController {
    /**
     * Defines the name or path to the default controller to load.
     * @return string
     */
    public static function getDefaultController() {
        return 'home';
    }
}
