<!DOCTYPE html>
<html lang="en">
    <head>
	<?php
	include("database.php");
	session_start();
	if(!isset($_SESSION["athena"]))
{
	echo "<script>window.location.href = 'index';</script>";
}
else
{
	$athena = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$_SESSION[athena]'"));
	$sso = 'ZettaCMS-'.rand(9,999).'/'.substr(sha1(time()).'/'.rand(9,9999999).'/'.rand(9,9999999).'/'.rand(9,9999999),0,33);
	mysqli_query($conn, "UPDATE users SET auth_ticket = '$sso' WHERE id = '$athena[id]'");
}
	?>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">

        <title>Zetta Athena: Client</title>
        <link rel="icon" href="zetta.ico">
        <link rel="stylesheet" href="client.css" type="text/css">

        <script type="text/javascript" src="swfobject.js"></script>
		<script src="jquery-3.2.0.min.js"></script>
        <script type="text/javascript">
            var BaseUrl = "http://localhost/swf/gordon/PRODUCTION-201701242205-837386173/";
            var flashvars =
            {
                "client.starting" : "Loading Zetta for you <?php echo $athena["username"]; ?>", 
				"client.starting.revolving" : "Loading Zetta Athena [_ETTA]/Loading Zetta Athena [Z_TTA]/Loading Zetta Athena [ZE_TA]/Loading Zetta Athena [ZET_A]/Loading Zetta Athena [ZETT_]",
                "client.allow.cross.domain" : "1", 
                "client.allow.cross.domain" : "1", 
                "client.notify.cross.domain" : "0", 
                "connection.info.host" : "data2.zetta-hotel.com", 
                "connection.info.port" : "30001", 
                "site.url" : "http://localhost", 
                "url.prefix" : "http://localhost", 
                "client.reload.url" : "http://localhost/client", 
                "client.fatal.error.url" : "http://localhost/me", 
                "client.connection.failed.url" : "http://localhost/client", 
                "external.variables.txt" : "http://localhost/swf/gamedata/external_variables.txt", 
                "external.texts.txt" : "http://localhost/swf/gamedata/external_flash_texts.txt", 
                "productdata.load.url" : "http://localhost/swf/gamedata/productdata.txt", 
                "furnidata.load.url" : "http://localhost/swf/gamedata/furnidata.xml", 
                "use.sso.ticket" : "1", 
                "sso.ticket" : "<?php echo $sso; ?>", 
                "processlog.enabled" : "0", 
                "flash.client.url" : BaseUrl, 
                "flash.client.origin" : "popup"				
            };
            var params =
            {
                "base" : BaseUrl,
                "allowScriptAccess" : "always",
                "menu" : "false",
				"wmode": "opaque"          
            };
            swfobject.embedSWF(BaseUrl + "Habbo.swf", "client", "100%", "100%", "10.0.0", BaseUrl+"/expressInstall.swf", flashvars, params, null);
        </script>
    </head>
    
    <body>
	
	
		<div id="wholeclient">

        <div id="client"></div>
		</div>

<div id="station_data"></div>

    </body>
</html>