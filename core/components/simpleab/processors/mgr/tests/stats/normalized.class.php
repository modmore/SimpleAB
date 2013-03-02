<?php
/**
 * Gets a list of sabConversion objects.
 */
class getNormalizedStatsGetListProcessor extends modProcessor {
    public $classKey = 'sabConversion';
    public $languageTopics = array('simpleab:default');
    public $defaultSortField = 'date';
    public $defaultSortDirection = 'ASC';

    /**
     * @return array|string
     */
    public function process() {
        $corePath = $this->modx->getOption('simpleab.core_path', null, $this->modx->getOption('core_path') . 'components/simpleab/');

        /** @var modProcessorResponse $picksProcessor */
        $picksProcessor = $this->modx->runProcessor('mgr/tests/stats/picks', array('test' => $this->getProperty('test')), array(
            'processors_path' => $corePath . 'processors/'
        ));
        if (!($picksProcessor instanceof modProcessorResponse)) {
            return $this->failure('No processor response getting picks' . $corePath);
        }
        $response = $this->modx->fromJSON($picksProcessor->getResponse());
        $picks = $response['results'];

        /** @var modProcessorResponse $conversionsProcessor */
        $conversionsProcessor = $this->modx->runProcessor('mgr/tests/stats/conversions', array('test' => $this->getProperty('test')), array(
            'processors_path' => $corePath . 'processors/'
        ));
        if (!($conversionsProcessor instanceof modProcessorResponse)) {
            return $this->failure('No processor response getting conversions' . $corePath);
        }
        $response = $this->modx->fromJSON($conversionsProcessor->getResponse());
        $conversions = $response['results'];


        /** Make sense of two separate, not per se in sync, data. */
        $data = array();
        foreach ($picks as $pick) {
            if (!isset($data[$pick['period']])) {
                $data[$pick['period']] = array(
                    'period' => $pick['period'],
                    'picks' => array(),
                    'conversions' => array(),
                    'rates' => array(),
                );
            }
            $data[$pick['period']]['picks'] = $pick;
        }
        foreach ($conversions as $conversion) {
            if (!isset($data[$conversion['period']])) {
                $data[$conversion['period']] = array(
                    'period' => $conversion['period'],
                    'picks' => array(),
                    'conversions' => array(),
                    'rates' => array(),
                );
            }
            $data[$conversion['period']]['conversions'] = $conversion;
        }

        /** Now calculate the conversion rates... */
        foreach ($data as $period => &$values) {
            foreach ($values['picks'] as $key => $pickCount) {
                if (in_array($key, array('id','period'))) continue;

                if ($pickCount > 0 && isset($values['conversions'][$key])) {
                    $values[$key] = round($values['conversions'][$key] / $pickCount * 100, 3) ;
                }
            }
        }

        return $this->outputArray(array_values($data));
    }
}
return 'getNormalizedStatsGetListProcessor';
