<?php

namespace isidoro\jstree\filesystem;

use Symfony\Component\Finder\Finder;

class NodeElement {

    //data to be serialized
    //public to be taken in account by json serialize
    public $text;
    public $id; //path from root
    public $children = false;
    public $icon; //for jstree represent the class to be applied or the sctring with the icon file 
    //private data
    private $type;
    private $requestedPath;

    public function __construct($requestedPath = '', \Symfony\Component\Finder\SplFileInfo $splFileInfo = null) {
        if (isset($splFileInfo)) {
            $this->createFromPathAndSplInfo($requestedPath, $splFileInfo);
        }//else can be made afterwords (to use always the same instance and reset it)
    }

    public function setRequestedPath($requestedPath) {
        //TODO: verify access
        $this->requestedPath = $requestedPath;
        return $this;
    }

    public function getRequestedPath() {

        return $this->requestedPath;
    }

    public function createFromPathAndSplInfo($requestedPath, \Symfony\Component\Finder\SplFileInfo $splFileInfo) {

        $this->setRequestedPath($requestedPath);

        /* @var $splFileInfo \Symfony\Component\Finder\SplFileInfo */
        $this->setText($splFileInfo->getBasename());
        $this->setId($requestedPath . '/' . $splFileInfo->getBasename());

        if ($splFileInfo->isFile()) {
            $this->setIcon('jstree-file');
            $this->setChildren(false);
        } else {

//            $fileInDir = scandir($splFileInfo->getPathname());
            if (count(scandir($splFileInfo->getPathname())) > 2) {
                $this->setChildren(true);
            } else {
                $this->setChildren(false);
            }

            $this->setIcon('jstree-folder');
        }
    }

    //getters


    function getId() {
        return $this->id;
    }

    function getText() {
        return $this->text;
    }

    function getChildren() {
        return $this->children;
    }

    function getType() {
        return $this->type;
    }

    function getIcon() {
        return $this->icon;
    }

    //setters

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setIcon($icon) {
        $this->icon = $icon;
        return $this;
    }

    function setText($text) {
        $this->text = $text;
        return $this;
    }

    function setChildren($children) {
        $this->children = $children;
        return $this;
    }

    function setType($type) {
        $this->type = $type;
        return $this;
    }

}
