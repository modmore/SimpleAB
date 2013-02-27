<?php
/**
 * Updates a sabVariation object
 */
class sabVariationUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'sabVariation';
    public $languageTopics = array('simpleab:default');

    /**
     * Before setting, we check if the name is filled and/or already exists. Also checkboxes.
     * @return bool
     */
    public function beforeSet() {
        $name = $this->getProperty('name');
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('required'));
        }

        $test = $this->getProperty('test');
        if (empty($test)) {
            $this->addFieldError('name','Required parameter test is not specified.');
        }

        $testObject = $this->modx->getObject('sabTest', $test);
        if (!$testObject) {
            $this->addFieldError('name','Parent test not found.');
        }

        $element = $this->getProperty('element');
        $elementType = $testObject->get('type');
        $elementObj = $this->modx->getObject($elementType, $element);
        if (!$elementObj) {
            $this->addFieldError('element', 'Element does not exist.');
        }

        /* Set checkbox */
        $this->setCheckbox('active', true);
        return parent::beforeSet();
    }
}
return 'sabVariationUpdateProcessor';
