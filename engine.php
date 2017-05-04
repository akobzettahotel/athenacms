<?php
session_start();
include("database.php");

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

if(isset($_POST["register"]))
{
	if(!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]))
	{
		$username = mysqli_real_escape_string($conn, $_POST["username"]);
		$email = mysqli_real_escape_string($conn, $_POST["email"]);
		$password = mysqli_real_escape_string($conn, $_POST["password"]);
		if(!preg_match('/^[a-zA-Z0-9]*$/', $username))
		{
			echo "Error: #01";
		}
		else
		{
			$reg1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'"));
			$reg2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE mail = '$email'"));
			if($reg1 > 0)
			{
				echo "Sorry username already taken";
			}
			else
			{
				if($reg2 > 0)
				{
					echo "Email address already in our server";
				}
				else
				{
					$passw = password_hash($password, PASSWORD_DEFAULT);
					$create = time();
					$sso = 'ZettaCMS-'.rand(9,999).'/'.substr(sha1(time()).'/'.rand(9,9999999).'/'.rand(9,9999999).'/'.rand(9,9999999),0,33);
					mysqli_query($conn, "INSERT INTO users (username, password, mail, auth_ticket, credits, account_created, look) VALUES ('$username', '$passw', '$email', '$sso', '0', '$create', 'ch-255-63.hd-208-1.hr-3163-31.lg-280-1408.')");
					//echo "INSERT INTO users (username, password, mail, auth_ticket, credits, account_created, look) VALUES ('$username', '$passw', '$email', '$sso', '0', '$create', 'ch-255-63.hd-208-1.hr-3163-31.lg-280-1408.')";
					$login = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'"));
					$_SESSION["athena"] = $login["id"];
					$_SESSION["athena_sso"] = $sso;
					//mysqli_query($conn, "INSERT INTO zetta (id) VALUES ('$login[id]')");
					echo "<script>window.location.href = 'me';</script>Creating your account...";
				}
			}
		}
	}
	else
	{
		echo "Error: #00";
	}
}
if(isset($_POST["login"]))
{
	if(!empty($_POST["username"]) && !empty($_POST["password"]))
	{
		$username = mysqli_real_escape_string($conn, $_POST["username"]);
		$pass = mysqli_real_escape_string($conn, $_POST["password"]);
		$login1 = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
		if(mysqli_num_rows($login1) > 0)
		{
			$login2 = mysqli_fetch_assoc($login1);
			if(password_verify("$pass", $login2["password"]))
			{
				$sso = 'ZettaCMS-'.rand(9,999).'/'.substr(sha1(time()).'/'.rand(9,9999999).'/'.rand(9,9999999).'/'.rand(9,9999999),0,33);
				mysqli_query($conn, "UPDATE users SET auth_ticket = '$sso' WHERE id = '$login2[id]'");
				$_SESSION["athena"] = $login2["id"];
				$_SESSION["athena_sso"] = $sso;
	//			$checkzetta = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM zetta WHERE id = '$login2[id]'"));
	//			if($checkzetta < 1)
	//			{
	//				mysqli_query($conn, "INSERT INTO zetta (id) VALUES ('$login2[id]')");
	//			}
				echo "Logging in.(<a href='me'>Click here if not load in 3 second</a>)<script>window.location.replace(\"me\");
				location.reload();
				</script>";
			}
			else
			{
				echo "Password not match";
			}
		}
		else
		{
			$login11 = mysqli_query($conn, "SELECT * FROM users WHERE mail = '$username'");
			if(mysqli_num_rows($login11) > 0)
			{
				$login21 = mysqli_fetch_assoc($login11);
				if(password_verify("$pass", $login21["password"]))
				{
					$sso = 'ZettaCMS-'.rand(9,999).'/'.substr(sha1(time()).'/'.rand(9,9999999).'/'.rand(9,9999999).'/'.rand(9,9999999),0,33);
					mysqli_query($conn, "UPDATE users SET auth_ticket = '$sso' WHERE id = '$login21[id]'");
					$_SESSION["athena"] = $login21["id"];
					$_SESSION["athena_sso"] = $sso;
//					$checkzetta = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM zetta WHERE id = '$login21[id]'"));
//					if($checkzetta < 1)
//					{
//						mysqli_query($conn, "INSERT INTO zetta (id) VALUES ('$login21[id]')");
//					}
					echo "Logging in.(<a href='me'>Click here if not load in 3 second</a>)<script>window.location.replace(\"me\");
					location.reload();</script>";
				}
				else
				{
					echo "Password not match";
				}
			}
			else
			{
				echo "Username not exist please register";
			}
		}
	}
	else
	{
		echo "Error: #02";
	}
}

