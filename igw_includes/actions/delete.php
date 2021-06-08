<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Copyright (C) 2020 Francisco Gálvez Prada                 *
 * This file is part of the project BackupMail               *
 * Contribute on https://github.com/Iguannaweb/backupmail    *
 *                                                           *
 * BACKUPMAIL                                                * 
 * This is a simple solution to backup all your mails.       *
 * It will organize your mails by account, year, month and   *
 * it will create a separate eml file for every mail.        *
 * It will download the attachments too.                     *
 * Contact: info@iguannaweb.com                              *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
if(!defined('INCLUDE_CHECK')) die('No puedes acceder directamente');

//MUST BE AN ADMIN
if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){

//DELETE TAGS
if(isset($_GET["t"]) && ((int)$_GET["t"]!=0) && ($_GET["a"]=="delete")){
	
}

//DELETE USERS
if(isset($_GET["u"]) && ((int)$_GET["u"]!=0) && ($_GET["a"]=="delete")){
	//echo "Se quiere borrar el usuario ".clear($_GET["u"])."<br/>";
	$count = mysqli_fetch_array(DBSelect('igw_members', 'COUNT(*) as total', "",''));
	if($count["total"]<=1){
		//You can't delete me: "It's the final admin, tinoninoooo tinoninoniiii"
		header("Location: /administrators.php?sms=ERROR");
	}else{
		if(DBDelete('igw_members', "WHERE id = '".clear((int)$_GET["u"])."'")){
			if(DBDelete('igw_adm', "WHERE id_member = '".clear((int)$_GET["u"])."'")){
				header("Location: ./administrators.php?sms=OK"); 
			}else{
				header("Location: /administrators.php?sms=ERROR"); 
			} 
		}else{
			header("Location: /administrators.php?sms=ERROR"); 
		}
	}
	
}

}
?>