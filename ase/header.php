
<head>
	<title>Zetta: Athena All Seeing Eyes</title>
	<meta charset="UTF-8">
	<meta name="description" content="Zetta is a teen social virtual life game. A strange place with awesome people. Meet and make friends, play games, chat with others, create your avatar, design rooms and more.">
	<meta name="keywords" content="Habbo,retro,game,rp,halfrp,social,zetta">
	<meta name="author" content="Akob And Wave">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="../jquery-ui-1.12.1.custom/jquery-ui.structure.min.css">
	<link rel="stylesheet" href="../jquery-ui-1.12.1.custom/jquery-ui.theme.min.css">
	<link rel="stylesheet" href="../jquery-ui-1.12.1.custom/jquery-ui.min.css">
	<link rel="stylesheet" href="../w3.css">
	<link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel='shortcut icon' type='image/x-icon' href='../zetta.ico' />
	
	<script src="../jquery-3.2.0.min.js"></script>
	<script src="../jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="../tinymce/tinymce.min.js"></script>
	<script>
		if(window.location.protocol == "http:"){
		//	window.location.href = "https://" + window.location.hostname + window.location.pathname;
		}
		$(window).on('load', function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
	</script>
</head>
<body class="w3-light-grey">
	<style>

		.se-pre-con {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url(../Preloader_3.gif) center no-repeat #fff;
		
}
#welcome_msg{
	background-repeat:no-repeat;
    background-size:contain;
	background-position: right bottom;
	background-image: url("../grass_view.png");
}
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
	</style>
	<?php include("../database.php");
	session_start();
	if(isset($_GET["logout"]))
	{
		session_unset();
		session_destroy();
		echo "<script>window.location.href = '../index'</script>";
	}
	$server = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM server_status"));
?>
	<div class="se-pre-con"></div>

	