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
$db_host		= 'server_name'; //usually localhost
$db_user		= 'db_user';
$db_pass		= 'db_pass';
$db_database	= 'db_name';
$debug          = '0';

$link = mysqli_connect($db_host,$db_user,$db_pass,$db_database);
mysqli_set_charset($link, "utf8");
date_default_timezone_set('UTC');
?>