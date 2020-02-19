<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - PW Change</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>PW Change</h2>', ob_get_clean());

if($url[1] == "pwchange"){
require_once('include/check.php');

?>
<center>
	<div style="text-align:center; width:400px;">
		<form action = "../pwchange/sql" method="POST">
			<table style="width:100%;">
				<tr>
					<td style="text-align:left;">Current PW</td>
					<td style="text-align:right;"><input type="password" name="oldpassword"></td>
				</tr>
				<tr>
					<td style="text-align:left;">New PW</td>
					<td style="text-align:right;"><input type="password" name="newpassword"></td>
				</tr>
				<tr>
					<td style="text-align:left;">New PW²</td>
					<td style="text-align:right;"><input type="password" name="new2password"></td>
				</tr>
			</table>
			<input type="submit" value="Change PW"></p>
		</form>
	</div>
</center>
<?
if(($pageName == "pwchange") AND ($action == "sql")){
$hashpw = "Ignis-aurum-probat";
loadclass("dbconnect");
$db = new db();
$id = $_SESSION[user_id];

require_once('include/check.php');

$pass_old = escape($db, $_POST[oldpassword]);
$pass_new = escape($db, $_POST[newpassword]);
$pass_new2 = escape($db, $_POST[new2password]);

		$sql="SELECT * FROM user WHERE id = '$id'";
			$salt = $db->query($sql);
			$salt = mysqli_fetch_array($salt);

		$user = $salt[user];
		$pass = $user.''.$pass_old;
		$salt = $salt[salt];
		$salted = $salt.'--'.$hashpw;
		$pass_hash = saltPassword($pass, $salted);
		
$sql="SELECT * FROM user WHERE user = '$user' AND pass = '$pass_hash'";
	$result_query = $db->query($sql);
	$resultdb = mysqli_num_rows($result_query);
	$array = mysqli_fetch_array($result_query);
	if($resultdb == 0){
		echo "Old Password is not correct";
	}else{
		if($pass_new != $pass_new2){
			echo "New Passwords does not match";
		}else{
			// New Password is going to be Generated here
			
			$pass = $user.''.$pass_new;
			$salt = rand(0, 99999999);
			$salted = $salt.'--'.$hashpw;
			$pass_hash = saltPassword($pass, $salted);
			
			$query = "UPDATE user SET pass = '$pass_hash', salt = '$salt' WHERE id = '$id'";
	
			if($db->query($query)){
				echo "password was changed";
			}
		}
	}
}
}
?>