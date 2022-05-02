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
include('./igw_template/header.php'); ?>
<?php if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){ ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Accounts configurations</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Config</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
	<strong>File config:</strong> ./igw_includes/config/mail.config.php<br>
	<pre>
	array(
		'folder' => 'folder_name', //folder where the files will be save
		'user_mail' => 'your_mail', //Email user
		'password_mail' => 'your_pass', //Email password
		'imap_connect' => '{imap.server.com:993/imap/ssl/novalidate-cert}', //Imap parametters this works for gmail
		'imap_folder' => 'Imap_inbox_folder', //IMAP folder to check INBOX?
		'imap_folder_archive' => 'Imap_archive_folder', //IMAP folder to archive
		'imap_search' => 'Imap_parameter_to_search', //IMAP parameter to search
		'imap_notes' => 'Imap_notes_folder', //folder to save notes
		'imap_sent' => 'Imap_sent_folder', //Folder to save sents emails
		'imap_draft' => 'Imap_drafts_folder', //Folder to save drafts
	)
	</pre>
	</section>
    <!-- /.content -->
  </div>			
			
							
<?php } ?>			
<?php include('./igw_template/footer.php'); ?>