<?
$hostname = 	"localhost";
$username = 	"GEHEIM";
$password = 	"GEHEIM";
$database = 	"GEHEIM";

$hashpw = "GEHEIM";

$url = 			"http://example.com/"; // with / at the end
// $title = "";
$datumfest=strtotime("14 December 2013");

$apiKey = 'GEHEIM';
$uId = 0000;

function saltPassword($password, $salt)
{
     return hash('sha256', $password . $salt);
}
if($url[1] == "logout"){
	session_destroy();
	header("Location: index.php?page=home");
}
// $koth = 		"410";


?>