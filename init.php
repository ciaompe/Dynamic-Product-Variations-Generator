<?php
/*
Display errors turn on
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
Import configuration lib
*/
use Noodlehaus\Config;

/*
Import Helpers to the application
 */
use Ciaompe\Helpers\Database;
use Ciaompe\Helpers\Variation;

//Load Composer Packages
require 'vendor/autoload.php';

//Load System Configurtions from config.php file
$config = Config::load('config.php');

//Twig Cofiguration
$loader = new Twig_Loader_Filesystem('system/templates');
$twig = new Twig_Environment($loader);

//Make Database Connection
$db =  new Database($config);

//Create new Variation Helper
$variation = new Variation();


