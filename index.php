<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define("BASE_CONTROLLER", "IndexController");

include("config/config.php");
include("libraries/autoloader.php");

$app = new App($config);
$app->start();