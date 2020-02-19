<section>
	<header>
		<h2>Gameserver Status</h2>
	</header>
<?
loadclass("dbconnect");
loadclass("fast_cache");
$mysqli = new db();
loadclass("gameserver");

$cache = getoptionvalue($mysqli, "cache");
phpFastCache::$storage = $cache;
$serverstatus = phpFastCache::get("serverstatus");

if($serverstatus == null) {
$j = new JiffyBox("121846");  
if($j->getStatus() == "READY"){ $status = "Online"; }else{ $status = "Offline"; }
		$serverstatus = '
 		<tr style="border-bottom: 1px solid #E2E6E8;">
			<td style="float:left; width:50%; text-align:center;">Test Server</td>
			<td style="float:right; width:50%; text-align:center;">'.$status.'</td>	
		</tr>';
		phpFastCache::set("serverstatus",$serverstatus,300);
}
?>
<table style="width:100%;">
<?
echo $serverstatus;
?>
</table>
</section>

<?
$mysqli->close();
?>