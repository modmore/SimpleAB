<?php
/**
 * Gets a list of sabConversion objects.
 */
class sabTestDuplicateProcessor extends modObjectDuplicateProcessor {
    public $classKey = 'sabTest';

    /**
     * @return bool
     */
    public function beforeSave() {
        $this->newObject->set('active', false);
        $this->newObject->set('archived', false);
        return parent::beforeSave();
    }

    /**
     * @return bool
     */
    public function afterSave() {
        $oldToNewVariations = array();
        foreach ($this->object->getMany('Variations') as $variation) {
            /**
             * @var sabVariation $variation
             * @var sabVariation $newVariation
             */
            $newVariation = $this->modx->newObject('sabVariation');
            $newVariation->fromArray($variation->toArray());
            $newVariation->set('test', $this->newObject->get('id'));
            if ($newVariation->save()) {
                $oldToNewVariations[$variation->get('id')] = $newVariation->get('id');
            }
        }

        /**
         * Handle duplication of picks and conversions
         */
        $duplicate = (bool)$this->getProperty('duplicate_data',false);
        if ($duplicate) {
            /**
             * Duplicate picks (views)
             */
            foreach ($this->modx->getIterator('sabPick', array('test' => $this->object->get('id'))) as $pick) {
                /**
                 * @var sabPick $pick
                 * @var sabPick $newPick
                 */
                $newPick = $this->modx->newObject('sabPick');
                $newPick->fromArray(array(
                    'test' => $this->newObject->get('id'),
                    'variation' => $oldToNewVariations[$pick->get('variation')],
                    'date' => $pick->get('date'),
                ));
                $newPick->save();
            }

            /**
             * Duplicate conversions
             */
            foreach ($this->modx->getIterator('sabConversion', array('test' => $this->object->get('id'))) as $conversion) {
                /**
                 * @var sabConversion $conversion
                 * @var sabConversion $newConversion
                 */
                $newConversion = $this->modx->newObject('sabConversion');
                $newConversion->fromArray(array(
                    'test' => $this->newObject->get('id'),
                    'variation' => $oldToNewVariations[$conversion->get('variation')],
                    'date' => $conversion->get('date'),
                    'value' => $conversion->get('value'),
                ));
                $newConversion->save();
            }
        }
        return parent::afterSave();
    }

    /**
     * Override alreadyExists to prevent issues creating tests with the same name.
     *
     * @param string $name
     *
     * @return bool
     */
    public function alreadyExists($name) {
        return false;
    }
}
return 'sabTestDuplicateProcessor';
