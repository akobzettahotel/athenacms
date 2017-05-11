<?php include("header.php"); 
if(!isset($_SESSION["athena"]))
{
	echo "<script>window.location.href = '../index';</script>";
}
else
{
	$athena = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$_SESSION[athena]'"));
}
$permission = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM zetta_ase WHERE id = '1'"));
if($athena["rank"] < $permission["rank"])
{
	echo "You don't have permissions to access this area.";
}
else
{
	?>

<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right">Zetta Athena Housekeeping</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="https://avatar-retro.com/habbo-imaging/avatarimage?figure=<?php echo $athena["look"]; ?>&headonly=1" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong><?php echo $athena["username"]; ?></strong></span><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="#" class="w3-bar-item w3-button w3-padding w3-blue tablink" onclick="openLink(event, 'overview')"><i class="fa fa-users fa-fw"></i>  Overview</a>
    <a href="#" class="w3-bar-item w3-button w3-padding tablink" onclick="openLink(event, 'userview')"><i class="fa fa-eye fa-fw"></i>  Views</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Traffic</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bullseye fa-fw"></i>  Geo</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-diamond fa-fw"></i>  Orders</a>
    <a href="#" class="w3-bar-item w3-button w3-padding tablink" onclick="openLink(event, 'news')"><i class="fa fa-bell fa-fw"></i>  News</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bank fa-fw"></i>  General</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i>  History</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Settings</a><br><br>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- news -->
<div id="news" class="w3-main city w3-animate-left" style="margin-left:300px;margin-top:43px; display:none;">
	
	<?php
	$news = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM zetta_ase WHERE id = '2'"));
	if($athena["rank"] < $news["rank"])
	{
		echo "You don't have permissions to access this area.";
	}
	else
	{ 
	?>
	<header class="w3-container" style="padding-top:22px">
		<h5><b><i class="fa fa-newspaper-o"></i> News Manager</b></h5>
	</header>
	<div class="w3-bar w3-blue">
		<button class="w3-bar-item w3-button w3-white newstablink" onclick="openNewstab(event, 'write')">Write</button>
		<button class="w3-bar-item w3-button w3-blue newstablink" onclick="openNewstab(event, 'list')">News List</button>
	</div>

	<div class="w3-row">
		<div class="w3-col l1">.</div>
		<div class="w3-col l10">
			<div id="write" class="newstab">
				<h6><b>Write a news</b></h6>
				<?php
				if(isset($_POST["addnews"]))
				{
					$title = mysqli_real_escape_string($conn, $_POST["news_title"]);
					$short_story = mysqli_real_escape_string($conn, $_POST["news_short"]);
					$long_story = mysqli_real_escape_string($conn, $_POST["news_long"]);
					$timenow = time();
					$author = $athena["id"];
					mysqli_query($conn, "INSERT INTO zetta_news (title, short_story, long_story, published, author) VALUES ('$title', '$short_story', '$long_story', '$timenow', '$author')");
					echo "<br>New news updated!<br>";
				}
				?>
				<form method="post">
					<input name="news_title" type="text" placeholder="Title" class="w3-input w3-border">
					<input name="news_short" type="text" placeholder="Short Story" class="w3-input w3-border">
					<textarea name="news_long" id="newswriter"></textarea>
					<button type="submit" name="addnews" class="w3-btn w3-black w3-block">Upload News</button>
				</form>
			</div>
			<div id="list" class="newstab" style="display:none;">
				<h6><b>News list</b></h6>
				<ul class="w3-ul w3-card-4">
					<?php
						$list1 = mysqli_query($conn, "SELECT * FROM zetta_news ORDER BY id DESC");
						while($list2 = mysqli_fetch_assoc($list1))
						{
							$author = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$list2[author]'"));
							$published = date("d/m/Y h:i a", $list2["published"]);
							if($author["gender"] == "F")
							{
								$bg = "w3-red";
							}
							else
							{
								$bg = "w3-blue";
							}
							echo "
								<li class='w3-padding-16 w3-white'>
									<span onclick=\"this.parentElement.style.display='none'\" class='w3-button w3-white w3-xlarge w3-right'>&times;</span>
    <img src='https://avatar-retro.com/habbo-imaging/avatarimage?figure=$author[look]&headonly=1' class='w3-left w3-circle w3-margin-right $bg' style='width:50px'>
    <span class='w3-large'>$list2[title]</span> <sub>($published)</sub><br>
    <span>$list2[short_story]</span>
  </li>";
						}
					?>
				<ul>
			</div>
		</div>
		<div class="w3-col l1"></div>
	</div>
	
	<script>
	function openNewstab(evt, tabname) {
		var i, x, tablinks;
		x = document.getElementsByClassName("newstab");
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("newstablink");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" w3-white", " w3-blue");
		}
		document.getElementById(tabname).style.display = "block";
		evt.currentTarget.className += " w3-white";
	}
	
	tinymce.init({ selector:'#newswriter',
	height: 350,
  theme: 'modern',
  skin: "athena",
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ],
  // enable title field in the Image dialog
			image_title: true, 
			// enable automatic uploads of images represented by blob or data URIs
			automatic_uploads: true,
			// URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
			images_upload_url: 'postAcceptor.php',
			// here we add custom filepicker only to Image dialog
			file_picker_types: 'image', 
			// and here's our custom image picker
			file_picker_callback: function(cb, value, meta) {
				var input = document.createElement('input');
				input.setAttribute('type', 'file');
				input.setAttribute('accept', 'image/*');
    
				// Note: In modern browsers input[type="file"] is functional without 
				// even adding it to the DOM, but that might not be the case in some older
				// or quirky browsers like IE, so you might want to add it to the DOM
				// just in case, and visually hide it. And do not forget do remove it
				// once you do not need it anymore.

				input.onchange = function() {
					var file = this.files[0];
      
					// Note: Now we need to register the blob in TinyMCEs image blob
					// registry. In the next release this part hopefully won't be
					// necessary, as we are looking to handle it internally.
					
					var id = 'blobid' + (new Date()).getTime();
					var blobCache = tinymce.activeEditor.editorUpload.blobCache;
					var blobInfo = blobCache.create(id, file);
					blobCache.add(blobInfo);
      
					// call the callback and populate the Title field with the file name
					cb(blobInfo.blobUri(), { title: file.name });
				};
		
				input.click();
			}

  });</script>
	<?php
	}
	?>
