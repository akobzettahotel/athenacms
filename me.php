<!DOCTYPE html>
<html>
<title>Zetta&trade; Athena</title>
<meta charset="UTF-8">
	<meta name="description" content="Zetta is a teen social virtual life game. A strange place with awesome people. Meet and make friends, play games, chat with others, create your avatar, design rooms and more.">
	<meta name="keywords" content="Habbo,retro,game,rp,halfrp,social,zetta">
	<meta name="author" content="Akob And Wave">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="w3-theme-blue-grey.css">
<link rel='shortcut icon' type='image/x-icon' href='zetta.ico' />
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="jquery-ui-1.12.1.custom/jquery-ui.css">
<script src="tinymce/tinymce.min.js"></script>
<script src="jquery-3.2.0.min.js"></script>
<script src="jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Open Sans", sans-serif}
.se-pre-con {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url(Preloader_3.gif) center no-repeat #fff;
		
}


.storyoverflow::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	border-radius: 10px;
	background-color: #F5F5F5;
}

.storyoverflow::-webkit-scrollbar
{
	width: 12px;
	background-color: #F5F5F5;
}

.storyoverflow::-webkit-scrollbar-thumb
{
	border-radius: 10px;
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
	background-color: #4d636f;
}
</style>
<body class="w3-theme-l5">
<div class="se-pre-con"><center><h1>Loading...</h1></center></div>
<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
session_start();
include("database.php");
if(!isset($_SESSION["athena"]))
{
	echo "<script>window.location.href = 'index';</script>";
}
else
{
	$athena = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$_SESSION[athena]'"));
}

if(isset($_GET["logout"]))
	{
		session_unset();
		session_destroy();
		echo "<script>window.location.href = 'index'</script>";
	}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>
<!-- Navbar -->
<div class="w3-top">
 <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  <a href="me" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>Zetta&trade; <sub>Athena</sub></a>
  <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="News"><i class="fa fa-globe"></i></a>
  <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Account Settings"><i class="fa fa-user"></i></a>
  <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Messages"><i class="fa fa-envelope"></i></a>
  <div class="w3-dropdown-hover w3-hide-small">
    <button class="w3-button w3-padding-large" title="Notifications"><i class="fa fa-bell"></i><span class="w3-badge w3-right w3-small w3-green">3</span></button>     
    <div class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:300px">
      <a href="#" class="w3-bar-item w3-button">One new friend request</a>
      <a href="#" class="w3-bar-item w3-button">John Doe posted on your wall</a>
      <a href="#" class="w3-bar-item w3-button">Jane likes your post</a>
    </div>
  </div>
  
 <div class="w3-dropdown-hover w3-hide-small w3-right">
    <button class="w3-button w3-padding-large" title="Notifications"><img src="https://avatar-retro.com/habbo-imaging/avatarimage?figure=<?php echo $athena["look"]; ?>&headonly=1" class="w3-circle" style="height:25px;width:25px" alt="Avatar"> Options</button>     
    <div class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:300px">
      <a href="#" class="w3-bar-item w3-button">My Profile</a>
      <a href="#" class="settings_button w3-bar-item w3-button">Settings</a>
      <a href="?logout" class="w3-bar-item w3-button">Logout</a>
    </div>
  </div>
   <button class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-right"><?php
   $getonline = mysqli_fetch_assoc(mysqli_query($conn, "SELECT users_online FROM server_status"));
   echo $getonline["users_online"];
   if($getonline["users_online"] > 1)
   {
	   echo " users online";
   }
   else
   {
	   echo " user online";
   }
   ?></button>
  </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 1</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 2</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 3</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">My Profile</a>
   <div class="w3-dropdown-hover">
    <button class="w3-button w3-padding-large" title="Notifications"><img src="https://avatar-retro.com/habbo-imaging/avatarimage?figure=<?php echo $athena["look"]; ?>&headonly=1" class="w3-circle" style="height:25px;width:25px" alt="Avatar"> Options</button>     
    <div class="w3-dropdown-content w3-card-4 w3-bar-block" >
      <a href="#" class="w3-bar-item w3-button">My Profile</a>
      <a href="#" class="settings_button w3-bar-item w3-button">Settings</a>
      <a href="?logout" class="w3-bar-item w3-button">Logout</a>
    </div>
  </div>
</div>


