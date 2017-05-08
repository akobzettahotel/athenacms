<?php include("header.php"); 
if(isset($_SESSION["athena"]))
{
	echo "<script>window.location.href = 'me';</script>";
}
?>
<div class="w3-margin">
	<div class="w3-container w3-gray w3-card-4" style=" opacity: 0.8;">
		<div class="w3-container ">
			<div class="w3-row">
				<div class="w3-col m5">
					<h2>Zetta</h2><sup>Athena</sup>
					<span class="w3-right w3-orange w3-padding"><?php echo $server["users_online"]; if($server["users_online"] > 1){ echo " users online"; } else { echo " user online"; } ?> </span>
				</div>
				<div class="w3-col m7">
				<div class="w3-panel w3-display-container w3-red" style="display:none;" id="log_msg">
							<span onclick="document.getElementById('log_msg').style.display='none'" class="w3-button w3-display-topright w3-red w3-hover-red" title="Close"><span class="ui-icon ui-icon-closethick"></span></span>
							<p id="log_msg_sub">Loading</p>
						</div>
					<div class="w3-row-padding">
						<div class="w3-col m12 l4">
							<label><span class="ui-icon ui-icon-person"></span> Username/Email: </label>
							<input class="w3-input w3-border" type="text" placeholder="Username / Email" id="log_username">
						</div>
						<div class="w3-col m12 l4">
							<label><span class="ui-icon ui-icon-locked"></span> Password</label>
							<input class="w3-input w3-border" type="password" placeholder="Password" id="log_pass">
						</div>
						<div class="w3-col m12 l4">
						
							<button class="w3-button w3-blue w3-margin-top" id="login"><span class="ui-icon ui-icon-key"></span> Login</button>
						</div>
					</div>
				</div>
			</div>
			<hr>
		</div>
		<div class="w3-container w3-white w3-padding-xlarge" id="welcome_msg">
			<div class="w3-row">
				<div class="w3-col m3">
					<center><button class="w3-btn w3-green w3-xlarge w3-padding-xlarge w3-margin-top" id="register">Register</button></center>
				</div>
				<div class="w3-col m6" id="register1">
					<h2>Welcome to Zetta</h2>
					Zetta is a teen social virtual life game. A strange place with awesome people. Meet and make friends, play games, chat with others, create your avatar, design rooms and more.
				</div>
				<div class="w3-col m6" style="display:none;" id="register2">
					<h2>Register Zetta</h2>
					<div class="w3-container">
						<div class="w3-panel w3-display-container w3-red" style="display:none;" id="reg_msg">
							<span onclick="document.getElementById('reg_msg').style.display='none'" class="w3-button w3-display-topright w3-red w3-hover-red" title="Close"><span class="ui-icon ui-icon-closethick"></span></span>
							<p id="reg_msg_sub">Loading</p>
						</div>
						<label><span class="ui-icon ui-icon-person"></span> Username</label>
						<input class="w3-input" type="text" id="reg_username">
						<label><span class="ui-icon ui-icon-mail-closed"></span> Email</label>
						<input class="w3-input" type="email" id="reg_email">
						<label><span class="ui-icon ui-icon-locked"></span> Password</label>
						<input class="w3-input" type="password" id="reg_pass1">
						<label><span class="ui-icon ui-icon-locked"></span> Confirm Password</label>
						<input class="w3-input" type="password" id= "reg_pass2">
						<br>
						<button class="w3-green w3-btn w3-btn-block" id="do_reg"><span class="ui-icon ui-icon-check"></span> Register</button>

					</div>
				</div>
			</div>
		</div>
		<div class="w3-container">
			<hr>
			<h2><u>News</u></h2>
		</div>
	</div>
</div>
<script>
var flag1 = 0;
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
	$("#register").click(function(){
		if(flag1 == 0)
		{
			$("#register1").hide("bind");
			$("#register2").delay( 700 ).show("bind");
			$("#register").html("Cancel");
			$("#register").removeClass("w3-green");
			$("#register").addClass("w3-red");
			flag1 = 1;
		}
		else if(flag1 == 1)
		{
			$("#register1").delay( 700 ).show("bind");
			$("#register2").hide("bind");
			$("#register").html("Register");
			$("#register").addClass("w3-green");
			$("#register").removeClass("w3-red");
			flag1 = 0;
		}
	})
	$("#do_reg").click(function(){
		do_register();
	});
	
	$('#reg_username, #reg_email, #reg_pass1, #reg_pass2').keypress(function (e) {
		if (e.which == 13) {
			do_register();
			return false;    //<---- Add this line
		}
	});
	
	$("#login").click(function(){
		do_login();
	});
	$('#log_username, #log_pass').keypress(function (e) {
		if (e.which == 13) {
			do_login();
			return false;    //<---- Add this line
		}
	});
	
	function do_register(){
		$("#reg_msg").show("explode");
		if($("#reg_username").val().length === 0)
		{
			
			$("#reg_msg_sub").html("Please fill your username");
		}
		else if($("#reg_email").val().length === 0)
		{
			
			$("#reg_msg_sub").html("Please fill your email");
		}
		else if($("#reg_pass1").val().length === 0)
		{
			
			$("#reg_msg_sub").html("Please fill your password");
		}
		else if($("#reg_pass2").val().length === 0)
		{
			
			$("#reg_msg_sub").html("Please confirm your password");
		}
		else
		{
			var str = $('#reg_username').val();
			var str1 = $('#reg_email').val();
			var pass1 = $('#reg_pass1').val();
			var pass2 = $('#reg_pass2').val();
			if(/^[a-zA-Z0-9]*$/.test(str) == false) {
				$("#reg_msg_sub").html('Special character not allow for username');
			}
			else if(!isEmail(str1))
			{
				$("#reg_msg_sub").html('Please check your email');
			}
			else if(pass1 != pass2)
			{
				$("#reg_msg_sub").html('Your confirm password not match');
			}
			else
			{
				$("#reg_msg_sub").html("Checking info");
				$.ajax({
					url: "engine.php",
					type: "post",
					data: {
						register: 1,
						username: $('#reg_username').val(),
						email: $('#reg_email').val(),
						password: $('#reg_pass1').val()
					},
					success: function(c) {
						$("#reg_msg_sub").html(c);
					}
				});
			}
			
		}
	}
	function do_login(){
		$('#log_msg').show('explode');
		if($("#log_username").val().length === 0)
		{
			$('#log_msg_sub').html("Please fill your username or email");
		}
		else if($('#log_pass').val().length === 0)
		{
			$('#log_msg_sub').html("Please fill your password");
		}
		else
		{
			$('#log_msg_sub').html("Loading...");
			$.ajax({
				url: "engine.php",
				type: "post",
				data: {
					login: 1,
					username: $('#log_username').val(),
					password: $('#log_pass').val()
				},
				success: function(c){
					$('#log_msg_sub').html(c)
				}
			});
		}
	}
</script>
<?php include("footer.php"); ?>