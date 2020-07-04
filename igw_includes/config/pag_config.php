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

$n_items=50;
if(isset($_GET["pag"]) && (!empty($_GET["pag"]))){
	$pag = (int)$_GET["pag"];
	$inicio = (($pag*$n_items)-$n_items);
	$final = ($pag*$n_items);
}else{
	$pag = 1;
	$inicio = 0;
	$final=$n_items;
}
?>