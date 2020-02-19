<section>
	<header>
		<h2>1on1 Stats</h2>
	</header>
	<?
$mysqli = new db();


$cache = getoptionvalue($mysqli, "cache");
phpFastCache::$storage = $cache;
$content_statsone = phpFastCache::get("statsone");
if($content_statsone == null) {
include'include/lang/en.php';

/*
$sql_time="SELECT time FROM reload WHERE id = '1'";
$row_time = $mysqli->query( $sql_time );
$row_time = $row_time->fetch_object;
*/
$sql_time2="SELECT time FROM reload WHERE id = '2'";
$row_time2 = $mysqli->query( $sql_time2 );
$row_time2 = $row_time2->fetch_object();

$sql_stats="select
  count(distinct player) as player
from
  1on1_player_game_relations
  ";
$row_stats = $mysqli->query( $sql_stats );
$row_stats = $row_stats->fetch_array();
$sql_stats2="select
  count(*) as games 
from
  1on1_game
  ";
$row_stats2 = $mysqli->query( $sql_stats2 );
$row_stats2 = $row_stats2->fetch_array();

$menge = 0;
$dirsize = 0;
$verz = "sig/";
$dir = opendir($verz);
while (($file = readdir($dir))!==false) {
 if ($file[0] <> '.') {
  $menge++;
  $dirsize = $dirsize + filesize($verz.$file);
}}
closedir($dir); 
$dirsize = $dirsize / 1024 / 1024; 
$dirsize = round($dirsize, 2);

		$datumfest=strtotime("5 September 2014");
		$datumjetzt=time();
		$ausgabe=$datumjetzt-$datumfest;
		$intagen=$ausgabe/60/60/24;
		$round=ceil($intagen);
		
		$round_games = $row_stats2[games] / $round;
		$round_games = round($round_games, 2);
		
		$round = $row_stats[player] / $round;
		$round = round($round, 2);
		
		$content_statsone.= '
	<tr style="border-bottom: 1px solid #E2E6E8;">
		<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_1ON1STATS_SIGRELOAD'].'</td>
		<td style="float:right; width:50%; text-align:center;">'.$row_time2->time.'</td>
	</tr>
	<tr style="border-bottom: 1px solid #E2E6E8;">
		<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_1ON1STATS_SIGDATABASE'].'</td>
		<td style="float:right; width:50%; text-align:center;">'.$dirsize.' MB</td>
	</tr>
	<tr style="border-bottom: 1px solid #E2E6E8;">
		<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_1ON1STATS_GAMES'].'</td>
		<td style="float:right; width:50%; text-align:center;">'.$row_stats2[games].'</td>
	</tr>
	<tr style="border-bottom: 1px solid #E2E6E8;">
		<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_1ON1STATS_GPERDAY'].'</td>
		<td style="float:right; width:50%; text-align:center;">'.$round_games.'</td>
	</tr>
	<tr style="border-bottom: 1px solid #E2E6E8;">
		<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_1ON1STATS_PLAYERS'].'</td>
		<td style="float:right; width:50%; text-align:center;">'.$row_stats[player].'</td>
	</tr>
	<tr style="border-bottom: 1px solid #E2E6E8;">
		<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_1ON1STATS_PLPERDAY'].'</td>
		<td style="float:right; width:50%; text-align:center;">'.$round.'</td>
	</tr>
	<tr style="text-align:center;">
		<td><a href="../recent/1on1">
			'.$lang['SIDEBAR_1ON1STATS_RECENT'].'
		</a></td>
	</tr>';
		phpFastCache::set("statsone",$content_statsone,300);
}
?>
<table style="width:100%;">
<? echo $content_statsone; ?>
</table>
</section>
<?
$mysqli->close();
?>