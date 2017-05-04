<?php 
$me = 1;
include("navbar.php"); ?>
		<div class="w3-row-padding">
			<div class="w3-col l8"> 
				<div class="w3-panel w3-white">
					<div class="w3-row">
						<div class="w3-col l3">
							<div class="w3-container w3-light-blue w3-round-large w3-margin">
								<center><img src="https://avatar-retro.com/habbo-imaging/avatarimage?figure=<?php echo $athena["look"]; ?>" class="w3-margin-bottom"></center>
							</div>
						</div>
						<div class="w3-col l4">
							<div class="w3-container w3-black w3-margin-top w3-padding-large">
								<?php echo "<b>".$athena["username"]."</b><br>$athena[motto]"; ?> 
								<a target="_blank" href="client"><button class="w3-btn w3-green w3-block w3-margin-top">Enter Zetta</button></a>
							</div>
						</div>
						<div class="w3-col l5">
				
							<div class="w3-panel w3-dark-grey w3-round-large w3-padding-4 w3-margin-left">Credits: <?php echo number_format($athena["credits"]); ?></div>
							<div class="w3-panel w3-dark-grey w3-round-large w3-padding-4 w3-margin-left">Pixels: <?php echo number_format($athena["activity_points"]); ?></div>
							<div class="w3-panel w3-dark-grey w3-round-large w3-padding-4 w3-margin-left">Shells: <?php echo number_format($athena["vip_points"]); ?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="w3-col l4">
				<div class="w3-panel w3-white">
					Zetta page is under construction
				</div>
			</div>
		</div>
	</div>
	<div class="w3-col l1">&nbsp;</div>
</div>

<?php include("footer.php"); ?>