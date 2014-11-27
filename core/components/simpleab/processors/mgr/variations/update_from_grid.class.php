<?php
/**
 */
class sabVariationUpdateFromGridProcessor extends modProcessor {
    /** @var array $records */
    public $record;

    /**
     * @return bool|null|string
     */
    public function initialize() {
        $data = $this->getProperty('data');
        if (empty($data)) return $this->modx->lexicon('invalid_data');
        $this->record = $this->modx->fromJSON($data);
        if (empty($this->record)) return $this->modx->lexicon('invalid_data');
        return true;
    }

    /**
     * @return array|string
     */
    public function process() {
        if (empty($this->record['id'])) {
            return $this->failure($this->modx->lexicon('simpleab.error.missing_id'));
        }

        $field = $this->modx->getObject('sabVariation', $this->record['id']);
        if (!$field) {
            return $this->failure($this->modx->lexicon('simpleab.error.field_not_found'));
        }

        $field->set('active', (bool)$this->record['active']);
        if ($field->save()) {
            return $this->success();
        }
        return $this->failure($this->modx->lexicon('simpleab.error.error_saving_object'));
    }
}
return 'sabVariationUpdateFromGridProcessor';
