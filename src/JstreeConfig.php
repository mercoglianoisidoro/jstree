<?php

namespace isidoro\jstree\filesystem;

class JstreeConfig {

//    private $basePath = null;
//    private $basePath = '../defaultPathForData';
    private $basePath = '../';
    private $errorMessage = ''; //used during validation

    public function __construct($inputData = null) {

        if (is_array($inputData) && !array_key_exists('basePath', $inputData)) {
            throw new \InvalidArgumentException("input data doesn't containt basePath");
        }

        if (is_array($inputData)) {

            $this->setBasePath($inputData['basePath']);
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

}
