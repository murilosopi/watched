<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  require_once "./vendor/autoload.php";

  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: *");
  session_start();
  $route = new \App\Route;
?>  