<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - Playerinfo</title>', ob_get_clean());
echo str_replace('<header><h2>Content Title</h2></header>', '', ob_get_clean());

if (!defined('init_pages'))
{	
	header('HTTP/1.0 404 not found');
	exit;
}
loadclass("dbconnect");
loadclass("playerlist");
$db = new db();
$player = escape($db, $url[2]);

$sql_one = "SELECT SUM(duration) as tim, Count(id) AS sum FROM 1on1_player_game_relations WHERE player = $player";
$sql_two = "SELECT SUM(duration) as tim, Count(id) AS sum FROM 2on2_player_game_relations WHERE player = $player";
$sql = "SELECT SUM(duration) as tim, count(id) as sum FROM player_game_relations WHERE player = $player";

$sql_one = $db->query($sql_one);
$one = mysqli_fetch_array($sql_one);

$sql_two = $db->query($sql_two);
$two = mysqli_fetch_array($sql_two);

$result = $db->query($sql);
$result = mysqli_fetch_array($result);

$query_info = "SELECT id, name, rating, 2on2_rating, oldrating FROM player WHERE id = '$player'";
$info = $db->prepare( $query_info );
$info->execute();
$info->bind_result( $id, $name, $rating, $rating2, $oldrating );
$info->fetch();
?>
	<script type="text/javascript">
		var jq142 = jQuery.noConflict();
		$(document).ready(function() { 
			// call the tablesorter plugin 
			$("table").tablesorter({ 
			// sort on the first column order asc 
			sortList: [[0,1]] 
			}); 
		}); 
	</script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script> 
			var jq1102 = jQuery.noConflict();
						
			$(document).ready(function(){
				$("#flip").click(function(){
					$("#panel").show();
						$("#panel1").hide();
						$("#panel2").hide();
						
						$("#foo").attr("class","active");
						$("#foo1").removeClass("active");
						$("#foo2").removeClass("active");
				});
			});
			$(document).ready(function(){
				$("#flip1").click(function(){
					$("#panel1").show();
						$("#panel").hide();
						$("#panel2").hide();
						
						$("#foo1").attr("class","active");
						$("#foo").removeClass("active");
						$("#foo2").removeClass("active");
				});
			});
			
			$(document).ready(function(){
				$("#flip2").click(function(){
					$("#panel2").show();
						$("#panel").hide();
						$("#panel1").hide();
						
						$("#foo2").attr("class","active");
						$("#foo").removeClass("active");
						$("#foo1").removeClass("active");
				});
			});
		</script>
