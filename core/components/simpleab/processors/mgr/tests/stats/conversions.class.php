<?php

require_once __DIR__ . '/stats.class.php';

/**
 * Gets a list of sabConversion objects.
 */
class getConversionStatsGetListProcessor extends StatsGetListProcessor {
    public $classKey = sabConversion::class;

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c): xPDOQuery
    {
        $c->innerJoin('sabVariation', 'Variation');
        $c->where([
            'Variation.test' => $this->getProperty('test', 0),
        ]);

        $c->groupby('date');
        $c->groupby('var_id');

        $c->select([
            'id' => 'MAX(sabConversion.id)',
            'var_id' => 'Variation.id',
            'label' => 'Variation.name',
            'amount' => 'SUM(amount)',
            'date',
        ]);

        return $c;
    }
}
return 'getConversionStatsGetListProcessor';
