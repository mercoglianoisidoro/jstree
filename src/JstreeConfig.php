<?php

namespace isidoro\jstree\filesystem;

class JstreeConfig {

//TODO:      * filterRegex = regex to filter name file


    private $basePath = '../defaultPathForData/';
    private $errorMessage = ''; //used during validation
    private $showDirectories = true;
    private $showFiles = true;
    private $extensionsToShow = null;
    private $callbackToChangeNodesText = null;

    /**
     * Constructor
     * It needs an array, with min conf = array('basePath'=>'directory')
     * Other confs:
     * showDirectories = true/false (true default)
     * showFiles = true/false (true default)
     * extensionsToShow = list of file extensions to show (semi colon list separated; case insensitive)
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

            //basePath conf
            $this->setBasePath($inputData['basePath']); //the funcion check if valid path
            //showDirectories 
            if (array_key_exists('showDirectories', $inputData) && !$inputData['showDirectories']) {
                //means $inputData['showDirectories'] == false, otherwise true
                $this->setShowDirectories($inputData['showDirectories']);
            }

            //showFiles
            if (array_key_exists('showFiles', $inputData) && !$inputData['showFiles']) {
                //means $inputData['showFiles'] == false, otherwise true
                $this->setShowFiles($inputData['showFiles']);
            }

            //extensionsToShow
            if (array_key_exists('extensionsToShow', $inputData)) {
                $this->setExtensionsToShowFromList($inputData['extensionsToShow']);
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

    public function setCallbackToChangeNodesText(callable $changeText) {
        $this->callbackToChangeNodesText = $changeText;
        
    }
    public function getCallbackToChangeNodesText() {
        return $this->callbackToChangeNodesText;
    }
    
    public function isSetCallbackToChangeNodesText() {
         if (isset($this->callbackToChangeNodesText)){
            return true;
        }
        return false;
    }
    public function changeNodesText($text) {
        if (!isset($this->callbackToChangeNodesText)){
            return $text;
        }
        return call_user_func($this->callbackToChangeNodesText, $text);
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

    function getExtensionsToShow() {
        return $this->extensionsToShow;
    }

    /**
     * 
     * @param string Semi colon separated list of extensions file to show
     * @return \isidoro\jstree\filesystem\JstreeConfig
     */
    function setExtensionsToShowFromList($extensionsToShow) {
        if (!is_string($extensionsToShow)) {
            throw new \InvalidArgumentException('setExtensionsToShowFromList() accept only string values');
        }
        $this->extensionsToShow = explode(';', $extensionsToShow);
        return $this;
    }

    function setExtensionsToShow($extensionsToShow) {
        if (!is_array($extensionsToShow)) {
            throw new \InvalidArgumentException('setExtensionsToShow() accept only array values');
        }
        $this->extensionsToShow = $extensionsToShow;
        return $this;
    }

}
