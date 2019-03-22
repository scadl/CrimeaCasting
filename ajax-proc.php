<?php

switch ( $_GET['action'] ){
	
	case 0: // Uploading avatar				
		if ( move_uploaded_file( $_FILES['userava']['tmp_name'], 'userpic/'.basename($_FILES['userava']['name']) ) ){
			echo('userpic/'.basename($_FILES['userava']['name']));	
		} else {
			echo('img/user.png');
		}		
	break;

	case 1: // Deliting actor
		$dbact = new SQLite3("crimeacasting-actors.db");
		$dbact -> exec("DELETE FROM actors WHERE id=".$_GET['id']);
		if ($_GET['ava']!='img/user.png'){ unlink($_GET['ava']); }
		echo('Delited actor N'.$_GET['id']);
		//echo('Delited actor N'.$_GET['ava']);
	break;
	
	case 2: // Saving InfoPage contents
		if ( $_GET['lc']==0 ) { $pg_col='text_eng'; } else { $pg_col='text_rus'; }
		$db = new SQLite3("crimeacasting-data.db");
		$db -> exec ("UPDATE pages SET ".$pg_col."='".$_POST['text']."' WHERE id=".$_GET['page']);
		//echo($_GET['page'].' '.$pg_col.' '.$_POST['text']);
		echo('<hr width="100"><span style="color:blue">UPDATED</span>');
	break;
	
	case 3: // Updating (and protecting) seo meta strings
		$db = new SQLite3("crimeacasting-data.db");
		$db -> exec("UPDATE admins SET password='".rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).$_POST['keyword']."' WHERE login='meta-kewords'");
		$db -> exec("UPDATE admins SET password='".rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).$_POST['descr']."' WHERE login='meta-description'");
		echo('<span style="color:green"> OK </span>');
	break;
	
	case 4:
	$dbact = new SQLite3("crimeacasting-actors.db");
	if ( !isset($_POST['update']) ){
	$dbact -> exec("INSERT INTO actors (first, second, last, role, about, photo) VALUES (
		'".$_POST['first']."', 
		'".$_POST['second']."',
		'".$_POST['fird']."',
		".$_POST['role'].",
		'".$_POST['aboutac']."',
		'".$_POST['file']."'
		)");
		if (!$_GET['lc']) { print("Succesfully added!"); } else { print('Успешно добавлено!'); }
	} else {
		$dbact -> exec("UPDATE actors SET 
		first='".$_POST['first']."', 
		second='".$_POST['second']."',
		last='".$_POST['fird']."',
		role=".$_POST['role'].",
		about='".$_POST['aboutac']."',
		photo='".$_POST['file']."'
		WHERE id=".$_POST['id']);
		if (!$_GET['lc']) { print("Succesfully updated!"); } else { print('Успешно обновлено!'); }
	}
	break;
}
?>