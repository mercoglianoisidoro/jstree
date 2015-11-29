<?php

namespace isidoro\jstree\test;

use isidoro\jstree\filesystem\JstreeFileSystem;
use isidoro\jstree\filesystem\JstreeConfig;

class JstreeFileSystemTest extends \PHPUnit_Framework_TestCase {

    private static $dataPath = null;
    private static $jstreeConfig = null;

    public static function setUpBeforeClass() {
        static::$dataPath = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
        static::$jstreeConfig = new JstreeConfig(array('basePath' => static::$dataPath));
    }

    public function setUp() {

        if (!is_dir(static::$dataPath . 'empty_dir')) {
            mkdir(static::$dataPath . 'empty_dir'); //to avoid empty dir in git
        }
        
        $dir2 = static::$dataPath . 'multiple_files/empty_dir';
         if (!is_dir($dir2)) {
            mkdir($dir2); //to avoid empty dir in git
        }
    }

    /**
     * Test constructor
     */
    public function testConstructor_with_config() {

        $jstreeFileSystem = new JstreeFileSystem('multiple_files', static::$jstreeConfig);
        $this->assertEquals(static::$dataPath . 'multiple_files', $jstreeFileSystem->getBasePath());
        $this->assertEquals('multiple_files', $jstreeFileSystem->getRequestedPath());
    }

    /**
     * @expectedException DomainException
     */
    public function testConstructor_exception() {

        $jstreeFileSystem = new JstreeFileSystem('single_file' . DIRECTORY_SEPARATOR . 'ciao.txt', static::$jstreeConfig);
    }

    public function testGetList1() {

        $jstreeFileSystem = new JstreeFileSystem('', static::$jstreeConfig);
        $jsonResult = $jstreeFileSystem->getList();
        $arrayResul = json_decode($jsonResult, true);
        $this->assertCount(5, $arrayResul);
    }

    public function testGetList1_with_filter_on_extension_files() {
  
        $confs = new JstreeConfig(array('basePath' => static::$dataPath,
            'extensionsToShow' => 'php',
        ));
        $jstreeFileSystem = new JstreeFileSystem('', $confs);
        $jsonResult = $jstreeFileSystem->getList();
        $arrayResul = json_decode($jsonResult, true);
        $this->assertCount(4, $arrayResul);
    }

    

    public function testGetList2() {

        $jstreeFileSystem = new JstreeFileSystem('empty_dir', static::$jstreeConfig);
        $jsonResult = $jstreeFileSystem->getList();
        $arrayResul = json_decode($jsonResult, true);

        $this->assertCount(0, $arrayResul);
    }

    public function testGetList_onlyDirectoies() {
        $confs = array('basePath' => static::$dataPath,
            'showFiles' => false);
        $jstreeFileSystem = new JstreeFileSystem('', new JstreeConfig($confs));
        $jsonResult = $jstreeFileSystem->getList();
        $arrayResul = json_decode($jsonResult, true);
        $this->assertCount(3, $arrayResul);
    }

    public function testGetList_onlyDirectoies2() {
        $confs = array('basePath' => static::$dataPath,
            'showFiles' => false);
        $jstreeFileSystem = new JstreeFileSystem('multiple_files', new JstreeConfig($confs));
        $jsonResult = $jstreeFileSystem->getList();
        $arrayResul = json_decode($jsonResult, true);
        $this->assertCount(2, $arrayResul);
    }

    public function testGetList_onlyFiles() {
        $confs = array('basePath' => static::$dataPath,
            'showDirectories' => false);
        $jstreeFileSystem = new JstreeFileSystem('', new JstreeConfig($confs));
        $jsonResult = $jstreeFileSystem->getList();
        $arrayResul = json_decode($jsonResult, true);
        $this->assertCount(2, $arrayResul);
    }
    
    
    public function testGetList_changeName_by_provided_callback() {
        
        $confs = array('basePath' => static::$dataPath,
            'showDirectories' => false);
        
        $jstreeConfs = new JstreeConfig($confs);
        
        $jstreeFileSystem = new JstreeFileSystem('', $jstreeConfs);
        $jsonResult = $jstreeFileSystem->getList();
        $arrayResul = json_decode($jsonResult, true);
        $this->assertCount(2, $arrayResul);
        $this->assertEquals('file.php', $arrayResul[0]['text']);
        
        
        $jstreeConfs->setCallbackToChangeNodesText(function ($test){
            return substr($test, 3);
        });        
        $jstreeFileSystem = new JstreeFileSystem('', $jstreeConfs);
        $jsonResult = $jstreeFileSystem->getList();
        $arrayResul = json_decode($jsonResult, true);
        $this->assertCount(2, $arrayResul);
        $this->assertEquals('e.php', $arrayResul[0]['text']); //now the name must be changed
        
        
    }

    

    public function testGetList3() {

        $jstreeFileSystem = new JstreeFileSystem('single_file', static::$jstreeConfig);
        $jsonResult = $jstreeFileSystem->getList();
        $arrayResul = json_decode($jsonResult, true);

        $this->assertCount(1, $arrayResul);
        $this->assertEquals('ciao.txt', $arrayResul[0]['text']);
        $this->assertEquals(false, $arrayResul[0]['children']);
        $this->assertEquals('jstree-file', $arrayResul[0]['icon']);
    }

    public function testGetList4_security_checks() {

        $jstreeFileSystem = new JstreeFileSystem('../../', static::$jstreeConfig);
        $jsonResult = $jstreeFileSystem->getList();
        $arrayResul = json_decode($jsonResult, true);
        $this->assertCount(0, $arrayResul);
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
