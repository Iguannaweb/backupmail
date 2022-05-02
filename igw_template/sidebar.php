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

<div class="col-md-3 col-sm-4">
  <!--a href="#" class="btn btn-primary btn-block mb-3">Compose</a -->

  <div class="card">
	<div class="card-header">
	  <h3 class="card-title"><strong>Inbox's Accounts</strong></h3>

	  <div class="card-tools">
		<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
		</button>
	  </div>
	</div>
	<div class="card-body p-0">
	  <!-- ul class="nav nav-pills flex-column">
		<li class="nav-item active">
		  <a href="#" class="nav-link">
			<i class="fas fa-inbox"></i> Inbox
			<span class="badge bg-primary float-right">12</span>
		  </a>
		</li>
		<li class="nav-item">
		  <a href="#" class="nav-link">
			<i class="far fa-envelope"></i> Sent
		  </a>
		</li>
		<li class="nav-item">
		  <a href="#" class="nav-link">
			<i class="far fa-file-alt"></i> Drafts
		  </a>
		</li>
		<li class="nav-item">
		  <a href="#" class="nav-link">
			<i class="fas fa-filter"></i> Junk
			<span class="badge bg-warning float-right">65</span>
		  </a>
		</li>
		<li class="nav-item">
		  <a href="#" class="nav-link">
			<i class="far fa-trash-alt"></i> Trash
		  </a>
		</li>
	  </ul -->
		  <?php
			$preferences = array(
				"input-charset" => "ISO-8859-1",
				"output-charset" => "UTF-8",
				"line-length" => 76,
				"line-break-chars" => "\n"
			);
			$correos_loop=array();
			foreach($correos_config as $mails){
				$data = DBSelect('igw_emails', '*', "WHERE MAIL = '".$mails["user_mail"]."' AND FOLDER='INBOX'",'ORDER BY UDATE DESC');

				$i=0;
				
				$icono="igw_template/assets/img/icons8-email-document-16.png";
				while($row=mysqli_fetch_array($data)){
					$partes[$i]=explode('/',$row["FILE"]);
					$anio[$i]=$partes[$i][3];
					$mes[$i]=$partes[$i][4];
					
					$correos_loop["".$mails["user_mail"].""]["".$anio[$i].""]["".$mes[$i].""]["".$row["UDATE"].""]=array(
						'icon'=>$icono,
						'id'=>$row["UDATE"],
						'anio'=>$anio[$i],
						'mes'=>$mes[$i],
						'asunto'=>iconv_mime_decode($row["SUBJECT"],0, "UTF-8")
					);
					
					$i++;
				}
			}
			
			//echo '<pre>';print_r($correos);echo '</pre>';
		?>
		<div id="jstree_demo_div">
			<?php //listFolderFiles('./mailbackup'); ?>
			
			<?php
			foreach($correos_loop as $c=>$correo){
				$c=str_replace(array('@','.'),'_',$c);
				echo '<ul class="nav nav-pills flex-column">
					<li '; 
					if($c==$_GET["c"]){
						echo '  class="jstree-open"';
					}else{
						
					}
					echo '><a '; 
					if($c==$_GET["c"]){
						echo '  class="jstree-clicked"';
					}else{
						
					}
					echo ' href="?c='.$c.'">'.$c.'</a>
					<ul>';
				
				foreach($correo as $key=>$anio){
					echo '<li '; 
					if(($key==$_GET["y"]) && ($c==$_GET["c"])){
						echo '  class="jstree-open"';
					}else{
						
					}
					echo '><a '; 
					if(($key==$_GET["y"]) && ($c==$_GET["c"])){
						echo '  class="jstree-clicked"';
					}else{
						
					}
					echo ' href="?c='.$c.'&y='.$key.'">'.$key.'</a>';
						echo '<ul>'; 
						foreach($anio as $kmes=>$mes){
							echo '<li '; 
									if(($c==$_GET["c"]) && ($key==$_GET["y"]) && ($kmes==$_GET["m"])){
										echo '  class="jstree-open"';
									}else{
										
									}
									echo '><a '; 
									if(($key==$_GET["y"]) && ($c==$_GET["c"]) && ($kmes==$_GET["m"])){
										echo '  class="jstree-clicked"';
									}else{
										
									}
									echo ' href="?c='.$c.'&y='.$key.'&m='.$kmes.'">'.$kmes.'</a>'; 
									/*if(isset($_GET["m"]) && ((int)$_GET["m"]!=0) && ($key==$_GET["y"]) && ($c==$_GET["c"]) && ($kmes==$_GET["m"])){
										echo '<ul>'; 
										foreach($mes as $kmail=>$mail){
											echo '<li 
											data-jstree=\'{"icon":"'.$mail["icon"].'"}\'>
											<a '; 
											if($mail["id"]==$_GET["id"]){
												echo '  class="jstree-clicked"';
											}else{
												
											}
											echo ' href="?c='.$c.'&y='.$mail["anio"].'&m='.$mail["mes"].'&id='.$mail["id"].'">'.$mail["asunto"].'</a>';
											echo '</li>';
										}
										echo '</ul>';
									}*/
							echo '</li>';
						}
						echo '</ul>';
					echo '</li>';
					
				}
				echo '</ul>
					</li>
					</ul>';
				
			}
			?>
			
		</div>
	</div>
	<!-- /.card-body -->
  </div>
  <!-- /.card -->
  <div class="card">
	<div class="card-header">
	  <h3 class="card-title"><strong>Tags</strong></h3>

	  <div class="card-tools">
		<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
		</button>
	  </div>
	</div>
	<div class="card-body p-0"  id="jstree_tag_div">
	  <!-- ul class="nav nav-pills flex-column">
		<li class="nav-item">
		  <a href="#" class="nav-link">
			<i class="far fa-circle text-danger"></i>
			Important
		  </a>
		</li>
		<li class="nav-item">
		  <a href="#" class="nav-link">
			<i class="far fa-circle text-warning"></i> Promotions
		  </a>
		</li>
		<li class="nav-item">
		  <a href="#" class="nav-link">
			<i class="far fa-circle text-primary"></i>
			Social
		  </a>
		</li>
	  </ul -->

		<ul class="nav nav-inbox">
			<?php
			$datatags = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '0'",'ORDER BY POSICION ASC');

			$i=0;
			
			while($rowt=mysqli_fetch_array($datatags)){
				echo '<li'; 
				echo " data-jstree='{ \"icon\" : \"fa".$rowt["ICON_S"]." fa-".$rowt["TAG_ICON"]." text-".$rowt["TAG_COLOR"]."\" }'";	
				echo '><a '; 
					if($rowt["ID_TAG"]==$_GET["t"]){
						echo '  class="nav-item jstree-clicked"';
					}else{
						echo '  class="nav-item "';
					}
					echo ' href="index.php?t='.$rowt["ID_TAG"].'&c='.$_GET["c"].'"><i class="jstree-icon fa'.$rowt["ICON_S"].' fa-fw f-s-10 m-r-5 fa-'.$rowt["TAG_ICON"].' text-'.$rowt["TAG_COLOR"].'"></i> '.$rowt["TAG"].' ('.get_tag_count($rowt["ID_TAG"]).')</a>';
				$datatags_children[$i] = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '".$rowt["ID_TAG"]."'",'ORDER BY POSICION ASC');
				echo '<ul>';
				while($rowt_children[$i]=mysqli_fetch_array($datatags_children[$i])){
				echo '<li'; 
				echo " data-jstree='{ \"icon\" : \"fa".$rowt_children[$i]["ICON_S"]." fa-".$rowt_children[$i]["TAG_ICON"]." text-".$rowt_children[$i]["TAG_COLOR"]."\" }'";	
				echo '><a '; 
					if($rowt_children[$i]["ID_TAG"]==$_GET["t"]){
						echo '  class="jstree-clicked"';
					}else{
						
					}
					echo ' href="index.php?t='.$rowt_children[$i]["ID_TAG"].'&c='.$_GET["c"].'"><i class="jstree-icon fa'.$rowt_children[$i]["ICON_S"].' fa-fw f-s-10 m-r-5 fa-'.$rowt_children[$i]["TAG_ICON"].' text-'.$rowt_children[$i]["TAG_COLOR"].'"></i> '.$rowt_children[$i]["TAG"].' ('.get_tag_count($rowt_children[$i]["ID_TAG"]).')</a></li>';
				}
				echo '</ul>';
				echo '</li>';
			}
			?>
			
		</ul>
	</div>
	<!-- /.card-body -->
  </div>
  <!-- /.card -->
  
  <div class="card">
	  <div class="card-header">
	  <h3 class="card-title"><strong>Others mails</strong></h3>

	  <div class="card-tools">
		<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
		</button>
	  </div>
	</div>
	  <div  class="card-body p-0" id="jstree_otros_div">
		<ul class="nav nav-inbox">
			<li <?php echo " data-jstree='{ \"icon\" : \"fa fa-envelope text-info\" }'"; ?>>
			<a href="index.php?tipo=sent&c="><i class="fa fa-envelope text-info"></i> SENTS</a></li>
			<li <?php echo " data-jstree='{ \"icon\" : \"fa fa-pencil-alt text-grey\" }'"; ?>>
			<a href="index.php?tipo=draft&c="><i class="fa fa-pencil-alt text-grey"></i> DRAFTS</a></li>
			<li <?php echo " data-jstree='{ \"icon\" : \"fa fa-sticky-note text-yellow\" }'"; ?>>
			<a href="index.php?tipo=notes&c="><i class="fa fa-sticky-note text-yellow"></i> NOTES</a></li>
		</ul>
		</div>
  </div>
</div>