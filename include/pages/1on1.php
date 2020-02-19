<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - 1on1</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>1on1 playerlist</h2>', ob_get_clean());
?>
<style type="text/css">
  a.infobox { border-bottom: 1px #c30; text-decoration:none; }
  a.infobox:hover { cursor:hand; color:#c30; background:white; }
  a.infobox span { visibility:hidden; position:absolute; width: 250px;
		/* rounded corner */
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	/* box shadow */
	-webkit-box-shadow: 0 1px 3px rgba(0,0,0,.4);
	-moz-box-shadow: 0 1px 3px rgba(0,0,0,.4);
	box-shadow: 0 1px 3px rgba(0,0,0,.4);
    margin-top:1.5em; padding:1em; text-decoration:none; }
  a.infobox:hover span, a.infobox:focus span, a.infobox:active span {
    visibility:visible;
    border:0px solid #c30; color:blue; background:white; }
</style>
<script type="text/javascript">
	$(document).ready(function() { 
		$("table").tablesorter({ 
			sortList: [[0,0]]
		}); 
	}); 
</script>
<!--[if IE 5]><style type="text/css">
  a.infobox span { display:none; }
  a.infobox:hover span { display:block; }
</style><![endif]-->
<?php
loadclass("dbconnect");
loadclass("playerlist");
loadclass("fast_cache");

$db = new db();

$reload = getoptionvalue($db, "reload");

if($reload == "reloading"){
echo '<p><b><pre>For Maintance closed,<br>We are Reloading at the moment all Playerdata</pre></b></p>';
}else{
	$cache = getoptionvalue($db, "cache");
	phpFastCache::$storage = $cache;
	$oneonone = phpFastCache::get("oneonone");

if($oneonone == null) {
		$c ="0";
		$sql="SELECT
			p.id,
			p.name,
			p.oldrank,
			p.oldrating,
			p.registred,
			count(g.id),
			count(r.player),
			p.rating,
			p.active,
			p.achievments
		FROM
			1on1_player_game_relations r
			left outer join 1on1_game g on (g.id = r.game and g.winner = r.team_id)
			left outer join player p on (p.id = r.player)
		WHERE
			p.active IN (0,1)
		GROUP BY
			p.id,
			p.name,
			p.rating
		ORDER BY
			p.rating DESC";
		$ergebnis = $db->prepare( $sql );
		$ergebnis->execute();
		$ergebnis->bind_result( $id, $name, $oldrank, $oldrating, $registred, $wins, $games, $rating, $active, $achievments);
    while ($ergebnis->fetch()){

		$loses = $games - $wins;
		$name = substr($name , 0 ,20);
		$ratio = ratio($wins, $loses);
		$achievments = explode(" ", $achievments);
		$c++;
		$rank = rank($c, $active, $oldrank, $id, $koth);
		$bold = firstbold($c);
		
		// Highest rank # | for # days // Highest rank # | longest time held # days
		$content_1on1.= '
		<tr class="ladder">
			<td style="text-align:right; padding-right:5px; vertical-align:middle; '.$bold.'">'.$c.'</td>
			<td>'.$rank.'</td>
			<td style="'.$bold.''.$border.'" class="tabledata"><a onclick="return loading();" class="infobox" style="background:#222;" href="player/'.$id.'">'.$name.'<center><span style="background-color:#222"><table style="color:white; width:100%;"><tr><td>Highest rank <b>'.$achievments[1].'</b></td><td>longest time held <b>'.$achievments[0].'</b> days</td></tr><tr><td>Former Rank:</td><td>'.$oldrank.'</td></tr><tr><td>Former Rating:</td><td>'.$oldrating.'</td></tr></table></span></center></a></td>
			<td style="text-align:center; '.$bold.''.$border.'">'.$games.'</td>
			<td style="text-align:center; '.$bold.''.$border.'">'.$wins.'</td>
			<td style="text-align:center; '.$bold.''.$border.'">'.$loses.'</td>
			<td style="text-align:center; '.$bold.''.$border.'">'.$ratio.'</td>
			<td style="text-align:center; '.$bold.''.$border.'">'.$rating.'</td>
		</tr>';

	}
	phpFastCache::set("oneonone",$oneonone,300);
}
		echo'
		<table class="ladder" cellspacing="1" style="width:100%; border-spacing: 1px; border-collapse: separate;" id="tablesorter">
			<thead>
				<tr style="background:#222">
					<th class="tables">'.$lang['1ON1_1_COLUMN'].'</th>
					<th class="tables">#</th>
					<th class="tables">'.$lang['1ON1_2_COLUMN'].'</th>
					<th class="tables">'.$lang['1ON1_3_COLUMN'].'</th>
					<th class="tables">'.$lang['1ON1_4_COLUMN'].'</th>
					<th class="tables">'.$lang['1ON1_5_COLUMN'].'</th>
					<th class="tables">'.$lang['1ON1_6_COLUMN'].'</th>
					<th class="tables">'.$lang['1ON1_7_COLUMN'].'</th>
				</tr>
			</thead>
			<tbody>
				'.$content_1on1.'
			</tbody>
		</table>';
}
$db->close();
?>