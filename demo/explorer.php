<?php



include '../vendor/autoload.php';

use isidoro\jstree\filesystem\JstreeFileSystem;
use isidoro\jstree\filesystem\JstreeConfig;


$config = new JstreeConfig(array('basePath'=>'../defaultPathForData/')); //can throw exceptions

$path = '';//demanded path.
if (isset($_GET['path'])){ 
    $path = $_GET['path'];
}

header('Content-Type: application/json');
echo (new JstreeFileSystem($path,$config))->getList();

/**
 * Meaning:
 * explorer the path  = $config->getBasePath() . $path, and get in the json format for jstree plugin
 */