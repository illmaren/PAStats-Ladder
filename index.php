<? 
header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE>
<? include'include/header.php'; 
?>
<html>
	<head>
		<title>PA Ladder</title>

		<script src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/jquery.min.js"></script>
		<script src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/skel.min.js"></script>
		<script src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/skel-layers.min.js"></script>
		<script type="text/javascript" src="http://paladder.com/include/js/jquery-latest.js"></script> 
		<script src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/init.js"></script>
		
			<link rel="stylesheet" type="text/css" href="http://dev.illmaren.de/css/skel.css" />
			<link rel="stylesheet" type="text/css" href="http://dev.illmaren.de/css/style.css" />
			<link rel="stylesheet" type="text/css" href="http://dev.illmaren.de/css/style-mobile.css" />
		
	
		<script type="text/javascript" src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/jquery.tablesorter.widgets.js"></script>
		<script type="text/javascript" src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/jquery.tablesorter.pager.js"></script>
		
		<script src="http://<? echo $_SERVER['HTTP_HOST']; ?>/include/ckeditor/ckeditor.js"></script>
		<link rel="stylesheet" href="http://<? echo $_SERVER['HTTP_HOST']; ?>/include/ckeditor/sample/sample.css">
		<!--[if lte IE 9]><link rel="stylesheet" href="http://<? echo $_SERVER['HTTP_HOST']; ?>/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><script src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/html5shiv.js"></script><![endif]-->

		<script>
			function moveScroll(){
				var scroll = $(window).scrollTop();
				var anchor_top = $("#my-table").offset().top;
				var anchor_bottom = $("#bottom_anchor").offset().top;
				if (scroll>anchor_top && scroll<anchor_bottom) {
				clone_table = $("#clone");
				if(clone_table.length == 0){
					clone_table = $("#my-table").clone();
					clone_table.attr('id', 'clone');
					clone_table.css({position:'fixed',
							 'pointer-events': 'none',
							 top:0});
					clone_table.width($("#my-table").width());
					$("#table-container").append(clone_table);
					$("#clone").css({visibility:'hidden'});
					$("#clone thead").css({visibility:'visible'});
				}
				} else {
				$("#clone").remove();
				}
			}
			$(window).scroll(moveScroll);
			
			var jq1102 = jQuery.noConflict();
			window.onload = function(){
				$("#loading").hide();
			}
			$(document).ready(function(){
				$('#loadinglink').click(function() {
					$('#loading').toggle();
				});
			});
			function loading()
            {
				$("#loading").show();
			}
		</script>
		<script type="text/javascript" src="http://paladder.com/include/js/jquery.tablesorter.js"></script>
	</head>
	<body class="subpage">
	<div id="loading">
		<div style="float:left; top: 15px;
position: absolute;
left: 100px;">
			<!--<img style="height:50px; width:50px;" src="http://www.eartesan.com/wp-content/themes/eartesan/images/loading.gif">
		--></div>
		<div style="float:right; float: right;
