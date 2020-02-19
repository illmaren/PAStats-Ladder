<?
if($id == "7222"){
	echo 'General of the Armies<br>'; 
	echo '<img style="height:25px;" src="../include/image/rank/6star.png">';
}elseif($rating <= "2000"){
echo 'Recruit<br><br>'; 
}elseif(($rating >= "2000") AND ($rating <= "2025")){
	echo 'Private<br>'; 
	echo '<img src="../include/image/rank/PVT.png" alt="Private">';
}elseif(($rating >= "2026") AND ($rating <= "2050")){
	echo 'Corporal<br>'; 
	echo '<img src="../include/image/rank/CPL.png">';
}elseif(($rating >= "2051") AND ($rating <= "2075")){
	echo 'Sergeant<br>'; 
	echo '<img src="../include/image/rank/SGT.png">';
}elseif(($rating >= "2076") AND ($rating <= "2100")){
	echo 'Staff Sergeant<br>'; 
	echo '<img src="../include/image/rank/SSG.png">';
}elseif(($rating >= "2101") AND ($rating <= "2125")){
	echo 'Sergeant First Class<br>'; 
	echo '<img src="../include/image/rank/SFC.png">';
}elseif(($rating >= "2126") AND ($rating <= "2150")){
	echo 'Master Sergeant<br>'; 
	echo '<img src="../include/image/rank/MSG.png">';
}elseif(($rating >= "2151") AND ($rating <= "2175")){
	echo 'Sergeant Major<br>'; 
	echo '<img src="../include/image/rank/SGM.png">';
}elseif(($rating >= "2176") AND ($rating <= "2200")){
	echo 'Second Lieutenant<br>'; 
	echo '<img src="../include/image/rank/2LT.png">';
}elseif(($rating >= "2201") AND ($rating <= "2225")){
	echo 'First Lieutenant<br>'; 
	echo '<img src="../include/image/rank/1LT.png">';
}elseif(($rating >= "2226") AND ($rating <= "2250")){
	echo 'Captain<br>'; 
	echo '<img src="../include/image/rank/CPT.png">';
}elseif(($rating >= "2251") AND ($rating <= "2275")){
	echo 'Major<br>'; 
	echo '<img src="../include/image/rank/MAJ.png">';
}elseif(($rating >= "2276") AND ($rating <= "2300")){
	echo 'Lieutenant Colonel<br>'; 
	echo '<img src="../include/image/rank/LTC.png">';
}elseif(($rating >= "2301") AND ($rating <= "2400")){
	echo 'Colonel<br>'; 
	echo '<img src="../include/image/rank/COL.png">';
}elseif(($rating >= "2401") AND ($rating <= "2600")){
	echo 'Brigadier General<br>'; 
	echo '<img src="../include/image/rank/BG.png">';
}elseif(($rating >= "2601") AND ($rating <= "2700")){
	echo 'Major General<br>'; 
	echo '<img src="../include/image/rank/MG.png">';
}
?>