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

    public $lastPickDetails = array();


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
            
            'randomThreshold' => $this->modx->getOption('simpleab.random_threshold', null, 100),
            'randomPercentage' => $this->modx->getOption('simpleab.random_percentage', null, 25),
        ),$config);

        $modelpath = $this->config['model_path'];
        $this->modx->addPackage('simpleab',$modelpath);
        $this->modx->lexicon->load('simpleab:default');
        
        $this->debug = $this->modx->getOption('simpleab.debug',null,false);
    }

    /**
     * @return array
     */
    public function getUserData() {
        $data = array();

        if (isset($_SESSION['_simpleab'])) {
            $data = $_SESSION['_simpleab'];
        } else {
            $_SESSION['_simpleab'] = array();
        }

        return $data;
    }

    /**
     * @todo Implement this method.
     * @param $key
     *
     * @return array
     */
    public function getHistoricData($key) {
        return array();
    }


    /**
     * Picks one of the supplied array of options to display.
     *
     * Makes sure that if the user has previously been shown an option for this key before, it will show the same.
     *
     * @see self._pickOneHistorically
     * @see self._pickOneRandomly
     *
     * @param $key
     * @param array $options
     * @param array $userData
     * @param array $historicData
     *
     * @return mixed
     */
    public function pickOne ($key, array $options = array(), array $userData = array(), array $historicData = array()) {
        $theOne = false;
        /**
         * Check if we have picked something for this element already for this user. If we did, we'll want to
         * show them the same one.
         */
        if (array_key_exists('_picked', $userData) && array_key_exists($key, $userData['_picked'])) {
            $previous = $userData['_picked'][$key];
            // Make sure the previously chosen one is still an option..
            if (in_array($previous, $options)) {
                $theOne = $previous;
                $this->lastPickDetails = array(
                    'mode' => 'previous',
                    'key' => $key,
                    'data' => $userData['_picked'],
                    'result' => $theOne,
                );
            }
        }

        /**
         * If we didn't get a previous pick, we'll have to do some logic to get one.
         */
        if (!$theOne) {
            // Check if we can pick it randomly, by matching the total historic conversions
            // to the threshold.
            $random = $historicData['total'] <= $this->config['randomThreshold'];
            if (!$random) {
                // If we're past the threshold, we see if we need to do it randomly
                // anyway, as part of the randomPercentage "sanity check".
                $randomChance = rand(0,100);
                if ($randomChance < $this->config['randomPercentage']) {
                    $random = true;
                }
            }

            // Yay, we can do it randomly!
            if ($random) {
                $theOne = array_rand($options);
                $this->lastPickDetails = array(
                    'mode' => 'random',
                    'key' => $key,
                    'data' => null,
                    'result' => $theOne,
                );
            }

            // No randomness involved - perform some statistical stuff and pick the best option.
            else {
                // @todo implement this
                $theOne = null;
            }
        }
        return $theOne;
    }
}