<div class="user-view user-account">
	<div class="isleft">
		<div class="left40" style="height:287px;">
			<div class="user-desc">
				<h2><? echo $name; ?>
					<span style="color:#9A9A9A">
					<?
						include "include/classes/class.rank.php";
					?>
					</span>
				</h2>
				<div style="text-align:center; width:50%; float:left;">
					Rating<br>
					Oldrating<br>
					2on2 Rating<br>
					1on1 Playedtime<br>
					2on2 Playedtime<br>
					Overall Playedtime<br>
					<a href="http://www.pastats.com/player?player=<? echo $id; ?>">PAStats</a>
				</div>
				<div style="text-align:center; width:50%; float:right;">
					<? echo $rating; ?><br>
					<? echo $oldrating; ?><br>
					<? echo $rating2; ?><br>
					<? $secs = round($one["tim"] / 1000,0);
						
						$now = date_create('now', new DateTimeZone('GMT'));
						$here = clone $now;
						$here->modify($secs.' seconds');
						$diff = $now->diff($here);
					echo $diff->format('%dd %hh %im %ss'); ?><br>
					<? $secs = round($two["tim"] / 1000,0);
						
						$now = date_create('now', new DateTimeZone('GMT'));
						$here = clone $now;
						$here->modify($secs.' seconds');
						$diff = $now->diff($here);
					echo $diff->format('%dd %hh %im %ss'); ?><br>
					<? $secs = round($result["tim"] / 1000,0);
						
						$now = date_create('now', new DateTimeZone('GMT'));
						$here = clone $now;
						$here->modify($secs.' seconds');
						$diff = $now->diff($here);
					echo $diff->format('%mm %dd %hh %im %ss'); ?><br>
					<a href="http://exodusesports.com/?pastats_player_id=<? echo $id; ?>">eXodus</a>
				</div>
				<div style="clear:both;"></div>
				
				<div id="staff-tabs1" style="position:relative; top:5px;">
					<ul>
						<li id="foo" class="active">
							<a class="user-chars-realm version6" id="flip">1on1 (<? echo $one[sum]; ?>)</a>
						</li>
						<li id="foo1">
							<a class="user-chars-realm version6" id="flip1">2on2 (<? echo $two[sum];?>)</a>
						</li>
						<li id="foo2">
							<a class="user-chars-realm version6" id="flip2">all (<? echo $result[sum]; ?>)</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="isright" style="height:287px;">
		<div class="left60 isright" style="text-align:center; height:100%;">
			<? if($player == "-1"){ 
				echo "<div style='text-align:left !important;'>Anon is not an Real player. Anon was Generated automatically by the System to Store Games with \"Non PAStats\" Player within.<br>He does never take part in any 1on1 Games so the Tab \"1on1\" will never be anything but \"0\". </div>";
			}else{ ?>
			<img style="max-width:100%;" alt="You must play atleast two games and be active in 1on1 Ladder to get an Signature." src="../sig/<? echo $url[2]; ?>.png">
			<div style="width:100%; min-height:100; background:#;">
				<br>
				BBCode for Board Embbed
				<br>
				<textarea class="button" rows="2" style="width:90%;">[url=http://<? echo $_SERVER['HTTP_HOST']; ?>/player/<? echo $url[2]; ?>][img]http://<? echo $_SERVER['HTTP_HOST']; ?>/sig/<? echo $url[2]; ?>.png[/img][/url]</textarea>
			</div>
			<? } ?>
		</div>
	</div>
</div>
<div style="height:7px;"></div>
<?
$info->close();
?>
<div id="panel" style="min-height:200px;">
	<table class="ladder" cellspacing="1" style="width:100%; border-spacing: 1px; border-collapse: separate;" id="tablesorter">
		<thead>
			<tr style="color:white; background:#222">
				<th class="tables">##</th>
				<th class="tables">GameID</th>
				<th class="tables"></th>
				<th class="tables">Against</th>
				<th class="tables">Game started</th>
				<th class="tables">duration</th>
				<th class="tables">Rating</th>
				<th class="tables">Diff</th>
			</tr>
		</thead>
		<tbody>
		<?
			$sql="SELECT team_id, game, time, duration, automatch FROM 1on1_player_game_relations where player = '$player' ORDER by game DESC limit 20";
			$ergebnis = $db->prepare( $sql );
			$ergebnis->execute();
			$ergebnis->bind_result( $team_id, $game, $time, $duration, $automatch );
			$ergebnis->store_result();
			$number = $ergebnis->num_rows;
			if($number == "0"){
				echo "<tr><td colspan='8' style='text-align:center; color:white;'>No Records found</td></tr>";
			}
			
			$c = $one[sum] + 1;
			while ($ergebnis->fetch()){
				$c--;
				
				$secs = round($duration / 1000,0);
				
				$now = date_create('now', new DateTimeZone('GMT'));
				$here = clone $now;
				$here->modify($secs.' seconds');
				$diff = $now->diff($here);
		?>
			<tr class="ladder" style="text-align:center; color:white;">
				<td><? echo $c; if($automatch == "1"){ echo "*"; } ?></td>
				<td><a onclick="return loading();" href="http://pastats.com/chart?gameId=<? echo $game; ?>"><? echo $game; ?></a></td>
				<td><? winner($game, $team_id, $db); ?></td>
				<td><? against($game, $url[2], $db); ?></td>
				<td><? echo timea($time, "2"); ?></td>
				<td><? echo $diff->format('%im %ss'); ?></td>
				<td><? differenced($db, $team_id, $game, "rating"); ?></td>
				<td><? differenced($db, $team_id, $game, "difference"); ?></td>
			</tr>
		<? 
			}
			$ergebnis->close();
		?>
		</tbody>
	</table>
	* It's an Automatch Game
</div>
<? ////////////////////////////////////////////////////// ?>
<div id="panel1" style="min-height:200px;">
	<table class="ladder" cellspacing="1" style="width:100%; border-spacing: 1px; border-collapse: separate;" id="tablesorter">
		<thead>
			<tr style="color:white; background:#222">
				<th class="tables">##</th>
				<th class="tables">GameID</th>
				<th class="tables"></th>
				<th class="tables">Game started</th>
				<th class="tables">duration</th>
			</tr>
		</thead>
		<tbody>
		<?
			$sql="SELECT team_id, game, time, duration FROM 2on2_player_game_relations where player = '$player' ORDER by game DESC limit 20";
			$ergebnis = $db->prepare( $sql );
			$ergebnis->execute();
			$ergebnis->bind_result( $team_id, $game, $time, $duration );
			$ergebnis->store_result();
			$number = $ergebnis->num_rows;
			if($number == "0"){
				echo "<tr><td colspan='5' style='text-align:center; color:white;'>No Records found</td></tr>";
			}
			$c = $two[sum] + 1;
			while ($ergebnis->fetch()){
				$c--;
				
				$secs = round($duration / 1000,0);
				
				$now = date_create('now', new DateTimeZone('GMT'));
				$here = clone $now;
				$here->modify($secs.' seconds');
				$diff = $now->diff($here);
		?>
			<tr class="ladder" style="text-align:center; color:white;">
				<td><? echo $c; ?></td>
				<td><a onclick="return loading();" href="http://pastats.com/chart?gameId=<? echo $game; ?>"><? echo $game; ?></a></td>
				<td><? winner($game, $team_id, $db); ?></td>
				<td><? echo timea($time, "2"); ?></td>
				<td><? echo $diff->format('%im %ss'); ?></td>
			</tr>
		<? 
			}
			$ergebnis->close();
		?>
		</tbody>
	</table>
</div>
<? ////////////////////////////////////////////////////// ?>
<div id="panel2" style="min-height:200px;">
	<table class="ladder" cellspacing="1" style="width:100%; border-spacing: 1px; border-collapse: separate;" id="tablesorter">
		<thead>
			<tr style="color:white; background:#222">
				<th class="tables">##</th>
				<th class="tables">GameID</th>
				<th class="tables"></th>
				<th class="tables">Game started</th>
				<th class="tables">duration</th>
			</tr>
		</thead>
		<tbody>
		<?
			$sql="SELECT team_id, game, time, duration FROM player_game_relations where player = '$player' ORDER by game DESC limit 20";
			$ergebnis = $db->prepare( $sql );
			$ergebnis->execute();
			$ergebnis->bind_result( $team_id, $game, $time, $duration );
			$ergebnis->store_result();
			$number = $ergebnis->num_rows;
			if($number == "0"){
				echo "<tr><td colspan='5' style='text-align:center; color:white;'>No Records found</td></tr>";
			}
			$c = $result[sum] + 1;
			while ($ergebnis->fetch()){
				$c--;
				$secs = round($duration / 1000,0);
				
				$now = date_create('now', new DateTimeZone('GMT'));
				$here = clone $now;
				$here->modify($secs.' seconds');
				$diff = $now->diff($here);
		?>
			<tr class="ladder" style="text-align:center; color:white;">
				<td><? echo $c; ?></td>
				<td><a onclick="return loading();" href="http://pastats.com/chart?gameId=<? echo $game; ?>"><? echo $game; ?></a></td>
				<td><? winner($game, $team_id, $db); ?></td>
				<td><? echo timea($time, "2"); ?></td>
				<td><? echo $diff->format('%im %ss'); ?></td>
			</tr>
		<? 
			}
			$ergebnis->close();
		?>
		</tbody>
	</table>
</div>
<?
$db->close();
?>