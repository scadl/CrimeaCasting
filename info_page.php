<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>CrimeaCasting</title>
	<script type="text/javascript" src="script/nicEdit.js"></script>
	<script type="text/javascript" src="script/jquery-1.10_2.js"></script>
</head>
<body>
<div align="center">

<?php	

if(!isset($_GET['lc'])){
	$lc=0;
} else {
	$lc=$_GET['lc'];
}

$db = new SQLite3("crimeacasting-data.db");
$fres = $db -> query("SELECT text_eng, text_rus FROM pages WHERE id=".$_GET['id']);
while ($row = $fres -> fetchArray(SQLITE3_NUM) ){
	$data=$row[$lc];	
}

//session_start(); 

if ( isset($_SESSION['edit']) && isset($_GET['id']) ){ 
	print ("<textarea rows='20' cols='130' id='pMemo'> ".$data." </textarea>
	<br><input type='button' value='Save' onclick='dSave()'><br><span id='lbSv'></span>");
} else {
	print($data);
}

?>

</div>

<script type="text/javascript">
var textar;
textar = new nicEditor({iconsPath : "script/nicEditorIcons.gif", fullPanel : true}).panelInstance('pMemo');

function dSave(){
	textar.removeInstance('pMemo');
	$.ajax({ 
		url: "ajax-proc.php?action=2&page=<?php echo($_GET['id']); ?>&lc=<?php echo($lc); ?>",
		type: "POST",
		data: {
			text: document.getElementById("pMemo").value
		},
		success: function(data){
			//alert(data);
			$("#lbSv").html(data);
			textar = new nicEditor({iconsPath : "script/nicEditorIcons.gif", fullPanel : true}).panelInstance('pMemo');
		}
	});
}

</script>

</body>
</html>