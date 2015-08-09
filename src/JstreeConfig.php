<?php

namespace isidoro\jstree\filesystem;

class JstreeConfig {

    private $basePath = '../defaultPathForData/';
    private $errorMessage = ''; //used during validation
    private $showDirectories = true;
    private $showFiles = true;

    /**
     * Constructor
     * It needs an array, with min conf = array('basePath'=>'directory')
     * Other confs:
     * showDirectories = true/false (true default)
     * $showFiles = true/false (true default)
     * 
     * 
     * @param array array for input data.
     * @return \isidoro\jstree\filesystem\JstreeConfig
     * @throws \InvalidArgumentException in case no minimal conf provided
     */
    public function __construct($inputData = null) {

        //check for $inputData array
        if (is_array($inputData) && !array_key_exists('basePath', $inputData)) {
            throw new \InvalidArgumentException("input data doesn't containt basePath");
        }

        if (is_array($inputData)) {
            $this->setBasePath($inputData['basePath']); //the funcion check if valid path
        }

        if (is_array($inputData)) {
            if (array_key_exists('showDirectories', $inputData) && !$inputData['showDirectories']) {
                //means $inputData['showDirectories'] == false
                $this->setShowDirectories(false);
            }
            if (array_key_exists('showFiles', $inputData) && !$inputData['showFiles']) {
                //means $inputData['showFiles'] == false
                $this->setShowFiles(false);
            }
        }
        return $this;
    }

    public function getBasePath() {
        return $this->basePath;
    }

    public function setBasePath($basePath) {
        $this->isValidPath($basePath);
        $this->basePath = $basePath;
        return $this;
    }

    /**
     * Check for the path
     * @param string $basePath
     * @return \isidoro\jstree\filesystem\JstreeConfig
     * @throws \DomainException in case path not valid (not readable or it's not a directory). 
     */
    public function isValidPath($basePath) {

        if (!is_readable($basePath)) {
            throw new \DomainException(
            "JstreeConfig not valid ( path not readable )");
        }
        if (!is_dir($basePath)) {
            throw new \DomainException(
            "JstreeConfig not valid ( the provided path is not a directory)");
        }

        return $this;
    }

    //others getters and setters

    function getShowDirectories() {
        return $this->showDirectories;
    }

    function getShowFiles() {
        return $this->showFiles;
    }

    function setShowDirectories($showDirectories) {
        if (!is_bool($showDirectories)) {
            throw new \InvalidArgumentException('setShowDirectories() accept only boolean values');
        }
        $this->showDirectories = $showDirectories;
        return $this;
    }

    function setShowFiles($showFiles) {
        if (!is_bool($showFiles)) {
            throw new \InvalidArgumentException('setShowFiles() accept only boolean values');
        }
        $this->showFiles = $showFiles;
        return $this;
    }

}
