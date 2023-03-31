<?php
/**
 * Gets a list of sabConversion objects.
 */
class getNormalizedStatsGetListProcessor extends modProcessor {
    protected array $picks = [];
    protected array $conversions = [];
    protected array $dates = [];
    protected array $labels = [];

    public function initialize()
    {
        $init = parent::initialize();

        $corePath = $this->modx->getOption('simpleab.core_path', null, $this->modx->getOption('core_path') . 'components/simpleab/');

        /** @var modProcessorResponse $picksProcessor */
        $picksProcessor = $this->modx->runProcessor('mgr/tests/stats/picks', ['test' => $this->getProperty('test')], [
            'processors_path' => $corePath . 'processors/'
        ]);
        if (!($picksProcessor instanceof modProcessorResponse)) {
            return $this->failure('No processor response getting picks' . $corePath);
        }
        $response = json_decode($picksProcessor->getResponse(), true);
        $this->picks = $response['results'];
        $this->dates = $response['dates'];
        $this->labels = $response['labels'];

        /** @var modProcessorResponse $conversionsProcessor */
        $conversionsProcessor = $this->modx->runProcessor('mgr/tests/stats/conversions', ['test' => $this->getProperty('test')], [
            'processors_path' => $corePath . 'processors/'
        ]);
        if (!($conversionsProcessor instanceof modProcessorResponse)) {
            return $this->failure('No processor response getting conversions' . $corePath);
        }
        $response = json_decode($conversionsProcessor->getResponse(), true);
        $this->conversions = $response['results'];

        return $init;
    }


    /**
     * {@inheritdoc}
     */
    public function process()
    {
        $data = [
            'results' => [],
            'dates' => $this->dates,
            'labels' => $this->labels,
        ];

        foreach ($this->picks as $varId => $picks) {
            $data['results'][$varId] = [];

            foreach ($picks as $date => $pickCount) {
                $conversionCount = $this->conversions[$varId][$date];

                // If we have numbers to work with, get percentage.
                if ($conversionCount > 0 && $pickCount > 0) {
                    $data['results'][$varId][$date] = number_format($conversionCount / $pickCount * 100, 2);
                }
                else {
                    $data['results'][$varId][$date] = 0;
                }
            }
        }

        return $this->outputArray($data, count($data['dates']));
    }

    public function outputArray(array $array, $count = false) {
        if ($count === false) {
            $count = count($array);
        }

        $output = json_encode([
            'success' => true,
            'total' => $count,
            'results' => $array['results'],
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
return 'getNormalizedStatsGetListProcessor';