if(isset($_POST["like"]))
{
	$pid = mysqli_real_escape_string($conn, $_POST["like"]);
	$like = mysqli_query($conn, "SELECT * FROM athena_post_like WHERE uid = '$_SESSION[athena]' AND pid = '$pid'");
	if(mysqli_num_rows($like) > 0)
	{
		$like1 = mysqli_num_rows($like);
		$like3 = mysqli_fetch_assoc($like);
		if($like3["islike"] == "1")
		{
			mysqli_query($conn, "UPDATE athena_post_like SET islike = '0' WHERE id = '$like3[id]'");
		}
		if($like3["islike"] == "0")
		{
			mysqli_query($conn, "UPDATE athena_post_like SET islike = '1' WHERE id = '$like3[id]'");
		}
	}
	else
	{
		mysqli_query($conn, "INSERT INTO athena_post_like (uid, pid, islike) VALUES ('$_SESSION[athena]', '$pid', '1')");
	}
	$like2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM athena_post_like WHERE pid = '$pid' AND islike = '1'"));
	if($like2 < 2)
			  {
				  $a5 = "Like";
			  }
			  else
			  {
				  $a5 = "Likes";
			  }
	echo "<i class='fa fa-thumbs-up'></i> &nbsp; $like2 $a5";
}

if(isset($_POST["accfr"]))
{
	if(!empty($_POST["accfr"]))
	{
		$fr = mysqli_real_escape_string($conn, $_POST["accfr"]);
		$ck1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM messenger_requests WHERE id = '$fr'"));
		if($ck1["to_id"] == $_SESSION["athena"])
		{
			mysqli_query($conn, "INSERT INTO messenger_friendships (user_one_id, user_two_id) VALUES ('$ck1[to_id]', '$ck1[from_id]')");
			mysqli_query($conn, "DELETE FROM messenger_requests WHERE id = '$fr'");
			//this
			$fr0 = mysqli_query($conn, "SELECT * FROM messenger_requests WHERE to_id = '$_SESSION[athena]' ORDER BY id DESC LIMIT 1");
			$fr4 = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM messenger_requests WHERE to_id = '$_SESSION[athena]'"));
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
              <button id='declineq$fr2[id]' class='w3-button w3-block w3-red w3-section' title='Decline'><i class='fa fa-remove'></i></button>
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
			//untill this
		}
		else
		{
			echo "not own";
		}
	}
	else
	{
		echo "string empty";
	}
}

if(isset($_POST["decfr"]))
{
	if(!empty($_POST["decfr"]))
	{
		$fr = mysqli_real_escape_string($conn, $_POST["decfr"]);
		$ck1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM messenger_requests WHERE id = '$fr'"));
		if($ck1["to_id"] == $_SESSION["athena"])
		{
			mysqli_query($conn, "DELETE FROM messenger_requests WHERE id = '$fr'");
			//this
			$fr0 = mysqli_query($conn, "SELECT * FROM messenger_requests WHERE to_id = '$_SESSION[athena]' ORDER BY id DESC LIMIT 1");
			$fr4 = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM messenger_requests WHERE to_id = '$_SESSION[athena]'"));
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
              <button id='declineq$fr2[id]' class='w3-button w3-block w3-red w3-section' title='Decline'><i class='fa fa-remove'></i></button>
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
			//untill this
		}
		else
		{
			echo "not own";
		}
	}
	else
	{
		echo "string empty";
	}
}

