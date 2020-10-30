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
include('igw_includes/config/dbc.php');
include('igw_includes/config/mail.config.php');
include('igw_includes/functions/functions.php');


if($_GET["tipo"]=="DRAFT"){
	$principal='mailbackup_drafts';
	$ds = '/'; 
	foreach($correos_config as $correos){
		if($correos["imap_draft"]!=""){
			$carpetas_sent=explode(',',$correos["imap_draft"]);
			foreach($carpetas_sent as $c_s){
				//echo '<pre>';print_r($correos);echo '</pre>';
				echo 'Descargando correo de <strong>'.$correos["user_mail"].'</strong><br>';
				$storeFolder = $principal.$ds.''.$correos["folder"].''; 
				if(!file_exists($storeFolder)){ mkdir($storeFolder); }
				$inbox = imap_open(''.$correos["imap_connect"].''.$c_s.'', $correos["user_mail"], $correos["password_mail"]) or die('Cannot connect: ' . imap_last_error());
				
				//echo '<pre>';print_r($inboxmails);echo '</pre>';
				$list = imap_list($inbox, ''.$correos["imap_connect"].'', "*");
				
				//remove  any } characters from the folder
				if (preg_match("/}/i", $list[0])) {
				    $arr = explode('}', $list[0]);
				}
				
				//also remove the ] if it exists, normally Gmail have them
				if (preg_match("/]/i", $list[0])) {
				    $arr = explode(']/', $list[0]);
				}
				
				//remove INBOX. from the folder name
				$folder = str_replace('INBOX.', '', stripslashes($arr[1]));
				
				//check if inbox is first folder if not reorder array
				if($folder !== 'INBOX'){
				    krsort($list);
				}
				echo '<pre>';print_r($list);echo '</pre>';
			
				$inboxmails = imap_search($inbox, ''.$correos["imap_search"].'');  //, SE_UID //SUBJECT "LA19S"
				$check = imap_mailboxmsginfo($inbox);
				echo "Mensajes antes de mover: " . $check->Nmsgs . "<br />\n";
				
				if($inboxmails) {
					$output = '';
					
					rsort($inboxmails);
					$i=0;
				
					foreach($inboxmails as $email_number) {
						
						 $overview = imap_fetch_overview($inbox,$email_number,0);
						 $headers = imap_fetchheader($inbox, $email_number, FT_PREFETCHTEXT);
						 $body = imap_body($inbox, $email_number);
				
							$randomstr[$i]=generateRandomString();
							$randomstr2[$i]=generateRandomString();
							$randomstr3[$i]=generateRandomString();
							$randomstr4[$i]=generateRandomString();
							$targetPathD = '.'. $ds. $storeFolder . $ds; 
				
							echo $targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml<br>';
							if(!file_exists($targetPathD.date('Y',$overview[0]->udate))){
								mkdir($targetPathD.date('Y',$overview[0]->udate));
							}
							
							if(!file_exists($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate))){
								mkdir($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate));
							}
							
							if(file_exists($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml')){
								//imap_mail_move($inbox,$email_number,''.$c_s.'');
							}else{
								if(file_put_contents($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml', $headers . "\n" . $body)){
				
									$form_data_m[$i] = array(
									    'MAIL' => clear($correos["user_mail"]),
									    'UID' => clear(imap_uid($inbox, $email_number)),
									    'FILE' => $targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml',
									    'MESSAGE_ID' => clear($overview[0]->message_id),
									    'UDATE' => clear($overview[0]->udate),
									    'SUBJECT' => clear(''.$overview[0]->subject.''),
									    'FOLDER' => clear('DRAFT')
										);
									if(DBInsert('igw_emails', $form_data_m[$i])){
										//imap_mail_move($inbox,$email_number,''.$c_s.'');
									}
										
								}
							
							}
						 
						
						 $i++;
					}
					
					imap_expunge($inbox);
					
				
					$check = imap_mailboxmsginfo($inbox);
					echo "Mensajes despu&eacute;s de mover: " . $check->Nmsgs . "<br />\n";
					
					imap_close($inbox);
					
				}
				imap_close($inbox);
				
			}
		}
	}

}
elseif($_GET["tipo"]=="SENT"){
	$principal='mailbackup_sents';
	$ds = '/'; 
	foreach($correos_config as $correos){
		if($correos["imap_sent"]!=""){
			$carpetas_sent=explode(',',$correos["imap_sent"]);
			foreach($carpetas_sent as $c_s){
				//echo '<pre>';print_r($correos);echo '</pre>';
				echo 'Descargando correo de <strong>'.$correos["user_mail"].'</strong><br>';
				$storeFolder = $principal.$ds.''.$correos["folder"].''; 
				if(!file_exists($storeFolder)){ mkdir($storeFolder); }
				$inbox = imap_open(''.$correos["imap_connect"].''.$c_s.'', $correos["user_mail"], $correos["password_mail"]) or die('Cannot connect: ' . imap_last_error());
				
				//echo '<pre>';print_r($inboxmails);echo '</pre>';
				$list = imap_list($inbox, ''.$correos["imap_connect"].'', "*");
				
				//remove  any } characters from the folder
				if (preg_match("/}/i", $list[0])) {
				    $arr = explode('}', $list[0]);
				}
				
				//also remove the ] if it exists, normally Gmail have them
				if (preg_match("/]/i", $list[0])) {
				    $arr = explode(']/', $list[0]);
				}
				
				//remove INBOX. from the folder name
				$folder = str_replace('INBOX.', '', stripslashes($arr[1]));
				
				//check if inbox is first folder if not reorder array
				if($folder !== 'INBOX'){
				    krsort($list);
				}
				echo '<pre>';print_r($list);echo '</pre>';
			
				$inboxmails = imap_search($inbox, ''.$correos["imap_search"].'');  //, SE_UID //SUBJECT "LA19S"
				$check = imap_mailboxmsginfo($inbox);
				echo "Mensajes antes de mover: " . $check->Nmsgs . "<br />\n";
				
				if($inboxmails) {
					$output = '';
					
					rsort($inboxmails);
					$i=0;
				
					foreach($inboxmails as $email_number) {
						
						 $overview = imap_fetch_overview($inbox,$email_number,0);
						 $headers = imap_fetchheader($inbox, $email_number, FT_PREFETCHTEXT);
						 $body = imap_body($inbox, $email_number);
				
							$randomstr[$i]=generateRandomString();
							$randomstr2[$i]=generateRandomString();
							$randomstr3[$i]=generateRandomString();
							$randomstr4[$i]=generateRandomString();
							$targetPathD = '.'. $ds. $storeFolder . $ds; 
				
							echo $targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml<br>';
							if(!file_exists($targetPathD.date('Y',$overview[0]->udate))){
								mkdir($targetPathD.date('Y',$overview[0]->udate));
							}
							
							if(!file_exists($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate))){
								mkdir($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate));
							}
							
							if(file_exists($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml')){
								//imap_mail_move($inbox,$email_number,''.$c_s.'');
							}else{
								if(file_put_contents($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml', $headers . "\n" . $body)){
				
									$form_data_m[$i] = array(
									    'MAIL' => clear($correos["user_mail"]),
									    'UID' => clear(imap_uid($inbox, $email_number)),
									    'FILE' => $targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml',
									    'MESSAGE_ID' => clear($overview[0]->message_id),
									    'UDATE' => clear($overview[0]->udate),
									    'SUBJECT' => clear(''.$overview[0]->subject.''),
									    'FOLDER' => clear('SENT')
										);
									if(DBInsert('igw_emails', $form_data_m[$i])){
										//imap_mail_move($inbox,$email_number,''.$c_s.'');
									}
										
								}
							
							}
						 
						
						 $i++;
					}
					
					imap_expunge($inbox);
					
				
					$check = imap_mailboxmsginfo($inbox);
					echo "Mensajes despu&eacute;s de mover: " . $check->Nmsgs . "<br />\n";
					
					imap_close($inbox);
					
				}
				imap_close($inbox);
				
			}
		}
	}

}
elseif($_GET["tipo"]=="NOTES"){
	$principal='mailbackup_notes';
	$ds = '/'; 
	foreach($correos_config as $correos){
		if($correos["imap_notes"]!=""){
			//echo '<pre>';print_r($correos);echo '</pre>';
			echo 'Descargando correo de <strong>'.$correos["user_mail"].'</strong><br>';
			$storeFolder = $principal.$ds.''.$correos["folder"].''; 
			if(!file_exists($storeFolder)){ mkdir($storeFolder); }
			$inbox = imap_open(''.$correos["imap_connect"].''.$correos["imap_notes"].'', $correos["user_mail"], $correos["password_mail"]) or die('Cannot connect: ' . imap_last_error());
			
			//echo '<pre>';print_r($inboxmails);echo '</pre>';
			$list = imap_list($inbox, ''.$correos["imap_connect"].'', "*");
			
			//remove  any } characters from the folder
			if (preg_match("/}/i", $list[0])) {
			    $arr = explode('}', $list[0]);
			}
			
			//also remove the ] if it exists, normally Gmail have them
			if (preg_match("/]/i", $list[0])) {
			    $arr = explode(']/', $list[0]);
			}
			
			//remove INBOX. from the folder name
			$folder = str_replace('INBOX.', '', stripslashes($arr[1]));
			
			//check if inbox is first folder if not reorder array
			if($folder !== 'INBOX'){
			    krsort($list);
			}
			echo '<pre>';print_r($list);echo '</pre>';
		
			$inboxmails = imap_search($inbox, ''.$correos["imap_search"].'');  //, SE_UID //SUBJECT "LA19S"
			$check = imap_mailboxmsginfo($inbox);
			echo "Mensajes antes de mover: " . $check->Nmsgs . "<br />\n";
			
			if($inboxmails) {
				$output = '';
				
				rsort($inboxmails);
				$i=0;
			
				foreach($inboxmails as $email_number) {
					
					 $overview = imap_fetch_overview($inbox,$email_number,0);
					 $headers = imap_fetchheader($inbox, $email_number, FT_PREFETCHTEXT);
					 $body = imap_body($inbox, $email_number);
			
						$randomstr[$i]=generateRandomString();
						$randomstr2[$i]=generateRandomString();
						$randomstr3[$i]=generateRandomString();
						$randomstr4[$i]=generateRandomString();
						$targetPathD = '.'. $ds. $storeFolder . $ds; 
			
						echo $targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml<br>';
						if(!file_exists($targetPathD.date('Y',$overview[0]->udate))){
							mkdir($targetPathD.date('Y',$overview[0]->udate));
						}
						
						if(!file_exists($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate))){
							mkdir($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate));
						}
						
						if(file_exists($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml')){
							//imap_mail_move($inbox,$email_number,''.$correos["imap_notes"].'');
						}else{
							if(file_put_contents($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml', $headers . "\n" . $body)){
			
								$form_data_m[$i] = array(
								    'MAIL' => clear($correos["user_mail"]),
								    'UID' => clear(imap_uid($inbox, $email_number)),
								    'FILE' => $targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml',
								    'MESSAGE_ID' => clear($overview[0]->message_id),
								    'UDATE' => clear($overview[0]->udate),
								    'SUBJECT' => clear(''.$overview[0]->subject.''),
								    'FOLDER' => clear('NOTES')
									);
								if(DBInsert('igw_emails', $form_data_m[$i])){
									//imap_mail_move($inbox,$email_number,''.$correos["imap_notes"].'');
								}
									
							}
						
						}
					 
					
					 $i++;
				}
				
				imap_expunge($inbox);
				
			
				$check = imap_mailboxmsginfo($inbox);
				echo "Mensajes despu&eacute;s de mover: " . $check->Nmsgs . "<br />\n";
				
				imap_close($inbox);
				
			}
			imap_close($inbox);
		
		}
	}

}
else{
	$principal='mailbackup';
	$ds = '/'; 
	foreach($correos_config as $correos){
		//echo '<pre>';print_r($correos);echo '</pre>';
		echo 'Descargando correo de <strong>'.$correos["user_mail"].'</strong><br>';
		$storeFolder = $principal.$ds.''.$correos["folder"].''; 
		if(!file_exists($storeFolder)){ mkdir($storeFolder); }
		$inbox = imap_open(''.$correos["imap_connect"].''.$correos["imap_folder"].'', $correos["user_mail"], $correos["password_mail"]) or die('Cannot connect: ' . imap_last_error());
		
		//echo '<pre>';print_r($inboxmails);echo '</pre>';
		$list = imap_list($inbox, ''.$correos["imap_connect"].'', "*");
		
		//remove  any } characters from the folder
		if (preg_match("/}/i", $list[0])) {
		    $arr = explode('}', $list[0]);
		}
		
		//also remove the ] if it exists, normally Gmail have them
		if (preg_match("/]/i", $list[0])) {
		    $arr = explode(']/', $list[0]);
		}
		
		//remove INBOX. from the folder name
		$folder = str_replace('INBOX.', '', stripslashes($arr[1]));
		
		//check if inbox is first folder if not reorder array
		if($folder !== 'INBOX'){
		    krsort($list);
		}
		//echo '<pre>';print_r($list);echo '</pre>';
	
		$inboxmails = imap_search($inbox, ''.$correos["imap_search"].'');  //, SE_UID //SUBJECT "LA19S"
		$check = imap_mailboxmsginfo($inbox);
		echo "Mensajes antes de mover: " . $check->Nmsgs . "<br />\n";
		
		if($inboxmails) {
			$output = '';
			
			rsort($inboxmails);
			$i=0;
		
			foreach($inboxmails as $email_number) {
				
				 $overview = imap_fetch_overview($inbox,$email_number,0);
				 $headers = imap_fetchheader($inbox, $email_number, FT_PREFETCHTEXT);
				 $body = imap_body($inbox, $email_number,FT_PEEK);
		
					$randomstr[$i]=generateRandomString();
					$randomstr2[$i]=generateRandomString();
					$randomstr3[$i]=generateRandomString();
					$randomstr4[$i]=generateRandomString();
					$targetPathD = '.'. $ds. $storeFolder . $ds; 
		
					echo $targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml';
					if(!file_exists($targetPathD.date('Y',$overview[0]->udate))){
						mkdir($targetPathD.date('Y',$overview[0]->udate));
					}
					
					if(!file_exists($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate))){
						mkdir($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate));
					}
					
					if(file_exists($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml')){
						imap_mail_move($inbox,$email_number,''.$correos["imap_folder_archive"].'');
					}else{
						if(file_put_contents($targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml', $headers . "\n" . $body)){
		
							$form_data_m[$i] = array(
							    'MAIL' => clear($correos["user_mail"]),
							    'UID' => clear(imap_uid($inbox, $email_number)),
							    'FILE' => $targetPathD.date('Y',$overview[0]->udate). $ds.date('m',$overview[0]->udate). $ds.'MSG_ID_'.$overview[0]->udate.'.eml',
							    'MESSAGE_ID' => clear($overview[0]->message_id),
							    'UDATE' => clear($overview[0]->udate),
							    'SUBJECT' => clear(''.$overview[0]->subject.''),
							    'FOLDER' => clear('INBOX')
								);
							if(DBInsert('igw_emails', $form_data_m[$i])){
								echo ' - Creado registro';
								imap_mail_move($inbox,$email_number,''.$correos["imap_folder_archive"].'');
							}
								
						}
					
					}
					echo '<br>';
				
				 $i++;
			}
			
			imap_expunge($inbox);
			
		
			$check = imap_mailboxmsginfo($inbox);
			echo "Mensajes despu&eacute;s de mover: " . $check->Nmsgs . "<br />\n";
			
			imap_close($inbox);
			
		}
		imap_close($inbox);
		
		
	}

}
?>