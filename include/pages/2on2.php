<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - 2on2</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>2on2 playerlist</h2>', ob_get_clean());
?>
<script type="text/javascript">
	$(document).ready(function() { 
		$("table").tablesorter({ 
			sortList: [[0,0]]
		}); 
	}); 
</script>
<?php


loadclass("dbconnect");
loadclass("playerlist");
loadclass("fast_cache");

$mysqli = new db();

$reload = getoptionvalue($mysqli, "reload");

if($reload == "reloading"){
echo '<p></b><pre>For Maintance closed,<br>We are Reloading at the moment all Playerdata</pre></b></p>';
}else{
	$cache = getoptionvalue($mysqli, "cache");
	phpFastCache::$storage = $cache;
	$twoontwo = phpFastCache::get("twoontwo");
	
if($twoontwo == null) {
	$c ="0";
	$sql="
	SELECT
		p.id,
		p.name,
		count(g.id) as wins,
		count(r.player)as games,
		r.time as time,
		p.2on2_rating as rating
	FROM
		2on2_player_game_relations r
		left outer join 2on2_game g on (g.id = r.game and g.winner = r.team_id)
		left outer join player p on (p.id = r.player)
	GROUP BY
		p.id,
		p.name,
		p.2on2_rating
	ORDER BY
		p.2on2_rating DESC
	";
	$result = $mysqli->query($sql);
	while($row = mysqli_fetch_assoc($result)){
		$rating = $row[rating];
		$wins = $row[wins];
		$games = $row[games];
		$loses = $games - $wins;

		$ratiopro = (($wins) / ($wins + $loses)) * 100;
		$ratiopro = round($ratiopro, 2);

		if($ratiopro == "100"){
			$ratio = $wins;
		}else{
			$ratio = ($wins / $loses);
			$ratio = round($ratio, 2);
		}
		$rating = $row[rating];
		$c++;
		$twoontwo.= '
				<tr>
					<td style="text-align:center;">'.$c.'</td>
					<td class="tabledata"><a onclick="return loading();" href="player/'.$row[id].'">'.$row[name].'</a></td>
					<td style="text-align:center;">'.$games.'</td>
					<td style="text-align:center;">'.$wins.'</td>
					<td style="text-align:center;">'.$loses.'</td>
					<td style="text-align:center;">'.$ratio.'</td>
					<td style="text-align:center;">'.$rating.'</td>
				</tr>';
	}
		phpFastCache::set("twoontwo",$twoontwo,300);
}
echo '
<table class="ladder" cellspacing="1" style="width:100%; border-spacing: 1px; border-collapse: separate;" id="tablesorter">
	<thead>
		<tr style="background:#222">
			<th class="tables">'.$lang['2ON2_1_COLUMN'].'</th>
			<th class="tables">'.$lang['2ON2_2_COLUMN'].'</th>
			<th class="tables">'.$lang['2ON2_3_COLUMN'].'</th>
			<th class="tables">'.$lang['2ON2_4_COLUMN'].'</th>
			<th class="tables">'.$lang['2ON2_5_COLUMN'],'</th>
			<th class="tables">'.$lang['2ON2_6_COLUMN'].'</th>
			<th class="tables">'.$lang['2ON2_7_COLUMN'].'</th>
		</tr>
	</thead>
	<tbody>
		'.$twoontwo.'
	</tbody>
</table>'; 
}
?>