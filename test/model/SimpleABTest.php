<?php
/**
 * Tests the SimpleAB class.
 */
class SimpleABTest extends PHPUnit_Framework_TestCase {
    /** @var SimpleAB $SimpleAB */
    protected $SimpleAB;
    /** @var modX $modx */
    protected $modx;

    protected function setUp() {
        global $modx;
        global $SimpleAB;

        $this->modx = $modx;
        $this->SimpleAB = $SimpleAB;
    }

    public function testIsProperObject() {
        $this->assertInstanceOf('SimpleAB', $this->SimpleAB);
        $this->assertInstanceOf('modX', $this->modx);
    }

    public function testHasValidConfigOptions() {
        $this->assertTrue(is_array($this->SimpleAB->config), 'config is not an array.');
        $this->assertNotEmpty($this->SimpleAB->config['basePath'], 'missing basePath config entry.');
        $this->assertNotEmpty($this->SimpleAB->config['corePath'], 'missing corePath config entry.');
        $this->assertNotEmpty($this->SimpleAB->config['modelPath'], 'missing modelPath config entry.');
        $this->assertNotEmpty($this->SimpleAB->config['processorsPath'], 'missing processorsPath config entry.');
        $this->assertNotEmpty($this->SimpleAB->config['elementsPath'], 'missing elementsPath config entry.');
        $this->assertNotEmpty($this->SimpleAB->config['templatesPath'], 'missing templatesPath config entry.');
        $this->assertNotEmpty($this->SimpleAB->config['assetsPath'], 'missing assetsPath config entry.');
        $this->assertNotEmpty($this->SimpleAB->config['assetsUrl'], 'missing assetsUrl config entry.');
        $this->assertNotEmpty($this->SimpleAB->config['jsUrl'], 'missing jsUrl config entry.');
        $this->assertNotEmpty($this->SimpleAB->config['cssUrl'], 'missing cssUrl config entry.');
        $this->assertNotEmpty($this->SimpleAB->config['connectorUrl'], 'missing connectorUrl config entry.');
    }

    /**
     * @dataProvider providerPickOnePreviously
     *
     * @param $expected
     * @param $test
     * @param $variations
     * @param $userData
     *
     * @return void
     */
    public function testPickOnePreviously ($expected, $test, $variations, $userData) {
        $this->SimpleAB->considerPreviousPicks = true;

        /** @var $sabTest sabTest */
        $sabTest = $this->modx->newObject('sabTest');
        $sabTest->fromArray($test, '', true);

        $pick = $this->SimpleAB->pickOne($sabTest, $variations, $userData);
        $this->assertEquals('previous', $this->SimpleAB->lastPickDetails['mode']);
        $this->assertEquals($sabTest->get('id'), $this->SimpleAB->lastPickDetails['test']);
        $this->assertEquals($variations, $this->SimpleAB->lastPickDetails['variations']);
        $this->assertEquals($expected['id'], $this->SimpleAB->lastPickDetails['pick']);
        $this->assertEquals($expected, $pick);
    }

    /**
     * @return array
     */
    public function providerPickOnePreviously () {
        return array(
            array(
                array('id' => 'foo'),
                array('id' => 99999,'threshold' => 1000,'randomize' => 0,),
                array(
                    'foo' => array('id' => 'foo'),
                    'bar' => array('id' => 'bar'),
                    'dog' => array('id' => 'dog'),
                    'lalala' => array('id' => 'lalala'),
                ),
                array(
                    '_picked' => array(99999 => 'foo')
                )
            ),
            array(
                array('id' => 'bar'),
                array('id' => 999999,'threshold' => 1000,'randomize' => 0,),
                array(
                    'foo' => array('id' => 'foo'),
                    'bar' => array('id' => 'bar'),
                    'dog' => array('id' => 'dog'),
                    'lalala' => array('id' => 'lalala'),
                ),
                array(
                    '_picked' => array(999999 => 'bar')
                )
            ),
            array(
                array('id' => 'dog'),
                array('id' => 999990,'threshold' => 1000,'randomize' => 0,),
                array(
                    'foo' => array('id' => 'foo'),
                    'bar' => array('id' => 'bar'),
                    'dog' => array('id' => 'dog'),
                    'lalala' => array('id' => 'lalala'),
                ),
                array(
                    '_picked' => array(999990 => 'dog')
                )
            ),
            array(
                array('id' => 'lalala'),
                array('id' => 9990,'threshold' => 1000,'randomize' => 0,),
                array(
                    'foo' => array('id' => 'foo'),
                    'bar' => array('id' => 'bar'),
                    'dog' => array('id' => 'dog'),
                    'lalala' => array('id' => 'lalala'),
                ),
                array(
                    '_picked' => array(9990 => 'lalala')
                )
            ),
        );
    }

    public function testPickOneUseRandom () {
        $this->SimpleAB->considerPreviousPicks = false;

        /** @var $test sabTest */
        $test = $this->modx->newObject('sabTest');
        $test->fromArray(array(
            'id' => 123,
            'threshold' => 1000,
            'randomize' => 0
        ), '', true);

        $userData = $this->SimpleAB->getUserData();
        $variations = array(
            'foo' => array('id' => 'foo'),
            'bar' => array('id' => 'bar'),
            'dog' => array('id' => 'dog'),
            'lalala' => array('id' => 'lalala'),
        );

        $this->SimpleAB->pickOne($test, $variations, $userData);
        $this->assertEquals('random', $this->SimpleAB->lastPickDetails['mode']);
    }

    /**
     * @dataProvider providerPickOneRandomly
     *
     * @param $expected
     * @param $threshold
     * @param $conversions
     * @param $randomizePercentage
     */
    public function testPickOneRandomly($expected, $threshold, $conversions, $randomizePercentage) {
        $this->assertEquals($expected,
            $this->SimpleAB->pickOneRandomly($threshold, $conversions, $randomizePercentage));
    }

    /**
     * @return array
     */
    public function providerPickOneRandomly() {
        return array(
            array(true, 100, 50, 50),
            array(false, 50, 100, 0),
            array(true, 100, 50, 0),
            array(true, 50, 100, 100),
        );
    }

    public function testGetUserData() {
        $uData = $this->SimpleAB->getUserData();
        $this->assertInternalType('array', $uData);
        $this->assertArrayHasKey('_picked', $uData);
    }
}