<!-- some script -->
				<script>
					tinymce.init({
  selector: '.postwall',
  theme: 'modern',
  skin: 'athena',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic striketrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
 //   '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });
 
 var onprofile = '<?php echo $athena["username"]; ?>';
 </script>
<!-- End some script -->

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
	<!-- Alert Box -->
      <div class="w3-container w3-display-container w3-round w3-pale-yellow w3-border w3-theme-border w3-margin-bottom w3-hide-small">
        <span onclick="this.parentElement.style.display='none'" class="w3-button w3-orange w3-display-topright">
          <i class="fa fa-remove"></i>
        </span>
        <p><strong>Zetta is under beta mode</strong></p>
      </div>
      <!-- Profile -->
      <div class="w3-card-2 w3-round w3-white">
        <div class="w3-container">
         <h4 class="w3-center"><?php echo $athena["username"]; ?></h4>
         <p class="w3-center"><img src="https://avatar-retro.com/habbo-imaging/avatarimage?figure=<?php echo $athena["look"]; ?>" class="w3-circle" style="height:106px;" alt="Avatar"></p>
         <a href="client" target="zettaclient" class="w3-button w3-block w3-green">Enter Client</a>
		 <hr>
         <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> <span id="display_motto"><?php echo $athena["motto"]; ?></span></p>
         <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> home_room</p>
         <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> <?php $esdate = date("d F Y", $athena["account_created"]); echo $esdate; ?></p>
        </div>
      </div>
      <br>
      
      <!-- Accordion -->
      <div class="w3-card-2 w3-round">
        <div class="w3-white">
          <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> Groups</button>
          <div id="Demo1" class="w3-hide w3-container">
			<h6><strong>Your Groups</strong></h6>
			<div class="w3-row">
			<?php $mygroup1 = mysqli_query($conn, "SELECT * FROM groups WHERE owner_id = '$athena[id]'");
					while($mygroup2 = mysqli_fetch_assoc($mygroup1))
					{
						echo "
						<p><div class='w3-col s4'>
			<center><img src='swf/habbo-imaging/badge.php?badge=$mygroup2[badge].gif'></center>
			</div>
			<div class='w3-col s8'>
			<b>$mygroup2[name]</b><br>$mygroup2[desc]
			</div></p>";
					}
			?>
			
          </div>
			<div class="w3-row">
				<h6><strong>Groups you join</strong></h6>
				<?php $mygroup3 = mysqli_query($conn, "SELECT * FROM group_memberships WHERE user_id = '$athena[id]'");
					while($mygroup4 = mysqli_fetch_assoc($mygroup3))
					{
						$mygroup5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM groups WHERE id = '$mygroup4[group_id]'"));
						if($mygroup5["owner_id"] != $athena["id"])
						{
						echo "
						<p><div class='w3-col s4'>
			<center><img src='swf/habbo-imaging/badge.php?badge=$mygroup5[badge].gif'></center>
			</div>
			<div class='w3-col s8'>
			<b>$mygroup5[name]</b><br>$mygroup5[desc]
			</div></p>";
						}
					}
			?>
			</div>
          </div>
          <button onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> My Events</button>
          <div id="Demo2" class="w3-hide w3-container">
            <p>Some other text..</p>
          </div>
          <button onclick="myFunction('Demo3')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> My Photos</button>
          <div id="Demo3" class="w3-hide w3-container">
         <div class="w3-row-padding">
         <br>
           <div class="w3-half">
             <img src="https://w3schools.com/w3images/lights.jpg" style="width:100%" class="w3-margin-bottom">
           </div>
           <div class="w3-half">
             <img src="https://w3schools.com/w3images/nature.jpg" style="width:100%" class="w3-margin-bottom">
           </div>
           <div class="w3-half">
             <img src="https://w3schools.com/w3images/mountains.jpg" style="width:100%" class="w3-margin-bottom">
           </div>
           <div class="w3-half">
             <img src="https://w3schools.com/w3images/forest.jpg" style="width:100%" class="w3-margin-bottom">
           </div>
           <div class="w3-half">
             <img src="https://w3schools.com/w3images/nature.jpg" style="width:100%" class="w3-margin-bottom">
           </div>
           <div class="w3-half">
             <img src="https://w3schools.com/w3images/fjords.jpg" style="width:100%" class="w3-margin-bottom">
           </div>
         </div>
          </div>
        </div>      
      </div>
      <br>
      
      <!-- Interests --> 
      <div class="w3-card-2 w3-round w3-white w3-hide-small">
        <div class="w3-container">
          <p>Interests</p>
          <p>
            <span class="w3-tag w3-small w3-theme-d5">News</span>
            <span class="w3-tag w3-small w3-theme-d4">W3Schools</span>
            <span class="w3-tag w3-small w3-theme-d3">Labels</span>
            <span class="w3-tag w3-small w3-theme-d2">Games</span>
            <span class="w3-tag w3-small w3-theme-d1">Friends</span>
            <span class="w3-tag w3-small w3-theme">Games</span>
            <span class="w3-tag w3-small w3-theme-l1">Friends</span>
            <span class="w3-tag w3-small w3-theme-l2">Food</span>
            <span class="w3-tag w3-small w3-theme-l3">Design</span>
            <span class="w3-tag w3-small w3-theme-l4">Art</span>
            <span class="w3-tag w3-small w3-theme-l5">Photos</span>
          </p>
        </div>
      </div>
      <br>
      
      <!-- Alert Box -->
      <div class="w3-container w3-display-container w3-round w3-theme-l4 w3-border w3-theme-border w3-margin-bottom w3-hide-small">
        <span onclick="this.parentElement.style.display='none'" class="w3-button w3-theme-l3 w3-display-topright">
          <i class="fa fa-remove"></i>
        </span>
        <p><strong>Hey!</strong></p>
        <p>People are looking at your profile. Find out who.</p>
      </div>
    
    <!-- End Left Column -->
    </div>
    
    <!-- Middle Column -->
    <div id="middlecolumn_main" class="middlecolumn w3-col m7">
	
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card-2 w3-round w3-white">
            <div class="w3-container w3-padding">
              <h6 class="w3-opacity">Send to your wall:</h6>
              <form method="post">
			  <?php
			  if(isset($_POST["sendpost"]))
			  {
				  if(!empty($_POST["postwall"]))
				  {
					  
					  $postwall = mysqli_real_escape_string($conn, $_POST["postwall"]);
					  $taiem = time();
					  mysqli_query($conn, "INSERT INTO athena_post (postby, postat, posttime, poststory, comment, edited) VALUES ('$athena[id]', '$athena[id]', '$taiem', '$postwall', '0', '0')");
					  echo "<div class='w3-panel w3-pale-green w3-card-4 '><span onclick=\"this.parentElement.style.display='none'\" class='w3-button w3-display-topright'>X</span>Your post have been post.</div>";
				  }
			  }

			  ?>

				<textarea name="postwall" class="postwall"></textarea>
				<button  type="submit" class="w3-button w3-theme" name="sendpost"><i class="fa fa-pencil"></i> &nbsp; Post</button> 
			  </form>
            </div>
          </div>
        </div>
      </div>
      <?php
	  $a0 = mysqli_query($conn, "SELECT * FROM athena_post WHERE comment = '0' ORDER BY id DESC");
	  while($a1 = mysqli_fetch_assoc($a0))
	  {
		  $a2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM messenger_friendships WHERE user_one_id = '$athena[id]' AND user_two_id = '$a1[postby]' OR user_one_id = '$a1[postby]' AND user_two_id = '$athena[id]'"));
		  if($a2 > 0)
		  {
			  $a3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$a1[postby]'"));
			  $a4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM athena_post_like WHERE pid = '$a1[id]'"));
			  if($a4 < 2)
			  {
				  $a5 = "Like";
			  }
			  else
			  {
				  $a5 = "Likes";
			  }
			  $a6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM athena_post WHERE comment = '$a1[id]'"));
			  if($a6 < 2)
			  {
				  $a7 = "Comment";
			  }
			  else
			  {
				 $a7 = "Comments"; 
			  }
			  if($a1["edited"] != "0")
			  {
				  $a9 = date("d F Y h:i a", $a1["edited"]);
				  $a8 = "<span class='w3-tag w3-theme-l2 w3-small'>Edited $a9</span>";
			  }
			  else
			  {
				  $a8 = "";
			  }
			  echo "
				<div class='w3-container w3-card-2 w3-white w3-round w3-margin'><br>
					<img src='https://avatar-retro.com/habbo-imaging/avatarimage?figure=$a3[look]&headonly=1' alt='Avatar' class='w3-left w3-circle w3-margin-right' style='width:60px'>
					<span class='w3-right w3-opacity'>" . time_elapsed_string('@' . $a1["posttime"] . '') . "</span>
					<h4 class='onprofile' data-onprofile='$a3[username]'>$a3[username]</h4><br>
					<hr class='w3-clear'>
					<div style='max-height: 250px; overflow:auto;' class='storyoverflow'>$a1[poststory]</div> $a8<br>
         <button id='$a1[id]' type='button' class='likebutton w3-button w3-theme-d1 w3-margin-bottom'><i class='fa fa-thumbs-up'></i> &nbsp; $a4 $a5</button> 
        <button id='cmtcnt$a1[id]' data-postid='$a1[id]' type='button' class='cmtbutton w3-button w3-theme-d2 w3-margin-bottom'><i class='fa fa-comment'></i> &nbsp; $a6 $a7</button>
      </div>  ";
		  }
		  else //diri sendiri
		  {
			if($a1["postby"] == $athena["id"])
			{
				$a4 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM athena_post_like WHERE pid = '$a1[id]' AND islike = '1'"));
			  if($a4 < 2)
			  {
				  $a5 = "Like";
			  }
			  else
			  {
				  $a5 = "Likes";
			  }
			  $a6 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM athena_post WHERE comment = '$a1[id]'"));
			  if($a6 < 2)
			  {
				  $a7 = "Comment";
			  }
			  else
			  {
				 $a7 = "Comments"; 
			  }
			  if($a1["edited"] != "0")
			  {
				  $a9 = date("d F Y h:i a", $a1["edited"]);
				  $a8 = "<span class='w3-tag w3-theme-l2 w3-small'>Edited $a9</span>";
			  }
			  else
			  {
				  $a8 = "";
			  }
				 echo "
				<div id='post$a1[id]' class='w3-container w3-display-container w3-card-2 w3-white w3-round w3-margin'>
				
				<div class='w3-display-topright'>
				<div class='w3-bar'>
  <button class='editpost w3-bar-item w3-button w3-blue' data-postid='$a1[id]'><i class='fa fa-pencil' aria-hidden='true'></i></button>
  <button class='deletepost w3-bar-item w3-button w3-red' data-postid='$a1[id]'><i class='fa fa-times' aria-hidden='true'></i></button>
</div>
</div>
				<br>
				<br>
					<img src='https://avatar-retro.com/habbo-imaging/avatarimage?figure=$athena[look]&headonly=1' alt='Avatar' class='w3-left w3-circle w3-margin-right' style='width:60px'>
					<span class='w3-right w3-opacity'>" . time_elapsed_string('@' . $a1["posttime"] . '') . "</span>
					<h4>$athena[username]</h4><br>
					<hr class='w3-clear'>
					<div style='max-height: 250px; overflow:auto;' class='storyoverflow'>$a1[poststory]</div> $a8<br>
        <button id='$a1[id]' type='button' class='likebutton w3-button w3-theme-d1 w3-margin-bottom'><i class='fa fa-thumbs-up'></i> &nbsp; $a4 $a5</button> 
        <button id='cmtcnt$a1[id]' data-postid='$a1[id]' type='button' class='cmtbutton w3-button w3-theme-d2 w3-margin-bottom'><i class='fa fa-comment'></i> &nbsp; $a6 $a7</button> 

   </div>  ";
			}				
		  }
	  }

	  ?>

      
    <!-- End Middle Column -->
    </div>
    
	
	    <!-- Middle Column profile -->
    <div id="middlecolumn_profile" class="middlecolumn w3-col m7" style="display:none;">

      Perofaiel: <span class="nowonprofile"></span>
    <!-- End Middle Column -->
    </div>
	
	
	
	<!-- Middle Column Settings -->
	 <div id="middlecolumn_settings" class="middlecolumn w3-col m7" style="display:none;">
	 <div class="w3-row-padding">
		<div class="w3-col m12">
          <div class="w3-card-2 w3-round w3-white">
		  <div class="w3-container w3-display-container w3-theme">
				<span class="middlecolumn_main w3-button w3-theme-l1 w3-display-topright">
					<i class="fa fa-remove"></i>
				</span>
        <p><strong>Settings</strong></p>

		  </div>
            <div class="w3-container w3-padding">
			<!-- setting msg -->
			<div id="setting_msg" style="display:none;" class="w3-container w3-display-container w3-round w3-pale-green w3-border w3-theme-border w3-margin-bottom">
				<span onclick="this.parentElement.style.display='none'" class="w3-button w3-green w3-display-topright">
					<i class="fa fa-remove"></i>
				</span>
        <p id="setting_msg_content" ><strong>Saved</strong></p>
      </div>
			<!-- setting msg -->
			
				<p><label class="w3-text-theme"><b>Motto:</b></label>
				<input id="setting_motto" class="w3-input w3-border" type="text" value="<?php echo $athena["motto"]; ?>"></p>
				<hr>
				<p><label class="w3-text-theme"><b>Allow user to add:</b></label></p>
				<p>
					<div class="w3-row">
						<div class="w3-half">
							<label><input class="block_newfriends w3-radio" type="radio" name="block_newfriends" value="0" <?php if($athena["block_newfriends"] == "0"){ echo "checked"; } ?>>
							Yes</label>
						</div>
						<div class="w3-half">
							<label><input class="block_newfriends w3-radio" type="radio" name="block_newfriends" value="1" <?php if($athena["block_newfriends"] == "1"){ echo "checked"; } ?>>
							No</label>
						</div>
					</div>
				</p>
				<hr>
				<p>
				<label class="w3-text-theme"><b>Show online to friends:</b></label>
				</p>
				<p>
				<div class="w3-row">
				<div class="w3-half">
				<label><input class="hide_online w3-radio" type="radio" name="hide_online" value="0" <?php if($athena["hide_online"] == "0"){ echo "checked"; } ?>>
				Yes</label>
				</div>
				<div class="w3-half">
				<label><input class="hide_online w3-radio" type="radio" name="hide_online" value="1" <?php if($athena["hide_online"] == "1"){ echo "checked"; } ?>>
				No</label>
				</div>
				</div>
				</p>
				<hr>
				<p>
				<label class="w3-text-theme"><b>Allow to follow:</b></label>
				</p>
				<p>
				<div class="w3-row">
				<div class="w3-half">
				<label><input class="hide_inroom w3-radio" type="radio" name="hide_inroom" value="0" <?php if($athena["hide_inroom"] == "0"){ echo "checked"; } ?>>
				Yes</label>
				</div>
				<div class="w3-half">
				<label><input class="hide_inroom w3-radio" type="radio" name="hide_inroom" value="1" <?php if($athena["hide_inroom"] == "1"){ echo "checked"; } ?>>
				No</label>
				</div>
				</div>
				</p>
			</div>
			</div>
			</div>
			</div>
	 </div>
	<!-- End Middle Column Settings -->
	

	<!-- start comment form -->
<!--	//Just combile this and use attr -->
	<div id="comment-dialog" title="Comment">Loading...</div>
	<div id="delete-dialog" title="Delete confirmation">Loading...</div>
	<div id="edit-dialog" title="Edit"><input id="editingpost" style="display:none;"><textarea id="edittextarea" class="postwall"></textarea><button name='savepost' id="savepost" data-postid="0" class='w3-button w3-green'>Save</button></div>
	<div id="edit-dialogcmt" title="Edit"><input id="editingpostcmt" style="display:none;"><textarea id="edittextareacmt" class="postwall"></textarea><button id="savepostcmt" data-postid="0" class='w3-button w3-green'>Save</button></div>

	<!-- end comment form -->
	
    <!-- Right Column -->
    <div class="w3-col m2">
      <div class="w3-card-2 w3-round w3-white w3-center">
        <div class="w3-container">
         <p><button id="" class="middlecolumn_main w3-button w3-block w3-theme-l4">Test</button></p>
		 <script>
		 //edit dialog
		 $("#edit-dialog").dialog({
			 autoOpen: false,
			 width: "80%",
			 modal: true
		 });
		 $("#edit-dialogcmt").dialog({
			 autoOpen: false,
			 width: "80%",
			 modal: true
		 });
		 $(document).on("click", ".editpost", function(){
			 var postid = $(this).data("postid");
			 $("#edit-dialog").dialog("open");
			 $.ajax({
				 url: "engine.php",
				 type: "post",
				 data: {
					 editpost: $(this).data("postid")
				 },
				 success: function(z){
					$("#editingpost").val(postid);
					tinymce.get('edittextarea').setContent(z);
				 }
			 });
		 });
		 $(document).on("click", ".editpostcmt", function(){
			 var postid = $(this).data("postid");
			 $("#edit-dialogcmt").dialog("open");
			 $.ajax({
				 url: "engine.php",
				 type: "post",
				 data: {
					 editpostcmt: $(this).data("postid")
				 },
				 success: function(z){
					$("#editingpostcmt").val(postid);
					tinymce.get('edittextareacmt').setContent(z);
				 }
			 });
		 });
		 $("#savepost").click(function(){
			 var posti = $("#editingpost").val();
			 $.ajax({
				 url: "engine.php",
				 type: "post",
				 data: {
					 savepost: tinymce.get('edittextarea').getContent(),
					 postid: posti
				 },
				 success: function(z){
					 $("#post" + posti).html(z);
					 $("#edit-dialog").dialog("close");
				 }
			 });
		 }); 
		 
		 $("#savepostcmt").click(function(){
			 var posti = $("#editingpostcmt").val();
			 $.ajax({
				 url: "engine.php",
				 type: "post",
				 data: {
					 savepostcmt: tinymce.get('edittextareacmt').getContent(),
					 postid: posti
				 },
				 success: function(z){
					 $("#postcmt" + posti).html(z);
					 $("#edit-dialogcmt").dialog("close");
				 }
			 });
		 });
		 //comment dialog
		 $( "#comment-dialog" ).dialog({
			autoOpen: false,
			width: "80%",
			modal: true
		});
		
		$(document).on('click', '.cmtbutton', function(event){
			$("#comment-dialog").dialog("open");
			$("#comment-dialog").html("Loading");
			$.ajax({
				url: "engine.php",
				type: "post",
				data: {
					request_comment: $(this).data("postid")
				},
				success: function(z){
					$("#comment-dialog").html(z)
				}
			});
			event.preventDefault();
		});
		
		//delete comment area
		$("#delete-dialog").dialog({
			autoOpen: false,
			modal: true
		});
		$(document).on("click", ".deletepost", function(event){
			$("#delete-dialog").dialog("open");
			$("#delete-dialog").html("Loading post...");
			$.ajax({
				url: "engine.php",
				type: "post",
				data: {
					deletepost: $(this).data("postid")
				},
				success: function(z){
					$("#delete-dialog").html(z);
				}
			});
			event.preventDefault();
		});
		 
		 $(document).on("click", ".deletecmtpost", function(event){
			$("#delete-dialog").dialog("open");
			$("#delete-dialog").html("Loading post...");
			$.ajax({
				url: "engine.php",
				type: "post",
				data: {
					deletecmtpost: $(this).data("postid")
				},
				success: function(z){
					$("#delete-dialog").html(z);
				}
			});
			event.preventDefault();
		});
		 
		 //show main column button
		 $(".middlecolumn_main").click(function(){
			 $(".middlecolumn").hide();
			 $("#middlecolumn_main").show();
		 });
		 
		 //Settings button
		 $(".settings_button").click(function(){
			 $(".middlecolumn").hide();
			 $("#middlecolumn_settings").show();
			 
		 });
		 
		 //myprofile button
		 $(".onprofile").click(function(){
			 $(".middlecolumn").hide();
			 $("#middlecolumn_profile").show();
			 onprofile = $(".onprofile").data("onprofile");
			 $(".nowonprofile").html(onprofile);
		 });
		 
		 //save settings
		 $("#setting_motto").change(function(){
			 $("#setting_msg_content").html("<strong>Saving...</strong>");
			 $("#setting_msg").show();
			 $.ajax({
				 url: "engine.php",
				 type: "post",
				 data: {
					 setting_motto: $("#setting_motto").val()
				 },
				 success: function(z){
					 $("#setting_msg_content").html(z);
					 $("#display_motto").html($("#setting_motto").val());
				 }
			 })
		 });
		 
		 $(".block_newfriends").change(function(){
			 $("#setting_msg_content").html("<strong>Saving...</strong>");
			 $("#setting_msg").show();
			 $.ajax({
				 url: "engine.php",
				 type: "post",
				 data: {
					 setting_block_newfriends: this.value
				 },
				 success: function(z){
					 $("#setting_msg_content").html(z);
				 }
			 })
		 });
		 
		 $(".hide_online").change(function(){
			 $("#setting_msg_content").html("<strong>Saving...</strong>");
			 $("#setting_msg").show();
			  $.ajax({
				 url: "engine.php",
				 type: "post",
				 data: {
					 setting_hide_online: this.value
				 },
				 success: function(z){
					 $("#setting_msg_content").html(z);
				 }
			 })
		 });
		 
		 $(".hide_inroom").change(function(){
			  $("#setting_msg_content").html("<strong>Saving...</strong>");
			 $("#setting_msg").show();
			  $.ajax({
				 url: "engine.php",
				 type: "post",
				 data: {
					 setting_hide_inroom: this.value
				 },
				 success: function(z){
					 $("#setting_msg_content").html(z);
				 }
			 })
		 });
		 </script>
        </div>
      </div>
      <br>
	  
	  <div class="w3-card-2 w3-round w3-white w3-center">
        <div class="w3-container">
          <p>News:</p>
		  <?php 
		  $gnews1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM zetta_news ORDER BY id DESC LIMIT 1"));
		  $dmy = date("d/m/Y", $gnews1["published"]);
		  echo "<div class='w3-display-container'><span class='w3-display-topright w3-tag w3-theme'>$dmy</span><br><p><strong>$gnews1[title]</strong></p><p>$gnews1[short_story]</p>";
		  ?>
          <p><button class="w3-button w3-block w3-theme-l4">Read more</button></p>
        </div>
        </div>
      </div>
      <br>
      
      <div class="w3-card-2 w3-round w3-white w3-center">
        <div class="w3-container">
          <p><b>Friend Request</b></p>
		  <div id="friendrequest">
          <?php 
			$fr0 = mysqli_query($conn, "SELECT * FROM messenger_requests WHERE to_id = '$athena[id]' ORDER BY id DESC LIMIT 1");
			$fr4 = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM messenger_requests WHERE to_id = '$athena[id]'"));
			$fr1 = mysqli_num_rows($fr0);
			if($fr1 > 0)
			{
				$fr2 = mysqli_fetch_assoc($fr0);
				$fr3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$fr2[from_id]'"));
				echo "<img src='https://avatar-retro.com/habbo-imaging/avatarimage?figure=$fr3[look]&headonly=1' alt='Avatar' style='width:50%'><br>
          <span>$fr3[username]</span>
		  <br>
		  
          <div class='w3-row w3-opacity'>
            <div class='w3-half'>
              <button id='acceptq$fr2[id]' class='w3-button w3-block w3-green w3-section' title='Accept'><i class='fa fa-check'></i></button>
            </div>
            <div class='w3-half'>
              <button id='declineq$fr2[id]' class='decfriendbtn w3-button w3-block w3-red w3-section' title='Decline'><i class='fa fa-remove'></i></button>
            </div>
          </div>
		  <a href='#'>See all $fr4 Request</a><br><br>
		  <script>
			$('#acceptq$fr2[id]').click(function(){
				$('#friendrequest').html('Loading...');
				$.ajax({
					url: 'engine.php',
					type: 'post',
					data: {
						accfr: '$fr2[id]'
					},
					success: function(z){
						$('#friendrequest').html(z);
					}
				})
		  });
		  $('#declineq$fr2[id]').click(function(){
			  $('#friendrequest').html('Loading...');
			  $.ajax({
				  url: 'engine.php',
				  type: 'post',
				  data: {
					  decfr: '$fr2[id]'
				  },
				  success: function(z){
					  $('#friendrequest').html(z);
				  }
			  })
		  });
		  </script>
		  ";
			}
			else
			{
				echo "No friend request.";
			}
		  ?>
        </div>
        </div>
      </div>
      <br>
      
      <div class="w3-card-2 w3-round w3-white w3-padding-16 w3-center">
        <p>ADS</p>
      </div>
      <br>
      
      <div class="w3-card-2 w3-round w3-white w3-padding-32 storyoverflow w3-padding" style="max-height: 300px; overflow:auto;">
	  <div class="w3-center">
	  <h5>Change Log Emulator</h5>

        <p><i class="fa fa-bug w3-xxlarge"></i></p>
		</div>
		<u>Date: 5.5.2017 10.18 PM</u><br>
		<b>New Log: </b> New Log: RentableSpace Added, Navigator Improved, CrackableEggs Improved <hr>
		
		<u>Date: 5.5.2017 8.53 PM</u><br>
		<b>New Log: </b>Navigator Search Improved + Feature Navigator (Staff Picks) , CrackableEggs Improved get some new item when the egg is cracked<hr>
		
		<u>Date Log: 3.5.2017 5.43 PM</u><br>
		<b>Log: </b>Crafting System improved, Recyclers(Ecotron) System improved, Room Polls improved, Combat System Fixed, Guide System improved & ball improved<hr>
		
		<u>Date Log: 1.5.2017 6.39 PM</u><br>
		<b>Log: </b>Crafting System Added, Crackable Eggs added 100% work, Catalogue Ecotron Added<hr>
		
		<u>Date Log: 26.4.2017 9.16 PM</u><br>
		<b>Log: </b>Guide Helper Tool Added<hr>
		
		<u>Date Log: 22.4.2017  8.50 AM</u><br>
		<b>Log: </b>Added Polls feature, Navigator search improved , inventory quick load , fishing system improved , friend list quick load<hr>
      </div>
	  <br>
	  <div class="w3-card-2 w3-round w3-white w3-padding-32 w3-center">
	  <h5>Change Log CMS</h5>
	  <span>(Version 2.1.0)</span>
        <p><i class="fa fa-bug w3-xxlarge"></i></p>
		<ul>
			<li>Adding all component</li>
			<li>Still in debug mode</li>
			<li>Not stable</li>
		</ul>
      </div>
      
    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<br>

<!-- Footer -->
<footer class="w3-container w3-theme-d3 w3-padding-16">
  <h5>Zetta&trade; Athena</h5>
  Zetta is a teen social virtual life game. A strange place with awesome people. Meet and make friends, play games, chat with others, create your avatar, design rooms and more.
</footer>

<footer class="w3-container w3-theme-d5">
  <p>&copy; Copyrights Zetta&trade; Athena 2017. ZettaCMS by Akob and Wave</p>
</footer>
 
<script>
//loader

		$(window).on('load', function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});

	//send comment
	/*
	TODO
	FIX the variable from php to javascript #request_comment
	*/
	$(document).on('click', '#sendcomment', function(){
			var filter = /(<([^>]+)>)/ig;
			var comment = $('#commentwall').val();
			var newcomment = comment.replace(filter, '');
			var reqcmt = $(this).data("postid");
			$('#showcommentarea').html("Loading");
			$("#commentwall").val("");
			$.ajax({
			url: 'engine.php',
			type: 'post',
			data: {
				sendcomment: newcomment,
				commenton: reqcmt
			},
			success: function(z){
				$('#showcommentarea').html(z);
				updatecmtcount(reqcmt);
			}
		});
		});
		
		function updatecmtcount(y){
			$.ajax({
				url: "engine.php",
				type: "post",
				data: {
					updatecmtcnt: y
				},
				success: function(z){
					$("#cmtcnt" + y).html(z);
				}
			});
		}
		function updatecmtcounts(y){
			var upd = y;
			$.ajax({
				url: "engine.php",
				type: "post",
				data: {
					updatecmtcnts: upd
				},
				success: function(z){
					$.ajax({
					url: "engine.php",
					type: "post",
					data: {
						updatecmtcnt: z
					},
					success: function(y){
						$("#cmtcnt" + z).html(y);
					}
			});
				}
			});
		}
		
//delete post
	
		$(document).on('click', '.dodeletepost', function(){
			var deletepost = $(this).data('postid');
			$('#post' + deletepost).html('Deleting...');
			$('#delete-dialog').dialog( 'close' );
			$.ajax({
				url: 'engine.php',
				type: 'post',
				data: {
					dodeletepost: deletepost
				},
				success: function(z){
					if(z == 'OK')
					{
						$('#post' + deletepost).remove()
					}
					else
					{
						$('#post' + deletepost).html('Error unknown')
					}
				}
			});
		});
		
		$(document).on('click', '.dodeletecmtpost', function(){
			var deletepost = $(this).data('postid');
			$('#comment-dialog').html('Deleting...');
			$('#delete-dialog').dialog( 'close' );
			updatecmtcounts(deletepost);
			$.ajax({
				url: 'engine.php',
				type: 'post',
				data: {
					dodeletecmtpost: deletepost
				},
				success: function(z){
					$("#comment-dialog").html(z);
					
				}
			});
		});
		
		function delpost(){
			var deletepost = $(this).data('postid');
			$('#post' + deletepost).html('Deleting...');
			$('#delete-dialog').dialog( 'close' );
			$.ajax({
				url: 'engine.php',
				type: 'post',
				data: {
					dodeletepost: deletepost
				},
				success: function(z){
					if(z == 'OK')
					{
						$('#post' + deletepost).remove()
					}
					else
					{
						$('#post' + deletepost).html('Error unknown')
					}
				}
			});
		}
		

// Like button
$(document).on("click", ".likebutton", function(){
	var likes = this.id;
	$("#" + likes).html("Loading...");
	$.ajax({
		url: "engine.php",
		type: "post",
		data: {
			like: likes
		},
		success: function(z){
			$("#" + likes).html(z)
		}
	})
});

// Accordion
function myFunction(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-theme-d1";
    } else { 
        x.className = x.className.replace("w3-show", "");
        x.previousElementSibling.className = 
        x.previousElementSibling.className.replace(" w3-theme-d1", "");
    }
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}


</script>

</body>
</html> 
