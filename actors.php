<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ru-RU">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>CrimeaCasting</title>
	<style type="text/css">
		@font-face{
			font-family: OCRAExtend;
			src: url('style/EnigmaU_2.TTF');
		}
		
		body{
			font-family: OCRAExtend, monospace;
			font-stretch: ultra-condensed;
		}
		
		.actorname{
			color: #000;
			font-size:20pt;
		}
		
		.actordata{
			color: #aaa;
			font-size:11pt;
		}
		.avat{
			border-radius: 5px;
			border: 3px solid #aaa;
		}
		
	</style>
</head>
<body>

<div align="center">
<table border="0" cellspacing="10" style="min-width:800px; max-width:90%;">
<?php
$dbact = new SQLite3("crimeacasting-actors.db");
$actreq = $dbact -> query("SELECT * FROM actors WHERE role=".$_GET['cat']);
while ( $actrow = $actreq -> fetchArray(SQLITE3_NUM) ){
	print("<tr class='str_".$actrow[0]."'>
	<td rowspan='2' width='70' valign='top' style='border-left:2px solid #0096ff; padding-left:10px;'> <img class='avat' id='img_".$actrow[0]."' src='".$actrow[6]."' height='100'> </td>");
	if ( isset( $_SESSION['edit'] ) ) { 
		print("<td rowspan='2' width='25' valign='top'> 
			<div aid='".$actrow[0]."' style='cursor:pointer;' class='editact'> <img src='img/Pencil3.png' width='24'> </div> <br>
			<div aid='".$actrow[0]."' style='cursor:pointer;' class='delactor'> <img src='img/trash.png' width='24'> </div> 
		</td>");
	}
	print("
	<td align='left' class='actorname' style='cursor:pointer' aidnm='".$actrow[0]."'> ".$actrow[2]." ".$actrow[1]." ".$actrow[3]." </td>
	</tr>
	<tr class='str_".$actrow[0]."'>
	<td class='actordata' colspan='2' valign='middle'> " . substr( strip_tags($actrow[5]), 0, 1000). "... </td>
	</tr>
	
	<tr><td style='border-top:2px solid #ff9c00' colspan='3'></td></tr>
	
	<tr style='display:none;' id='bio_".$actrow[0]."' title='About / О актёре'><td>
	<table border='0' style='float:left; background:#eee; padding: 0px 5px 0px 0px; margin: 10px; border-radius:5px;'>
	<tr>
		<td rowspan='3' width='70'><img class='avat' src='".$actrow[6]."' height='100'></td>
		<td height='30%'>".$actrow[2]."</td>
	</tr>	
	<tr><td height='30%'>".$actrow[1]."</td></tr>
	<tr><td height='30%'>".$actrow[3]."</td></tr>
	</table>
	
		<div style='padding:10px; font-family:sans-serif; font-size: 11pt;'>".$actrow[5]."</div>	
	
	");
}
?>
</table>
<?php
	print("<table style='display:none;' id='bio' title='About / О актёре' border='0' cellpadding='5'>
	<tr>
		<td rowspan='3'><img class='avat' src='".$actrow[6]."' height='100'></td>
		<td>".$actrow[2]."</td>
	</tr>	
	<tr><td>".$actrow[1]."</td></tr>
	<tr><td>".$actrow[3]."</td></tr>
	<tr>
		<td colspan='2' class='actordata'>".$actrow[5]."</td>
	</tr>
	</table>");
?>
</div>

<script type="text/javascript" >
	
	$(".editact,.delactor").mouseenter(function(){
		$(this).animate({opacity: 0.5},100);
	});
	$(".editact,.delactor").mouseleave(function(){
		$(this).animate({opacity: 1},100);
	});
	
	$('.actorname').click(function(){
		$("#bio_"+$(this).attr('aidnm')).dialog({ 
			modal:true,
			width: window.innerWidth - 150
		});
	});

	var aid="";
	$('.editact').click(function(){
			aid = $(this).attr('aid');		
			//document.getElementById("fm").src = "sform.php?lc=<?php echo($_GET['lc']); ?>&id="+aid;
			//alert(aid);
			$('#fo').load('sform.php?lc=<?php echo($_GET['lc']); ?>&id='+aid);
			$('#fo').dialog({
				width: 800,
				resizable: false,
				modal:true				
			});
	});
	
	$('.delactor').click(function(){
	aid = $(this).attr('aid');
		$.ajax({ url: "ajax-proc.php?action=1&id="+aid+"&ava="+$("#img_"+aid).attr('src') }).done( function(data){ 
			alert(data); 
			//document.getElementById( "str_"+$(this).attr('aid') ).style.display="none";
			$(".str_"+aid).hide();
		} );
	});
</script>

</body>
</html>