if(isset($_POST["setting_motto"])){
	$motto = mysqli_real_escape_string($conn, $_POST["setting_motto"]);
	mysqli_query($conn, "UPDATE users SET motto = '$motto' WHERE id = '$_SESSION[athena]'");
	echo "<strong>Your motto have been saved.</strong>";
}

if(isset($_POST["setting_block_newfriends"]))
{
	$setting_block_newfriends = mysqli_real_escape_string($conn, $_POST["setting_block_newfriends"]);
	mysqli_query($conn, "UPDATE users SET block_newfriends = '$setting_block_newfriends' WHERE id = '$_SESSION[athena]'");
	if($setting_block_newfriends == "1")
	{
		echo "Saved. You are not allow user to add.";
	}
	if($setting_block_newfriends == "0")
	{
		echo "saved. You allow user to add.";
	}
}

if(isset($_POST["setting_hide_online"]))
{
	$setting_hide_online = mysqli_real_escape_string($conn, $_POST["setting_hide_online"]);
	mysqli_query($conn, "UPDATE users SET hide_online = '$setting_hide_online' WHERE id = '$_SESSION[athena]'");
	if($setting_hide_online == "1")
	{
		echo "Saved. Your friend can't see you online.";
	}
	if($setting_hide_online == "0")
	{
		echo "saved. You friend can see you online.";
	}
}

if(isset($_POST["setting_hide_inroom"]))
{
	$setting_hide_inroom = mysqli_real_escape_string($conn, $_POST["setting_hide_inroom"]);
	mysqli_query($conn, "UPDATE users SET hide_inroom = '$setting_hide_inroom' WHERE id = '$_SESSION[athena]'");
	if($setting_hide_inroom == "1")
	{
		echo "Saved. Your friend can't follow you.";
	}
	if($setting_hide_inroom == "0")
	{
		echo "saved. You friend can follow you.";
	}
}

if(isset($_POST["request_comment"]))
{
	if(!empty($_POST["request_comment"]))
	{
		$request_comment = mysqli_real_escape_string($conn, $_POST["request_comment"]);
		echo "<textarea class='w3-input' id='commentwall'></textarea><button id='sendcomment' class='w3-button w3-theme-d4' data-postid='$request_comment'>Comment</button><hr><div id='showcommentarea'>";
		$req1 = mysqli_query($conn, "SELECT * FROM athena_post WHERE comment = '$request_comment' ORDER BY id DESC");
		if(mysqli_num_rows($req1) > 0)
		{
			while($a1 = mysqli_fetch_assoc($req1))
			{
				$a3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$a1[postby]'"));
				echo "<div class='w3-container w3-card-2 w3-white w3-round w3-margin'>
					<img src='https://avatar-retro.com/habbo-imaging/avatarimage?figure=$a3[look]&headonly=1' alt='Avatar' class='w3-left w3-circle w3-margin-right' style='width:60px'>
					<span class='w3-right w3-opacity'>" . time_elapsed_string('@' . $a1["posttime"] . '') . "</span>
					<h4 class='onprofile' data-onprofile='$a3[username]'>$a3[username]</h4>
					$a1[poststory]<br>
					</div>";
			}
		}
		else
		{
			echo "No comment";
		}
		echo "</div>
		<script>
		
		</script>
		";
	}
	else
	{
		
	}
}

