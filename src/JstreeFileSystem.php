<?php

namespace isidoro\jstree\filesystem;

use Symfony\Component\Finder\Finder;
use isidoro\jstree\filesystem\JstreeConfig;

class JstreeFileSystem {

    private $finder; // Symfony\Component\Finder\Finder
    private $basePath = null;
    private $requestedPath = '';
    private $dataNode = array(); //represent the json for the response

    public function __construct($requestedPath = '', \isidoro\jstree\filesystem\JstreeConfig $jstreeConfig = null) {

        if ($jstreeConfig == null) {
            $jstreeConfig = new JstreeConfig();
        }

        $this->basePath = $jstreeConfig->getBasePath();
        $this->requestedPath = $requestedPath;
        $this->basePath .= $requestedPath;
        if (!is_dir($this->basePath)) {
            throw new \DomainException('the path (' . $this->basePath . ') is not a directory');
        }
        if (!@is_readable($this->basePath)) {
            throw new \DomainException('the path (' . $this->basePath . ') is not a readable');
        }

        $this->finder = new Finder();
        $this->finder->in($this->basePath);

        // access checks
        $basePathForSecurityChecks = realpath($jstreeConfig->getBasePath());
        $this->finder->filter(function (\SplFileInfo $file) use ($basePathForSecurityChecks) {

//            $t = $basePathForSecurityChecks.PHP_EOL;
//            $t2 = $file->getRealPath().PHP_EOL;
            if (strpos($file->getRealPath(), $basePathForSecurityChecks) === 0) {
                return true;
            } else {
                return false;
            }
        });
    }

    function getBasePath() {
        return $this->basePath;
    }

    function getRequestedPath() {
        return $this->requestedPath;
    }

    public function getList($width = 0) {

        $this->finder->depth($width)->sortByName();

        $found = $this->finder->directories();
        //directories first
        foreach ($this->finder->directories() as $file) {
            $this->dataNode[] = new NodeElement($this->requestedPath, $file);
        }

        $found = $this->finder->files();

        //files after
        foreach ($this->finder->files() as $file) {
            $this->dataNode[] = new NodeElement($this->requestedPath, $file);
        }
//        foreach ($this->dataNode as $value) {
//            echo $value->text.PHP_EOL;
//        }
        return json_encode($this->dataNode); //TODO: check se ok
    }

}
