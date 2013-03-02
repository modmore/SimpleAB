<?php
/**
 * SimpleAB
 *
 * Copyright 2011 by Mark Hamstra <hello@markhamstra.com>
 *
 * This file is part of SimpleAB.
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
 * @package simpleab
*/

class SimpleAB {
    /** @var \modX $modx */
    public $modx;
    /** @var array Array of configuration options, primarily paths. */
    public $config = array();

    public $debug = false;

    public $considerPreviousPicks = true;

    public $lastPickDetails = array();

    public $cacheOptions = array(
        xPDO::OPT_CACHE_KEY => 'simpleab',
    );

    protected $_defaultSession = array(
        '_picked' => array(),
    );


    /**
     * @param \modX $modx
     * @param array $config
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $basePath = $this->modx->getOption('simpleab.core_path',$config,$this->modx->getOption('core_path').'components/simpleab/');
        $assetsUrl = $this->modx->getOption('simpleab.assets_url',$config,$this->modx->getOption('assets_url').'components/simpleab/');
        $assetsPath = $this->modx->getOption('simpleab.assets_path',$config,$this->modx->getOption('assets_path').'components/simpleab/');
        $this->config = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'processorsPath' => $basePath.'processors/',
            'elementsPath' => $basePath.'elements/',
            'templatesPath' => $basePath.'templates/',
            'assetsPath' => $assetsPath,
            'assetsUrl' => $assetsUrl,
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'connectorUrl' => $assetsUrl.'connector.php',
        ),$config);

        $this->modx->lexicon->load('simpleab:default');

        $modelPath = $this->config['modelPath'];
        $this->modx->addPackage('simpleab',$modelPath);
        $this->modx->loadClass('sabConversion', $modelPath.'simpleab/');
        $this->modx->loadClass('sabTest', $modelPath.'simpleab/');
        $this->modx->loadClass('sabVariation', $modelPath.'simpleab/');
        $this->modx->loadClass('sabPick', $modelPath.'simpleab/');

        $this->debug = $this->modx->getOption('simpleab.debug',null,false);
    }

    /**
     * @return array
     */
    public function getUserData() {
        if (isset($_SESSION['_simpleab'])) {
            $data = $_SESSION['_simpleab'];
        }
        else {
            $data = $_SESSION['_simpleab'] = $this->_defaultSession;
        }
        return $data;
    }

    /**
     * Picks one of the supplied array of options to display.
     *
     * Makes sure that if the user has previously been shown an option for this key before, it will show the same.
     * Otherwise it will either pick randomly or with a bit of logic.
     *
     * @param sabTest $test
     * @param array $variations
     * @param array $userData
     *
     * @return mixed
     */
    public function pickOne (sabTest $test, array $variations = array(), array $userData = array()) {
        $testId = $test->get('id');
        $options = array_keys($variations);

        $theOne = false;
        $mode = '';

        $totalPicks = 0;
        foreach ($variations as $variation) {
            $totalPicks += $variation['picks'];
        }
        /**
         * Check if we have picked something for this element already for this user. If we did, we'll want to
         * show them the same one.
         */
        if ($this->considerPreviousPicks && array_key_exists('_picked', $userData) && array_key_exists($testId, $userData['_picked'])) {
            $previous = $userData['_picked'][$testId];
            // Make sure the previously chosen one is still an option..
            if (in_array($previous, $options)) {
                $theOne = $previous;
                $mode = 'previous';
            }
        }

        /**
         * If we didn't get a previous pick, we'll have to do some logic to get one.
         */
        if (!$theOne) {
            // Check if we can pick it randomly, by matching the total historic conversions
            // to the threshold.
            $random = $this->pickOneRandomly($test->get('threshold'), $totalPicks, $test->get('randomize'));

            // Yay, we can do it randomly!
            if ($random) {
                shuffle($options);
                $theOne = reset($options);
                $mode = 'random';
                $this->registerPick($testId, $theOne);
            }

            // No randomness involved - perform some smart stuff and pick the best option.
            else {
                // @todo implement this
                $mode = 'bestpick';
                $theOne = null;
                if (isset($this->modx->phpconsole)) $this->modx->phpconsole->send('Logical pick is not yet implemented for test ' . $testId);
            }
        }

        $this->lastPickDetails = array(
            'test' => $testId,
            'mode' => $mode,
            'options' => $options,
            'pick' => $theOne,
        );
        if (isset($variations[$theOne])) {
            return $variations[$theOne];
        }
        return null;
    }

    /**
     * @param $threshold
     * @param $conversions
     * @param $randomizePercentage
     *
     * @return bool
     */
    public function pickOneRandomly($threshold, $conversions, $randomizePercentage) {
        $random = ($conversions <= $threshold);
        if (!$random) {
            $randomChance = rand(0,100);
            if ($randomChance < $randomizePercentage) {
                $random = true;
            }
        }
        return $random;
    }

    /**
     * @param $key
     * @param $theOne
     */
    public function registerPick($key, $theOne) {
        /** Set the session */
        if (!isset($_SESSION['_simpleab'])) {
            $_SESSION['_simpleab'] = $this->_defaultSession;
        }
        $data =& $_SESSION['_simpleab'];
        $data['_picked'][$key] = $theOne;

        /** Log the pick in the database for stats. */
        $pick = $this->modx->newObject('sabPick');
        $pick->fromArray(array(
            'test' => $key,
            'variation' => $theOne,
            'date' => date('Ymd'),
        ));
        $pick->save();
    }
}

