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
								
	if(
	((int)$_GET["id"]==0) 
	){ 
		//What type of emails are you listing?
		if($_GET["tipo"]=="notes"){
			$variable_notes="_notes";
			$variable_tipo="AND FOLDER='NOTES'";
		}elseif($_GET["tipo"]=="sent"){
			$variable_notes="_sents";
			$variable_tipo="AND FOLDER='SENT'";
		}elseif($_GET["tipo"]=="draft"){
			$variable_notes="_drafts";
			$variable_tipo="AND FOLDER='DRAFT'";
		}else{
			$variable_notes="";
			$variable_tipo="AND FOLDER='INBOX'";
		}
		
		//Do you selected a tag?
		//Future: Two tag selection?
		if((int)$_GET["t"]!="0"){
			$tagurl = ' AND UDATE IN (
				SELECT ID_MAIL FROM `igw_emails_tags` WHERE `ID_TAG` = '.(int)$_GET["t"].'
			)';
		}
		
		//Show special tags or hide them on the list
		if(clear($_GET["st"])=="archived"){
			$tagurl = " AND ARCHIVE='1'";
		}elseif(clear($_GET["st"])=="trash"){
			$tagurl = " AND DELETED='1'";
		}else{
			$tagurl = " AND DELETED='0' AND ARCHIVE='0'";
		}
		
		//Did you select a mail account, year or month?
		//Why not a day filter?
		if(($_GET["c"]!="") && ((int)$_GET["y"]!=0) && ((int)$_GET["m"]!=0)){
			$buscar= "WHERE FILE LIKE '%mailbackup".$variable_notes."/".$_GET["c"]."/".$_GET["y"]."/".$_GET["m"]."/MSG_ID_%' ".$tagurl." ".$variable_tipo."";
		}elseif(($_GET["c"]!="") && ((int)$_GET["y"]!=0) && ((int)$_GET["m"]==0)){
			$buscar= "WHERE FILE LIKE '%mailbackup".$variable_notes."/".$_GET["c"]."/".$_GET["y"]."/%' ".$tagurl." ".$variable_tipo."";
			
		}elseif(($_GET["c"]!="") && ((int)$_GET["y"]==0) && ((int)$_GET["m"]==0)){
			$buscar= "WHERE FILE LIKE '%mailbackup".$variable_notes."/".$_GET["c"]."/%' ".$tagurl." ".$variable_tipo."";
			
		}else{
			$buscar= "WHERE FILE LIKE '%mailbackup".$variable_notes."/%' ".$tagurl." ".$variable_tipo."";
		}
		
		
		//Query!
		$admtotal = mysqli_fetch_array(DBSelect('igw_emails', 'COUNT(*) AS total', "".$buscar."",'ORDER BY UDATE DESC'));
		$pages = new Paginator;  
		$pages->items_total = $admtotal['total'];  
		$pages->mid_range = 9; 
		$pages->paginate(); 
		$datamaillist = DBSelect('igw_emails', '*', "".$buscar."",'ORDER BY UDATE DESC', $pages->limit); 

		//$datamaillist = DBSelect('igw_emails', '*', "WHERE FILE LIKE '%mailbackup/".$_GET["c"]."/".$_GET["y"]."/".$_GET["m"]."/MSG_ID_%'",'ORDER BY UDATE DESC');
		
	?>
