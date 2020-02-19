<section>
	<header>
		<h2>Stats</h2>
	</header>
<?
loadclass("dbconnect");
loadclass("fast_cache");
$mysqli = new db();

$cache = getoptionvalue($mysqli, "cache");
phpFastCache::$storage = $cache;
$content_stats = phpFastCache::get("statss");

if($content_stats == null) {
include'include/lang/en.php';


$sql_time="SELECT time, new_games FROM reload WHERE id = '1'";
$sql_stats="select count(*) as player from player";
$sql_stats2="select count(*) as games from game";
$query = "Show Table status";

$ergebnis = $mysqli->query( $query );
$player = $mysqli->query( $sql_stats );
$games = $mysqli->query( $sql_stats2 );
$reload = $mysqli->query( $sql_time );

$player = $player->fetch_object();
$games = $games->fetch_object();
$reload = $reload->fetch_object();

    while ($row = $ergebnis->fetch_object()){
        $summe = $row->Index_length + $row->Data_length;
        $gesamt += $summe;
    }
	
	$ergebnis = $gesamt / 1024 / 1024;
	$ergebnis = round($ergebnis, 2);
	
		$datumfest=strtotime("5 September 2014");
		$datumjetzt=time();
		$ausgabe=$datumjetzt-$datumfest;
		$intagen=$ausgabe/60/60/24;
		$round=ceil($intagen);
		$round_games = $games->games / $round;
		$round_games = round($round_games, 2);
		
		$round = $player->player / $round;
		$round = round($round, 2);
		
		$content_stats.= '
		<tr style="border-bottom: 1px solid #E2E6E8;">
			<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_STATS_RELOAD'].'</td>
			<td style="float:right; width:50%; text-align:center;">'.$datum = date("F j, Y, g:i a",$reload->time).'</td>
		</tr>
		
		<tr style="border-bottom: 1px solid #E2E6E8;">
			<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_STATS_NEW_GAMES'].'</td>
			<td style="float:right; width:50%; text-align:center;">'.$reload->new_games.'</td>
		</tr>
		
		<tr style="border-bottom: 1px solid #E2E6E8;">
			<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_STATS_GAMES'].'</td>
			<td style="float:right; width:50%; text-align:center;">'.$games->games.'</td>	
		</tr>
		
		<tr style="border-bottom: 1px solid #E2E6E8;">
			<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_STATS_GPERDAY'].'</td>
			<td style="float:right; width:50%; text-align:center;">'.$round_games.'</td>	
		</tr>
		
		<tr style="border-bottom: 1px solid #E2E6E8;">
			<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_STATS_PLAYERS'].'</td>
			<td style="float:right; width:50%; text-align:center;">'.$player->player.'</td>	
		</tr>
		
		<tr style="border-bottom: 1px solid #E2E6E8;">
			<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_STATS_PLPERDAY'].'</td>
			<td style="float:right; width:50%; text-align:center;">'.$round.'</td>	
		</tr>
		
		<tr style="border-bottom: 1px solid #E2E6E8;">
			<td style="float:left; width:50%; text-align:center;">'.$lang['SIDEBAR_STATS_DATABASE'].'</td>
			<td style="float:right; width:50%; text-align:center;">'.$ergebnis.' MB </td>	
		</tr>';
		phpFastCache::set("statss",$content_stats,300);
}

?>
<table style="width:100%;">
<?
echo $content_stats;
?>

		<tr style="">
			<td><center><a onclick="return loading();" href="../../stats/month">Game Statistics</a></center></td>
		</tr>
</table>
</section>
<?
$mysqli->close();
?>