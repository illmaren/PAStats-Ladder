<?
session_start();
error_reporting(E_ERROR);
	function mymicrotime() {   
		list($usec, $sec) = explode(" ",microtime());   
		return ((float)$usec + (float)$sec);   
	}
	$time_start = mymicrotime(); 
$requestURI = array();
$url = explode('/', $_SERVER['REQUEST_URI']);

if($_COOKIE[Login]){
	$loginuser = $_COOKIE[Name];
	$loginuserid = $_COOKIE[Login];
}elseif($_SESSION[user_id]){
	$loginuser = $_SESSION[name];
	$loginuserid = $_SESSION[user_id];
}

if($url[1] == "logout"){
	session_destroy();
	setcookie("Login", "peter", time()-3600,'/');
	setcookie("Name", "peter", time()-3600,'/');
	header("Location: ../../home");
}

if(($url[1] == "lang") AND ($url[2])) {
	$lang = $url[2];

	// register the session and set the cookie
	$_SESSION['lang'] = $lang;

	setcookie('lang', $lang, time() + (3600 * 24 * 30));
	
}
else if(isSet($_SESSION['lang']))
{
$lang = $_SESSION['lang'];
}
else if(isSet($_COOKIE['lang']))
{
$lang = $_COOKIE['lang'];
}
else
{
$lang = 'en';
}

switch ($lang) {
  case 'en':
  $lang_file = 'en.php';
  break;

  case 'de':
  $lang_file = 'de.php';
  break;

  case 'es':
  $lang_file = 'es.php';
  break;

  default:
  $lang_file = 'en.php';
}
include_once 'include/lang/'.$lang_file;


?>