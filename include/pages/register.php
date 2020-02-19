<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - Registration</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>Registration</h2>', ob_get_clean());

if($url[1] == "register"){

loadclass("recaptchalib");
// Register API keys at https://www.google.com/recaptcha/admin
$siteKey = "6LfbNQITAAAAAAeUSpXPkge_wSY-mgFVmlEKBYdA";
$secret = "6LfbNQITAAAAAP11Th3LQefQ33ISfyFGBlBudgFk";

$lang = "en";
// The response from reCAPTCHA
$resp = null;
// The error code from reCAPTCHA, if any
$error = null;
$reCaptcha = new ReCaptcha($secret);
// Was there a reCAPTCHA response?
if ($_POST["g-recaptcha-response"]) {
$resp = $reCaptcha->verifyResponse(
$_SERVER["REMOTE_ADDR"],
$_POST["g-recaptcha-response"]
);
}
?>
<center>
<script src='https://www.google.com/recaptcha/api.js'></script>
<div style="text-align:center; width:300px;">
<form action = "../register/sql" method="POST">
	Name<br>
	<input type="text" name="name"><br>
	Password<br>
	<input type="password" name="password"><br>
	Password again<br>
	<input type="password" name="password2"><br>
	E-Mail<br>
	<input type="email" name="email"><br>
	<div class="g-recaptcha" data-sitekey="<?php echo $siteKey;?>"></div>
<script type="text/javascript"
src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang;?>">
</script><br>
	<input type="submit" value="Register"></p>
</form>
<div class="g-recaptcha" data-sitekey="6LfbNQITAAAAAAeUSpXPkge_wSY-mgFVmlEKBYdA"></div>
</div>
</center>
<?
if(($pageName == "register") AND ($action == "sql") AND ($resp != null && $resp->success)){
$hashpw = "Ignis-aurum-probat";

loadclass("dbconnect");
$db = new db();

$user = escape($db, $_POST[name]);
$pass = escape($db, $_POST[password]);
$pass2 = escape($db, $_POST[password2]);
$email = escape($db, $_POST[email]);

$user = strtolower ( $user );

$sql="SELECT * FROM user WHERE user = '$user'";
	$resultdb = $db->query($sql);
	$resultdb = mysqli_num_rows($resultdb);
	
$sql="SELECT * FROM user WHERE email = '$email'";
	$resultdbb = $db->query($sql);
	$resultdbb = mysqli_num_rows($resultdbb);

if($resultdb != "0"){
	echo 'User already Exist';
}else{
	if($resultdbb != "0"){
		echo 'E-Mail already Exist';
	}else{
		if($pass != $pass2){
			echo 'Password does not Match';
		}else{

			$pass = $user.''.$pass;
			$salt = rand(0, 99999999);
			$salted = $salt.'--'.$hashpw;
			$pass_hash = saltPassword($pass, $salted);

			$query = "INSERT INTO user (user, pass, email, salt)
				VALUES ('$user', '$pass_hash', '$email', '$salt')";

			if($db->query($query)){
				echo "Account Created";
			}else{
				echo 'Account was not Created';
			}
		}
	}
}		
$db->close();
}
}
?>