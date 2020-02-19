<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - User ControlPanel</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>User ControlPanel</h2>', ob_get_clean());
$id = $loginuserid;
if(!$id){
?><meta http-equiv="refresh" content="0;url=http://<? echo $_SERVER['HTTP_HOST']; ?>/login"> <?

}
loadclass("dbconnect");
loadclass("admin");
$db = new db();

$id = escape($db, $id);
$sql="SELECT * FROM user WHERE id = '$id'";
$user = $db->query($sql);
$user = mysqli_fetch_array($user);
$rights = rights($db, $id);

?>
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
<center>
<div class="user-view user-account">
	<div class="isleft">
		<div class="left40">
			<div class="user-desc">
				<h2><? echo $user[user]; ?>
					<span style="color:#9A9A9A">
					<? 
						if($rights[0] == 1){
							echo "Administrator";
						}else{
							echo "Registered";
					} ?>
					</span>
				</h2>
				<div style="text-align:left; float:left;">
					E-Mail: <? echo $user[email]; ?><br>
					Balance: <? echo $user[fund]; ?> Coins
				</div>
				<div style="text-align:left; float:right;">
					Threads: <? echo $user[forum_thread]; ?><br>
					Posts: <? echo $user[forum_post]; ?><br>
					Comments: <? echo $user[user_comment]; ?>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
	</div>
	<div class="isright">
		<div class="left60 isright">
			<div id="staff-tabs1">
				<ul>
					<li id="foo" class="active">
						<a class="user-chars-realm version6" id="flip">Threads</a>
					</li>
					<li id="foo1">
						<a class="user-chars-realm version6" id="flip1">Posts</a>
					</li>
					<li id="foo2">
						<a class="user-chars-realm version6" id="flip2">Comments</a>
					</li>
				</ul>
				<? ////////////////////////////////////////////////////////////////// ?>
				<div id="panel">
					<table class="ladder" cellspacing="1" style="width:100%; border-spacing: 1px; border-collapse: separate;" id="tablesorter">
						<thead>
							<tr style="background:#222">
								<th>Name</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
						<? 
						$sql="SELECT forum_theard.`name` AS `name`, forum_theard.date AS date FROM
						`forum_theard` WHERE forum_theard.author_id = $user[id] ORDER BY forum_theard.date ASC LIMIT 5";
							$thread = $db->prepare( $sql );
							$thread->execute();
							$thread->bind_result( $title, $date);
						while ($thread->fetch()){ ?>
							<tr class="ladder">
								<td><? echo $title; ?></td>
								<td><? echo date('H:i',$date); ?></td>
							</tr>
						<? } ?>
						</tbody>
					</table>
				</div>
				<? ////////////////////////////////////////////////////////////////// ?>
				<div id="panel1">
					<table class="ladder" cellspacing="1" style="width:100%; border-spacing: 1px; border-collapse: separate;" id="tablesorter">
						<thead>
							<tr style="background:#222">
								<th>Name</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
						<? 
						$sql = "SELECT forum_theard.`name` AS `name`, forum_posts.date AS date, forum_posts.id AS id FROM 
						forum_posts , forum_theard WHERE forum_posts.author_id = $user[id] LIMIT 5"; 
							$thread = $db->prepare( $sql );
							$thread->execute();
							$thread->bind_result( $title, $date);
						while ($thread->fetch()){ ?>
							<tr class="ladder">
								<td><? echo $title; ?></td>
								<td><? echo date('H:i',$date); ?></td>
							</tr>
						<? } ?>
						</tbody>
					</table>
				</div>
				<? ////////////////////////////////////////////////////////////////// ?>
				<div id="panel2">
					<table class="ladder" cellspacing="1" style="width:100%; border-spacing: 1px; border-collapse: separate;" id="tablesorter">
						<thead>
							<tr style="background:#222">
								<th>Title</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
						<? 
						$sql = "SELECT news.title, news_comments.date FROM news_comments
						RIGHT OUTER JOIN news ON news.id = news_comments.news_id WHERE news_comments.author = $user[id] order by news_comments.date ASC LIMIT 5"; 
							$comments = $db->prepare( $sql );
							$comments->execute();
							$comments->bind_result( $title, $date);
						while ($comments->fetch()){ ?>
							<tr class="ladder">
								<td><? echo $title; ?></td>
								<td><? echo $date; ?></td>
							</tr>
						<? } ?>
						</tbody>
					</table>
				</div>
				<? ////////////////////////////////////////////////////////////////// ?>
			</div>
		</div>
	</div>
</div>
<br>
<div class="ucp-options">
<a style="text-decoration:none; color:white;" href="../pwchange">
<div style="height:90px; width:100%; background:#222; margin:2px;
	border-style: solid; text-align:left; padding:5px; border-color: black;
    border-width: 5px;">
		<b>Change password</b>
		<p>keep your password secured.</p>
</div>
</a>
<?
if($rights[0] == 1){
// Admin Area
?>
<a style="text-decoration:none; color:white;" href="../acp">
<div style="height:90px; width:100%; background:#222; margin:2px;
	border-style: solid; text-align:center; padding:5px; border-color: black;
    border-width: 5px;">
	Admin Area
</div>
</a>
<?
// Admin Area END
}
?>
</div>
</center>
