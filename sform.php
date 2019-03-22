<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<style type="text/css">
#actordata{
	font-family:sans-serif;
	font-size: 10pt;
}
</style>
<script type="text/javascript" src="script/jquery-1.10_2.js"></script>
<script type="text/javascript" src="script/jquery-ui.js"></script>
<script type="text/javascript" src="script/nicEdit.js"></script>
<script type="text/javascript">
window.onmessage = function(e){
	//alert(e.data);
	nicEditors.allTextAreas({iconsPath : 'script/nicEditorIcons.gif'});
	//bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
}

</script>
</head>
<body>

<div align="center">

<?php

if(!isset($_GET['lc'])){
	$lc=0;
} else {
	$lc=$_GET['lc'];
}

$lcstr = array();

$db = new SQLite3("crimeacasting-data.db");
$dbact = new SQLite3("crimeacasting-actors.db");
$fres = $db -> query("SELECT eng, rus FROM locale");
$aces = $dbact -> query("SELECT * FROM role");
while ($row = $fres -> fetchArray(SQLITE3_NUM) ){
	$lcstr[]=$row[$lc];
}

//session_start();
//print_r($_SESSION);
?>

<form enctype="multipart/form-data" action="submit_process.php?lc=<?php echo($lc); ?>" method="post" id="actordata">
<table width="650" border="0" cellspacing="5">
<tr>
	<td> <?php echo($lcstr[19]); ?> </td>
	<td colspan="2"> <input type="text" size="80" name="first" id="name"> </td>
	</tr><tr>
	<td> <?php echo($lcstr[20]); ?> </td>
	<td colspan="2"> <input type="text" size="80" name="second" id="sern"> </td>
	</tr><tr>
	<td> <?php echo($lcstr[21]); ?> </td>
	<td colspan="2"> <input type="text" size="80" name="fird" id="last"> </td>
	</tr><tr>
	<td> <?php echo($lcstr[22]); ?> </td>
	<td colspan="2"> <select name="role">
	<?php
	while ($rowa = $aces -> fetchArray(SQLITE3_NUM) ){
		print("<option id='el_".$rowa[0]."' value='".$rowa[0]."'> ".$rowa[$lc+1]." </option>");
	}		
	?> </td>
	</tr><tr>
	<td valign="top"> <?php echo($lcstr[23]); ?> </td>
	<td> 
		<textarea width="100%" rows="10" cols="57" name="aboutac" id="about">
		<?php 
		if ( isset($_SESSION['edit']) && isset($_GET['id']) ){ 
		$adces = $dbact -> query("SELECT about FROM actors WHERE id=".$_GET['id']);
			while ($rowad = $adces -> fetchArray(SQLITE3_NUM)){
				print($rowad[0]); 
			}
		}  
		?>
		</textarea> 
	</td>
	<td align="center" width="120" valign="top"> 
		<?php echo($lcstr[24]); ?>
		<img src="img/User.png" height="110px;" style="margin:15px;" id="ava"><br>
		<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
		<input type="file" name="userava" style="border:0px solid #000; width:75px;" onchange="Updtpic(this.files)" accept="image/x-png, image/gif, image/jpeg, image/jpg">
		<?php if ( isset($_SESSION['edit']) && isset($_GET['id']) ){ 
			print('<input type="hidden" name="update" value="1" />');
			print('<input type="hidden" name="id" value="'.$_GET['id'].'" />'); 
			print('<input type="hidden" name="file" id="file" value="" />'); 
		} else {
			print('<input type="hidden" name="file" id="file" value="img/User.png" />');
		}?>
		<input type="hidden" name="newpic" id="newpic" value="0">
	</td>
	</tr><tr>
	<td colspan="3" align="center"> <input onclick="AddActor(<?php echo($lc); ?>)" type="button" value="<?php echo($lcstr[25]); ?>"> </td>
</tr>
</table>
</form>

<span id="log"></span>
</div>

<?php 
if ( isset($_SESSION['edit']) && isset($_GET['id']) ){
$adces = $dbact -> query("SELECT * FROM actors WHERE id=".$_GET['id']);
while ($rowad = $adces -> fetchArray(SQLITE3_NUM) ){

	print ("<script type='text/javascript'>
			document.getElementById('el_".$rowad[4]."').selected=true;
			document.getElementById('name').value='".$rowad[1]."';
			document.getElementById('sern').value='".$rowad[2]."';
			document.getElementById('last').value='".$rowad[3]."';
			document.getElementById('ava').src='".$rowad[6]."';
			document.getElementById('file').value='".$rowad[6]."';
		</script>");
	} 
 } 
?>

<script type="text/javascript">
var textar;
textar = new nicEditor({iconsPath : "script/nicEditorIcons.gif", fullPanel : true}).panelInstance('about');

function Updtpic(files){
	//alert( $('#ava') );
	//document.getElementById('newpic').value=1;
	var formData = new FormData();
	formData.append("userava", files.item(0));
	
	$.ajax( {
		url: "ajax-proc.php?action=0",
		type: "POST",
		data: formData,
        async: false,
        success: function (data) {
             $('#ava').attr('src', data);
			 $('#file').attr('value', data);
         },
         cache: false,
         contentType: false,
         processData: false
		});
}

function AddActor(lc){
	$('#actordata').fadeOut(100);
	$('#log').html('Waiting....');
	textar.removeInstance('about');
	var fdat = new FormData( document.getElementById("actordata") );
	$.ajax({
		url: "ajax-proc.php?action=4&lc="+lc,
		type: "POST",
		data: fdat,
		processData: false,
		contentType: false,
		success: function(resl){
			//alert(resl);
			//$("#ct").dialog("close");
			$('#log').html(resl);
		}
	});
}

</script>
	
</body>
</html>