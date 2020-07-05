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
require_once './vendor/autoload.php';
if($_GET["tipo"]=="notes"){ $folder_tipo='_notes';}
elseif($_GET["tipo"]=="sent"){ $folder_tipo="_sents"; }
elseif($_GET["tipo"]=="draft"){ $folder_tipo="_drafts"; }
$path = './mailbackup'.$folder_tipo.'/'.$_GET["c"].'/'.(int)$_GET["y"].'/'.$_GET["m"].'/MSG_ID_'.(int)$_GET["id"].'.eml';
$parser = new PhpMimeMailParser\Parser();

// 1. Specify a file path (string)
$parser->setPath($path);


$text = $parser->getMessageBody('text');
// return the text version

$html = $parser->getMessageBody('html');
// return the html version

$htmlEmbedded = $parser->getMessageBody('htmlEmbedded');
// return the html version with the embedded contents like images

if($_GET["t"]=="htmlplus"){
	echo ''.$htmlEmbedded.'';
}elseif($_GET["t"]=="html"){
	echo ''.$html.'';
}elseif($_GET["t"]=="txt"){
	echo ''.nl2br($text).'';
}
?>