<?
function adfly($url, $key, $uid, $domain = 'link.pastats.tk', $advert_type = 'int')
{
return $url;
/*
  // base api url
  $api = 'http://api.adf.ly/api.php?';

  // api queries
  $query = array(
    'key' => $key,
    'uid' => $uid,
    'advert_type' => $advert_type,
    'domain' => $domain,
    'url' => $url
  );

  // full api url with query string
  $api = $api . http_build_query($query);
  // get data
  if ($data = file_get_contents($api))
    return $data;
	*/
}

function against($game){
	global $mysqli;
	global $player_escape;
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
	$ergebnis = $mysqli->prepare( $sql );
    $ergebnis->execute();
    $ergebnis->bind_result( $id, $name, $player );
    while ($ergebnis->fetch()){
		if($player_escape == $player){
	
		}else{
			print_r('<a href="../player/'.$id.'">'.$name.'</a> ');
		}
	}
}


function adflysig($url, $key, $uid, $domain = 'sig.pastats.tk', $advert_type = 'int')
{
  // base api url
  $api = 'http://api.adf.ly/api.php?';

  // api queries
  $query = array(
    'key' => $key,
    'uid' => $uid,
    'advert_type' => $advert_type,
    'domain' => $domain,
    'url' => $url
  );

  // full api url with query string
  $api = $api . http_build_query($query);
  // get data
  if ($data = file_get_contents($api))
    return $data;
}

function mymicrotime() {   
list($usec, $sec) = explode(" ",microtime());   
return ((float)$usec + (float)$sec);   
}

function safe($value){
   return mysql_real_escape_string($value);
}

function safing($value){
   return mysqli_real_escape_string($value);
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


function visitor($lang){
phpFastCache::$storage = "memcached";
$day = phpFastCache::get("day");
$week = phpFastCache::get("week");
$lastweek = phpFastCache::get("lastweek");
if(($day == null) OR ($week == null) OR ($lastweek == null)){
	$json_viss = file_get_contents ("http://195.5.121.117/piwik/index.php?module=API&method=VisitsSummary.getVisits&idSite=2&period=week&date=today&format=json&token_auth=44fc1c58180b8df3c95b29f2314fdd67");
	$json_vis = file_get_contents ("http://195.5.121.117/piwik/index.php?module=API&method=VisitsSummary.getVisits&idSite=2&period=day&date=today&format=json&token_auth=44fc1c58180b8df3c95b29f2314fdd67");
	$json_lastweek = file_get_contents ("http://195.5.121.117/piwik/index.php?module=API&method=VisitsSummary.getVisits&idSite=2&period=week&date=yesterday&format=json&token_auth=44fc1c58180b8df3c95b29f2314fdd67");

	
	$visitor_lweek = json_decode($json_lastweek);
	$lastweek = $visitor_lweek->value;
	
	$visitor_week = json_decode($json_viss);
	$week = $visitor_week->value;
	$visitor_day = json_decode($json_vis);
	$day = $visitor_day->value;
	
	phpFastCache::set("lastweek",$lastweek,1800);
	phpFastCache::set("day",$day,1800);
	phpFastCache::set("week",$week,1800);
}
printf($lang, $day, $week, $lastweek);
}

function winner($game, $teamid){
$sqls="SELECT * FROM game WHERE id = $game";
		$wins = $mysqli->query($sqls);
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

function win($game){
	global $team_id;
	global $mysqli;
	$sqls="SELECT * FROM game WHERE id = $game";
	$wins = $mysqli->query($sqls);
	$win = mysqli_fetch_assoc($wins);
		if($win[winner] == $team_id){ 
			echo'<font color="green">won</font>'; 
		}elseif($win[winner] == "-1"){ 
			echo'<font color="orange">draw</font>'; 
		}else{
			echo'<font color="red">loss</font>'; 
		}
	$win->close;
}
function menu (){
	 $sql="SELECT * FROM menu ORDER by ord ASC";
	  $result = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_assoc($result)){

		if($_SERVER['REQUEST_URI'] == $row[href]){
			print_r('
				<a href="'.$row[href].'">
					<div style="width:80px;	height:50px; 
						text-align:center;
						background-color: #101010;
						float:left;
						line-height:50px;
						margin:0 auto; 
						color:white;
						display: table;
						border-left-width:1px;
						border-left-style:solid;
						border-left-color:white; 
						border-right-width:1px;
						border-right-style:solid;
						border-right-color:white; 
					">
						'.$row[name].'
					</div>
				</a>
				');

		}else{
			print_r('
				<a href="'.$row[href].'">
					<div class="menu" style="width:80px;">'.$row[name].'</div>
				</a>
				');
		}
	}
}

function differenced($gameid, $display, $newrating, $oldrating) {
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



function blaetterfunktion($seite,$maxseite,$url="",$anzahl=4,$get_name="")
   {

   if($anzahl%2 != 0) $anzahl++; //Wenn $anzahl ungeraden, dann $anzahl++

   $a = $seite-($anzahl/2);
   $b = 0;
   $blaetter = array();
   while($b <= $anzahl)
      {
      if($a > 0 AND $a <= $maxseite)
         {
         $blaetter[] = $a;
         $b++;
         }
      else if($a > $maxseite AND ($a-$anzahl-2)>=0)
         {
         $blaetter = array();
         $a -= ($anzahl+2);
         $b = 0;
         }
      else if($a > $maxseite AND ($a-$anzahl-2)<0)
         {
         break;
         }

      $a++;
      }
   $return = "";
   
   if(!in_array(1,$blaetter) AND count($blaetter) > 1)
      {
      if(!in_array(2,$blaetter)) $return .= "&nbsp;<a href=\"{$url}{$anhang}{$get_name}1\">1</a>&nbsp;...";
      else $return .= "&nbsp;<a href=\"{$url}{$anhang}{$get_name}1\">1</a>&nbsp;";
      }
$maxseite = round($maxseite, 0);
$maxseite = $maxseite + 1;
   foreach($blaetter AS $blatt)
      {
      if($blatt == $seite) $return .= "&nbsp;<b>$blatt</b>&nbsp;";
      else $return .= "&nbsp;<a href=\"{$url}{$anhang}{$get_name}$blatt\">$blatt</a>&nbsp;";
      }
   if(!in_array($maxseite,$blaetter) AND count($blaetter) > 1)
      {
      if(!in_array(($maxseite),$blaetter)) $return .= "...&nbsp;<a href=\"{$url}{$anhang}{$get_name}$maxseite\">last</a>&nbsp;";
      else $return .= "&nbsp;<a href=\"{$url}{$anhang}{$get_name}$maxseite\">$maxseite</a>&nbsp;";
      }

   if(empty($return))
      return  "&nbsp;<b>1</b>&nbsp;";
   else
      return $return;
   }

?>