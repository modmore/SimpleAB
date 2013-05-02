<?php
/**
 * Gets a list of sabConversion objects.
 */
class sabTestArchiveProcessor extends modObjectProcessor {
    public $classKey = 'sabTest';

    /**
     * @return array|string
     */
    public function process() {
        $this->object = $this->modx->getObject($this->classKey, $this->getProperty($this->primaryKeyField));
        if (!$this->object) return $this->failure('err_obj_nf');

        if ($this->object->get('archived')) {
            return $this->failure('simpleab.archive_test.already_archived');
        }

        $this->object->set('archived', true);
        $this->object->set('active', false);

        if ($this->object->save()) {
            return $this->success();
        } else {
            return $this->failure('obj_err_save');
        }
    }
}
return 'sabTestArchiveProcessor';