</div>

<!-- userview -->
<div id="userview" class="w3-main city w3-animate-left" style="margin-left:300px;margin-top:43px; display:none;">
	<?php
	$userview = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM zetta_ase WHERE id = '3'"));
	if($athena["rank"] < $userview["rank"])
	{
		echo "You don't have permissions to access this area.";
	}
	else
	{ 
	?>
	<header class="w3-container" style="padding-top:22px">
		<h5><b><i class="fa fa-user-o"></i> View Users</b></h5>
	</header>
	<input name="searchuser" id="searchuser" type="text" class="w3-input" placeholder="Search users...">
	<div id="searchuserresult"></div>
	<div id="searchuserresult2"></div>
	<script>
	$("#searchuser").keypress(function(){
		$("#searchuserresult").html("Loading...");
		$.ajax({
					url: "engine.php",
					type: "post",
					data: {
						searchuser: 1,
						username: $('#searchuser').val()
					},
					success: function(c) {
						$("#searchuserresult").html(c);
					}
				});
	});
		
		function chooseuser(a){
			$("#searchuserresult2").html("Loading...");
			$.ajax({
					url: "engine.php",
					type: "post",
					data: {
						choosuser: 1,
						id: a
					},
					success: function(c) {
						$("#searchuserresult2").html(c);
					}
				});
		}
	</script>
		<?php
	}
	?>
