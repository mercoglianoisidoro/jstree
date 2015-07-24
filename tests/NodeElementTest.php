<?php

namespace isidoro\jstree\test;

use isidoro\jstree\filesystem\NodeElement;

class NodeElementTest extends \PHPUnit_Framework_TestCase {

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

        $nodeElement = new NodeElement();
        $this->assertNotNull($nodeElement);
    }

    public function testConstructor_withSplFileInfo() {
        $splFileInfo = new \Symfony\Component\Finder\SplFileInfo(static::$dataPath . 'single_file/ciao.txt', null, null);
        $nodeElement = new NodeElement('data/single_file', $splFileInfo);

        $this->assertEquals('ciao.txt', $nodeElement->getText());
        $this->assertEquals('data/single_file/ciao.txt', $nodeElement->getId());
        $this->assertEquals('jstree-file', $nodeElement->getIcon());
        $this->assertFalse($nodeElement->getChildren());
    }

//    public function testConstructorWithRequestedPath()
//    {
//        $nodeElement  = new NodeElement(static::$dataPath);
//        $this->assertEquals(static::$dataPath, $nodeElement->getRequestedPath());
//    }


    public function testCreateFromPathAndSplInfo_withDirectory() {

        $splFileInfo = new \Symfony\Component\Finder\SplFileInfo(static::$dataPath . 'single_file', null, null);
        $nodeElement = new NodeElement();
        $jsonResult = $nodeElement->createFromPathAndSplInfo('data', $splFileInfo);

        $this->assertEquals('single_file', $nodeElement->getText());
        $this->assertEquals('data/single_file', $nodeElement->getId());
        $this->assertEquals('jstree-folder', $nodeElement->getIcon());
        $this->assertTrue($nodeElement->getChildren());
    }

    public function testCreateFromPathAndSplInfo_withEmptyDirectory() {

        $splFileInfo = new \Symfony\Component\Finder\SplFileInfo(static::$dataPath . 'empty_dir', null, null);
        $nodeElement = new NodeElement();
        $nodeElement->createFromPathAndSplInfo('data', $splFileInfo);

        $this->assertEquals('empty_dir', $nodeElement->getText());
        $this->assertEquals('data/empty_dir', $nodeElement->getId());
        $this->assertEquals('jstree-folder', $nodeElement->getIcon());
        $this->assertFalse($nodeElement->getChildren());
    }

    public function testCreateFromPathAndSplInfo_withFile() {

        $splFileInfo = new \Symfony\Component\Finder\SplFileInfo(static::$dataPath . 'single_file/ciao.txt', null, null);
        $nodeElement = new NodeElement();
        $nodeElement->createFromPathAndSplInfo('data/single_file', $splFileInfo);

        $this->assertEquals('ciao.txt', $nodeElement->getText());
        $this->assertEquals('data/single_file/ciao.txt', $nodeElement->getId());
        $this->assertEquals('jstree-file', $nodeElement->getIcon());
        $this->assertFalse($nodeElement->getChildren());
    }

    public function testRequestedPath() {
        $nodeElement = new NodeElement();
        $nodeElement->setRequestedPath(static::$dataPath);
        $this->assertEquals(static::$dataPath, $nodeElement->getRequestedPath());
    }

    public function testId() {
        $test = 'test';
        $nodeElement = new NodeElement();
        $nodeElement->setId($test);
        $this->assertEquals($test, $nodeElement->getId());
        $this->assertEquals($test, $nodeElement->id);
    }

    public function testText() {
        $test = 'test';
        $nodeElement = new NodeElement();
        $nodeElement->setText($test);
        $this->assertEquals($test, $nodeElement->getText());
        $this->assertEquals($test, $nodeElement->text);
    }

    public function testChildren() {
        $test = true;
        $nodeElement = new NodeElement();
        $nodeElement->setChildren($test);
        $this->assertEquals($test, $nodeElement->getChildren());
        $this->assertEquals($test, $nodeElement->children);
    }

    public function testType() {
        $test = 'test';
        $nodeElement = new NodeElement();
        $nodeElement->setType($test);
        $this->assertEquals($test, $nodeElement->getType());
    }

    public function testIcon() {
        $test = 'test';
        $nodeElement = new NodeElement();
        $nodeElement->setIcon($test);
        $this->assertEquals($test, $nodeElement->getIcon());
        $this->assertEquals($test, $nodeElement->icon);
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
