<?php
session_start();
include("../database.php");
if(isset($_POST["searchuser"]))
{
	if(!empty($_POST["username"]))
	{
		$username = mysqli_real_escape_string($conn, $_POST["username"]);
		$search1 = mysqli_query($conn, "SELECT id,username FROM users WHERE username LIKE '%$username%'");
		while($searchr1 = mysqli_fetch_assoc($search1))
		{
			echo " <span onclick='chooseuser($searchr1[id])' class='chooseuser w3-button w3-white w3-border w3-border-red w3-round-large'>$searchr1[username]</span>";
		}
	}
}
if(isset($_POST["choosuser"]))
{
	if(!empty($_POST["id"]))
	{
		$id = mysqli_real_escape_string($conn, $_POST["id"]);
		$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'"));
		$rank = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM ranks WHERE id = '$u[rank]'"));
		$acc_create = date("d/m/Y h:i a", $u["account_created"]);
		$acc_online = date("d/m/Y h:i a", $u["last_online"]);
		echo "
		<hr>
		<div class='w3-row w3-white'>
			<div class='w3-col m2'>
				<center>
				<img src='https://avatar-retro.com/habbo-imaging/avatarimage?figure=$u[look]&headonly=1' class='w3-circle w3-margin-right' style='width:46px'>
				</center>
			</div>
			<div class='w3-col m10'>
				<b>Username:</b> $u[username]<br>
				<b>Motto:</b> $u[motto]<br>
				<b>Email:</b> $u[mail]<br>
				<b>Rank:</b> $rank[name]($u[rank])<br>
				<b>Account Created:</b> $acc_create<br>
				<b>Last Online:</b> $acc_online<br>
			</div>
		</div>
		";
	}
}