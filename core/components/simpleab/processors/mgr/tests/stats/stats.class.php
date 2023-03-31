<?php

/**
 * Gets a list of sabPick objects.
 */
class StatsGetListProcessor extends modObjectGetListProcessor {
    public $classKey = sabPick::class;
    public $languageTopics = ['simpleab:default'];
    public $defaultSortField = 'date';
    public $defaultSortDirection = 'ASC';
    protected array $dates = [];
    protected array $labels = [];

    /**
     * {@inheritDoc}
     * @return bool
     */
    public function initialize()
    {
        parent::initialize();
        $this->setDefaultProperties([
            'limit' => 9999,
        ]);

        // Build a list of dates for the last 30 days (could potentially change this to any number)
        for ($i = 0; $i < 30; $i++) {
            $this->dates[] = date("Ymd", strtotime('-' . $i . ' days'));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     * @param array $data
     * @return array
     */
    public function iterate(array $data): array
    {
        $list = [];
        $list = $this->beforeIteration($list);

        $this->currentIndex = 0;

        // If we have no results, we still need to set initial values for each variation and date.
        if (empty($data['results'])) {
            $list = $this->setEmptyStats($list);
            return $this->afterIteration($list);
        }

        /** @var xPDOObject|modAccessibleObject $object */
        foreach ($data['results'] as $object) {
            $objectArray = $this->prepareRow($object);
            if (!empty($objectArray)) {
                $varId = 'var_' . $objectArray['var_id'];

                // Sort into sets by variation id -> date
                foreach ($this->dates as $date) {
                    if (!isset($list[$varId][$date])) {
                        $list[$varId][$date] = 0;
                    }
                }

                $list[$varId][$objectArray['date']] = $objectArray['amount'];
                $this->labels[$varId] = $objectArray['label'];
                $this->currentIndex++;
            }
        }

        return $this->afterIteration($list);
    }

    /**
     * @param array $list
     * @return array
     */
    protected function setEmptyStats(array $list): array
    {
        $c = $this->modx->newQuery(sabVariation::class);
        $c->where([
            'test' => (int)$this->getProperty('test'),
        ]);
        $c->sortby('name');
        $variations = $this->modx->getCollection(sabVariation::class, $c);
        foreach ($variations as $id => $variation) {
            $varId = 'var_' . $id;
            $this->labels[$varId] = $variation->get('name');

            $list[$varId] = [];
            foreach ($this->dates as $date) {
                $list[$varId][$date] = 0;
            }
        }

        return $list;
    }

    /**
     * Transform the xPDOObject derivative to an array;
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object): array
    {
        return $object->toArray('', false, true);
    }

    public function outputArray(array $array, $count = false) {
        if ($count === false) {
            $count = count($array);
        }

        $output = json_encode([
            'success' => true,
            'total' => $count,
            'results' => $array,
            'dates' => $this->dates,
            'labels' => $this->labels,
        ], JSON_INVALID_UTF8_SUBSTITUTE);

        if ($output === false) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'Processor failed creating output array due to JSON error '.json_last_error());
            return json_encode(['success' => false]);
        }
        return $output;
    }
}
return 'StatsGetListProcessor';
