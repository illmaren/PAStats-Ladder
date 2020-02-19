<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - Playerlist</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>Playerlist</h2>', ob_get_clean());
?>
<head>
  <script type='text/javascript' src='//code.jquery.com/jquery-1.11.0.js'></script>
		<script type="text/javascript" src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/jquery.tablesorter.widgets.js"></script>
		<script type="text/javascript" src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/jquery.tablesorter.pager.js"></script>
		
  <script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
$('#my-table')
   .tablesorter({
      theme: 'blue',
      widget: ['zebra']
   })
   .tablesorterPager({
      container: $('#pager'),
      size: 100
   });
});//]]>  

</script>
<script type="text/javascript">
	$(document).ready(function() { 
		$("table").tablesorter({ 
			sortList: [[0,0]]
		}); 
	});
</script>
</head>
<?php

loadclass("dbconnect");
loadclass("playerlist");
loadclass("blaetter");
loadclass("fast_cache");

$mysqli = new db();

$reload = getoptionvalue($mysqli, "reload");
if($reload == "reloading"){
echo '<p><b><pre>For Maintance closed,<br>We are Reloading at the moment all Playerdata</pre></b></p>';
}else{

$cache = getoptionvalue($mysqli, "cache");
phpFastCache::$storage = $cache;
$content = phpFastCache::get("toplist");

if($content == null) {
		$i = $start;
		$sql="
		SELECT
		  p.id as id,
		  p.name name,
		  count(g.id) as wins,
		  count(r.player)as games,
		  p.rating as rating
		FROM
			player_game_relations r
			left outer join game g on (g.id = r.game and g.winner = r.team_id)
			left outer join player p on (p.id = r.player)
			WHERE p.id != -1
		GROUP BY 
			p.id, 
			p.name
		ORDER BY
			count(g.id) DESC
		";
		$mysqli->set_charset("UTF-8");
		$ergebnis = $mysqli->prepare( $sql );
		$ergebnis->execute();
		$mysqli->set_charset("UTF-8");
		$ergebnis->bind_result( $id, $name, $wins, $games, $rating );
		while ($ergebnis->fetch())
		{
		$i++;
		$loses = $games - $wins;

		$ratiopro = (($wins) / ($wins + $loses)) * 100;
		$ratiopro = round($ratiopro, 2);

		if($ratiopro == "100"){
		$ratio = $wins;
		}else{
		$ratio = ($wins / $loses);
		$ratio = round($ratio, 2);
		}

		$content.= '
	<tr class="ladder">
		<td style="text-align:center; ">'.$i.'</td>
		<td class="tabledata"><a onclick="return loading();" href="../player/'.$id.'">'.$name.'</a></td>
		<td style="text-align:center; ">'.$games.'</td>
		<td style="text-align:center; ">'.$wins.'</td>
		<td style="text-align:center; ">'.$loses.'</td>
		<td style="text-align:center; ">'.$ratio.'</td>
	</tr>';
		}
    phpFastCache::set("toplist", $content,3600);
}
?>
<div id="table-container">


<div id="pager" class="pager">
<!--
   <img alt="|<" src="http://mottie.github.com/tablesorter/addons/pager/icons/first.png" class="first" style="cursor:pointer;"/> 
   <img alt="<<" src="http://mottie.github.com/tablesorter/addons/pager/icons/prev.png" class="prev" style="cursor:pointer;"/> 
   <span class="pagedisplay"></span>
   <img alt=">>" src="http://mottie.github.com/tablesorter/addons/pager/icons/next.png" class="next" style="cursor:pointer;"/> 
   <img alt=">|" src="http://mottie.github.com/tablesorter/addons/pager/icons/last.png" class="last" style="cursor:pointer;"/> 
-->   <select class="pagesize" title="Select page size"> 
      <option selected="selected" value="100">100</option> 
      <option value="200">200</option>
      <option value="500">500</option>
	  <option value="5000000">All</option>
   </select>
   <select class="gotoPage" title="Select page number"></select>
</div>

<table class="ladder" cellspacing="1" style="color:white; width:100%; border-spacing: 1px; border-collapse: separate;" id="my-table">
	<thead>
	<? echo '
		<tr style="background:#222">
			<th class="tables">'.$lang['PLAYERLIST_1_COLUMN'].'</th>
			<th class="tables">'.$lang['PLAYERLIST_2_COLUMN'].'</th>
			<th class="tables">'.$lang['PLAYERLIST_3_COLUMN'].'</th>
			<th class="tables">'.$lang['PLAYERLIST_4_COLUMN'].'</th>
			<th class="tables">'.$lang['PLAYERLIST_5_COLUMN'].'</th>
			<th class="tables">'.$lang['PLAYERLIST_6_COLUMN'].'</th>
		</tr> '; ?>
	</thead>
   <tbody>
		<? echo $content; ?>
   </tbody>
</table>

<div id="bottom_anchor"></div>
</div>
<? }
$mysqli->close(); ?>