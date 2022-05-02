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
												
if(isset($_GET["c"]) && ($_GET["c"]!='') && isset($_GET["y"]) && ((int)$_GET["y"]!=0) && isset($_GET["m"]) && ((int)$_GET["m"]!=0) && isset($_GET["id"]) && ((int)$_GET["id"]!=0)){
?>		
	 <div class="col-md-9">
	  <div class="card card-primary card-outline">
		<div class="card-header">
		  <h3 class="card-title">Reading mail </h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body p-0">
		   <?php
			   if($_GET["tipo"]=="notes"){ $folder_tipo='_notes';}
			elseif($_GET["tipo"]=="sent"){ $folder_tipo="_sents"; }
			elseif($_GET["tipo"]=="draft"){ $folder_tipo="_drafts"; }
				$path = './mailbackup'.$folder_tipo.'/'.$_GET["c"].'/'.$_GET["y"].'/'.$_GET["m"].'/MSG_ID_'.$_GET["id"].'.eml';
				$parser = new PhpMimeMailParser\Parser();
				$parser->setPath($path);
				
				
				$to = $parser->getHeader('to');
				$to_address = $parser->getAddresses('to');
				$delivered_to = $parser->getHeader('delivered-to');
				$from = $parser->getHeader('from');
				$from_address = $parser->getAddresses('from');
				$subject = $parser->getHeader('subject');
				$text = $parser->getMessageBody('text');
				$html = $parser->getMessageBody('html');
				$htmlEmbedded = $parser->getMessageBody('htmlEmbedded');

				$attachments = $parser->getAttachments();

		   
		   ?>
		  <div class="mailbox-read-info">
			<a href="javascript:;" class="float-left">
			<img class="media-object rounded-corner" alt="" src="<?php echo ''.get_gravatar($from_address[0]["address"]).''; ?>" />
			</a>
			<h5><?php echo ''.iconv_mime_decode($subject,0, "UTF-8").''; ?></h5>
			<h6><strong>To:</strong> <?php echo ''.$to.' '.$to_address[0]["address"].''; ?><br>
			<strong>From:</strong> <?php echo ''.$from.' '.$from_address[0]["address"].''; ?>
			  <span class="mailbox-read-time float-right"><i class="fa fa-clock fa-fw"></i> <?php echo ''.date('d/m/Y H:i:s',$_GET["id"]).''; ?></span></h6>
		  </div>
		  <!-- /.mailbox-read-info -->
		  <!-- div class="mailbox-controls with-border text-center">
			<div class="btn-group">
			  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
				<i class="far fa-trash-alt"></i></button>
			  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
				<i class="fas fa-reply"></i></button>
			  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">
				<i class="fas fa-share"></i></button>
			</div>
			<button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
			  <i class="fas fa-print"></i></button>
		  </div -->
		  <!-- /.mailbox-controls -->
		  <div class="mailbox-read-message">
			<?php
						
					if(!file_exists('./mailbackup'.$folder_tipo.'/'.$_GET["c"].'/'.$_GET["y"].'/'.$_GET["m"].'/MSG_ID_'.$_GET["id"].'/')){
						mkdir('./mailbackup'.$folder_tipo.'/'.$_GET["c"].'/'.$_GET["y"].'/'.$_GET["m"].'/MSG_ID_'.$_GET["id"].'/');
					}
					$save_dir = './mailbackup'.$folder_tipo.'/'.$_GET["c"].'/'.$_GET["y"].'/'.$_GET["m"].'/MSG_ID_'.$_GET["id"].'/'; 
					$j=1;
					
					
						
					if($htmlEmbedded!=""){
					echo '<hr><iframe src="./mail_reader.php?tipo='.$_GET["tipo"].'&c='.$_GET["c"].'&y='.$_GET["y"].'&m='.$_GET["m"].'&id='.$_GET["id"].'&t=htmlplus" style="border:0px #ffffff none;" name="myiFrame" scrolling="yes" frameborder="0" marginheight="0px" marginwidth="0px" height="400px" width="100%" allowfullscreen></iframe><br>';
					}elseif($html!=""){
					echo '<hr><iframe src="./mail_reader.php?tipo='.$_GET["tipo"].'&c='.$_GET["c"].'&y='.$_GET["y"].'&m='.$_GET["m"].'&id='.$_GET["id"].'&t=html" style="border:0px #ffffff none;" name="myiFrame" scrolling="yes" frameborder="0" marginheight="0px" marginwidth="0px" height="400px" width="100%" allowfullscreen></iframe><br>';
					}else{
					echo '<hr><strong>Mensaje TEXTO:</strong><br><iframe src="./mail_reader.php?tipo='.$_GET["tipo"].'&c='.$_GET["c"].'&y='.$_GET["y"].'&m='.$_GET["m"].'&id='.$_GET["id"].'&t=text" style="border:0px #ffffff none;" name="myiFrame" scrolling="yes" frameborder="0" marginheight="0px" marginwidth="0px" height="400px" width="100%" allowfullscreen></iframe><br>';
					}
				?>
		  </div>
		  <!-- /.mailbox-read-message -->
		</div>
		<?php
		echo '<div class="card-footer bg-white">
		<ul class="mailbox-attachments d-flex align-items-stretch clearfix">';
		foreach ($attachments as $attachment) {

			if(file_exists('./mailbackup'.$folder_tipo.'/'.$_GET["c"].'/'.$_GET["y"].'/'.$_GET["m"].'/MSG_ID_'.$_GET["id"].'/'.$attachment->getFilename().'')){
			}else{
				$filename = $attachment->getFilename(); 
				// write the file to the directory you want to save it in 
				//Parser class give error
				$attachment->save('./mailbackup'.$folder_tipo.'/'.$_GET["c"].'/'.$_GET["y"].'/'.$_GET["m"].'/MSG_ID_'.$_GET["id"].'/'); //, Parser::ATTACHMENT_DUPLICATE_SUFFIX
			}
			echo '<li>
			  <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

			  <div class="mailbox-attachment-info">
				<a href="./mailbackup'.$folder_tipo.'/'.$_GET["c"].'/'.$_GET["y"].'/'.$_GET["m"].'/MSG_ID_'.$_GET["id"].'/'.$attachment->getFilename().'" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> '.$attachment->getFilename().'</a>
					<span class="mailbox-attachment-size clearfix mt-1">
					  <!-- span>1,245 KB</span -->
					  <a href="./mailbackup'.$folder_tipo.'/'.$_GET["c"].'/'.$_GET["y"].'/'.$_GET["m"].'/MSG_ID_'.$_GET["id"].'/'.$attachment->getFilename().'" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
					</span>
			  </div>
			</li>';
		$j++;
		}
		echo '</ul>
		</div>';
		?>
	   
		<!-- /.card-footer -->
		<div class="card-footer">
		  <!-- div class="float-right">
			<button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
			<button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
		  </div>
		  <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
		  <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button -->
		</div>
		<!-- /.card-footer -->
	  </div>
	  <!-- /.card -->
	</div>       
<?php																					
}			
?>