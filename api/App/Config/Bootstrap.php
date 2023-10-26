<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Credentials: true");

define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT']."/../public/uploads/");

require_once __DIR__."/../../vendor/autoload.php";

?>