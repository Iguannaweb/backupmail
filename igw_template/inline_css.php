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
<style>
	.jstree-default a { 
	    white-space:normal !important; height: auto; 
	}
	.jstree-anchor {
	    height: auto !important;
	}
	.jstree-default li > ins { 
	    vertical-align:top; 
	}
	.jstree-leaf {
	    height: auto;
	}
	.jstree-leaf a{
	    height: auto !important;
	}
	.inbox .list-email>li.list-group-item .email-title {
	    width: 400px;
	    text-overflow: inherit; 
	}
	.inbox .list-email>li.list-group-item .email-time { background: transparent !important; }
</style>