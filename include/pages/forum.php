<section style="margin:0px 0px 0.5%;">
<a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/forum">Board</a>
</section>
<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - Forum</title>', ob_get_clean());

loadclass("dbconnect");
loadclass("forum");
$db = new db();
	if($url[3] == "thread"){
		$ergebnis = $db->query( "SELECT * FROM forum_category WHERE id = '$url[2]'" );
		$cat = $ergebnis->fetch_object();
		echo str_replace('Board</a>', 'Board</a> => '.$cat->name, ob_get_clean());
	?>
	<section>
		<form method="post" action="http://<? echo $_SERVER['HTTP_HOST']; ?>/forum/<? echo $url[2]; ?>/thread-sql">
			Title: <input type="text" name="title" value="">
			<fieldset>
				<textarea class="ckeditor" name="content"></textarea>
			</fieldset>
			<input type="submit" value="Enter Post">
		</form>
	</section>
	<?
	}elseif($url[3] == "thread-sql"){
	error_reporting(E_ALL);
ini_set("display_errors", 1);
				$title = escape($db, $_POST[title]);
				$content = escape($db, $_POST[content]);
				$user = $_SESSION['user_id'];
				$time = time();
				$ergebnis = $db->query( "SELECT * FROM user WHERE id = '$user'" );
				$name = $ergebnis->fetch_object();
				
				$query = "INSERT INTO forum_theard (category, date, name, content, author, author_id)
					VALUES ('$url[2]', '$time', '$title', '$content', '$name->user', '$user')";
				$db->query($query);
				count_user_threadpostcomment($db, $user, "thread");
				count_categorythread($db, $url[2], "0");
				
			$url = 'http://'.$_SERVER[HTTP_HOST].'/forum/'.$url[2];
			header("Location: $url");
	}elseif($url[4] == "post"){
				$content = escape($db, $_POST[content]);
				$user = $_SESSION[user_id];
				$time = time();
				
				$ergebnis = $db->query( "SELECT * FROM user WHERE id = '$user'" );
				$name = $ergebnis->fetch_object();
				
				$query = "INSERT INTO forum_posts (theard, date, author, author_id, content)
					VALUES ('$url[3]', '$time', '$name->user', '$user', '$content')";
				$db->query($query);
				count_user_threadpostcomment($db, $user, "post");
				count_categorythread($db, $url[2], $url[3]);
				
			$url = 'http://'.$_SERVER[HTTP_HOST].'/forum/'.$url[2].'/'.$url[3];
			header("Location: $url");
	}elseif($url[3]){
		$ergebnis = $db->query( "SELECT * FROM forum_category WHERE id = '$url[2]'" );
		$cat = $ergebnis->fetch_object();
		
		$sql="SELECT * FROM forum_theard WHERE id = '$url[3]'";
		$ergebnis = $db->query( $sql );
		$theard = $ergebnis->fetch_object();
		
		echo str_replace('Board</a>', 'Board</a> => <a href="http://'.$_SERVER['HTTP_HOST'].'/forum/'.$url[2].'">'.$cat->name.'</a> => '.$theard->name, ob_get_clean());
		?>
			
			<section style="margin:0px 0px 1%;">
				<header>
					<h2><? echo $theard->name; ?></h2>
					<h3><? echo $theard->author ?> - <? echo date('d M Y', $theard->date) ?></h3>
				</header>
					<? echo $theard->content; ?>
			</section>
			
		<?
		$sql="SELECT * FROM forum_posts WHERE theard = '$url[3]'";
		$ergebnis = $db->query( $sql );
		while($post = $ergebnis->fetch_object()){
		?>
			<section style="margin:0px 0px 0.5%;">
				<header>
					<h3><? echo $post->author ?> - <? echo date('d M Y', $post->date) ?></h3>
				</header>
					<? echo $post->content; ?>
			</section>
 		<?
		}
		if($loginuserid){ ?>
		<section>
			<form method="post" action="http://<? echo $_SERVER['HTTP_HOST']; ?>/forum/<? echo $url[2]; ?>/<? echo $url[3]; ?>/post">
				<fieldset>
					<textarea class="ckeditor" name="content"></textarea>
				</fieldset>
				<input type="submit" value="Enter Post">
			</form>
		</section>
		<? }
	}elseif($url[2]){
		$ergebnis = $db->query( "SELECT * FROM forum_category WHERE id = '$url[2]'" );
		$cat = $ergebnis->fetch_object();
		echo str_replace('Board</a>', 'Board</a> => '.$cat->name, ob_get_clean());
		
		$sql="SELECT * FROM forum_theard WHERE category = '$url[2]'";
		$ergebnis = $db->query( $sql );
		while($theard = $ergebnis->fetch_object()){
		?>
			
			<section style="margin:0px 0px 1%;">
					<a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/forum/<? echo $url[2]; ?>/<? echo $theard->id; ?>"><? echo $theard->name; ?></a>
			</section>
			<? 
		}
			if($loginuserid){ ?>
			<a class="forum_btn_large" href="http://<? echo $_SERVER['HTTP_HOST']; ?>/forum/<? echo $url[2]; ?>/thread">Create new Theard</a>
		<?	}
	}else{
			$sql="SELECT * FROM forum_category";
			$ergebnis = $db->query( $sql );

			while($cat = $ergebnis->fetch_object()){
		?>
			<section style="min-height:50px; margin:0px 0px 1%;">
			<table style="width:100%;">
				<tr>
				<td style="width:5%; vertical-align:middle;">
					<img style="width:28px;" src="http://wrath.illmaren.de/template/forums/style/icons/forum_read.png" \>
				</td>
				<td style="vertical-align:middle; width:45%;">
					<a href="../forum/<? echo $cat->id; ?>"><? echo $cat->name; ?></a>
				</td>
				<td style="vertical-align:middle; width:20%;">
					<table style="width:100%;">
						<tr><td><? echo $cat->threads; ?></td><td><? echo $cat->posts; ?></td></tr>
					</table>
				</td>
				<td style="vertical-align:top; width:20%; line-height: 1em;">
					<? echo lastpost($db, $cat->id); ?>
				</td>
				</tr>
			</table>
			</section>
		<?	
			}
	}
$db->close();
?>