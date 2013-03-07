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
     * Only load variations for current test.
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $test = $this->getProperty('test', 0);
        $c->where(array(
            'test' => $test,
        ));
        return $c;
    }

    /**
     * Transform the xPDOObject derivative to an array;
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $row = $object->toArray('', false, true);
        $row['picks'] = $this->modx->getCount('sabPick', array('variation' => $row['id']));
        $row['conversions'] = $this->modx->getCount('sabConversion', array('variation' => $row['id']));
        $row['conversionrate'] = ($row['picks'] > 0) ? number_format($row['conversions'] / $row['picks'], 2) : 0.00;
        return $row;
    }
}
return 'sabVariationGetListProcessor';
