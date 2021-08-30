<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$configuration = include_once '../config/config.php';
include_once 'class/database.php';
include_once 'class/api.php';

$database = new Database($configuration);
$connection = $database->connect();
$api = new API($connection, $configuration);

$request = $_SERVER['REQUEST_URI'];
$api->router($request);
?> 