<?
if (!defined('init_pages'))
{	
	header('HTTP/1.0 404 not found');
	exit;
}
loadclass("dbconnect");
$db = new db();
$player = escape($db, $url[2]);

echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - Statistics</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>Statistics</h2>', ob_get_clean());

	$sql="
	SELECT
		time
	FROM
		game
	order by time
	";
	$ergebnis = $db->prepare( $sql );
    $ergebnis->execute();
    $ergebnis->bind_result( $time );
	$test = array();
	$uhr = array();
    while($ergebnis->fetch()){
		$times = $time / 1000;
		$datum = date("d.m.Y",$times);
		$uhrzeit = date("H:i",$times);
		$hour = date("H",$times);
		$month = date("m.Y",$times);
			
			$test[$datum][$hour]++;
			$test[$datum]["day"]++;
			$uhr[$month]++;
	}
if($url[2] == "month"){
$monthdx = date('Y-m', time());
$monthd = explode('-',$monthdx);
$monthda = $monthd[1] + 1;
if($monthda == "13"){
$monthda = 1;
$monthd[0] = $monthd[0] + 1;
}
$monthdd = $monthd[0].'-'.$monthda;
$month_von = '2014-9';
$month_bis = $monthdd;
$monthvon = strtotime($month_von);
$monthbis = strtotime($month_bis);;
while($monthvon!=$monthbis){
$month = date('m.Y', $monthvon);
$month_x = date ('Y-m', $monthvon);
echo '<a onclick="return loading();" href="'.$month_x.'">'.$month.' - '.$uhr[$month].'</a><br>';
$monthvon= strtotime('+1 month', $monthvon);
}
}elseif($url[2]){

$datum_von = date('Y-m-01',strtotime($url[2]));
$datum_bis = date('Y-m-t',strtotime($url[2]));
$datumvon = strtotime($datum_von);
$datumbis = strtotime($datum_bis);

while ($datumvon!=$datumbis)
{
$day = date('d.m.Y', $datumvon);

echo $day. ' - ' . $test[$day]["day"].'<br>';
$datumvon= strtotime('+1 day', $datumvon);
}


}else{
$datum_von = $url[2].'-01';
$datum_bis = $url[2].'-31';
$datumvon = strtotime($datum_von);
$datumbis = strtotime($datum_bis);

while ($datumvon!=$datumbis)
{
$day = date('d.m.Y', $datumvon);

echo $day. ' - ' . $test[$day]["day"].'<br>';
for ($i = 00; $i <= 23; $i++) {
$days = sprintf('%02d', $i);
echo $days . ' - ' .$test[$day][$days].'<br>';
}
echo '<br>';
}
}

	$ergebnis->close();
?>
<?
$db->close();
?>