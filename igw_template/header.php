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
//INFO: TRANSLATED EN
?>
<?php
if($debug=="1"){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}
include('igw_includes/login/session.php');
include('igw_includes/config/dbc.php');
include('igw_languages/'.$lang.'.php');
include('igw_includes/config/mail.config.php');
include('igw_includes/config/pag_config.php');
include('igw_includes/functions/functions.php');
include('igw_includes/login/login.php');
include('igw_includes/functions/paginator.class.php');
require_once './vendor/autoload.php';

$principal='mailbackup';
include('igw_includes/login/extra_parameters.php');
include('igw_includes/actions/actions.php');
include('igw_includes/actions/delete.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  
  <title><?php echo $lang_index_title; ?></title>
  
  <!-- favicon -->
  <link rel="shortcut icon" type="image/png" href="igw_template/assets/img/favicon.png"/>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
  <!-- Custom styles -->
  <link rel="stylesheet" href="igw_template/assets/css/custom.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Alets -->
  <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/toastr/toastr.min.css">
  <!-- JS tree -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/themes/default/style.min.css" />
  <?php include('./igw_template/inline_css.php'); ?>
</head>
<?php
if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){
?>
<body class="hold-transition sidebar-mini  accent-navy  text-sm">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link-logo" href="index.php" title="<?php echo $lang_index_title_logo; ?>" role="button"><img src="igw_template/assets/img/backupmail.png" alt="<?php echo $lang_index_alt_logo; ?>" height="30" ></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="administrators.php" class="nav-link" title="<?php echo $lang_index_menu_user_title; ?>"><i class="fa fa-users"></i> <?php echo $lang_index_menu_user; ?></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="configuration.php" class="nav-link" title="<?php echo $lang_index_menu_account_title; ?>"><i class="fa fa-envelope"></i> <?php echo $lang_index_menu_account; ?></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a target="_blank" href="cron_mail.php" class="nav-link" title="<?php echo $lang_index_menu_cron_title; ?>"><i class="fas fa-tasks"></i> <?php echo $lang_index_menu_cron; ?></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="tags.php" class="nav-link" title="<?php echo $lang_index_menu_tag_title; ?>"><i class="fas fa-tag"></i> <?php echo $lang_index_menu_tag; ?></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="stats.php" class="nav-link" title="<?php echo $lang_index_menu_stat_title; ?>"><i class="fas fa-chart-bar"></i> <?php echo $lang_index_menu_stat; ?></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
	
      <?php 
	  //TODO: EMAILS NOTIFICATIONS
	  /* <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-envelope"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="vendor/almasaeed2010/adminlte/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="vendor/almasaeed2010/adminlte/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="vendor/almasaeed2010/adminlte/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
	  //TODO: EMAIL STATS
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-chart-bar"></i>
          <!-- span class="badge badge-warning navbar-badge">15</span -->
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">Your stats</span>
          
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> Accounts
            <?php $accounts = mysqli_num_rows(DBSelect('igw_emails', '*', "",'GROUP BY MAIL','')); ?>
            <span class="float-right text-muted text-sm"><?php echo $accounts; ?></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> Mails saved
            <?php $mails = mysqli_num_rows(DBSelect('igw_emails', '*', "",'','')); ?>
            <span class="float-right text-muted text-sm"><?php echo $mails; ?></span>
          </a>
          <!-- div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-attachment mr-2"></i> Attachments
            <span class="float-right text-muted text-sm">4</span>
          </a -->
          <!--div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a -->
        </div>
      </li> */ ?>
	  <li class="nav-item d-block d-sm-none">
		  <a href="administrators.php" class="nav-link"><i class="fa fa-users"></i></a>
		</li>
		<li class="nav-item d-block d-sm-none">
		  <a href="configuration.php" class="nav-link"><i class="fa fa-envelope"></i></a>
		</li>
		<li class="nav-item d-block d-sm-none">
		  <a target="_blank" href="cron_mail.php" class="nav-link"><i class="fas fa-tasks"></i></a>
		</li>
		<li class="nav-item d-block d-sm-none">
		  <a href="tags.php" class="nav-link"><i class="fas fa-tag"></i></a>
		</li>
      <li class="nav-item d-none d-sm-block">
        <a class="nav-link" target="_blank" title="<?php echo $lang_index_menu_doc_title; ?>" href="https://iguannaweb.github.io/backupmail/" role="button"><i class="fas fa-book"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?logoff" title="<?php echo $lang_index_menu_logoff_title; ?>" role="button"><i class="fas fa-sign-out-alt"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <?php
	 }else{
		 echo '<body class="hold-transition login-page">';
	 }
	
?> 