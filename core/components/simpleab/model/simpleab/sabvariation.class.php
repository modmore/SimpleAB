<?php
/**
 * SimpleAB
 *
 * Copyright 2011-2013 by Mark Hamstra <support@modmore.com>
 *
 * This file is part of SimpleAB.
 *
 * For license terms, please review core/components/simpleab/docs/license.txt.
 *
*/
class sabVariation extends xPDOSimpleObject {
    public function clearCache() {
        $cacheOptions = $this->xpdo->simpleab->cacheOptions;
        $testId = $this->get('test');

        $this->xpdo->cacheManager->delete("tests/{$testId}/stats", $cacheOptions);
        $this->xpdo->cacheManager->delete("tests/{$testId}/variations", $cacheOptions);
    }

    /**
     * {@inheritdoc}
     *
     * @param null $cacheFlag
     *
     * @return bool
     */
    public function save($cacheFlag= null) {
        $return = parent::save($cacheFlag);
        $this->clearCache();
        return $return;
    }

    /**
     * {@inheritdoc}
     *
     * @param null $cacheFlag
     *
     * @return bool
     */
    public function remove (array $ancestors = array()) {
        $return = parent::remove($ancestors);
        $this->clearCache();
        return $return;
    }
}
