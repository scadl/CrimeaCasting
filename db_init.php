<?php
	$db -> exec ("INSERT INTO pages (text_eng, text_rus) VALUES ('About our organization','О нашей организации')");
	$db -> exec ("INSERT INTO pages (text_eng, text_rus) VALUES ('Contact us with','Свяжитесь с нами через')");
	$db -> exec ("INSERT INTO pages (text_eng, text_rus) VALUES ('Work Photos','Рабочие Фотографии')");
	$db -> exec ("INSERT INTO pages (text_eng, text_rus) VALUES ('Work Videos','Видео о нашей организации')");
	
	$db -> exec ("INSERT INTO admins (login, password) VALUES ('meta-kewords','".rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9)."casting, crimea')");	
	$db -> exec ("INSERT INTO admins (login, password) VALUES ('meta-description','".rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9)."CrimeaCasting - find actors for filming in south coast')");	
	//include "salt.php";
	//$crypt_pass = mcrypt_encrypt( MCRYPT_CAST_256, $key, 'sDpG6ShX7', MCRYPT_MODE_CFB, $cvect);
	$crypt_pass = password_hash('sDpG6ShX7', PASSWORD_BCRYPT, array('cost' => 13, 'salt' => mcrypt_create_iv(23, MCRYPT_DEV_RANDOM),));
	$db -> exec ("INSERT INTO admins (login, password) VALUES ('Admin','".$crypt_pass."')");
	
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('sabmit your CV','Отправить Анкету')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('about','О нас')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('our works','Наши работы')");
	
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Male','Мужчины')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('/professional<br> actors','/Актёры-<br>профессионалы')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Female','Женщины')");	
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Girls','Девушки')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES (' /models',' /Модели')");	
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Boys','Парни')");	
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Boys','Мальчики')");	
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES (' /childrens',' /Дети')");	
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Girls','Девочки')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Toms','Самцы')");	
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('/animals','/Животные')");	
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Dams','Самки')");	
	
	$dbact -> exec ("INSERT INTO role (role_eng, role_ru) VALUES ('Professional Actor','Профессиональный актёр')");
	$dbact -> exec ("INSERT INTO role (role_eng, role_ru) VALUES ('Professional Actress','Профессиональная актриса')");	
	$dbact -> exec ("INSERT INTO role (role_eng, role_ru) VALUES ('Model Girl','Девушка-Модель')");
	$dbact -> exec ("INSERT INTO role (role_eng, role_ru) VALUES ('Model Boy','Парень-Модель')");	
	$dbact -> exec ("INSERT INTO role (role_eng, role_ru) VALUES ('Children Boy','Мальчик')");
	$dbact -> exec ("INSERT INTO role (role_eng, role_ru) VALUES ('Children Girl','Девочки')");
	$dbact -> exec ("INSERT INTO role (role_eng, role_ru) VALUES ('Tom','Самец')");	
	$dbact -> exec ("INSERT INTO role (role_eng, role_ru) VALUES ('Dam','Самочка')");	
	
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Organization','Организация')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Contacts','Контакты')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Photos','Фотографии')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Video','Видеозаписи')");
	
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('First Name','Имя')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Sirname','Фамилия')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Patronymic','Отчество')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Apply as','Подать как')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('About me','Обо мне')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Upload your photo<br>(up to 30Kb)','Загрузить фото<br>(до 30Кб)')");
	$db -> exec ("INSERT INTO locale (eng, rus) VALUES ('Submit CV','Отправить анкету')");
?>