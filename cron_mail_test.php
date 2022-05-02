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
define(INCLUDE_CHECK,'true');
?>
<?php
include('igw_includes/config/dbc.php');
include('igw_includes/config/mail.config.php');
include('igw_includes/functions/functions.php');



	$principal='mailbackup';
	$ds = '/'; 
	foreach($correos_config as $correos){
		//echo '<pre>';print_r($correos);echo '</pre>';
		echo 'Descargando correo de <strong>'.$correos["user_mail"].'</strong><br>';
		$storeFolder = $principal.$ds.''.$correos["folder"].''; 
		if(!file_exists($storeFolder)){ mkdir($storeFolder); }
		$inbox = imap_open(''.$correos["imap_connect"].''.$correos["imap_folder"].'', $correos["user_mail"], $correos["password_mail"]) or die('Cannot connect: ' . imap_last_error());
		
		//echo '<pre>';print_r($inboxmails);echo '</pre>';
		$list = imap_list($inbox, ''.$correos["imap_connect"].'', "*");
		
		//remove  any } characters from the folder
		if (preg_match("/}/i", $list[0])) {
		    $arr = explode('}', $list[0]);
		}
		
		//also remove the ] if it exists, normally Gmail have them
		if (preg_match("/]/i", $list[0])) {
		    $arr = explode(']/', $list[0]);
		}
		
		//remove INBOX. from the folder name
		$folder = str_replace('INBOX.', '', stripslashes($arr[1]));
		
		//check if inbox is first folder if not reorder array
		if($folder !== 'INBOX'){
		    krsort($list);
		}
		echo '<pre>';print_r($list);echo '</pre>';
	
		$inboxmails = imap_search($inbox, ''.$correos["imap_search"].'');  //, SE_UID //SUBJECT "LA19S"
		$check = imap_mailboxmsginfo($inbox);
		echo "Mensajes antes de mover: " . $check->Nmsgs . "<br />\n";
		
		
		
		
	}


?>