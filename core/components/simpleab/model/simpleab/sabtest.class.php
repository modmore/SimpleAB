<?php
/**
 * SimpleAB
 *
 * Copyright 2011-2013 by Mark Hamstra <mark@modx.com>
 *
 * This file is part of SimpleAB
 *
 * SimpleAB is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * SimpleAB is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * SimpleAB; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
*/
class sabTest extends xPDOSimpleObject {
    protected $_variations = array();

    /**
     * @param $modx
     * @param $id
     *
     * @return array
     */
    public static function getTest(modX &$modx, $id) {
        $cacheKey = "tests/{$id}/details";

        $data = $modx->cacheManager->get($cacheKey, $modx->simpleab->cacheOptions);
        if (empty($data)) {
            $c = $modx->newQuery('sabTest');
            $c->where(array(
                'active' => true,
                'archived' => false,
                'id' => $id
            ));

            /** @var $test sabTest */
            $test = $modx->getObject('sabTest', $c);
            if ($test instanceof sabTest) {
                $data = $test->toArray();
                $modx->cacheManager->set($cacheKey, $data, 0, $modx->simpleab->cacheOptions);
                return $test;
            }
        }
        else {
            $test = $modx->newObject('sabTest');
            $test->fromArray($data, '', true);
            return $test;
        }
        return null;
    }


    /**
     * Gets variations (including stats from the past hour) for the test.
     *
     * @return array
     */
    public function getVariations() {
        if ($this->_variations) {
            return $this->_variations;
        }

        $cacheKey = "tests/{$this->get('id')}/variations";
        $variations = $this->xpdo->cacheManager->get($cacheKey, $this->xpdo->simpleab->cacheOptions);
        if (empty($variations)) {
            $variations = array();
            foreach ($this->getMany('Variations') as $variation) {
                /** @var sabVariation $variation */
                $variations[$variation->get('id')] = $variation->toArray();
            }
            $this->xpdo->cacheManager->set($cacheKey, $variations, 0, $this->xpdo->simpleab->cacheOptions);
        }


        $cacheKey = "tests/{$this->get('id')}/stats";
        $stats = $this->xpdo->cacheManager->get($cacheKey, $this->xpdo->simpleab->cacheOptions);
        if (empty($stats)) {
            $stats = array();

            foreach ($variations as $id => $values) {
                $stats[$id] = array(
                    'picks' => $this->xpdo->getCount('sabPick', array('test' => $this->get('id'), 'variation' => $id)),
                    'conversions' => $this->xpdo->getCount('sabConversion', array('test' => $this->get('id'), 'variation' => $id)),
                    'conversionrate' => 0,
                );
                if ($stats[$id]['conversions'] > 0) {
                    $stats[$id]['conversionrate'] = $stats[$id]['conversions'] / $stats[$id]['picks'];
                }
            }
            $this->xpdo->cacheManager->set($cacheKey, $stats, 3600, $this->xpdo->simpleab->cacheOptions);
        }

        foreach ($variations as $id => $variationValues) {
            $variationStats = (isset($stats[$id])) ? $stats[$id] : array();
            $this->_variations[$id] = array_merge($variationValues, $variationStats);
        }

        return $this->_variations;
    }

    public function clearCache() {
        $cacheOptions = $this->xpdo->simpleab->cacheOptions;
        $id = $this->get('id');

        $this->xpdo->cacheManager->delete("tests/{$id}/", $cacheOptions);
        $this->xpdo->cacheManager->delete("registry", $cacheOptions);
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
