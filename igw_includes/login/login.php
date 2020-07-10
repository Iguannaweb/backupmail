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

/*COMPROBAMOS COOKIE RECORDAR*/
if(isset($_SESSION['id']) && !isset($_COOKIE['tzRemember']) && ($_COOKIE['tzRemember']!=1)){ // && !$_SESSION['rememberMe']	
	$_SESSION = array();
	session_destroy();
}

/*QUEREMOS SALIR DEL SISTEMA*/
if(isset($_GET['logoff'])){
	
		/*QUEREMOS SALIR DEL SISTEMA*/
		if (isset($_SERVER['HTTP_COOKIE'])) {
		    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		    foreach($cookies as $cookie) {
		        $parts = explode('=', $cookie);
		        $name = trim($parts[0]);
		        if($name=="tzDispositivo"){}else{
		        setcookie($name, '', time()-1000);
		        setcookie($name, '', time()-1000, '/');
		        }
		    }
		}
		
		if(isset($_COOKIE[session_name()])):
	        setcookie(session_name(), '', time()-7000000, '/');
	    endif;
	

	$_SESSION = array();
	session_destroy();
	header("Location: index.php");
	exit;
}

/*QUEREMOS ENTRAR AL SISTEMA*/
if(isset($_POST['submit']) && ($_POST['action']=='Login')){
	
	$err = array();
	//Comprobamos que tenga usuario de telegram e id_chat
	$prerow = mysqli_fetch_assoc(mysqli_query($link,"SELECT id,usr, tipo, activo,pass FROM igw_members WHERE usr='".clear($_POST['username'])."'"));

	if(password_verify(clear($_POST['password']),$prerow["pass"])){
		$passverificado=true;
	}else{
		$passverificado=false;
	}
	
		
	if(!$_POST['username'] || !$_POST['password']) { $err[] = 'Debes rellenar todos los campos!'; }
	
	if(!count($err)){
		// Escaping all input data
		$_POST['username'] = mysqli_real_escape_string($link,$_POST['username']);
		$_POST['password'] = mysqli_real_escape_string($link,$_POST['password']);
		$_POST['rememberMe'] = (int)$_POST['rememberMe'];
		
		$row = mysqli_fetch_assoc(mysqli_query($link,"SELECT id,usr, tipo, activo,pass FROM igw_members WHERE usr='".clear($_POST['username'])."'"));
		
		
		if($row['usr'] && password_verify(clear($_POST['password']),$row["pass"])){
			// If everything is OK login
			$_SESSION['usr']=$row['usr'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['tipo'] = $row['tipo'];
			//$_SESSION['activo'] = $row['activo'];
			$_SESSION['rememberMe'] = $_POST['rememberMe'];

			// Store some data in the session
			setcookie('tzRemember',$_POST['rememberMe'], strtotime( '+30 days' ));
			
		}
		else { $err[]='Sorry, wrong username/password<br />'; }
			
			
	}
	
	if($err){ $_SESSION['msg']['login-err'] = implode('<br />',$err); }		

	header("Location: ./index.php");
	exit;
	
	
}

?>