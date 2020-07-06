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

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tags</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tags</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	     <?php
			if($_POST["action"]=="crear"){
				$form_data = array(
				    'ID_TAG_SUP' => clear((int)$_POST["ID_TAG_SUP"]),
				    'TAG' => clear($_POST["TAG"]),
				    'TAG_COLOR' => clear($_POST["TAG_COLOR"]),
				    'TAG_ICON' => clear($_POST["TAG_ICON"]),
				    'STATUS' => clear((int)$_POST["STATUS"]),
				    'POSICION' => clear((int)$_POST["POSICION"]),
				    'ICON_S' => clear($_POST["ICON_S"])
				);
				if(DBInsert('igw_tags', $form_data)){
					echo '<div class="alert alert-success fade show">
						  <span class="close" data-dismiss="alert">×</span>
						  <strong>¡Felicidades!</strong>
						  Se ha creado la nueva etiqueta 
						</div>';
				}else{
					echo '<div class="alert alert-danger fade show">
						  <span class="close" data-dismiss="alert">×</span>
						  <strong>¡Error!</strong>
						  Hubo un problema al crear la etiqueta. 
						</div>';
				}
			
			}
			
			if($_POST["action"]=="editar"){
				$form_data = array(
				    'ID_TAG_SUP' => clear((int)$_POST["ID_TAG_SUP"]),
				    'TAG' => clear($_POST["TAG"]),
				    'TAG_COLOR' => clear($_POST["TAG_COLOR"]),
				    'TAG_ICON' => clear($_POST["TAG_ICON"]),
				    'STATUS' => clear((int)$_POST["STATUS"]),
				    'POSICION' => clear((int)$_POST["POSICION"]),
				    'ICON_S' => clear($_POST["ICON_S"])
				);
				//echo '<pre>';print_r($form_data);echo '</pre>';
				//echo ''.clear((int)$_POST["ID_TAG"]).'';
				if(DBUpdate('igw_tags', $form_data,"WHERE ID_TAG='".clear((int)$_POST["ID_TAG"])."'")){
					echo '<div class="alert alert-success fade show">
						  <span class="close" data-dismiss="alert">×</span>
						  <strong>¡Felicidades!</strong>
						  Se ha creado la nueva etiqueta 
						</div>';
				}else{
					echo '<div class="alert alert-danger fade show">
						  <span class="close" data-dismiss="alert">×</span>
						  <strong>¡Error!</strong>
						  Hubo un problema al crear la etiqueta. 
						</div>';
				}
			
			}
			?>
        <div class="col-md-3">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Tag list</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
	              
	              <?php
						$datatags = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '0'",'ORDER BY POSICION ASC');
	
						$i=0;
						
						while($rowt=mysqli_fetch_array($datatags)){
							echo '<li><a href="tags.php?t='.$rowt["ID_TAG"].'&a=edit"><i class="fa'.$rowt["ICON_S"].' fa-fw f-s-10 m-r-5 fa-'.$rowt["TAG_ICON"].' text-'.$rowt["TAG_COLOR"].'"></i> '.$rowt["POSICION"].' - '.$rowt["TAG"].' ('.get_tag_count($rowt["ID_TAG"]).')</a></li>';
							$datatags_children[$i] = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '".$rowt["ID_TAG"]."'",'ORDER BY POSICION ASC');
							while($rowt_children[$i]=mysqli_fetch_array($datatags_children[$i])){
							echo '<li class="m-l-10"><a href="tags.php?t='.$rowt_children[$i]["ID_TAG"].'&a=edit"><i class="fa'.$rowt_children[$i]["ICON_S"].' fa-fw f-s-10 m-r-5 fa-'.$rowt_children[$i]["TAG_ICON"].' text-'.$rowt_children[$i]["TAG_COLOR"].'"></i> '.$rowt_children[$i]["POSICION"].' - '.$rowt_children[$i]["TAG"].' ('.get_tag_count($rowt_children[$i]["ID_TAG"]).')</a></li>';
							}
						}
					?>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">
	              <?php if(!isset($_GET["a"])){ ?><i class="fas fa-tag"></i> Add new tag<?php } ?>
	              <?php if($_GET["a"]=="edit"){ 
					
					$datatags_e = mysqli_fetch_array(DBSelect('igw_tags', '*', "WHERE ID_TAG = '".(int)$_GET["t"]."'",'ORDER BY POSICION ASC'));
					
				?>
				<i class="fas fa-tag"></i> Edit a tag
				<?php } ?>
	          </h3>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <?php if(!isset($_GET["a"])){ ?>
				<div class="panel panel-inverse" data-sortable-id="ui-widget-1">
				  <div class="panel-body">
				    <form method="post" action="tags.php">
					    <input type="hidden" name="action" value="crear"/>
					    <div class="row">
							<div class="col-sm-6">
								<strong>Nombre etiqueta</strong>
								<input class="form-control" type="text" name="TAG" id="TAG" placeholder="Etiqueta" required="required"/>
							</div>
							<div class="col-sm-6">
								<strong>Etiqueta padre</strong>
								<select class="form-control" name="ID_TAG_SUP" id="ID_TAG_SUP">
									<option value="0">Selecciona...</option>
									<?php
										$datatags = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '0'",'ORDER BY POSICION ASC');
					
										$i=0;
										
										while($rowt=mysqli_fetch_array($datatags)){
											echo '<option value="'.$rowt["ID_TAG"].'">'.$rowt["TAG"].'</option>';
											$datatags_children[$i] = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '".$rowt["ID_TAG"]."'",'ORDER BY POSICION ASC');
											while($rowt_children[$i]=mysqli_fetch_array($datatags_children[$i])){
											
											echo '<option value="'.$rowt_children[$i]["ID_TAG"].'"> -- '.$rowt_children[$i]["TAG"].'</option>';
											}
										}
									?>
									
								</select>
							</div>
							
					    </div>
					    
					    <div class="row">
						    <div class="col-sm-4">
								<strong>Color etiqueta</strong>
								<input class="form-control" type="text" name="TAG_COLOR" id="TAG_COLOR" placeholder="Color Etiqueta" required="required"/>
							</div>
						    <div class="col-sm-4">
								<strong>Icono etiqueta</strong>
								<input class="form-control" type="text" name="TAG_ICON" id="TAG_ICON" placeholder="Icono Etiqueta" required="required"/>
							</div>
							<div class="col-sm-4">
								<strong>Corrector icono etiqueta</strong>
								<select class="form-control" name="ICON_S" id="ICON_S">
									<option value="">NORMAL</option>
									<option value="s">SOLID</option>
									<option value="b">BRAND</option>
								</select>
							</div>
					    </div>
					    
					    <div class="row">
						    <div class="col-sm-6">
							    <strong>Posición etiqueta</strong>
								<input class="form-control" type="text" name="POSICION" id="POSICION" placeholder="Posición"/>
						    </div>
						    
						    <div class="col-sm-6">
							    <strong>Estado etiqueta</strong>
								<select class="form-control" name="STATUS" id="STATUS">
									<option value="1">Activa</option>
									<option value="0">Inactiva</option>
								</select>
						    </div>
					    </div>
					    <div class="row">
						    <div class="col-sm-12">
							    <div>&nbsp;</div>
							    <input type="submit" class="pull-right btn btn-inverse" value="Crear">
						    </div>
					    </div>
				    </form>
				  </div>
				</div>
				<?php } ?>
				
				 <!--  
					ID_TAG
					ID_TAG_SUP
					MAIL
					TAG
					TAG_COLOR
					TAG_ICON
					STATUS
					POSICION
					ICON_S
					-->
				
				<?php if($_GET["a"]=="edit"){ 
				
				?>
				<div class="panel panel-inverse" data-sortable-id="ui-widget-1">
				  
				  <div class="panel-body">
				    <form method="post" action="tags.php?t=<?php echo (int)$_GET["t"]; ?>&a=edit">
					    <input type="hidden" name="action" value="editar"/>
					    <input type="hidden" name="ID_TAG" value="<?php echo $datatags_e["ID_TAG"]; ?>"/>
					    <div class="row">
							<div class="col-sm-6">
								<strong>Nombre etiqueta</strong>
								<input class="form-control" type="text" name="TAG" id="TAG" placeholder="Etiqueta" value="<?php echo $datatags_e["TAG"]; ?>" required="required"/>
							</div>
							<div class="col-sm-6">
								<strong>Etiqueta padre</strong>
								<select class="form-control" name="ID_TAG_SUP" id="ID_TAG_SUP">
									<option value="0">Selecciona...</option>
									<?php
										$datatags = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '0'",'ORDER BY POSICION ASC');
					
										$i=0;
										
										while($rowt=mysqli_fetch_array($datatags)){
											echo '<option value="'.$rowt["ID_TAG"].'" '; 
											if($datatags_e["ID_TAG_SUP"]==$rowt["ID_TAG"]){ echo 'selected="selected"'; }
											echo '>'.$rowt["TAG"].'</option>';
											$datatags_children[$i] = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '".$rowt["ID_TAG"]."'",'ORDER BY POSICION ASC');
											while($rowt_children[$i]=mysqli_fetch_array($datatags_children[$i])){
											
											echo '<option value="'.$rowt_children[$i]["ID_TAG"].'"'; 
											if($datatags_e["ID_TAG_SUP"]==$rowt_children[$i]["ID_TAG"]){ echo 'selected="selected"'; }
											echo '> -- '.$rowt_children[$i]["TAG"].'</option>';
											}
										}
									?>
									
								</select>
							</div>
							
					    </div>
					    
					    <div class="row">
						    <div class="col-sm-4">
								<strong>Color etiqueta</strong>
								<input class="form-control" type="text" name="TAG_COLOR" id="TAG_COLOR" value="<?php echo $datatags_e["TAG_COLOR"]; ?>" placeholder="Color Etiqueta" required="required"/>
							</div>
						    <div class="col-sm-4">
								<strong>Icono etiqueta</strong>
								<input class="form-control" type="text" name="TAG_ICON" id="TAG_ICON" value="<?php echo $datatags_e["TAG_ICON"]; ?>" placeholder="Icono Etiqueta" required="required"/>
							</div>
							<div class="col-sm-4">
								<strong>Corrector icono etiqueta</strong>
								<select class="form-control" name="ICON_S" id="ICON_S">
									<option value="">NORMAL</option>
									<option value="s" <?php if($datatags_e["ICON_S"]=="s"){ echo 'selected="selected"'; } ?>>SOLID</option>
									<option value="b" <?php if($datatags_e["ICON_S"]=="b"){ echo 'selected="selected"'; } ?>>BRAND</option>
								</select>
							</div>
					    </div>
					    
					    <div class="row">
						    <div class="col-sm-6">
							    <strong>Posición etiqueta</strong>
								<input class="form-control" type="text" name="POSICION" value="<?php echo $datatags_e["POSICION"]; ?>" id="POSICION" placeholder="Posición"/>
						    </div>
						    
						    <div class="col-sm-6">
							    <strong>Estado etiqueta</strong>
								<select class="form-control" name="STATUS" id="STATUS">
									<option value="1" <?php if($datatags_e["STATUS"]=="1"){ echo 'selected="selected"'; } ?>>Activa</option>
									<option value="0" <?php if($datatags_e["STATUS"]=="0"){ echo 'selected="selected"'; } ?>>Inactiva</option>
								</select>
						    </div>
					    </div>
					    <div class="row">
						    <div class="col-sm-12">
							    <div>&nbsp;</div>
							    <input type="submit" class="pull-right btn btn-inverse" value="Editar">
						    </div>
					    </div>
				    </form>
				  </div>
				</div>
				<?php } ?>
            
              <!-- /.mail-box-messages -->
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>			
			
							
			
<?php include('./igw_template/footer.php'); ?>