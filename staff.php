<?php 
$community = 1;
$staff = 1;
include("navbar.php"); 

echo "<div class='w3-row-padding'>
";
$a0 = mysqli_query($conn, "SELECT * FROM ranks WHERE id > 1 ORDER BY id DESC");
while($a1 = mysqli_fetch_assoc($a0))
{
	echo "
	<div class='w3-col m4 w3-margin-top'>
		<div class='w3-container w3-white'>
			<div class='w3-container w3-teal w3-margin-top w3-round-large'><h4>$a1[name]</h4></div>
			<table class='w3-table w3-table-all'>
	";
	$a2 = mysqli_query($conn,"SELECT * FROM users WHERE rank = '$a1[id]'");
	while($a3 = mysqli_fetch_assoc($a2))
	{
		$gender = "w3-pale-yellow";
		if($a3["gender"] == "F")
		{
			$gender = "w3-pale-red";
		}
		if($a3["gender"] == "M")
		{
			$gender = "w3-pale-blue";
		}
		echo "<tr class='$gender'><td>
			<img src='https://avatar-retro.com/habbo-imaging/avatarimage?figure=$a3[look]'>
			</td><td>
			<b>$a3[username]</b><br>$a3[motto]</td>
			</tr>
		";
		
	}
	
	echo "</table>
		</div>
		</div>
		
	";
}
echo "</div>";
?>

<?php include("login_footer.php"); ?>