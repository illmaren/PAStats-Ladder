<?
function count_user_threadpostcomment($mysqli, $user, $place){
$sql="SELECT forum_thread, forum_post, user_comment FROM user WHERE id = '$user'";
if($player = $mysqli->query($sql)){
$player = $player->fetch_object();

$thread = $player->forum_thread;
$post = $player->forum_post;
$comment = $player->user_comment;

if($place == "thread"){
	$thread = $thread + 1;
}elseif($place == "post"){
	$post = $post + 1;
}elseif($place == "comment"){
	$comment = $comment + 1;
}

$query = "UPDATE user SET forum_thread = '$thread', forum_post = '$post', user_comment = '$comment' WHERE id = '$user'";
if($mysqli->query($query)){
	return "Everything ok <br> $thread <br> $post <br> $comment";
}else{
	$error = $mysqli->error;
	return "Something bad happend there <br> $error";
}
}else{
	$error = $mysqli->error;
	return "Something bad happend there <br> $error";
}
}

function count_categorythread($mysqli, $cat, $thread){
	$sql="SELECT threads, posts FROM forum_category WHERE id = '$cat'";
	if($cats = $mysqli->query($sql)){
	$cats = $cats->fetch_object();
	$user = "0";
		$posts = $cats->posts;
		$thread = $cats->threads;
		
		if($thread == "0"){
			$thread = $thread + 1;
		}else{
			$posts = $posts + 1;
		}

		$query = "UPDATE forum_category SET threads = '$thread', posts = '$posts' WHERE id = '$cat'";
		if($mysqli->query($query)){
			return "Everything ok <br> $thread <br> $posts";
		}else{
			$error = $mysqli->error;
			return "Something bad happend there <br> $error";
		}
	}else{
		$error = $mysqli->error;
		return "Something bad happend there <br> $error";
	}
}

function lastpost($mysqli, $cat){
	$sql="SELECT * FROM forum_theard WHERE category = '$cat'";
	if($cats = $mysqli->query($sql)){
	$cats = $cats->fetch_object();
		$category = $cats->id;
		$sqls="SELECT * FROM forum_posts WHERE theard = '$category' order by date DESC";
		if($posts = $mysqli->query($sqls)){
		$posts = $posts->fetch_object();
			
			if($posts->content){
				$date = $posts->date;
					$date = date('d M Y',$date);
					$link = 'http://'.$_SERVER['HTTP_HOST'].'/forum/'.$cats->category.'/'.$posts->theard;
				return "<a style='text-decoration:none;' href=' $link '> $cats->name <br> $posts->author - $date </a>";
			}else{
			
			}
		}else{
			$error = $mysqli->error;
			return "Something bad happend there <br> $error";
		}
	}else{
		$error = $mysqli->error;
		return "Something bad happend there <br> $error";
	}
}
?>