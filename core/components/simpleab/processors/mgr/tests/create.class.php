<?php
/**
 * Creates a sabTest object.
 */
class sabTestCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'sabTest';
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

        /* Set checkbox */
        $this->setCheckbox('active', true);
        $this->setCheckbox('smartoptimize', true);
        return parent::beforeSet();
    }
}
return 'sabTestCreateProcessor';
