<?
session_start();

include 'include/config.php';
include 'include/classes/class.dbconnect.php';
$db = new db();

function saltPassword($password, $salt)
{
     return hash('sha256', $password . $salt);
}

$user = escape($db, $_POST[name]);
$pass = escape($db, $_POST[password]);

$user = strtolower ( $user );

$sql="SELECT * FROM user WHERE user = '$user'";
	$salt = $db->query($sql);
	$salt = mysqli_fetch_array($salt);

$pass = $user.''.$pass;
$salt = $salt[salt];
$salted = $salt.'--'.$hashpw;
$pass_hash = saltPassword($pass, $salted);

$sql="SELECT * FROM user WHERE user = '$user' AND pass = '$pass_hash'";
	$result_query = $db->query($sql);
	$resultdb = mysqli_num_rows($result_query);
	$array = mysqli_fetch_array($result_query);

if($resultdb == "1"){
		$loginuserid_array = $array[id];
		$loginuser_array = $array[user];
	if($_POST[cookie] == "1"){
		setcookie("Login", $loginuserid_array, time()+(3600*365),'/');
		setcookie("Name", $loginuser_array, time()+(3600*365),'/');
		echo "Cookie was set";
	}else{
		$_SESSION['user_id'] = $loginuserid_array;
		$_SESSION['name'] = $loginuser_array;
	}
	echo $array[id];
	header("Location: ../home");
}else{
	echo "Access Denied";
}
$db->close();
?>