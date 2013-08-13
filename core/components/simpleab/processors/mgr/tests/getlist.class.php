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
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $includeArchived = $this->getProperty('include_archived', false);
        if (!$includeArchived) {
            $c->where(array(
                'archived' => false,
            ));
        }
        return $c;
    }

    /**
     * Transform the xPDOObject derivative to an array;
     * @param sabTest|xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $row = $object->toArray('', false, true);
        $row['variations'] = $this->modx->getCount('sabVariation', array('test' => $row['id']));
        $row['conversions'] = $this->modx->simpleab->getSum('sabConversion', array('test' => $row['id']));
        return $row;
    }
}
return 'sabTestGetListProcessor';
