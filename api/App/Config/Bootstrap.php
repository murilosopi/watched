<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

$http_origin = @$_SERVER['HTTP_ORIGIN'];

if (empty($http_origin) || $http_origin == "http://localhost:8080")
{  
    header("Access-Control-Allow-Origin: $http_origin");
}
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Credentials: true");

define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT']."/uploads");
define('PUBLIC_PATH', $_SERVER['DOCUMENT_ROOT']."/../public");

require_once __DIR__."/../../vendor/autoload.php";
require_once __DIR__.'/CredentialSets.php';

?>