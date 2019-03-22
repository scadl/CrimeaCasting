<?php 
session_start(); 
require('lib/password.php');

if(!isset($_GET['lc'])){
	$lc=0;
} else {
	$lc=$_GET['lc'];
}

$db = new SQLite3("crimeacasting-data.db");
$dbact = new SQLite3("crimeacasting-actors.db");
if ( $db->query("SELECT id FROM locale") ){
	//print('existing');
} else {
	print('Table created, and filled');
	
	$db -> exec ("CREATE TABLE IF NOT EXISTS locale (id INTEGER PRIMARY KEY AUTOINCREMENT, eng TEXT, rus TEXT)");
	$db -> exec ("CREATE TABLE IF NOT EXISTS pages (id INTEGER PRIMARY KEY AUTOINCREMENT, text_eng TEXT, text_rus TEXT)");
	$dbact -> exec ("CREATE TABLE IF NOT EXISTS actors (id INTEGER PRIMARY KEY AUTOINCREMENT, first TEXT, second TEXT, last TEXT, role TEXT, about TEXT, photo TEXT)");
	$dbact -> exec ("CREATE TABLE IF NOT EXISTS role (id INTEGER PRIMARY KEY AUTOINCREMENT, role_eng TEXT, role_ru TEXT)");	
	$db -> exec ("CREATE TABLE IF NOT EXISTS admins (id INTEGER PRIMARY KEY AUTOINCREMENT, login TEXT, password TEXT)");
	
	include 'db_init.php';
}

