<?php
require_once 'PHPUnit/Framework.php';
require_once(dirname(__FILE__).'/../../config.php');
require_once dirname(__FILE__).'/../../lib/Pandra.class.php';

/**
 * Test class for Pandra.
 * Generated by PHPUnit on 2010-01-09 at 11:52:23.
 */
class PandraTest extends PHPUnit_Framework_TestCase {
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * To test multiple nodes, add their connection strings here
     *
     * @access protected
     */
    protected function setUp() {
        Pandra::connect('default', 'localhost');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
        Pandra::disconnect('default');
    }

    /**
     * Get a modes list
     */
    public function testSupportedModes() {
        $modes = Pandra::getSupportedModes();
        $this->assertTrue(is_array($modes) && !empty($modes));
    }

    /**
     * Set Read Mode
     */
    public function testSetReadMode() {
        $supportedModes = Pandra::getSupportedModes();
        foreach ($supportedModes as $mode) {
            Pandra::setReadMode($mode);
            $this->assertEquals(Pandra::getReadMode(), $mode);
       }
    }

    /**
     * Set Write Mode
     */
    public function testSetWriteMode() {
        $supportedModes = Pandra::getSupportedModes();
        foreach ($supportedModes as $mode) {
            Pandra::setWriteMode($mode);
            $this->assertEquals(Pandra::getWriteMode(), $mode);
       }
    }

    /**
     * Set active node to named 'default', as well as unknown 'NOP'
     */
    public function testSetActiveNode() {
        $this->assertTrue(Pandra::setActiveNode('default'));
        $this->assertFalse(Pandra::setActiveNode('NOP'));
    }

    /**
     * @todo Implement testDisconnect().
     */
    public function testDisconnect() {
        $this->assertTrue(Pandra::disconnect('default'));
    }

    /**
     * Disconnect all nodes
     */
    public function testDisconnectAll() {
        $this->assertTrue(Pandra::disconnectAll());
    }

    /**
     * Connect to a good and bad host
     */
    public function testConnect() {
        $this->assertTrue(Pandra::connect('default', 'localhost'));
        $this->assertFalse(Pandra::connect('default_BAD', 'ih-opethishostdoesntexist'));
    }

    /**
     * Get client for all supported modes
     */
    public function testGetClient() {
        $supportedModes = Pandra::getSupportedModes();
        foreach ($supportedModes as $mode) {
            Pandra::setReadMode($mode);
            $client = Pandra::getClient();
            $this->assertEquals(get_class($client), 'CassandraClient', "Bad Client (mode $mode)");
       }
    }

    /**
     * Describe a named keyspace
     */
    public function testGetKeyspace() {
        $ks = Pandra::getKeyspace('Keyspace1');

        $this->assertTrue(is_array($ks) && !empty($ks));

        // While we don't care about the individual ColumnFamilies, we should
        // at least be able to pull out their basic attributes
        $expectedKeys = array('FlushPeriodInMinutes', 'Type', 'Desc');

        foreach ($ks as $columnFamily => $attributes) {
            $diff = array_diff($expectedKeys, array_keys($attributes    ));
            $this->assertTrue(empty($diff));
        }
    }

    /**
     * @todo Implement testLoadConfigXML().
     */
    public function testLoadConfigXML() {
        $config = Pandra::loadConfigXML();
        $this->assertTrue(get_class($config) == 'SimpleXMLElement');
    }

    /**
     * @todo
     */
    public function testGetCFSlice() {
    }

    /**
     * @todo
     */
    public function testDeleteColumnPath() {
    }

    /**
     * @todo
     */
    public function testSaveColumnPath() {
    }

}
?>