if(isset($_POST["sendcomment"])){
	
	$sendcomment = mysqli_real_escape_string($conn, $_POST["sendcomment"]);
	$commenton = mysqli_real_escape_string($conn, $_POST["commenton"]);
	$sendtimer = time();
	
	mysqli_query($conn, "INSERT INTO athena_post (postby, postat, posttime, poststory, comment) VALUES ('$_SESSION[athena]', '0', '$sendtimer', '$sendcomment', '$commenton')");
//	echo "INSERT INTO athena_post (postby, postat, posttime, poststory, comment) VALUES ('$_SESSION[athena]', '0', '$sendtimer', '$sendcomment', '$commenton')";
	
	if(!empty($_POST["commenton"]))
	{
		$request_comment = mysqli_real_escape_string($conn, $_POST["commenton"]);
//		echo "<textarea class='w3-input' id='commentwall'></textarea><button id='sendcomment' class='w3-button w3-theme-d4'>Comment</button><hr><div id='showcommentarea'>";
		$req1 = mysqli_query($conn, "SELECT * FROM athena_post WHERE comment = '$request_comment' ORDER BY id DESC");
		if(mysqli_num_rows($req1) > 0)
		{
			while($a1 = mysqli_fetch_assoc($req1))
			{
				$a3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$a1[postby]'"));
				echo "<div class='w3-container w3-card-2 w3-white w3-round w3-margin'>
					<img src='https://avatar-retro.com/habbo-imaging/avatarimage?figure=$a3[look]&headonly=1' alt='Avatar' class='w3-left w3-circle w3-margin-right' style='width:60px'>
					<span class='w3-right w3-opacity'>" . time_elapsed_string('@' . $a1["posttime"] . '') . "</span>
					<h4 class='onprofile' data-onprofile='$a3[username]'>$a3[username]</h4>
					$a1[poststory]<br>
					</div>";
			}
		}
		else
		{
			echo "No comment";
		}

	}
	else
	{
		
	}
}

if(isset($_POST["deletepost"]))
{
	if(!empty($_POST["deletepost"]))
	{
		$deletepost = mysqli_real_escape_string($conn, $_POST["deletepost"]);
		echo "Are you sure to delete your post?<br><br><center><button data-postid='$deletepost' class='dodeletepost w3-button w3-green'>Delete</button> <button onclick=\"$('#delete-dialog').dialog( 'close' )\" class='w3-button w3-red'>Cancel</button></center>";
	}
}
if(isset($_POST["dodeletepost"]))
{
	if(!empty($_POST["dodeletepost"]))
	{
		$dodeletepost = mysqli_real_escape_string($conn, $_POST["dodeletepost"]);
		$check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM athena_post WHERE id = '$dodeletepost'"));
		if($check["postby"] == $_SESSION["athena"])
		{
			mysqli_query($conn, "DELETE FROM athena_post WHERE id = '$dodeletepost'");
			echo "OK";
		}
	}
}

if(isset($_POST["editpost"]))
{
	if(!empty($_POST["editpost"]))
	{
		$editpost = mysqli_real_escape_string($conn, $_POST["editpost"]);
		$edit1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM athena_post WHERE id = '$editpost'"));
		if($edit1["postby"] == $_SESSION["athena"])
		{
			echo "$edit1[poststory]";
		}
	}
}
if(isset($_POST["savepost"]))
{
	if(!empty($_POST["savepost"]) && !empty($_POST["postid"]))
	{
		$savepost = mysqli_real_escape_string($conn, $_POST["savepost"]);
		$postid = mysqli_real_escape_string($conn, $_POST["postid"]);
		$edited = time();
		$a0 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT postby FROM athena_post WHERE id = '$postid'"));
		if($a0["postby"] == $_SESSION["athena"])
		{
			mysqli_query($conn, "UPDATE athena_post SET poststory = '$savepost', edited = '$edited' WHERE id = '$postid'");
		}
		$a1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM athena_post WHERE id = '$postid'"));
		$athena = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$a1[postby]'"));
		
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
			  
		echo "<div class='w3-display-topright'>
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
					$a1[poststory] $a8<br>
        <button id='$a1[id]' type='button' class='likebutton w3-button w3-theme-d1 w3-margin-bottom'><i class='fa fa-thumbs-up'></i> &nbsp; $a4 $a5</button> 
        <button data-postid='$a1[id]' type='button' class='cmtbutton w3-button w3-theme-d2 w3-margin-bottom'><i class='fa fa-comment'></i> &nbsp; $a6 $a7</button>";
	}
}