top: 30px;
position: absolute;
right: 130px;">
			Page Loading...
		</div>
		<div style="clear:both;"></div>
	</div>
	<!-- Header -->
			<div id="header-wrapper">
				<header id="header" class="container">
					<div class="row">
						<div class="12u">
							<div style="position:absolute; right:0px; color:white;">
								<? if($loginuser){ ?>
									Hello <a style="color:white; text-decoration:none;" href="http://<? echo $_SERVER['HTTP_HOST']; ?>/ucp"><? echo $loginuser; ?></a>
									<a style="color:white; text-decoration:none;" href="http://<? echo $_SERVER['HTTP_HOST']; ?>/logout"> | Logout </a>
								<? }else{ ?>
									<a style="color:white; text-decoration:none;" href="http://<? echo $_SERVER['HTTP_HOST']; ?>/login">Login </a>
								<? } ?>
							</div>
							<!-- Logo -->
								<h1><a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/home" id="logo">PA Ladder</a></h1>
							<!-- Nav -->
								<nav id="nav">
									<a <? if($url[1] == "home"){ ?>style="text-shadow: 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77;"<? } ?> href="http://<? echo $_SERVER['HTTP_HOST']; ?>/home">Home</a>
									<!-- 
									<a <? if($url[1] == "forum"){ ?>style="text-shadow: 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77;"<? } ?> href="http://<? echo $_SERVER['HTTP_HOST']; ?>/forum">Forum</a>
									-->
									<a onclick="return loading();" <? if($url[1] == "playerlist"){ ?>style="text-shadow: 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77;"<? } ?> href="http://<? echo $_SERVER['HTTP_HOST']; ?>/playerlist">Playerlist</a>
									<a onclick="return loading();" <? if($url[1] == "1on1"){ ?>style="text-shadow: 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77;"<? } ?> href="http://<? echo $_SERVER['HTTP_HOST']; ?>/1on1">1on1</a>
									<a onclick="return loading();" <? if($url[1] == "2on2"){ ?>style="text-shadow: 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77;"<? } ?> href="http://<? echo $_SERVER['HTTP_HOST']; ?>/2on2">2on2</a>
									<a onclick="return loading();" <? if($url[1] == "uberskill"){ ?>style="text-shadow: 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77;"<? } ?> href="http://<? echo $_SERVER['HTTP_HOST']; ?>/uberskill">UberSkill</a>
									<a <? if($url[1] == "chat"){ ?>style="text-shadow: 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77, 0 0 15px #88FF77;"<? } ?> href="http://<? echo $_SERVER['HTTP_HOST']; ?>/chat">Chat</a>
								</nav>

						</div>
					</div>
				</header>
			</div>
		<!-- Content -->
			<div id="content-wrapper">
				<div id="content">
					<div class="container">
						<div class="row">
							<div class="9u">
								<!-- Main Content -->
									<? if(($url[1] == "") OR ($url[1] == "home") OR ($url[1] == "chat") OR ($url[1] == "news") OR ($url[1] == "forum")){
										include 'core.php';
									}else{ ?>
										<section style="margin:0px 0px 2%; <? if($url[1] == "player"){ echo "padding:0px;"; }?>">
											<!-- <header><h2>Content Title</h2></header> -->
											<? include 'core.php'; ?>
										</section>
									<? } ?>
							</div>
							<div class="3u">
								<!-- Sidebar -->
									<? include 'core_sidebar.php'; ?>
									<? loadsidebar("stats"); ?>
									<? loadsidebar("onestats"); ?>
									
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- Footer -->
			<div id="footer-wrapper">
				<footer id="footer" class="container">
					<div class="row">
						<div class="8u">
							<!-- Links -->
								<section>
									<h2>Links to Important Stuff</h2>
									<div>
										<div class="row">
											<div class="3u">
												<ul class="link-list last-child">
													<li><a href="http://exodusesports.com/">eXodus eSports</a></li>
													<li><a href="http://pastats.com">PAStats</a></li>
													<li><a href="http://palobby.com">PALobby</a></li>
												</ul>
											</div>
											<div class="3u">
												<ul class="link-list last-child">
													<li><a href="http://beta.paladder.com/faq">PALadder FAQ</a></li>
													<li><a href="http://pa-db.com/">PA DB</a></li>
													<li><a href="http://pamatches.com/">PA Matches</a></li>
													<li><a href="http://www.pa-mods.com/">PA Mods</a></li>
												</ul>
											</div>
											<div class="3u">
												<ul class="link-list last-child">
													<li><a href="http://www.uberent.com/pa/">Official PA Site</a></li>
													<li><a href="https://forums.uberent.com/categories/planetary-annihilation.60/">Official PA Forum</a></li>
													<li><a href="http://www.ign.com/wikis/planetary-annihilation">Official PA Wiki</a></li>
												</ul>
											</div>
										</div>
									</div>
								</section>
						</div>
						<div class="4u">		
							<!-- Blurb -->
								<section style="color:black;">
									<h2>Informationen</h2>
									<p>
										Welcome to the PA Stats ladder. 
										Here you will find a ladder based on data from PA Stats.
										Click 1v1 above to show all 1v1 games. 1v1 Games are rated using ELO,
										note the special "Anon" who stands for all players who do not use PA Stats.
										Also note that currently only games with exactly 2 players are added as 1v1.
									</p>
								</section>
						</div>
					</div>
				</footer>
			</div>
		<!-- Copyright -->
			<div id="copyright">
				&copy; Illmaren. All rights reserved.
				<br><?
					$time_end = mymicrotime();   
					$time = round($time_end - $time_start,4);   
					printf(@$lang[RENDERED], $time);
				?>
			</div>
<script type="text/javascript">
var LHCChatOptions = {};
LHCChatOptions.opt = {widget_height:340,widget_width:300,popup_height:520,popup_width:500};
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
var refferer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
po.src = '//support.wrath-wow.com/index.php/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(top)/350/(units)/pixels/(leaveamessage)/true/(department)/3?r='+refferer+'&l='+location;
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>
	</body>
</html>