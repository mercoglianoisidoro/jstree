<?php

namespace isidoro\jstree\test;

use isidoro\jstree\filesystem\JstreeConfig;

class JstreeConfigTest extends \PHPUnit_Framework_TestCase {

    private static $dataPath = null;

    public static function setUpBeforeClass() {
        static::$dataPath = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
    }

    public function setUp() {
        
    }

    /**
     * Test constructor
     */
    public function testConstructor() {

        $jstreeConfig = new JstreeConfig();
        $this->assertNotNull($jstreeConfig);
    }

    public function testConstructor_with_array() {

        $jstreeConfig = new JstreeConfig(array('basePath' => static::$dataPath));
        $this->assertNotNull($jstreeConfig);
    }

    /**
     * @expectedException DomainException
     * @expectedExceptionMessage JstreeConfig not valid ( the provided path is not a directory)
     */
    public function testConstructor_with_array_error_directory() {

        $jstreeConfig = new JstreeConfig(array('basePath' => static::$dataPath . 'single_file' . DIRECTORY_SEPARATOR . 'ciao.txt'));
        $this->assertNotNull($jstreeConfig);
    }

    /**
     * @expectedException DomainException
     * @expectedExceptionMessage JstreeConfig not valid ( path not readable )
     */
    public function testConstructor_error_basePath() {

        $jstreeConfig = new JstreeConfig(array('basePath' => null));
        $this->assertNotNull($jstreeConfig);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructor_error_conf_array() {

        $jstreeConfig = new JstreeConfig(array('NONONONON' => static::$dataPath));
        $this->assertNotNull($jstreeConfig);
    }

    public function testGetBasePath_after_setBasePath() {

        $jstreeConfig = new JstreeConfig();
        $jstreeConfig->setBasePath(static::$dataPath);
        $this->assertEquals(static::$dataPath, $jstreeConfig->getBasePath());
    }

    public function testGetBasePath_after_constructor() {
        $dataConfig = array('basePath' => static::$dataPath);
        $jstreeConfig = new JstreeConfig($dataConfig);
        $this->assertEquals(static::$dataPath, $jstreeConfig->getBasePath());
    }

    /**
     * @expectedException DomainException
     * @expectedExceptionMessage JstreeConfig not valid ( path not readable )
     */
    public function testgetBasePath_with_Exception() {

        $jstreeConfig = new JstreeConfig();
        $jstreeConfig->setBasePath('');
    }

    /**
     * Developpement usage
     * @param type $input
     */
    public function log($input) {
        echo PHP_EOL;
        echo '-----------------------------------------------';
        echo PHP_EOL;
        if (is_string($input)) {
            echo $input;
        } else {
            print_r($input);
        }
        echo PHP_EOL;
        echo '-----------------------------------------------';
        echo PHP_EOL;
    }

}
