<?php 
session_start();

error_reporting(E_ALL ^ E_NOTICE);
$mysqli = new mysqli("localhost","root","root","shannta");
if ($mysqli->connect_errno) {
    //echo '<script>window.location="404.html";</script>';
}
$mysqli->query("set names utf8");

define('DIR_ROOT', '');
define('DIR_PUBLIC', 'public/');
define('DIR_ADMIN', 'admin/');
define('DIR_SELF', basename($_SERVER['PHP_SELF']));
define('DIR_HOST', $_SERVER['HTTP_HOST']);
define('DIR_URI', $_SERVER['REQUEST_URI']);
define('DIR_FILE','');
define('SITE', 'shanntadev');
$defaultLang = 1;


//////////////////////  function  //////////////////////

include("public/config/function.php");
include("_inc_lang.php");
?>