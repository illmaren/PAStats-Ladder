<?
echo str_replace('<title>PA Ladder</title>', '<title>PA Ladder - Donation</title>', ob_get_clean());
echo str_replace('<h2>Content Title</h2>', '<h2>Donation</h2>', ob_get_clean());
?>
<center>
	<div style="text-align:center; width:300px;">
		<form action = "../donate/sql" method="POST">
			Name<br>
			<input type="text" name="name"><br>
			<br>
			<select class="options" name="anmount">
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="15">15</option>
			</select>
			<select class="options" name="anmount">
				<option value="euro">Euro</option>
				<option value="dollar">Dollar</option>
			</select>
			
			<br>
			<br>
			<input type="submit" value="Donate"></p>
		</form>
	</div>
</center>