</div>

<!-- !PAGE CONTENT! -->
<div id="overview" class="w3-main city w3-animate-left" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo number_format(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM chatlogs"))); ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Messages</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-hotel w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo number_format(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM items"))); ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Furniture release</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-home w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo number_format(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM rooms"))); ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Room Created</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo number_format(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"))); ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Registered Users</h4>
      </div>
    </div>
  </div>

  <div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
        <h5>Regions</h5>
        <img src="/w3images/region.jpg" style="width:100%" alt="Google Regional Map">
      </div>
      <div class="w3-twothird">
        <h5>Feeds</h5>
        <table class="w3-table w3-striped w3-white">
          <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i></td>
            <td>New record, over 90 views.</td>
            <td><i>10 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bell w3-text-red w3-large"></i></td>
            <td>Database error.</td>
            <td><i>15 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-users w3-text-yellow w3-large"></i></td>
            <td>New record, over 40 users.</td>
            <td><i>17 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-comment w3-text-red w3-large"></i></td>
            <td>New comments.</td>
            <td><i>25 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bookmark w3-text-blue w3-large"></i></td>
            <td>Check transactions.</td>
            <td><i>28 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-laptop w3-text-red w3-large"></i></td>
            <td>CPU overload.</td>
            <td><i>35 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
            <td>New shares.</td>
            <td><i>39 mins</i></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>General Stats</h5>
    <p>New Visitors</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-green" style="width:25%">+25%</div>
    </div>

    <p>New Users</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-orange" style="width:50%">50%</div>
    </div>

    <p>Bounce Rate</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-red" style="width:75%">75%</div>
    </div>
  </div>
  <hr>

  <div class="w3-container">
    <h5>Countries</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <tr>
        <td>United States</td>
        <td>65%</td>
      </tr>
      <tr>
        <td>UK</td>
        <td>15.7%</td>
      </tr>
      <tr>
        <td>Russia</td>
        <td>5.6%</td>
      </tr>
      <tr>
        <td>Spain</td>
        <td>2.1%</td>
      </tr>
      <tr>
        <td>India</td>
        <td>1.9%</td>
      </tr>
      <tr>
        <td>France</td>
        <td>1.5%</td>
      </tr>
    </table><br>
    <button class="w3-button w3-dark-grey">More Countries  <i class="fa fa-arrow-right"></i></button>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Recent Users</h5>
    <ul class="w3-ul w3-card-4 w3-white">
		<?php
			$ru = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC LIMIT 5");
			while($ruu = mysqli_fetch_assoc($ru))
			{
				echo "<li class='w3-padding-16'>
        <img src='https://avatar-retro.com/habbo-imaging/avatarimage?figure=$ruu[look]&headonly=1' class='w3-left w3-circle w3-margin-right' style='width:35px'>
        <span class='w3-xlarge'>$ruu[username]</span><br>
      </li>";
			}
		?>
    </ul>
  </div>
  <hr>

  <div class="w3-container">
    <h5>Recent Comments</h5>
    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="/w3images/avatar3.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
        <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="/w3images/avatar1.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>
  </div>
  <br>
  <div class="w3-container w3-dark-grey w3-padding-32">
    <div class="w3-row">
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-green">Demographic</h5>
        <p>Language</p>
        <p>Country</p>
        <p>City</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-red">System</h5>
        <p>Browser</p>
        <p>OS</p>
        <p>More</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-orange">Target</h5>
        <p>Users</p>
        <p>Active</p>
        <p>Geo</p>
        <p>Interests</p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-light-grey">
    <h4>FOOTER</h4>
    <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
  </footer>

  <!-- End page content -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}

function openLink(evt, animName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
     tablinks[i].className = tablinks[i].className.replace(" w3-blue", "");
  }
  document.getElementById(animName).style.display = "block";
  evt.currentTarget.className += " w3-blue";
}

</script>

	
	<?php
}
?>

</body>