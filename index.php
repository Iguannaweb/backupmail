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

	include('./igw_template/header.php'); 
?>	  
	  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Inbox</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Inbox</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <!--a href="#" class="btn btn-primary btn-block mb-3">Compose</a -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Inbox's Accounts</h3>

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
						echo '<ul>
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
              <h3 class="card-title">Labels</h3>

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
						echo " data-jstree='{ \"icon\" : \"fa".$rowt["ICON_S"]." fa-".$rowt["TAG_ICON"]." fa-lg text-".$rowt["TAG_COLOR"]."\" }'";	
						echo '><a '; 
							if($rowt["ID_TAG"]==$_GET["t"]){
								echo '  class="jstree-clicked"';
							}else{
								
							}
							echo ' href="index.php?t='.$rowt["ID_TAG"].'&c='.$_GET["c"].'"><i class="jstree-icon fa'.$rowt["ICON_S"].' fa-fw f-s-10 m-r-5 fa-'.$rowt["TAG_ICON"].' text-'.$rowt["TAG_COLOR"].'"></i> '.$rowt["TAG"].' ('.get_tag_count($rowt["ID_TAG"]).')</a>';
						$datatags_children[$i] = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '".$rowt["ID_TAG"]."'",'ORDER BY POSICION ASC');
						echo '<ul>';
						while($rowt_children[$i]=mysqli_fetch_array($datatags_children[$i])){
						echo '<li'; 
						echo " data-jstree='{ \"icon\" : \"fa".$rowt_children[$i]["ICON_S"]." fa-".$rowt_children[$i]["TAG_ICON"]." fa-lg text-".$rowt_children[$i]["TAG_COLOR"]."\" }'";	
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
					<li <?php echo " data-jstree='{ \"icon\" : \"fa fa-envelope fa-lg text-info\" }'"; ?>>
					<a href="index.php?tipo=sent&c="><i class="fa fa-envelope fa-lg text-info"></i> ENVIADOS</a></li>
					<li <?php echo " data-jstree='{ \"icon\" : \"fa fa-pencil-alt fa-lg text-grey\" }'"; ?>>
					<a href="index.php?tipo=draft&c="><i class="fa fa-pencil-alt fa-lg text-grey"></i> BORRADORES</a></li>
					<li <?php echo " data-jstree='{ \"icon\" : \"fa fa-sticky-note fa-lg text-yellow\" }'"; ?>>
					<a href="index.php?tipo=notes&c="><i class="fa fa-sticky-note fa-lg text-yellow"></i> NOTAS</a></li>
				</ul>
				</div>
          </div>
        </div>
        <?php 
										
			if(
			((int)$_GET["id"]==0) 
			){ 
				
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
				
				if((int)$_GET["t"]!="0"){
					$tagurl = ' AND UDATE IN (
						SELECT ID_MAIL FROM `igw_emails_tags` WHERE `ID_TAG` = '.(int)$_GET["t"].'
					)';
				}
				
				if(($_GET["c"]!="") && ((int)$_GET["y"]!=0) && ((int)$_GET["m"]!=0)){
					$buscar= "WHERE FILE LIKE '%mailbackup".$variable_notes."/".$_GET["c"]."/".$_GET["y"]."/".$_GET["m"]."/MSG_ID_%' ".$tagurl." ".$variable_tipo."";
				}elseif(($_GET["c"]!="") && ((int)$_GET["y"]!=0) && ((int)$_GET["m"]==0)){
					$buscar= "WHERE FILE LIKE '%mailbackup".$variable_notes."/".$_GET["c"]."/".$_GET["y"]."/%' ".$tagurl." ".$variable_tipo."";
					
				}elseif(($_GET["c"]!="") && ((int)$_GET["y"]==0) && ((int)$_GET["m"]==0)){
					$buscar= "WHERE FILE LIKE '%mailbackup".$variable_notes."/".$_GET["c"]."/%' ".$tagurl." ".$variable_tipo."";
					
				}else{
					$buscar= "WHERE FILE LIKE '%mailbackup".$variable_notes."/%' ".$tagurl." ".$variable_tipo."";
				}
				
				
				$admtotal = mysqli_fetch_array(DBSelect('igw_emails', 'COUNT(*) AS total', "".$buscar."",'ORDER BY UDATE DESC'));
				$pages = new Paginator;  
				$pages->items_total = $admtotal['total'];  
				$pages->mid_range = 9; 
				$pages->paginate(); 
				$datamaillist = DBSelect('igw_emails', '*', "".$buscar."",'ORDER BY UDATE DESC', $pages->limit); 

				//$datamaillist = DBSelect('igw_emails', '*', "WHERE FILE LIKE '%mailbackup/".$_GET["c"]."/".$_GET["y"]."/".$_GET["m"]."/MSG_ID_%'",'ORDER BY UDATE DESC');
				
			?>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Inbox</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" placeholder="Search Mail">
                  <div class="input-group-append">
                    <div class="btn btn-primary">
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
					<!-- begin btn-group -->
					<div class="btn-group">
				<div class="custom-control btn btn-default btn-sm custom-checkbox  checkbox-toggle">
					<input type="checkbox" class="ml-2 custom-control-input" data-checked="email-checkbox" id="emailSelectAll" data-change="email-select-all" />
					<label class="custom-control-label" for="emailSelectAll"></label>
				</div>
						<button class="btn btn-default btn-sm" data-toggle="dropdown">
							Ver todos <span class="caret m-l-3"></span>
						</button>
						<div class="dropdown-menu">
							<?php
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
						
						<button class="btn btn-sm btn-default hide" data-email-action="importante"><i class="fa fa-star mr-2"></i> <span class="d-none d-xl-inline"></span></button>
						<button class="btn btn-sm btn-default hide" data-email-action="tarea"><i class="fa fa-tasks mr-2"></i> <span class="d-none d-xl-inline"></span></button>
						<button class="btn btn-sm btn-default hide" data-email-action="borrar"><i class="fa fa-trash mr-2"></i> <span class="d-none d-xl-inline"></span></button>
						<button class="btn btn-sm btn-default hide" data-email-action="archivar"><i class="fa fa-archive mr-2"></i> <span class="d-none d-xl-inline"></span></button>
						<button class="btn btn-sm btn-default hide" data-email-action="spam"><i class="fa fa-thumbs-down mr-2"></i> <span class="d-none d-xl-inline"></span></button>
						
						<button class="btn btn-default btn-sm hide" data-email-action="etiquetar" data-toggle="dropdown">
							Etiquetar <span class="caret m-l-3"></span>
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
								
                
                <div class="float-right">
                  <?php echo $pages->display_pages(); ?>
                </div>
                <!-- /.float-right -->
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
				
					echo '<td>';
					if(get_task($list["UDATE"])!="0"){
						echo '<div class="email-checkbox">'.get_task($list["UDATE"]).'</div>';
					}else{
						echo '<div class="email-checkbox">'.get_star($list["UDATE"]).'</div>';
					}
					echo '</td>';
					echo '<td class="mailbox-star">';
					if($list["ARCHIVE"]!="0"){
						echo '<div class="email-checkbox"><a href="index.php?a=unarchive&u='.$list["UDATE"].'"><i class="fa fa-archive fa-lg mr-2 text-warning"></i></a></div>';
					}elseif($list["DELETED"]!="0"){
						echo '<div class="email-checkbox"><a href="index.php?a=undelete&u='.$list["UDATE"].'"><i class="fa fa-trash fa-lg mr-2 text-red"></i></a></div>';
					}
					echo '</td>';
					
					echo '<td>';
					echo '<div class="email-checkbox">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" data-checked="email-checkbox" id="emailCheckbox'.$list["UDATE"].'" name="'.$list["UDATE"].'">
							<label class="custom-control-label" for="emailCheckbox'.$list["UDATE"].'"></label>
						</div>
					</div>
					</td>
					<td class="mailbox-name">
					<div class="email-checkbox ml-2">';
					if(($_GET["c"]=="")){
						echo '<span class="label label-info m-r-2"><i class="fas fa-envelope"></i> '.$list["MAIL"].'</span> ';
					}
					
					echo '<span class="email-tags">';
					echo get_tags($list["UDATE"]);
					echo '</span>
					</div>
					<a href="index.php?&c='.$partes_file[2].'&y='.$partes_file[3].'&m='.$partes_file[4].'&id='.$list["UDATE"].'" class="email-user">
						<img class="media-object rounded-corner img-circle" alt="" src="'.get_gravatar($from_address[0]["address"],20).'" />
					</a> <a href="index.php?tipo='.$_GET["tipo"].'&c='.$partes_file[2].'&y='.$partes_file[3].'&m='.$partes_file[4].'&id='.$list["UDATE"].'">
							<span class="email-sender">'.$from.' ['.$from_address[0]["address"].']</span>
						</a>
					</td>
					<td class="mailbox-subject">'.iconv_mime_decode($list["SUBJECT"],0, "UTF-8").'</td>
                    <td class="mailbox-attachment">'; 
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
            <div class="card-footer p-0">
              <div class="mailbox-controls">
                <div class="float-left text-inverse f-w-600"><?php 
					$partes = explode(',',str_replace('LIMIT ','',$pages->limit));
					echo $partes[0].' a '.($partes[0]+$partes[1]).'';
					echo ' de '.$admtotal['total']; ?> Correos
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
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  <?php } ?>
  
  <?php
	define(INCLUDE_CHECK,'true');
	include('./igw_template/footer.php'); 
?>