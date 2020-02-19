<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - Uberskill</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>UberSkill</h2>', ob_get_clean());
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
<!--[if IE 5]><style type="text/css">
  a.infobox span { display:none; }
  a.infobox:hover span { display:block; }
</style><![endif]-->
<script type="text/javascript">
	$(document).ready(function() { 
		$("table").tablesorter({ 
			sortList: [[6,1]]
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
$content_uberskill = phpFastCache::get("uberskill");
if($content_uberskill == null) {
	$c ="0";
	$sql="
	SELECT
		p.id,
		p.name,
		p.oldrank,
		p.uberskill,
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
		p.active IN (0,1) AND
		p.uberskill NOT IN ( 0 )
	GROUP BY
		p.id,
		p.name,
		p.rating
	ORDER BY
		p.uberskill ASC
	";
	$ergebnis = $mysqli->prepare( $sql );
    $ergebnis->execute();
    $ergebnis->bind_result( $id, $name, $oldrank, $uberskill, $oldrating, $registred, $wins, $games, $rating, $active, $achievments );
    while ($ergebnis->fetch()){
	

		$loses = $games - $wins;
		
		
		$name = substr($name , 0 ,20);
		$ratiopro = (($wins) / ($wins + $loses)) * 100;
		$ratiopro = round($ratiopro, 2);
		$achievments = explode(" ", $achievments);

		if($ratiopro == "100"){
			$ratio = $wins;
		}else{
			$ratio = ($wins / $loses);
			$ratio = round($ratio, 2);
		}
		
		$c++;
		
		$time_date = time();

		$newly =  $time_date - $registred;
		/*
		if($newly <= 259200){
			$ranking = '<img style="height:10px" src="../include/image/new.png" title="Just Joined" />';
		}else */ if($active == 1){
			$ranking = '<font style="color:blue;">Zz</font>';
		}elseif($c == $oldrank){
			$ranking = '<img style="height:10px" src="../include/image/same.png" title="Former Rank: '.$oldrank.'" />';
		}elseif($c >= $oldrank){
			$ranking = '<img style="height:10px" src="../include/image/down.png" title="Former Rank: '.$oldrank.'" />';
		}else{
			$ranking = '<img style="height:10px" src="../include/image/up.png" title="Former Rank: '.$oldrank.'" />';
		}

		if($koth == $id){
			$rank = '<img style="height:10px" src="../include/image/koth.png" title="King of the Planet" />';
		}else{
			$rank = "$uberskill";
		}
		if(($c >= 1) AND ($c <= 1)) {
			$bold= "font-weight: bold; ";
		}elseif($c == 2){
			$bold = "";
		}
		// Highest rank # | for # days // Highest rank # | longest time held # days
$content_uberskill.= '
		<tr>
			<td style="text-align:center; vertical-align:middle; '.$bold.'">'.$rank.'</td>
			<td style="'.$bold.''.$border.'" class="tabledata"><a class="infobox" href="player/'.$id.'">'.$name.'</a></td>
			<td style="text-align:center; '.$bold.''.$border.'">'.$games.'</td>
			<td style="text-align:center; '.$bold.''.$border.'">'.$wins.'</td>
			<td style="text-align:center; '.$bold.''.$border.'">'.$loses.'</td>
			<td style="text-align:center; '.$bold.''.$border.'">'.$ratio.'</td>
		</tr>';

	}
	// phpFastCache::set("uberskill",$content_uberskill,300);
}
echo'
<table class="ladder" cellspacing="1" style="width:100%; border-spacing: 1px; border-collapse: separate;" id="tablesorter">
	<thead>
		<tr style="background:#222">
			<th class="tables">'.$lang['1ON1_1_COLUMN'].'</th>
			<th class="tables">'.$lang['1ON1_2_COLUMN'].'</th>
			<th class="tables">'.$lang['1ON1_3_COLUMN'].'</th>
			<th class="tables">'.$lang['1ON1_4_COLUMN'].'</th>
			<th class="tables">'.$lang['1ON1_5_COLUMN'].'</th>
			<th class="tables">'.$lang['1ON1_6_COLUMN'].'</th>
		</tr>
	</thead>
	<tbody>
		'.$content_uberskill.'
	</tbody>
</table>';
}
?>