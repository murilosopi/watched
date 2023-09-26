<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  require_once "./vendor/autoload.php";

  header("Access-Control-Allow-Origin: http://localhost:8080");
  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
  header("Access-Control-Allow-Credentials: true");
  session_start();
  $route = new \App\Route;
?>  