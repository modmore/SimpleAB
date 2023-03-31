<?php
/**
 * Gets a list of sabConversion objects.
 */
class sabVariationPreviewProcessor extends modProcessor {

    /**
     * @return array|string
     */
    public function process() {
        $resource = (int)$this->getProperty('resource');
        $test = (int)$this->getProperty('test');
        $variation = (int)$this->getProperty('id');

        if ($resource > 0) {
            $url = $this->modx->makeUrl($resource, '', [], 'full');
            return $this->success('', [
                'url' => $url,
                'sabTest' => $test,
                'sabVariation' => $variation,
            ]);
        }

        return $this->failure('Please select a resource.');
    }
}
return 'sabVariationPreviewProcessor';
