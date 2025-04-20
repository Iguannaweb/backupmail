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
define('INCLUDE_CHECK','true'); if($debug=="1"){ ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); } include('igw_includes/login/session.php'); include('igw_includes/config/dbc.php'); include('igw_languages/'.$lang.'.php'); include('igw_includes/config/mail.config.php'); include('igw_includes/config/pag_config.php'); include('igw_includes/functions/functions.php'); include('igw_includes/login/login.php'); include('igw_includes/functions/paginator.class.php'); require_once './vendor/autoload.php'; $principal='mailbackup'; include('igw_includes/login/extra_parameters.php');if((int)$_SESSION['id']!=0){ echo '{ "respuesta":"OK"}'; }else{ echo '{ "respuesta":"KO"}'; } ?>