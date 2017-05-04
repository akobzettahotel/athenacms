<?php include("header.php"); 
if(!isset($_SESSION["athena"]))
{
	echo "<script>window.location.href = 'index';</script>";
}
else
{
	$athena = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$_SESSION[athena]'"));
}
?>
</div>

<div class="w3-col l1">
		</div>
</div>
<script>
$("#leftspace").html("");
</script>
<div class="w3-container w3-white w3-card-4">
<h2>Zetta</h2><sup>Athena</sup> 
<a class="w3-button w3-red w3-right w3-margin-bottom" href="?logout">Logout</a>
<a target="_blank" href="client" class="w3-button w3-green w3-right w3-margin-right w3-margin-bottom">Enter Zetta</a>
<button class="w3-button w3-black w3-right w3-margin-right w3-margin-bottom">Settings</button>
<span class="w3-right w3-orange w3-padding w3-margin-right"><?php echo $server["users_online"]; if($server["users_online"] > 1){ echo " users online"; } else { echo " user online"; } ?> </span>
</div>
<div class="w3-bar w3-cyan">
  <div class="w3-dropdown-hover">
      <button class="w3-button w3-border-right <?php if(isset($me)){ echo "w3-aqua"; } else { echo "w3-cyan"; } ?>">Me</button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="me" class="w3-bar-item w3-button <?php if(isset($me)){ echo "w3-aqua"; } ?>"><?php echo $athena["username"]; ?></a>
        <a href="#" class="w3-bar-item w3-button">Settings</a>
        <a href="#" class="w3-bar-item w3-button">My pages</a>
      </div>
    </div>
	<div class="w3-dropdown-hover">
		<button class="w3-button w3-border-right <?php if(isset($community)){ echo "w3-aqua"; } else { echo "w3-cyan"; } ?>">Community</button>
		<div class="w3-dropdown-content w3-bar-block w3-card-4">
			<a href="staff" class="w3-bar-item w3-button <?php if(isset($staff)){ echo "w3-aqua"; } ?>">Staff</a>
			<a href="stats" class="w3-bar-item w3-button <?php if(isset($stats)){ echo "w3-aqua"; } ?>">Stats</a>
			<a href="#" class="w3-bar-item w3-button">News</a>
      </div>
  </div>
  <button class="w3-bar-item w3-button w3-cyan w3-border-right">Management(comingsoon)</button>
</div>

<div class="w3-row">
	<div class="w3-col l1">&nbsp;</div>
	<div class="w3-col l10">
