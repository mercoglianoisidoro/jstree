<?php

namespace isidoro\jstree\filesystem;

use Symfony\Component\Finder\Finder;
use isidoro\jstree\filesystem\JstreeConfig;

class JstreeFileSystem {

    private $finder; // Symfony\Component\Finder\Finder
    private $basePath = null;
    private $requestedPath = '';
    private $dataNode = array(); //represent the json for the response

    /**
     * 
     * @param type path to explore (using the base path set in the configs as root)
     * @param JstreeConfig configurations
     * @throws \DomainException in case of problem for the demanded path
     */

    public function __construct($requestedPath = '', \isidoro\jstree\filesystem\JstreeConfig $jstreeConfig = null) {

        if ($jstreeConfig == null) {
            $jstreeConfig = new JstreeConfig(); //defaults
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

    /**
     * Get the list of the directory contents in the  json format readable by jstree plugin
     * @return json format for jstree plugin 
     * @throws LogicException
     */
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

        $result = json_encode($this->dataNode);

        if ($result !== false) {
            return $result;
        } else {
            throw new LogicException('impossible to decode data');
        }
    }

}
