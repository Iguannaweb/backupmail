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
define('INCLUDE_CHECK','true');

//TODO: Show trash label
//ERR: Prevent add duplicate tags
include('./igw_template/header.php'); 

if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){
	//NEW: PAGE HEADER
	$page_name=$lang_index_page_name;
	$parent_page_name=$lang_index_parent_page_name;
	$page_name_short=$lang_index_page_name_short;
	$parent_page_link='./index.php';
	include('./igw_template/page-header.php'); 
	?>	  
    	<!-- Main content -->
    	<section class="content">
        <!-- Row -->
      	<div class="row">
			<?php include('./igw_template/sidebar.php'); ?>
        	<?php include('./igw_includes/actions/list_mails.php'); ?>
			<?php include('./igw_includes/actions/read_mail.php'); ?>		
      	</div>
      	<!-- /.row -->
    	</section>
    	<!-- /.content -->
	<?php
}else{
	//LOGIN
	include('./igw_template/login_form.php');
}
//FOOTER
include('./igw_template/footer.php'); 
?>