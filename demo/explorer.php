<?php

if (file_exists('../vendor/autoload.php')) {
    include '../vendor/autoload.php';
} else {
    //to be run in the vendor directory
    include '../../../../vendor/autoload.php';
}

use isidoro\jstree\filesystem\JstreeFileSystem;
use isidoro\jstree\filesystem\JstreeConfig;

$config = new JstreeConfig(array('basePath' => '../defaultPathForData/')); //can throw exceptions

//filtering on extension
//$config->setExtensionsToShowFromList('cpp;txt');

//to avoid showing directories
//$config->setShowDirectories(false);

//to avoid showing files
//$config->setShowFiles(false);


$path = ''; //demanded path.
if (isset($_GET['path'])) {
    $path = $_GET['path'];
}

header('Content-Type: application/json');
echo (new JstreeFileSystem($path, $config))->getList();

/**
 * Meaning:
 * explorer the path  = $config->getBasePath() . $path, and get in the json format for jstree plugin
 */