<!-- /.col -->
<div class="col-md-9 col-sm-8">
  <div class="card card-navy card-outline">
	<div class="card-header">
	  	<h3 class="card-title"><?php echo $lang_content_title_inbox; ?> 
			<?php if(($_GET["c"]!="")){
		    	echo '<span class="btn btn-info btn-xs m-r-2"><i class="fas fa-envelope"></i>'.$_GET["c"].'</span> ';
	  		} ?>
		</h3>

	  <div class="card-tools">
		<div class="input-group input-group-sm">
		  <input type="text" class="form-control" placeholder="<?php echo $lang_content_title_search; ?>">
		  <div class="input-group-append">
			<div class="btn btn-secondary">
			  <i class="fas fa-search"></i>
			</div>
		  </div>
		</div>
	  </div>
	  <!-- /.card-tools -->
	</div>
	<!-- /.card-header -->
	<div class="card-body p-0">
	  <div class="mailbox-controls">
		  <div class="row">
		  	<div class="col-md-6 col-sm-6">
		  		<div class="btn-group">
			  	<div class="custom-control btn btn-default btn-sm custom-checkbox  checkbox-toggle">
					<input type="checkbox" class="ml-2 custom-control-input" data-checked="email-checkbox" id="emailSelectAll" data-change="email-select-all" />
					<label class="custom-control-label" for="emailSelectAll"></label>
				</div>
			  	<button class="btn btn-default btn-sm" data-toggle="dropdown">
						<i class="fa fa-filter mr-2"></i>Filter <span class="caret m-l-3"></span>
					</button>
					<div class="dropdown-menu">
						<?php
						echo '<a href="#" data-idtag="#" class="tag-filter dropdown-item"><i class="fas fa-fw f-s-10 m-r-5 fa-tag"></i> No filter</a>';
						
						$datatags = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '0'",'ORDER BY POSICION ASC');
				
							$i=0;
							
							while($rowt=mysqli_fetch_array($datatags)){
								echo '<a href="#" conclick="console.log($(this).attr(\'data-idtag\'));" data-idtag="'.$rowt["ID_TAG"].'" class="tag-filter dropdown-item"><i class="fa'.$rowt["ICON_S"].' fa-fw f-s-10 m-r-5 fa-'.$rowt["TAG_ICON"].' text-'.$rowt["TAG_COLOR"].'"></i> '.$rowt["TAG"].'</a>';
								$datatags_children[$i] = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '".$rowt["ID_TAG"]."'",'ORDER BY POSICION ASC');
								while($rowt_children[$i]=mysqli_fetch_array($datatags_children[$i])){
								echo '<a href="#" conclick="console.log($(this).attr(\'data-idtag\'));" data-idtag="'.$rowt_children[$i]["ID_TAG"].'" class="tag-filter dropdown-item m-l-10"><i class="fa'.$rowt_children[$i]["ICON_S"].' fa-fw f-s-10 m-r-5 fa-'.$rowt_children[$i]["TAG_ICON"].' text-'.$rowt_children[$i]["TAG_COLOR"].'"></i> '.$rowt_children[$i]["TAG"].'</a>';
								}
							}
						?>
						
					</div>
			  	
		  </div>
	
		  		<!-- begin btn-group -->
		  		<div class="btn-group">
			
					
					
					<button class="btn btn-sm btn-default hide" data-email-action="importante"><i class="fa fa-star mr-2"></i> <span class="d-none d-xl-inline"></span></button>
					<button class="btn btn-sm btn-default hide" data-email-action="tarea"><i class="fa fa-tasks mr-2"></i> <span class="d-none d-xl-inline"></span></button>
					<button class="btn btn-sm btn-default hide" data-email-action="borrar"><i class="fa fa-trash mr-2"></i> <span class="d-none d-xl-inline"></span></button>
					<button class="btn btn-sm btn-default hide" data-email-action="archivar"><i class="fa fa-archive mr-2"></i> <span class="d-none d-xl-inline"></span></button>
					<button class="btn btn-sm btn-default hide" data-email-action="spam"><i class="fa fa-thumbs-down mr-2"></i> <span class="d-none d-xl-inline"></span></button>
					
					<button class="btn btn-default btn-sm hide" data-email-action="etiquetar" data-toggle="dropdown">
						<i class="fa fa-tag mr-2"></i> <span class="caret m-l-3"></span>
					</button>
					<div class="dropdown-menu">
						<a href="javascript:;" class="dropdown-item"><i class="fa fa-circle f-s-9 fa-fw mr-2"></i> All</a>
						<?php
						$datatags = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '0'",'ORDER BY POSICION ASC');
				
							$i=0;
							
							while($rowt=mysqli_fetch_array($datatags)){
								echo '<a href="#" conclick="console.log($(this).attr(\'data-idtagadd\'));" data-idtag="'.$rowt["ID_TAG"].'" class="tag-filter dropdown-item"><i class="fa'.$rowt["ICON_S"].' fa-fw f-s-10 m-r-5 fa-'.$rowt["TAG_ICON"].' text-'.$rowt["TAG_COLOR"].'"></i> '.$rowt["TAG"].'</a>';
								$datatags_children[$i] = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '".$rowt["ID_TAG"]."'",'ORDER BY POSICION ASC');
								while($rowt_children[$i]=mysqli_fetch_array($datatags_children[$i])){
								echo '<a href="#" conclick="console.log($(this).attr(\'data-idtagadd\'));" data-idtag="'.$rowt_children[$i]["ID_TAG"].'" class="tag-filter dropdown-item m-l-10"><i class="fa'.$rowt_children[$i]["ICON_S"].' fa-fw f-s-10 m-r-5 fa-'.$rowt_children[$i]["TAG_ICON"].' text-'.$rowt_children[$i]["TAG_COLOR"].'"></i> '.$rowt_children[$i]["TAG"].'</a>';
								}
							}
						?>
					</div>	
					<button type="button" class="btn btn-default btn-sm"><i class="fas fa-sync-alt"></i></button>
			</div>
		  		<!-- end btn-group -->
		  	</div>				
			
		  	<div class="col-md-6 col-sm-12">
		    	<div style="float: right;"><?php echo $pages->display_pages(); ?></div>
		  	</div>
		  	<!-- /.float-right -->
	      </div>
	  </div>
	  <div class="table-responsive mailbox-messages">
		<table class="table table-hover table-striped">
		  <tbody>
		  
		<!-- /.table -->
		<?php
			$lm=0;
				
			while($list=mysqli_fetch_array($datamaillist)){
			
			
			$parser = new PhpMimeMailParser\Parser();
			$parser->setPath($list["FILE"]);
			$partes_file=explode('/',$list["FILE"]);
			$from = $parser->getHeader('from');
			$from_address = $parser->getAddresses('from');
			$attachments = $parser->getAttachments();
			echo '<tr ';	 
			if(get_spam($list["UDATE"])=="1"){ echo 'style="background: #d3d3d3;"'; }
			elseif($list["DELETED"]=="1"){ echo 'style="background: #ffd1d9;"'; }
			elseif($list["ARCHIVE"]=="1"){ echo 'style="background: #ebf3ff;"'; }
			echo '>';
		
			echo '<td  style="width: 24px;">';
			echo '<div class="email-checkbox">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" data-checked="email-checkbox" id="emailCheckbox'.$list["UDATE"].'" name="'.$list["UDATE"].'">
					<label class="custom-control-label" for="emailCheckbox'.$list["UDATE"].'"></label>
				</div>
			</div>
			</td>
			<td style="width: 24px;">';
			if(get_task($list["UDATE"])!="0"){
				echo '<div class="email-checkbox">'.get_task($list["UDATE"]).'</div>';
			}else{
				echo '<div class="email-checkbox">'.get_star($list["UDATE"]).'</div>';
			}
			echo '</td>';
			echo '<td class="mailbox-star" style="width: 24px;">';
			if($list["ARCHIVE"]!="0"){
				echo '<div class="email-checkbox"><a href="index.php?a=unarchive&st=archived&u='.$list["UDATE"].'"><i class="fa fa-archive mr-2 text-warning"></i></a></div>';
			}elseif($list["DELETED"]!="0"){
				echo '<div class="email-checkbox"><a href="index.php?a=undelete&st=trash&u='.$list["UDATE"].'"><i class="fa fa-trash mr-2 text-red"></i></a></div>';
			}
			echo '</td>';
			
			echo '
			<td>
			<div class="email-checkbox ml-2">';
			if(($_GET["c"]=="")){
				echo '<div class="btn btn-info btn-xs m-r-2"><i class="fas fa-envelope" style="display: inline;"></i>'.$list["MAIL"].'</div> ';
			}
			
			echo '<span class="email-tags">';
			echo get_tags($list["UDATE"]);
			echo '</span>
			</div>
			</td>
			<td class="mailbox-name"  style="width: 80%;">
			<a href="index.php?&c='.$partes_file[2].'&y='.$partes_file[3].'&m='.$partes_file[4].'&id='.$list["UDATE"].'" class="email-user">
				<img class="media-object rounded-corner img-circle" alt="" src="'.get_gravatar($from_address[0]["address"],20).'" />
			</a> <a href="index.php?tipo='.$_GET["tipo"].'&c='.$partes_file[2].'&y='.$partes_file[3].'&m='.$partes_file[4].'&id='.$list["UDATE"].'">
					<span class="email-sender"><strong>'.$from.' ['.$from_address[0]["address"].']</strong></span>
				</a><br>'.iconv_mime_decode($list["SUBJECT"],0, "UTF-8").'
			</td>
			<!--td class="mailbox-subject"  style="width: 45%;">'.iconv_mime_decode($list["SUBJECT"],0, "UTF-8").'</td -->
			<td class="mailbox-attachment"  style="width: 24px;">'; 
					if(count($attachments)>=1){ echo '<i class="fas fa-paperclip"></i> '; }
					echo '</td>
			<td class="mailbox-date">'.date('d/m/Y H:i:s',$list["UDATE"]).'</td>
		';
		$lm++;
		}								
			
			?>
		
	</ul>
	
		  
		  </tbody>
		</table>
	  </div>
	  <!-- /.mail-box-messages -->
	</div>
	<!-- /.card-body -->
	<div class="card-footer p-1">
	  <div class="mailbox-controls">
		<div class="float-left text-inverse f-w-600"><?php 
			$partes_d = explode(',',str_replace('LIMIT ','',$pages->limit));
			if((int)$partes_d['0']=='0'){ echo '1'; }else{ echo (int)$partes_d['0']; }
			echo ' '.$lang_content_footer_a.' '.((int)$partes_d['0']+(int)$partes_d['1']).'';
			echo ' '.$lang_content_footer_of.' '.(int)$admtotal['total']; ?> <?php echo $lang_content_footer_items; ?>
		</div>
	   
		<div class="float-right">
			  <div class="btn-group ml-auto">
				<?php echo $pages->display_pages(); ?>
			</div>
		</div>
		<!-- /.float-right -->
	  </div>
	</div>

  </div>
  <!-- /.card -->
</div>
<!-- /.col -->
<?php } ?>