$mdsqr = $db -> query("SELECT password FROM admins WHERE login='meta-description'");
$mkwqr = $db -> query("SELECT password FROM admins WHERE login='meta-kewords'");
//print ($mdsqr->numColumns());
while ($mrow = $mdsqr -> fetchArray(SQLITE3_NUM)){ $mds=$mrow[0]; };
while ($mrow = $mkwqr -> fetchArray(SQLITE3_NUM)){ $mkw=$mrow[0]; };

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ru-RU">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="description" content="<?php print( substr($mds, 5) ); ?>">
	<meta name="Keywords" content="<?php print( substr($mkw, 5) ); ?>">
	<title>CrimeaCasting</title>
	<style type="text/css">
		@font-face{
			font-family: OCRAExtend;
			src: url('style/EnigmaU_2.TTF');
		}
		
		.upmenu{
			font-family: OCRAExtend, monospace;
			font-stretch: ultra-condensed;
			font-size: 17pt;
			font-weight: 100;
			padding: 20px;
			text-decoration: none;
			cursor:pointer;
		}
		
		.labeltext{
			font-family: OCRAExtend;
			font-size: 20pt;
			padding: 20px 0px;
			color: #ffffff;
			width: auto;
			display: block;
			letter-spacing: 3px;
			cursor:pointer;
		}
		
		#loginf{
			font-family: sans-serif;
			padding: 10px;
			background: #ccc;
			border-radius: 0px 10px 10px 0px;
			border: 3px solid #888;
			position: absolute;
			z-index: 3;
			top: 150px;
			left: -0px;
		}
		
		.warning{
			color:white; 
			background:red;
			margin: 3px;
			font-family: sans-serif;
		}
		
		a:link{ color:#000; text-decoration:none; } 
		a:visited{ color:#000; text-decoration:none; }
		a:hover{ color:#000; text-decoration:none; }
	</style>
	<script type="text/javascript" src="script/jquery-1.10_2.js"></script>
	<script type="text/javascript" src="script/jquery.animate-colors.js"></script>
	<script type="text/javascript" src="script/jquery-ui.js"></script>
	<link rel="stylesheet" href="script/jquery-ui.css">
	<script type="text/javascript">
		$(function(){
		
			$(".upmenu").mouseenter(function(){
				$(this).animate({color: '#b654a0'}, 300);
			});
			$(".upmenu").mouseleave(function(){
				$(this).animate({color: '#000000'}, 300);
			});
			
			$(".sub1,.sub2").mouseenter(function(){
				$(this).animate({color: $(this).attr('hcl')}, 150);
			});
			$(".sub1,.sub2").mouseleave(function(){
				$(this).animate({color: '#ffffff'}, 150);
			});
			
			$(".labeltext").mouseenter(function(){
				var caller = $(this);
				var chg = $(this).outerHeight();
				$(this).children("#sub3").fadeOut(150, function(){
					caller.css({'padding': '0px', 'font-size': '20pt', 'height': chg});
					//alert(caller.children(".sub1").attr("tilt"));
					caller.children(".sub1").toggle();
					caller.children(".sub1").animate({'left': '+='+caller.children(".sub1").attr("tilt"), 'opacity': '1'}, 300);
					caller.children(".sub2").toggle(); 
					caller.children(".sub2").animate({'left': '-='+caller.children(".sub2").attr("tilt"), 'opacity': '1'}, 300);
				});
			});
			$(".labeltext").mouseleave(function(){
				var caller = $(this);
				var chg = $(this).outerHeight();
					caller.children(".sub1").animate({'left': '-='+caller.children(".sub1").attr("tilt"), 'opacity': '0'}, 300, function(){
						caller.children(".sub1").toggle();
					});
					caller.children(".sub2").animate({'left': '+='+caller.children(".sub2").attr("tilt"), 'opacity': '0'}, 300, function(){
						caller.children(".sub2").toggle();						
						caller.children("#sub3").css({'padding-top': '20px', 'font-size': '20pt'});
						caller.children("#sub3").fadeIn(150);
					});
			});
			
			
			$('.upmenu,.upsub,.sub1,.sub2').click(function(){
			
				$('.upsub').css({color: "#000000"});
				$(this).css({color: "#b654a0"});
			
				if ( $(this).attr('type') == "frame" ){
				
					//document.getElementById("fm").src = "sform.php?lc=<?php echo($lc); ?>";
					//document.getElementById("fm").style.height = "600px";
					//document.getElementById("fm").style.width = "800px";
					$('#fo').load('sform.php?lc=<?php echo($lc); ?>');
					$('#fo').dialog({
						width: 800,
						height: 500,
						resizable: false,
						modal:true
					});
					/*
					$('.maincl').fadeOut(500, function(){						
						$('#fm').fadeIn(300);
						//AdjustFrame();
						document.getElementById("fm").style.height = (window.innerHeight-170)+"px";
						document.getElementById("fm").style.width = (window.innerWidth-30)+"px";
						document.getElementById("fm").contentWindow.postMessage('data','*');
					});				
					//alert('frame'); 
					*/
					
				}
				
				if ( $(this).attr('type') == "content" ){
					$('#fm').hide();
					$('#ct').load( $(this).attr('target') );
					$('.maincl').fadeOut(500, function(){
						$('#ct').fadeIn(300);
					});
					//alert('content');
				}
			
			});
			
			$('.upmenu').click(function(){
				$('#'+$(this).attr('sub')).slideToggle(300);
				$('#'+$(this).attr('sub')).css({'display':'inline-block'});
			});
			
			$('#loginf').css({'left' : '-' + $('#loginf').outerWidth() + 'px' });
			$('#hidenlogin').click(function(){
				$('#loginf').animate({'left' : '+=' + ($('#loginf').outerWidth()-3) + 'px' }, 350);
				//alert($('#loginf').width());
			});
			
		});
	</script>
</head>
<body style="padding: 0px; margin 0:px;">

<!-- <Handling the DB and admin> -->
<?php

$localestring = array();

$fres = $db -> query("SELECT eng, rus FROM locale");
while ($row = $fres -> fetchArray(SQLITE3_NUM) ){
	$localestring[]=$row[$lc];
}

if ( isset($_POST['user']) && isset($_POST['passw']) ) { 		
//	$alogin = array();
//	$apassw = array();
	$logq = $db -> query("SELECT login, password FROM admins");
	while ($lrow = $logq -> fetchArray(SQLITE3_NUM) ) { 
		if ( $lrow[0] == $_POST['user'] && $_POST['passw'] ){
		//if ( $lrow[0] == $_POST['user'] && password_verify($_POST['passw'], $lrow[1]) ){
			//print('Admin here'); 
			
			$_SESSION['edit']=1;
		}
		//$apassw[] = mcrypt_decrypt(MCRYPT_CAST_256, $key, $lrow[1], MCRYPT_MODE_CFB, $cvect); 
		//echo (mcrypt_decrypt(MCRYPT_CAST_256, $key, $lrow[1], MCRYPT_MODE_CFB, $cvect));
	};
	
	/*
	if ( in_array($_POST['user'], $alogin) && in_array($_POST['passw'], $apassw) ) 
	{ 
		//print('Admin here'); 
		$_SESSION['edit']=1;
	} else { 
		//print('Just guest');
		//$_SESSION['edit']=0;
	}
	*/
}

if ( isset($_POST['logout']) ) {  
	unset($_SESSION['edit']);
	session_destroy();
}

?>
<!-- <DB prepeared> -->

<!-- <Login form> -->
<form action="index.php" method="post" id="loginf">
<table>
<?php if ( !isset($_SESSION['edit']) ){ ?>
<tr><td> Login </td><td> <input type="text" size="15" name="user"> </td></tr>
<tr><td> Password </td><td> <input type="text" size="15" name="passw"> </td></tr>
<tr><td colspan="2" align="center"> <input type="submit" size="15" value="Login"> </td></tr>
<?php } else { ?>
<input type="hidden" name="logout" value="1">
<tr><td align="center"> <input type="submit" size="15" value="Logout"> </td></tr>
<?php } ?>
</table>
</form>
<!-- <Login form END> -->

<!-- <Title_Page> -->
<table border="0" width="100%">
	<tr><td style="background:#fff;" align="center">
		<table border="0">
		<tr>
			<td width="120" align="center"> <img src="img/icon.png" width="120" id="hidenlogin"> </td>
			<td width="40%" align="center"> 
				<span style="font-family: OCRAExtend, monospace; font-size:30pt; font-weight:500; letter-spacing:5px;"> <a href="?&lc=<?php echo($lc); ?>">Crimeacasting</a> </span> 
			</td>
			<td width="60%" align="center"> 
				<span href=""> <span class="upmenu" type="frame"> <?php echo($localestring[0]); ?> </span> </span>
				<span href=""> <span class="upmenu" sub="supsub1"> <?php echo($localestring[1]); ?> </span> </span>
				<span href=""> <span class="upmenu" sub="supsub2"> <?php echo($localestring[2]); ?> </span> </span>
			</td>
		</tr>
		<tr>
			<td align="center"> <?php if(isset($_SESSION['edit'])){ print('<div class="warning">Admin mode</div>'); } ?> </td>
			<td align="center">		
				<a href="?lc=0" title="Switch to English"> <img src="img/GB.png" border="0"> </a>
				<a href="?lc=1" title="Переключиться на Русский"> <img src="img/RU.png" border="0"> </a>
			</td><td align="center" style="font-family: OCRAExtend;">
				<div id="supsub1" style="display:none;"> 
					<span class="upsub" style="cursor:pointer;" type="content" target="info_page.php?id=1&lc=<?php echo($lc); ?>"> <?php echo($localestring[15]); ?> </span> | 
					<span class="upsub" style="cursor:pointer;" type="content" target="info_page.php?id=2&lc=<?php echo($lc); ?>"> <?php echo($localestring[16]); ?> </span>
				</div>
				&emsp;
				<div id="supsub2" style="display:none;"> 
					<span class="upsub" style="cursor:pointer;" type="content" target="info_page.php?id=3&lc=<?php echo($lc); ?>"> <?php echo($localestring[17]); ?> </span> | 
					<span class="upsub" style="cursor:pointer;" type="content" target="info_page.php?id=4&lc=<?php echo($lc); ?>"> <?php echo($localestring[18]); ?> </span>
				</div>
			</td>
		</tr>
		</table>
		<?php if(isset($_SESSION['edit'])){ 
			print('
			<table><tr>
			<td>SEO description:</td><td> <input type="text" id="description" size="100" value="'.substr($mds, 5).'"></td>
			<td rowspan="2" valign="middle"><input type="button" onclick="SendKw()" Value="Save"><br><div align="center" id="logmt"></div></td>
			<tr><td>SEO keywords:</td><td> <input type="text" id="keywords" size="100" value="'.substr($mkw, 5).'"></td></tr>
			</table>
			'); 
			} ?>
	</td></tr>
	<tr id="mainpg"><td align="center">
		<table border="0" cellspacing="50" width="1300">
		<tr>
			<td width="25%" valign="top" style="padding-top:90px;" class="maincl"> 
				<img src="img/panel_1.png" width="100%">
				<div align="center" class="labeltext" 
				style="background: #b654a0; 
				position: relative;
				left: 50px; 
				top: -60px; 
				width: 250px;
				padding: 15px 0px;"
				> 
					<div class="sub1" style="display:none; opacity: 0; position:relative; top:10px;" tilt="90px" hcl="#d98bc7" type="content" target="actors.php?cat=1&lc=<?php echo($lc); ?>" align="left"><?php echo($localestring[3]); ?></div>
					<div id="sub3"> <?php echo($localestring[4]); ?> </div>
					<div class="sub2" style="display:none; opacity: 0; position:relative; top:20px;" tilt="70px" hcl="#d98bc7" type="content" target="actors.php?cat=2&lc=<?php echo($lc); ?>" align="right"> <?php echo($localestring[5]); ?> </div>
				</div>
				<div align="left" style="position: relative; top: 60px;"> <img src="img/logo.jpg" width="150"> </div>
			</td>
			<td width="25%" valign="top" class="maincl"> 
				<img src="img/panel_2.png" width="100%">
				<div align="left" class="labeltext" 
				style="background: #c0d12c; 
				position: relative;
				left: 220px; 
				top: -490px; 
				width: 170px;"> 
					<div class="sub1" style="display:none; opacity: 0; position:relative; top:5px;" tilt="20px" hcl="#dbe777" type="content" target="actors.php?cat=3&lc=<?php echo($lc); ?>" align="left"> <?php echo($localestring[6]); ?> </div>
					<div id="sub3"> <?php echo($localestring[7]); ?> </div>
					<div class="sub2" style="display:none; opacity: 0; position:relative; top:3px;" tilt="40px" hcl="#dbe777" type="content" target="actors.php?cat=4&lc=<?php echo($lc); ?>" align="right"> <?php echo($localestring[8]); ?> </div>
				</div>
			</td>
			<td width="25%" valign="top" style="padding-top:130px;" class="maincl"> 
				<img src="img/panel_3.png" width="100%">
				<div align="left" class="labeltext" 
				style="background: #51d7e6; 
				position: relative;
				left: 210px; 
				top: -465px; 
				width: 200px;"> 
					<div class="sub1" style="display:none; opacity: 0; position:relative; top:5px;" tilt="30px" hcl="#8fe2ec" type="content" target="actors.php?cat=5&lc=<?php echo($lc); ?>" align="left"> <?php echo($localestring[9]); ?> </div>
					<div id="sub3"> <?php echo($localestring[10]); ?> </div>
					<div class="sub2" style="display:none; opacity: 0; position:relative; top:3px;" tilt="40px" hcl="#8fe2ec" type="content" target="actors.php?cat=6&lc=<?php echo($lc); ?>" align="right"> <?php echo($localestring[11]); ?> </div>
				</div>
			</td>
			<td width="25%" valign="top" style="padding-top:270px;" class="maincl">
				<img src="img/panel_4.png" width="100%">
				<div align="right" class="labeltext" 
				style="background: #f5de42; 
				position: relative;
				left: -170px; 
				top: -50px; 
				width: 210px;"> 
					<div class="sub1" style="display:none; opacity: 0; position:relative; top:5px;" tilt="40px" hcl="#d6c238" type="content" target="actors.php?cat=7&lc=<?php echo($lc); ?>" align="left"> <?php echo($localestring[12]); ?> </div>
					<div id="sub3"> <?php echo($localestring[13]); ?> </div>
					<div class="sub2" style="display:none; opacity: 0; position:relative; top:3px;" tilt="40px" hcl="#d6c238" type="content" target="actors.php?cat=8&lc=<?php echo($lc); ?>" align="right"> <?php echo($localestring[14]); ?> </div>
				</div>				
			</td>
		</tr>
		</table>
	</td></tr>
</table>
<!-- </Title_Page Ends> -->
	
<!-- <Containers> -->
<div id="ct" style="display:none; padding:20px;"></div>
<div id="fo" style="display:none; padding:20px;" title="<?php echo($localestring[0]); ?>"></div>
<!-- <Containers Ends> -->

<!-- Meta Ajax -->
<script type="text/javascript">
function SendKw(){
	$.ajax({
		url: "ajax-proc.php?action=3",
		type: "POST",
		data: {
			keyword: $('#keywords').val(),
			descr: $('#description').val()
		},
		success: function(res){
			$('#logmt').html(res);
		}		
	});
}	
</script>
<!--/Meta Ajax -->
	
</body>
</html>



