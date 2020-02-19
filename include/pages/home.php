<?
if (!defined('init_pages'))
{	
	header('HTTP/1.0 404 not found');
	exit;
}
loadclass("dbconnect");
$db = new db();
	$sql="SELECT id, autor, title, news, date FROM news ORDER BY date desc LIMIT 5";
	$ergebnis = $db->query( $sql );
    while ($row = $ergebnis->fetch_object()){
	
		$sqls = "SELECT news_id FROM news_comments WHERE news_id = '$row->id'";
		$result = $db->query($sqls);
		$menge = $result->num_rows;	
		
		$body = utf8_encode($row->news);
		$content_news.= '	
	<section style="margin:0px 0px 2%;">
		<header>
			<h2>'.$row->title.'</h2>
			<h3>'.$row->autor.' - '.date('d M Y',strToTime($row->date)).'</h3>
		</header>
		<div>
			'.$body.'
		</div>
	<div style="padding: 0px 10px 3px 10px; margin:0px 0px 2%; text-align:right;">
		<a class="forum_btn_large" href="../news/'.$row->id.'">Comments ('.$menge.')</a> 
	</div>
	</section>
	';
	}
	$ergebnis->close();
echo $content_news;

$db->close();
?>