<?php
// Setting Output Buffer(make all data as a package to run)
ob_start();
// Error Handling
ini_set('display_errors', 1); //open errors
error_reporting(E_ALL & ~ E_NOTICE & ~ E_STRICT); 
		//all errors exepet notice and strict
// Shortcuts
define('DS', DIRECTORY_SEPARATOR);  //echo back slash \ in windows and \ in linux
define('PS', PATH_SEPARATOR);		//echo ; in windows and : in linux

// Domain related constants
define('HOST_NAME', 'http://' . $_SERVER['HTTP_HOST'] . '/10-Pharmacy/'); 

//CSS and JS direcories
define('CSS_DIR', HOST_NAME . 'css/');
define('JS_DIR', HOST_NAME . 'js/');

// Paths
define('APP_PATH', realpath(dirname(__FILE__)) . DS); 	//path of The Project
define('MODELS_PATH', APP_PATH . 'models' . DS);  		//path of my Classes
define('CSS_PATH', APP_PATH . 'css' . DS);				//path of css files
define('JS_PATH', APP_PATH . 'js' . DS);				//path of js files
define('TEMPLATE_PATH', APP_PATH . 'templates' . DS);	//path of template pages
define('VIEWS_PATH', APP_PATH . 'views' . DS);			//paths of Views Pages

/*Require All Models(classes)*/
// new paths that php uses to find called classes(models)
$path = get_include_path() . PS . MODELS_PATH;
// set the new paths
set_include_path($path);
// define the autoload function ,his function With High Performance than __autoload
function autoLoad($class) {
    require_once strtolower($class) . '.php';
}
//standard PHP library  ,To Include All Models
spl_autoload_register('autoLoad');
require_once('MangoPaginator/MP.php');
require_once('pdf/fpdf.php');
/*Connect To database*/
// Database Credentials|
define('DB_HOST', 'localhost');
define('DB_NAME', 'pharmacyproject');
define('DB_USER', 'root');
define('DB_PASS', '');
//(dbh is variable that returned from staic function DatabaseConnect)
 $dbh = DBConnect::DatabaseConnect();
// Open  session
session_start();

// End the buffer and send the output
ob_flush();