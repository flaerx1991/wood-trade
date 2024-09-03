<?php
// show error reporting
error_reporting(E_ALL);

// start php session
session_start();

// set your default time-zone
date_default_timezone_set('Europe/Kiev');

// home page url
define('HOME_URL','https://wood-trade.com.ua/');
define('CHANGE_SITE_URL','https://arabic.wood-trade.com.ua/');
//define('ROOT_PATH',ROOT_PATH.'');
//$home_url="http://wood-trade.com.ua/{{ session.language == baselocale ? '' :  session.language~'/' }}";

define('BASELOCALE','en');

define('BASEPATH','/');



?>
