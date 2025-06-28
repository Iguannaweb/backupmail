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
$cron_key="XXXXX";
$base_url="https://XXXX";

//WIP - It's better use APP Passwords with gmail accounts https://myaccount.google.com/apppasswords
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
		'oauth_token' => '1/0', //keep it in 0
		'imap_extra_folders' => array('folder_1','folder_2','folder_3'),
        'archive_mail' => '1/0'
        )
);

// Display external images inside emails. Set to '1' to allow downloading
// remote images or '0' to block them for privacy reasons.
$display_remote_images = '0';

// Array of allowed remote image base URLs. Leave empty to block all
// external images when $display_remote_images is '0'.
$allowed_image_urls = array();
?>