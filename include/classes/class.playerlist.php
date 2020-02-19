<?
function against($game, $playere, $db){
	$sql="
	SELECT
		p.id,
		p.name,
		r.player
	FROM
		player_game_relations r
		left outer join player p on (p.id = r.player)
	WHERE
		r.game = '$game'
	GROUP BY
		p.id,
		p.name,
		p.rating
	";
	$ergebnis = $db->prepare( $sql );
    $ergebnis->execute();
    $ergebnis->bind_result( $id, $name, $player );
    while ($ergebnis->fetch()){
		if($playere == $player){
	
		}else{
			print_r('<a onclick="return loading();" href="../player/'.$id.'">'.$name.'</a> ');
		}
	}
}

	function ratio($win, $loss){
		$ratiopro = (($win) / ($win + $loss)) * 100;
		$ratiopro = round($ratiopro, 2);
		if($ratiopro == "100"){
			$ratio = $win;
		}else{
			$ratio = ($win / $loss);
			$ratio = round($ratio, 2);
		}
		return $ratio;
	}
	
	function rank($c, $active, $oldrank, $id, $koth){
		if($active == 1){
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
			$rank = "$ranking";
		}
		return $rank;
	}
	
	function tenborder($c){
		if(($c >= 10) AND ($c <= 10)) {
			$border= "border-bottom:4px double black; padding-bottom:4px;";
		}elseif($c == 11){
			$border = "";
		}
		return $border;
	}
	
	function firstbold($c){
		if(($c >= 1) AND ($c <= 1)) {
			$bold= "font-weight: bold; ";
		}elseif($c == 2){
			$bold = "";
		}
		return $bold;
	}
	
	function timea($time, $format){
		$timea = $time / 1000;
		if($format == "1"){
		$datum = date("l jS \of F Y h:i:s a",$timea);
		}elseif($format == "2"){
		$datum = date("F j, Y, g:i a",$timea);
		}
		print_r($datum);
	}
	
	function winner($game, $teamid, $db){
	$sqls="SELECT * FROM game WHERE id = $game";
			$wins = $db->query($sqls);
			$win = mysqli_fetch_assoc($wins);
		
		if($win[winner] == $teamid){ 
			echo'<font color="green">won</font>'; 
		}elseif($win[winner] == "-1"){ 
			echo'<font color="orange">draw</font>'; 
		}else{
			echo'<font color="red">loss</font>'; 
		}
	$win->close;
	}
	
	function differenced($db, $team_id, $gameid, $display) {
	
			if($team_id == "1"){ 
				$sql_rating = "SELECT pla_oldrating as oldrating, pla_newrating as newrating FROM 1on1_recent WHERE gameid = $gameid";
				$result_rating = $db->query($sql_rating);
				$row_rating = mysqli_fetch_assoc($result_rating);
			}elseif($team_id == "0"){ 
				$sql_rating = "SELECT plb_oldrating as oldrating, plb_newrating as newrating FROM 1on1_recent WHERE gameid = $gameid";
				$result_rating = $db->query($sql_rating);
				$row_rating = mysqli_fetch_assoc($result_rating);
			}
			$newrating = $row_rating[newrating];
			$oldrating = $row_rating[oldrating];
			
		if($display == "difference"){	
		
			$difference = $newrating - $oldrating;
			if($difference == "0"){
				print_r('<font style="color:white">'.$difference.'</font>');
			}elseif($difference >= "1"){
				print_r('<font style="color:green">'.$difference.'</font>');
			}elseif($difference <= "-1"){
				print_r('<font style="color:red">'.$difference.'</font>');
			}
			
		}elseif($display == "rating"){
		
			$rating = $oldrating;
			print_r($rating);
			
		}
	}