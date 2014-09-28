<?php 
session_start();
/*
error_reporting(E_ALL ^ E_NOTICE);
$mysqli = new mysqli("localhost","root","root","shannta");
if ($mysqli->connect_errno) {
    //echo '<script>window.location="404.html";</script>';
}
$mysqli->query("set names utf8");*/

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

function setLang($lang_id,$url){
	$lang_id = intval($lang_id);
	
	if(!empty($lang_id)){
		$_SESSION[SITE.'_lang_id'] = $lang_id;
		$name = SITE.'_lang_id';
		$cookie_lang_id = intval(fetch_cookie($name));
		if($cookie_lang_id != $lang_id || empty($cookie_lang_id) && $cookie_lang_id != 'public'){
			set_cookie($name, $lang_id);
		}
	}
	if(!empty($url)){
	
		if(stripslashes(DIR_ROOT) != "" && DIR_ROOT != '/'){
			$cUrl=explode(DIR_ROOT,$url);
		}else{
			$cUrl[1] = substr($url,1);
		}
		$langcUrl=explode('/lang/',$cUrl[1]);
		
		if(!empty($langcUrl[1])){
			$_SESSION['currenturl'] = $langcUrl[0];
		}else{
			$_SESSION['currenturl'] = $cUrl[1];
		}
	}
}
function getDefaultLangId(){
	$name = SITE.'_lang_id';
	$lang_id = fetch_cookie($name);
	if(!isset($_SESSION[SITE.'_lang_id']) && empty($_SESSION[SITE.'_lang_id']) && !empty($lang_id)){
		$_SESSION[SITE.'_lang_id'] = $lang_id;
	}else if(empty($_SESSION[SITE.'_lang_id']) && empty($lang_id)){
		//$arr = mysql_query("SELECT language_id FROM admin_language WHERE language_front='1'");
		//if(mysql_num_rows($arr)>0){
		//	$result = mysql_fetch_array($arr);
		//	echo $_SESSION[SITE.'_lang_id'] = $result['language_id'];
		//}
		$_SESSION[SITE.'_lang_id'] = 2;
	}
	return $defaultLang = $_SESSION[SITE.'_lang_id'];
}

//////////////////////  lang  //////////////////////

if(isset($_GET['lang'])) setLang($_GET['lang'],$_SERVER['REQUEST_URI']);
$defaultLang = getDefaultLangId();
include("_inc_lang.php");

?>