<?php
/**
 * Updates a sabTest object
 */
class sabTestUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'sabTest';
    public $languageTopics = array('simpleab:default');

    /**
     * Before setting, we check if the name is filled and/or already exists. Also checkboxes.
     * @return bool
     */
    public function beforeSet() {
        $name = $this->getProperty('name');
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('simpleab.cgsetting_err_ns_name'));
        }

        $this->setCheckbox('active', true);
        return parent::beforeSet();
    }
}
return 'sabTestUpdateProcessor';
