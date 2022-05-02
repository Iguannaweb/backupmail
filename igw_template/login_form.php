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
<div class="login-box">
  <div class="login-logo">
	<a href="./index.php"><img src="./igw_template/assets/img/backupmail.png" alt="BackupMail" height="50" /></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
	<div class="card-body login-card-body">
	  <p class="login-box-msg">Sign in to see your mails saved</p>
	  
	  <?php
		  if(isset($_SESSION['msg']['login-err']) && !empty($_SESSION['msg']['login-err']))
		{
			echo '<div class="alert alert-danger fade show">'.$_SESSION['msg']['login-err'].'</div> ';
			unset($_SESSION['msg']['login-err']);
		}
		
	  ?>
	  <form action="" method="post">
		  <input type="hidden" name="action" value="Login"/>
		<div class="input-group mb-3">
		  <input type="text" class="form-control" id="username" placeholder="Username" name="username" required="required">
		  <div class="input-group-append">
			<div class="input-group-text">
			  <span class="fas fa-user"></span>
			</div>
		  </div>
		</div>
		<div class="input-group mb-3">
		  <input type="password" class="form-control" id="password"  name="password" required="required" placeholder="Password">
		  <div class="input-group-append">
			<div class="input-group-text">
			  <span class="fas fa-lock"></span>
			</div>
		  </div>
		</div>
		<div class="row">
		  <div class="col-8">
			<div class="icheck-primary">
			  <input type="checkbox" name="rememberMe" id="rememberMe" value="1">
			  <label for="remember">
				Remember Me
			  </label>
			</div>
		  </div>
		  <!-- /.col -->
		  <div class="col-4">
			<button type="submit" name="submit" class="btn btn-secondary btn-block">Sign In</button>
		  </div>
		  <!-- /.col -->
		  
		</div>
		<hr class="separator"/>
		<p class="text-center text-secondary mb-0">
			&copy; <?php echo date('Y'); ?> <a target="_blank" href="https://github.com/Iguannaweb/backupmail" title="" rel="nofollow" class="text-secondary">BackupMail by IguannaWeb</a>
		</p>
	  </form>

	  

	  <!-- p class="mb-1">
		<a href="forgot-password.html">I forgot my password</a>
	  </p -->
	</div>
	<!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->