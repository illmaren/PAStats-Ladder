<?
function rights($db, $uid){
$sql="SELECT * FROM user WHERE id = '$uid'";
$user = $db->query($sql);
$user = mysqli_fetch_array($user);

$rights = explode(" ", $user[rights]);
return $rights;
}
?>