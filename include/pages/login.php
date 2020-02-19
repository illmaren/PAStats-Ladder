<center>
<div style="text-align:center; width:300px;">
	<form action = "http://<? echo $_SERVER['HTTP_HOST']; ?>/login_sql.php" method="POST">
		<div style="text-align:left;">Username:</div>
		<input type="text" name="name"><br>
		<div style="text-align:left;">Password:</div>
		<input type="password" name="password"><br>
		<div>
		
		<label style="text-align:left; width:40%; margin: 10px 0px 0px 10px; float:right;" class="label_check">
			<input style="float:left;"type="checkbox" value="1" name="cookie">
			<p>Remember me</p>
			<div style="clear:both;"></div>
		</label>
		<input style="float:left;" type="submit" value="Login">
		<div style="clear:both;"></div>
		</div>
	</form>
	<br>
<div style="text-align:left;">
<a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/register">No Account? Register</a><br>
<a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/forgot">Password forgotten</a>
</div>
</div>

<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - Login</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>Login</h2>', ob_get_clean());

if(($pageName == "login") AND ($action == "sql")){
loadclass("dbconnect");
$db = new db();

$user = escape($db, $_POST[name]);
$pass = escape($db, $_POST[password]);

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
		setcookie("Login", $loginuserid_array, time()+(3600*365));
		setcookie("Name", $loginuser_array, time()+(3600*365));
		echo "Cookie was set";
	}
		$_SESSION['user_id'] = $loginuserid_array;
		$_SESSION['name'] = $loginuser_array;
	echo $array[id];
	header("Location: ../home");
}else{
	echo "Access Denied";
}
$db->close();
}
?>