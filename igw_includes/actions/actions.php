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

if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){

	//TAG
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
		
		/*if($_GET["t"]!=""){
			$url.='&t='.$_GET["t"].'';
		}*/
	
		header('Location: index.php?1=1'.$url.'');
		die();
		
	}
	
	//ESPECIAL TAGS
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
		}
		elseif($_GET["a"]=="archivar"){
			foreach($mensajes as $m){
				if((int)$m !=0){
					$form_data[$i] = array(
						'ARCHIVE' => 1
					);
					DBUpdate('igw_emails', $form_data[$i],"WHERE UDATE='".$m."'");
				
				}
				
				$i++;
			}
		}
		elseif($_GET["a"]=="borrar"){
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
	
	//ADD STAR
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
	
	//DELETE STAR
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
	
	//UNARCHIVE
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
	
	//UNDELETE
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
	
	//DELETE TASK
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
?>