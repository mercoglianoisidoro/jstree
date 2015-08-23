<?php


include '../vendor/autoload.php';

use isidoro\jstree\filesystem\JstreeFileSystem;
use isidoro\jstree\filesystem\JstreeConfig;



$path = ''; //demanded path.
if (isset($_GET['path'])) {
    $path = $_GET['path'];
}


ini_set('display_errors', 'Off');
header('Content-Type: application/json');


try{

$config = new JstreeConfig(array('basePath' => '../defaultPathForData/')); //can throw exceptions
echo (new JstreeFileSystem($path, $config))->getList();

}catch(Exception $e){
        http_response_code(400); //bad request
        header("X-edera: Exception");
        echo json_encode($e);
}

/**
 * Meaning:
 * explorer the path  = $config->getBasePath() . $path, and get in the json format for jstree plugin
 */