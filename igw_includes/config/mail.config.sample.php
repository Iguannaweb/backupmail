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
$correonotificacion="your_mail@notification.com";
$ClientID="XXXXXX";
$ClientSecret="XXXXXX";
$apikey="XXXXXX";

$correos_config=array(
	array(
		'folder' => 'folder_name',
		'user_mail' => 'your_mail',
		'password_mail' => 'your_pass',
		'imap_connect' => '{imap.server.com:993/imap/ssl/novalidate-cert}',
		'imap_folder' => 'Imap_inbox_folder',
		'imap_folder_archive' => 'Imap_archive_folder',
		'imap_search' => 'Imap_parameter_to_search',
		'imap_notes' => 'Imap_notes_folder',
		'imap_sent' => 'Imap_sent_folder',
		'imap_draft' => 'Imap_drafts_folder',
		'imap_trash' => 'Imap_trash_folder',
		'imap_spam' => 'Imap_spam_folder',
		'oauth_token' => 'save_here_your_temp_oauth_accessToken'
	)
);
?>