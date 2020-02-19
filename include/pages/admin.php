<?
if ($_SESSION["user_id"]) 
{
	$right = $_SESSION["user_id"];

	loadclass("dbconnect");
	$db = new db();

	$right_string = getright($db, $right);
	$rights = explode(" ", $right_string);
	
		if(($rights[0]) OR ($rights[1]) OR ($rights[2]) OR ($rights[3])){
			echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - AdminCP</title>', ob_get_clean());
			echo str_replace('<h2>Content Title</h2>', '<h2>AdminCP</h2>', ob_get_clean());
			
			if($url[2] == ""){
				echo "<a href='../admin/gameserver'>Server</a>";
			}elseif($url[2] == "gameserver"){
				loadclass("gameserver");
				
				$serverid = "121846";
				$j = new JiffyBox($serverid);  
				$status = $j->getInfo()->status;
				$running = $j->getInfo()->running;
				if($status == "FROZEN"){
					$status = "Frozen";
					$start = '<a href="../../../admin/gameserver/start/'.$serverid.'">Start</a>';
				}elseif($status == "THAWING"){
					$status = "Thawing";
					$start = "Thaw...";
				}elseif(($status == "READY") AND ($running == "")){
					$status = "Ready";
					$start = '<a href="../../../admin/gameserver/startserver/'.$serverid.'">Start</a>';
				}elseif(($status == "UPDATING") AND ($running == "")){
					$status = "Ready";
					$start = 'Updating...';
				}elseif(($status == "READY") AND ($running == "1")){
					$status = "Online";
					$start = '<a href="../../../admin/gameserver/stop/'.$serverid.'">Stop</a>';
				}

				echo '
				<table style="width:200px;">
				<tr style="border-bottom: 1px solid #E2E6E8;">
					<td style="width:33%; text-align:center;">Test Server</td>
					<td style="width:33%; text-align:center;">'.$status.'</td>
					<td style="width:34%; text-align:center;">'.$start.'</td>	
				</tr></table>';
				if($url[3] == "start"){
					$server = $url[4];
					//$j = new JiffyBox($server); 
					echo $j->thaw("33");
					sleep(1);
					echo '<meta http-equiv="refresh" content="0;url=http://'.$_SERVER['HTTP_HOST'].'/admin/gameserver">';
				}elseif($url[3] == "stop"){
					$server = $url[4];
					$j = new JiffyBox($server); 
					$j->stop();
					echo "Stopping Server";
					sleep(1);
					$j->freeze();
					echo '<meta http-equiv="refresh" content="0;url=http://'.$_SERVER['HTTP_HOST'].'/admin/gameserver">';
				}elseif($url[3] == "startserver"){
					$server = $url[4];
					$j = new JiffyBox($server);  
					sleep(1);
					$j->start();
					echo '<meta http-equiv="refresh" content="0;url=http://'.$_SERVER['HTTP_HOST'].'/admin/gameserver">';
				}
			}
			
			
			
			
			
			
		}else{
			header('Location:../login');
		}
}else{
	header('Location:../login');
}

?>