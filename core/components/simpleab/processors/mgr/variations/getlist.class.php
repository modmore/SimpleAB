<?php
/**
 * Gets a list of sabVariation objects.
 */
class sabVariationGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sabVariation';
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
        $row['picks'] = $this->modx->getCount('sabPick', array('variation' => $row['id']));
        $row['conversions'] = $this->modx->getCount('sabConversion', array('variation' => $row['id']));
        return $row;
    }
}
return 'sabVariationGetListProcessor';
