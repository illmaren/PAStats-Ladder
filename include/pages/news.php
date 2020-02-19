<?
loadclass("dbconnect");
$db = new db();

$news = escape($db, $url[2]);
if($url[3] == "sql"){
	if($loginuserid){
		$game = $news; 
		$user = $loginuserid;

		$query = "SELECT * FROM user WHERE id = $user";
		$result = mysqli_fetch_array($db->query($query));
		// $user = $result[Nickname];

		$inhalt = escape($db, $_POST["comment"]);
		// $inhalt = str_replace("\n", "<br>", $inhalt);

		if ($inhalt == "" or $user == "")
		   {
		   echo "<font color='white'>You must fill the Text Area to post something<br>
		   <a href='../../news/".$url[2]."'>Go Back</font>";
		   }
		else
		   {
				$query = "INSERT INTO news_comments (news_id, author, comment, date)
					VALUES ('$game', '$user', '$inhalt', now())";
				$db->query($query);
				count_user_threadpostcomment($db, $user, "comment");

		   echo "new post added";
		   $url = 'http://'.$_SERVER[HTTP_HOST].'/news/'.$url[2];
		   header("Location: $url");
		   }
	}else{
		echo 'You´re not registred';
	}
	$result->close();
}

	$sql="SELECT id, autor, title, news, date FROM news WHERE id = '$news'";
	$ergebnis = $db->prepare( $sql );
    $ergebnis->execute();
    $ergebnis->bind_result( $id, $autor, $title, $body, $date );
    while ($ergebnis->fetch()){
		$body = utf8_encode($body);
		$content_news.= '	
	<section style="margin:0px 0px 0.1%;">
		<header>
			<h2>'.$title.'</h2>
			<h3>'.$autor.' - '.date('d M Y',strToTime($date)).'</h3>
		</header>
			'.$body.'
	</section>';
	}
echo $content_news;

$game = $db->real_escape_string($url[2]);

$sql_stats="
SELECT
	*
FROM
	news_comments
WHERE
	news_id = '$game'
  ";
$result_stats = $db->query($sql_stats);
while($row = mysqli_fetch_assoc($result_stats)){

$sql_autor="
SELECT
	*
FROM
	user
WHERE
	id = '$row[author]'
  ";
$result_autor = $db->query($sql_autor);
$row_autor = mysqli_fetch_assoc($result_autor);

echo '	<section style="margin:0px 0px 0.1%;">
		<header>
			<h3>'.$row_autor[user].'</h3>
		</header>
			'.$row[comment].'
	</section>';
}

if($loginuserid){ ?>
<section>
	<form method="post" action="../news/<? echo $game; ?>/sql">
		<fieldset>
			<textarea class="ckeditor" name="comment"></textarea>
		</fieldset>
		<input type="submit" value="Enter Post">
	</form>
</section>
<? }else{
echo '<br><a class="forum_btn_large" href="../login">Login to Post</a>';
}
?>