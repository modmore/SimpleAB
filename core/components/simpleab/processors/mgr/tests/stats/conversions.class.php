<?php
/**
 * Gets a list of sabConversion objects.
 */
class getConversionStatsGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sabConversion';
    public $languageTopics = array('simpleab:default');
    public $defaultSortField = 'date';
    public $defaultSortDirection = 'DESC';

    /**
     * {@inheritDoc}
     * @return boolean
     */
    public function initialize() {
        parent::initialize();
        $this->setDefaultProperties(array(
            'limit' => 9999,
        ));
        return true;
    }

    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->innerJoin('sabVariation', 'Variation');
        $c->where(array(
            'Variation.test' => $this->getProperty('test', 0),
        ));


        $c->groupby('date');
        $c->groupby('var_id');

        $c->select(array(
            'id' => 'MAX(sabConversion.id)',
            'var_id' => 'Variation.id',
            'amount' => 'SUM(amount)',
            'date',
        ));
        return $c;
    }

    /**
     * {@inheritdoc}
     * @param array $data
     *
     * @return array
     */
    public function iterate(array $data) {
        $list = array();
        $list = $this->beforeIteration($list);


        $interimList = array();

        $this->currentIndex = 0;
        /** @var xPDOObject|modAccessibleObject $object */
        foreach ($data['results'] as $object) {
            $objectArray = $this->prepareRow($object);
            if (!empty($objectArray) && is_array($objectArray)) {
                $date = $objectArray['date'];
                if (!isset($interimList[$date])) {
                    $interimList[$date] = array(
                        'id' => $objectArray['id'],
                        'period' => $objectArray['date'],
                    );
                }

                if (!isset($interimList[$date]['var_'.$objectArray['var_id']])) {
                    $interimList[$date]['var_'.$objectArray['var_id']] = $objectArray['amount'];
                }

                $this->currentIndex++;
            }
        }
        $interimList = array_reverse($interimList);

        $list = array_merge($list, array_values($interimList));

        $list = $this->afterIteration($list);
        return $list;
    }

    /**
     * Transform the xPDOObject derivative to an array;
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $row = $object->toArray('', false, true);
        return $row;
    }
}
return 'getConversionStatsGetListProcessor';
