<?php 
$community = 1;
$stats = 1;
include("navbar.php"); 

echo "<div class='w3-row-padding'>

<div class='w3-col m4 w3-margin-top'>
		<div class='w3-container w3-white'>
			<div class='w3-container w3-teal w3-margin-top w3-round-large'><h4>Top Credits</div>
				<table class='w3-table w3-table-all'>";
	$top1 = mysqli_query($conn, "SELECT * FROM users ORDER BY credits DESC LIMIT 5");
	while($top2 = mysqli_fetch_assoc($top1))
	{
		$gender = "w3-pale-yellow";
		if($top2["gender"] == "F")
		{
			$gender = "w3-pale-red";
		}
		if($top2["gender"] == "M")
		{
			$gender = "w3-pale-blue";
		}
		echo "<tr class='$gender'><td>
			<img src='https://avatar-retro.com/habbo-imaging/avatarimage?figure=$top2[look]'>
			</td><td>
			<b>$top2[username]</b><br>$top2[motto]<br>" . number_format($top2["credits"]) ." Credits</td>
			</tr>
		";
	}
echo "</table></div></div>


</div>";



?>

<?php include("login_footer.php"); ?>