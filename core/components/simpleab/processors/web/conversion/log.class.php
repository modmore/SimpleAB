<?php
/**
 * Gets a list of sabConversion objects.
 */
class sabWebConversionLogProcessor extends modProcessor {
    /**
     * @return array|string
     */
    public function process() {
        $tests = $this->getProperty('tests');
        $resetPick = (bool)$this->getProperty('resetPick', true);

        if (empty($tests)) {
            return $this->failure('Required parameter "tests" not specified.');
        }
        $this->modx->simpleab->registerConversion($tests, $resetPick);
        return $this->success();
    }

    /**
     * Return a success message from the processor.
     * @param string $msg
     * @param mixed $object
     * @return array|string
     */
    public function success($msg = '',$object = null) {
        return $this->modx->toJSON(array('success' => true, 'message' => $msg));
    }

    /**
     * Return a failure message from the processor.
     * @param string $msg
     * @param mixed $object
     * @return array|string
     */
    public function failure($msg = '',$object = null) {
        return $this->modx->toJSON(array('success' => false, 'message' => $msg));
    }
}
return 'sabWebConversionLogProcessor';
