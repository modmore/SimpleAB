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

        /** Specifics for SimpleAB */
        $this->assertNotEmpty($this->SimpleAB->config['randomThreshold'], 'missing randomThreshold config entry.');
        $this->assertInternalType('integer', $this->SimpleAB->config['randomThreshold']);
        $this->assertGreaterThan(0, $this->SimpleAB->config['randomThreshold']);

        $this->assertNotEmpty($this->SimpleAB->config['randomPercentage'], 'missing randomPercentage config entry.');
        $this->assertInternalType('integer', $this->SimpleAB->config['randomPercentage']);
        $this->assertGreaterThan(0, $this->SimpleAB->config['randomPercentage']);
        $this->assertLessThan(100, $this->SimpleAB->config['randomPercentage']);
    }

    /**
     * @dataProvider providerPickOnePreviously
     *
     * @param $expected
     * @param $key
     * @param $options
     * @param $userData
     */
    public function testPickOnePreviously ($expected, $key, $options, $userData) {
        $this->assertEquals($expected, $this->SimpleAB->pickOne($key, $options, $userData));
        $this->assertEquals('previous', $this->SimpleAB->lastPickDetails['mode']);
    }

    /**
     * @return array
     */
    public function providerPickOnePreviously () {
        return array(
            array('foo', 'uniquekey', array('bar','foo','dog'),array('_picked' => array('uniquekey' => 'foo') ) ),
            array('bar', 'uniquekey', array('bar','foo','dog'),array('_picked' => array('uniquekey' => 'bar') ) ),
            array('dog', 'uniquekey', array('bar','foo','dog'),array('_picked' => array('uniquekey' => 'dog') ) ),
        );
    }
}
