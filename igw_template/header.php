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
$debug="0";
if($debug=="1"){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}
include('igw_includes/login/session.php');
include('igw_includes/config/dbc.php');
include('igw_includes/config/mail.config.php');
include('igw_includes/config/pag_config.php');
include('igw_includes/functions/functions.php');
include('igw_includes/login/login.php');
include('igw_includes/functions/paginator.class.php');
require_once './vendor/autoload.php';

$principal='mailbackup';
include('igw_includes/login/extra_parameters.php');
if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){

//ETIQUETAR
if(($_GET["a"]=="tag") && ((int)$_GET["t"]!=0) && ($_GET["mails"]!="")){

	$mensajes = explode('|', $_GET["mails"]);
	$id_tag = (int)$_GET["t"];
	/*echo 'Se quieren tagear con la id '.$id_tag.' los mensajes:';
	echo '<pre>';print_r($mensajes);echo '</pre>';*/
	
	$i=0;
	foreach($mensajes as $m){
		if((int)$m !=0){
			$form_data[$i] = array(
			    'ID_MAIL' => $m,
			    'ID_TAG' => $id_tag
			);
			DBInsert('igw_emails_tags', $form_data[$i]);
		
		}
		
		$i++;
	}
	$url='';
	if($_GET["page"]!=""){
		$url.='&page='.$_GET["page"].'';
	}
	if($_GET["ipp"]!=""){
		$url.='&ipp='.$_GET["ipp"].'';
	}
	
	if($_GET["m"]!=""){
		$url.='&m='.$_GET["m"].'';
	}
	if($_GET["y"]!=""){
		$url.='&y='.$_GET["y"].'';
	}
	if($_GET["c"]!=""){
		$url.='&c='.$_GET["c"].'';
	}
	
	if($_GET["t"]!=""){
		$url.='&t='.$_GET["t"].'';
	}

	header('Location: index.php?1=1'.$url.'');
	die();
	
}

if((($_GET["a"]=="starb") || ($_GET["a"]=="tarea") || ($_GET["a"]=="borrar") || ($_GET["a"]=="archivar") || ($_GET["a"]=="spam")) && ($_GET["mails"]!="")){
	
	$mensajes = explode('|', $_GET["mails"]);
	if($_GET["a"]=="starb"){
		$id_tag = 1;
	}elseif($_GET["a"]=="tarea"){
		$id_tag = 3;
	}elseif($_GET["a"]=="spam"){
		$id_tag = 2;
	}
	
	/*echo 'Se quieren tagear con la id '.$id_tag.' los mensajes:';
	echo '<pre>';print_r($mensajes);echo '</pre>';*/
	
	$i=0;
	if(($_GET["a"]=="starb") || ($_GET["a"]=="tarea") || ($_GET["a"]=="spam")){
		foreach($mensajes as $m){
			if((int)$m !=0){
				$form_data[$i] = array(
				    'ID_MAIL' => $m,
				    'ID_TAG' => $id_tag
				);
				DBInsert('igw_emails_tags', $form_data[$i]);
			
			}
			
			$i++;
		}
	}elseif($_GET["a"]=="archivar"){
		foreach($mensajes as $m){
			if((int)$m !=0){
				$form_data[$i] = array(
				    'ARCHIVE' => 1
				);
				DBUpdate('igw_emails', $form_data[$i],"WHERE UDATE='".$m."'");
			
			}
			
			$i++;
		}
	}elseif($_GET["a"]=="borrar"){
		foreach($mensajes as $m){
			if((int)$m !=0){
				$form_data[$i] = array(
				    'DELETED' => 1
				);
				DBUpdate('igw_emails', $form_data[$i],"WHERE UDATE='".$m."'");
			
			}
			
			$i++;
		}
	}
		
	
	
	$url='';
	if($_GET["page"]!=""){
		$url.='&page='.$_GET["page"].'';
	}
	if($_GET["ipp"]!=""){
		$url.='&ipp='.$_GET["ipp"].'';
	}
	
	if($_GET["m"]!=""){
		$url.='&m='.$_GET["m"].'';
	}
	if($_GET["y"]!=""){
		$url.='&y='.$_GET["y"].'';
	}
	if($_GET["c"]!=""){
		$url.='&c='.$_GET["c"].'';
	}
	
	if($_GET["t"]!=""){
		$url.='&t='.$_GET["t"].'';
	}

	header('Location: index.php?1=1'.$url.'');
	die();
	
}

//PONER ESTRELLA
if(($_GET["a"]=="star") && ((int)$_GET["u"]!=0)){
	$id_tag = 1;
	/*echo 'Se quieren tagear con la id '.$id_tag.' los mensajes:';
	echo '<pre>';print_r($mensajes);echo '</pre>';*/
	
		if((int)$_GET["u"] !=0){
			$form_data[$i] = array(
			    'ID_MAIL' => clear((int)$_GET["u"]),
			    'ID_TAG' => $id_tag
			);
			DBInsert('igw_emails_tags', $form_data[$i]);
		
		}

	$url='';
	if($_GET["page"]!=""){
		$url.='&page='.$_GET["page"].'';
	}
	if($_GET["ipp"]!=""){
		$url.='&ipp='.$_GET["ipp"].'';
	}
	
	if($_GET["m"]!=""){
		$url.='&m='.$_GET["m"].'';
	}
	if($_GET["y"]!=""){
		$url.='&y='.$_GET["y"].'';
	}
	if($_GET["c"]!=""){
		$url.='&c='.$_GET["c"].'';
	}
	if($_GET["t"]!=""){
		$url.='&t='.$_GET["t"].'';
	}

	header('Location: index.php?1=1'.$url.'');
	die();
	
}

//QUITAR ESTRELLA
if(($_GET["a"]=="unstar") && ((int)$_GET["u"]!=0)){
		if((int)$_GET["u"]!=0){
			DBDelete('igw_emails_tags', "WHERE ID_MAIL='".clear((int)$_GET["u"])."' AND ID_TAG=1");
		}

	$url='';
	if($_GET["page"]!=""){
		$url.='&page='.$_GET["page"].'';
	}
	if($_GET["ipp"]!=""){
		$url.='&ipp='.$_GET["ipp"].'';
	}
	
	if($_GET["m"]!=""){
		$url.='&m='.$_GET["m"].'';
	}
	if($_GET["y"]!=""){
		$url.='&y='.$_GET["y"].'';
	}
	if($_GET["c"]!=""){
		$url.='&c='.$_GET["c"].'';
	}
	if($_GET["t"]!=""){
		$url.='&t='.$_GET["t"].'';
	}

	header('Location: index.php?1=1'.$url.'');
	die();
	
}

//QUITAR ARCHIVO
if(($_GET["a"]=="unarchive") && ((int)$_GET["u"]!=0)){
		if((int)$_GET["u"]!=0){
			$form_data[$i] = array(
			    'ARCHIVE' => 0
			);
			DBUpdate('igw_emails', $form_data[$i],"WHERE UDATE='".(int)$_GET["u"]."'");
		
		}

	$url='';
	if($_GET["page"]!=""){
		$url.='&page='.$_GET["page"].'';
	}
	if($_GET["ipp"]!=""){
		$url.='&ipp='.$_GET["ipp"].'';
	}
	
	if($_GET["m"]!=""){
		$url.='&m='.$_GET["m"].'';
	}
	if($_GET["y"]!=""){
		$url.='&y='.$_GET["y"].'';
	}
	if($_GET["c"]!=""){
		$url.='&c='.$_GET["c"].'';
	}
	if($_GET["t"]!=""){
		$url.='&t='.$_GET["t"].'';
	}
	
	header('Location: index.php?1=1'.$url.'');
	die();
	
}

//QUITAR DELETE
if(($_GET["a"]=="undelete") && ((int)$_GET["u"]!=0)){
		if((int)$_GET["u"]!=0){
			$form_data[$i] = array(
			    'DELETED' => 0
			);
			DBUpdate('igw_emails', $form_data[$i],"WHERE UDATE='".(int)$_GET["u"]."'");
		
		}

	$url='';
	if($_GET["page"]!=""){
		$url.='&page='.$_GET["page"].'';
	}
	if($_GET["ipp"]!=""){
		$url.='&ipp='.$_GET["ipp"].'';
	}
	
	if($_GET["m"]!=""){
		$url.='&m='.$_GET["m"].'';
	}
	if($_GET["y"]!=""){
		$url.='&y='.$_GET["y"].'';
	}
	if($_GET["c"]!=""){
		$url.='&c='.$_GET["c"].'';
	}
	
	if($_GET["t"]!=""){
		$url.='&t='.$_GET["t"].'';
	}

	header('Location: index.php?1=1'.$url.'');
	die();
	
}

//QUITAR TASK
if(($_GET["a"]=="untag") && ((int)$_GET["mail"]!=0) && ((int)$_GET["t"]!=0)){
		if((int)$_GET["mail"]!=0){
			DBDelete('igw_emails_tags', "WHERE ID_MAIL='".clear((int)$_GET["mail"])."' AND ID_TAG=".(int)$_GET["t"]."");
		}

	$url='';
	if($_GET["page"]!=""){
		$url.='&page='.$_GET["page"].'';
	}
	if($_GET["ipp"]!=""){
		$url.='&ipp='.$_GET["ipp"].'';
	}
	
	if($_GET["m"]!=""){
		$url.='&m='.$_GET["m"].'';
	}
	if($_GET["y"]!=""){
		$url.='&y='.$_GET["y"].'';
	}
	if($_GET["c"]!=""){
		$url.='&c='.$_GET["c"].'';
	}
	if($_GET["t"]!=""){
		$url.='&t='.$_GET["t"].'';
	}

	header('Location: index.php?1=1'.$url.'');
	die();
	
}


}
include('igw_includes/actions/delete.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  
  <title>BackupMail by IguannaWeb</title>
  
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
        <a class="nav-link-logo" href="index.php" role="button"><img src="igw_template/assets/img/backupmail.png" alt="backupmail" height="30" ></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="administrators.php" class="nav-link"><i class="fa fa-users"></i> Users</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="configuration.php" class="nav-link"><i class="fa fa-envelope"></i> Accounts</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a target="_blank" href="cron_mail.php" class="nav-link"><i class="fas fa-tasks"></i> Cron</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="tags.php" class="nav-link"><i class="fas fa-tag"></i> Tags</a>
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
      <?php /* <!-- Messages Dropdown Menu -->
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
      <li class="nav-item">
        <a class="nav-link" target="_blank" title="Docs in github pages ;)" href="https://iguannaweb.github.io/backupmail/" role="button"><i class="fas fa-book"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?logoff" role="button"><i class="fas fa-sign-out-alt"></i></a>
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