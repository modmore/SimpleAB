<?php
/**
 * Gets a list of sabTest objects.
 */
class sabTestGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sabTest';
    public $languageTopics = array('simpleab:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';

    /**
     * Transform the xPDOObject derivative to an array;
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $row = $object->toArray('', false, true);
        $row['variations'] = $this->modx->getCount('sabVariation', array('test' => $row['id']));
        $row['conversions'] = $this->modx->getCount('sabConversion', array('test' => $row['id']));
        return $row;
    }
}
return 'sabTestGetListProcessor';
