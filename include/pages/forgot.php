<center>
<div style="text-align:center; width:300px;">
<form action = "../forgot/sql" method="POST">
	<input type="email" name="email"><br>
	<input type="submit" value="Send me my Password"></p>
</form>
</div></center>
<?
if(($pageName == "forgot") AND ($action == "sql")){
$hashpw = "Ignis-aurum-probat";
loadclass("dbconnect");
$db = new db();

echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - PW Forgot</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>PW Forgot</h2>', ob_get_clean());

$email = escape($db, $_POST[email]);
$sql="SELECT * FROM user WHERE email = '$email'";
	$resultdbb = $db->query($sql);
	$newpw = mysqli_fetch_array($resultdbb);
	$resultdbb = mysqli_num_rows($resultdbb);
	
	if($resultdbb == 0){
		echo "Your E-Mail is not in our System";
	}else{
		$user = $newpw[user];
		function zufallsstring ($string_laenge) {
			srand ((double)microtime()*1000000);
			$zufall = rand();
			$zufallsstring = substr( md5($zufall) , 0 , $string_laenge );
			return $zufallsstring;
		}
		  
		  $new_pw = zufallsstring(10);
		
		$pass = $user.''.$new_pw;
		$salt = rand(0, 99999999);
		$salted = $salt.'--'.$hashpw;
		$pass_hash = saltPassword($pass, $salted);
			$query = "UPDATE user SET pass = '$pass_hash', salt = '$salt' WHERE email = '$email'";
	
		if($db->query($query)){
			require_once('include/class/PHPMailerAutoload.php');

			$mail = new PHPMailer;

			// $mail->SMTPDebug = 3;									// Enable verbose debug output

			$mail->isSMTP();										// Set mailer to use SMTP
			$mail->Host = 'smtp.paladder.com';						// Specify main and backup SMTP servers
			$mail->SMTPAuth = true;									// Enable SMTP authentication
			$mail->Username = 'support@paladder.com';				// SMTP username
			$mail->Password = 'Clever01!';							// SMTP password
			$mail->SMTPSecure = 'ssl';								// Enable TLS encryption, `ssl` also accepted
			$mail->Port = 465;										// TCP port to connect to

			$mail->From = 'support@paladder.com';
			$mail->FromName = 'PALadder Support';
			$mail->addAddress($email);     							// Empfänger
			$mail->addReplyTo('support@paladder.com', 'Support');	// Antwort an

			$mail->WordWrap = 50;									// Set word wrap to 50 characters
			$mail->isHTML(true);									// Set email format to HTML

			$mail->Subject = 'You Requested an New PW';
			$mail->Body    = 'This here is your New PW: <b>'.$new_pw.'</b>';
			$mail->AltBody = 'This is your new PW: "'.$new_pw.'"';

			if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
				echo 'Message has been sent';
			}
		}
	}
}
?>