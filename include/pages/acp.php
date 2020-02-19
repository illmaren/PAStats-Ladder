<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - Admin ControlPanel</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>Admin ControlPanel</h2>', ob_get_clean());
$id = $loginuserid;
if(!$id){
?><meta http-equiv="refresh" content="0;url=http://<? echo $_SERVER['HTTP_HOST']; ?>/login"> <?
} ?>
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
<?
loadclass("dbconnect");
loadclass("admin");
$db = new db();
$rights = rights($db, $id);
if($rights[0] == 1){
	// Admin Area
?>
<div class="user-view user-account">
		<div class="left60 isright">
			<div id="staff-tabs1">
				<ul>
					<li id="foo" class="active">
						<a class="user-chars-realm version6" id="flip">Infos / Options</a>
					</li>
					<li id="foo1">
						<a class="user-chars-realm version6" id="flip1">Users</a>
					</li>
					<li id="foo2">
						<a class="user-chars-realm version6" id="flip2">Players</a>
					</li>
				</ul>
				<div id="panel">
					Some Infos and Options
				</div>
				<div id="panel1">
					<table class="ladder" cellspacing="1" style="color:white; width:100%; border-spacing: 1px; border-collapse: separate;" id="tablesorter">
						<thead>
							<tr style="background:#222">
								<th class="tables">Name</th>
								<th class="tables">E-Mail</th>
								<th class="tables">Funds</th>
								<th class="tables">Rights</th>
								<th class="tables">-</th>
							</tr>
						</thead>
						<tbody>
						<? 
						$sql="SELECT id, user, email, fund, rights FROM user";
							$thread = $db->prepare( $sql );
							$thread->execute();
							$thread->bind_result( $id, $user, $email, $fund, $rights);
						while ($thread->fetch()){ ?>
							<tr class="ladder">
								<td><? echo $user; ?></td>
								<td><? echo $email; ?></td>
								<td><? echo $fund; ?></td>
								<td><? echo $rights; ?></td>
								<td><a href="">Edit</a></td>
							</tr>
						<? } ?>
						</tbody>
					</table>
				</div>
				<div id="panel2">
					<table class="ladder" cellspacing="1" style="color:white; width:100%; border-spacing: 1px; border-collapse: separate;" id="tablesorter">
						<thead>
							<tr style="background:#222">
								<th class="tables">Name</th>
								<th class="tables">Uberskill Rank</th>
								<th class="tables">Rating 1on1 ELO</th>
								<th class="tables">Rating 2on2 ELO</th>
								<th class="tables">Active</th>
							</tr>
						</thead>
						<tbody>
						<? 
						$sql="SELECT id, name, uberskill, rating, 2on2_rating, active FROM player";
							$thread = $db->prepare( $sql );
							$thread->execute();
							$thread->bind_result( $id, $name, $uberskill, $rating, $rating2, $active);
						while ($thread->fetch()){ ?>
							<tr class="ladder">
								<td><? echo $name; ?></td>
								<td><? echo $uberskill; ?></td>
								<td><? echo $rating; ?></td>
								<td><? echo $rating2; ?></td>
								<td><? echo $active; ?></td>
							</tr>
						<? } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
</div>

<?
	// Admin Area END
}else{
?><meta http-equiv="refresh" content="0;url=http://<? echo $_SERVER['HTTP_HOST']; ?>/login"> <?
}
?>