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

    public function testConstructor_with_simpleArray() {

        $jstreeConfig = new JstreeConfig(array('basePath' => static::$dataPath));
        $this->assertNotNull($jstreeConfig);
        $this->assertTrue($jstreeConfig->getShowDirectories());
        $this->assertTrue($jstreeConfig->getShowFiles());
    }

    public function testConstructor_withArray_showDirectories_option() {

        $jstreeConfig = new JstreeConfig(array('basePath' => static::$dataPath,
            'showDirectories' => false));
        $this->assertNotNull($jstreeConfig);
        $this->assertFalse($jstreeConfig->getShowDirectories());
        $this->assertTrue($jstreeConfig->getShowFiles());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructor_withArray_showDirectories__exception() {

        $jstreeConfig = new JstreeConfig(array('basePath' => static::$dataPath));
        $this->assertNotNull($jstreeConfig);
        $jstreeConfig->setShowDirectories('ciao');
    }

    public function testConstructor_withArray_showFiles_option() {

        $jstreeConfig = new JstreeConfig(array('basePath' => static::$dataPath,
            'showFiles' => false));
        $this->assertNotNull($jstreeConfig);
        $this->assertTrue($jstreeConfig->getShowDirectories());
        $this->assertFalse($jstreeConfig->getShowFiles());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructor_withArray_showFiles__exception() {

        $jstreeConfig = new JstreeConfig(array('basePath' => static::$dataPath));
        $this->assertNotNull($jstreeConfig);
        $jstreeConfig->setShowFiles('ciao');
    }

    /**
     * @expectedException DomainException
     * @expectedExceptionMessage JstreeConfig not valid ( the provided path is not a directory)
     */
    public function testConstructor_with_array_error_directory() {

        $jstreeConfig = new JstreeConfig(array('basePath' => static::$dataPath . 'single_file' . DIRECTORY_SEPARATOR . 'ciao.txt'));
        $this->assertNotNull($jstreeConfig);
    }

    public function testShowDirectories() {
        $jstreeConfig = new JstreeConfig();
        $this->assertTrue($jstreeConfig->getShowDirectories());
        $jstreeConfig->setShowDirectories(false);
        $this->assertFalse($jstreeConfig->getShowDirectories());
    }

    public function testShowFiles() {
        $jstreeConfig = new JstreeConfig();
        $this->assertTrue($jstreeConfig->getShowFiles());
        $jstreeConfig->setShowFiles(false);
        $this->assertFalse($jstreeConfig->getShowFiles());
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
     */
    public function test_configuration_extensionsToShow_in_constructor() {
        $dataConfig = array('basePath' => static::$dataPath,
            'extensionsToShow' => 'php'
        );
        $jstreeConfig = new JstreeConfig($dataConfig);
        $this->assertContains('php', $jstreeConfig->getExtensionsToShow());
    }

    public function test_configuration_extensionsToShow() {
        $dataConfig = array('basePath' => static::$dataPath);
        $jstreeConfig = new JstreeConfig($dataConfig);
        $jstreeConfig->setExtensionsToShow(array('php'));
        $this->assertContains('php', $jstreeConfig->getExtensionsToShow());
    }

    public function test_configuration_extensionsToShow2() {
        $dataConfig = array('basePath' => static::$dataPath);
        $jstreeConfig = new JstreeConfig($dataConfig);
        $jstreeConfig->setExtensionsToShowFromList('php');
        $this->assertContains('php', $jstreeConfig->getExtensionsToShow());
        $jstreeConfig->setExtensionsToShowFromList('php;txt');
        $this->assertContains('php', $jstreeConfig->getExtensionsToShow());
        $this->assertContains('txt', $jstreeConfig->getExtensionsToShow());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_configuration_extensionsToShow_error() {
        $dataConfig = array('basePath' => static::$dataPath);
        $jstreeConfig = new JstreeConfig($dataConfig);
        $jstreeConfig->setExtensionsToShow('php');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_configuration_extensionsToShow_error2() {
        $dataConfig = array('basePath' => static::$dataPath);
        $jstreeConfig = new JstreeConfig($dataConfig);
        $jstreeConfig->setExtensionsToShowFromList(array('php'));
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
