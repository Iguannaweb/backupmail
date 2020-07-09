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
?>
<?php
	//GET SOME DATA IF SESSION ID
	if(isset($_SESSION['id']) && ($_SESSION['id']!="")){
	   $activo = mysqli_fetch_assoc(mysqli_query($link,"SELECT usr,email,tipo,activo FROM igw_members WHERE id='{$_SESSION['id']}'"));
	}
?>