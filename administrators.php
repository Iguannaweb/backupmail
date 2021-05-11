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
            <h1>Admins configurations</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admins</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		<?php
			/*if($_POST["action"]=="crear"){
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
					echo '<div class="row"><div class="col-md-12"><div class="alert alert-success fade show">
						  <span class="close" data-dismiss="alert">×</span>
						  <strong>¡Felicidades!</strong>
						  Se ha creado la nueva etiqueta 
						</div></div></div>';
				}else{
					echo '<div class="row"><div class="col-md-12"><div class="alert alert-danger fade show">
						  <span class="close" data-dismiss="alert">×</span>
						  <strong>¡Error!</strong>
						  Hubo un problema al crear la etiqueta. 
						</div></div></div>';
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
					echo '<div class="row"><div class="col-md-12"><div class="alert alert-success fade show">
						  <span class="close" data-dismiss="alert">×</span>
						  <strong>¡Felicidades!</strong>
						  Se ha creado la nueva etiqueta 
						</div></div></div>';
				}else{
					echo '<div class="row"><div class="col-md-12"><div class="alert alert-danger fade show">
						  <span class="close" data-dismiss="alert">×</span>
						  <strong>¡Error!</strong>
						  Hubo un problema al crear la etiqueta. 
						</div></div></div>';
				}
			
			}*/
			?>
        <div class="row">
        <div class="col-md-3">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">User list <a href="javascripts:return false;" class="toastrDefaultInfo"><i class="fas fa-info-circle"></i></a></h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
	              
	              <?php
						$datatags = DBSelect('igw_members', '*', "",'ORDER BY usr ASC');
	
						$i=0;
						
						while($rowt=mysqli_fetch_array($datatags)){
							$datatags_children[$i] = mysqli_fetch_array(DBSelect('igw_adm', '*', "WHERE id_member = '".$rowt["id"]."'",' LIMIT 0,1'));
							echo '<li class="nav-item"><a class="nav-link" href="administrators.php?u='.$rowt["id"].'&a=edit"><i class="fa fa-user"></i> '.$datatags_children[$i]["nombre"].' '.$datatags_children[$i]["apellidos"].' ('.$rowt["usr"].')</a></li>';
							
						}
					?>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-secondary card-outline">
            <div class="card-header">
              <h3 class="card-title">
	              <?php if(!isset($_GET["a"])){ ?><i class="fas fa-user"></i> Add new user<?php } ?>
	              <?php if($_GET["a"]=="edit"){ 
					
					$datauser_e = mysqli_fetch_array(DBSelect('igw_members', '*', "WHERE id = '".(int)$_GET["u"]."'",'LIMIT 0,1'));
					$datauser_ed = mysqli_fetch_array(DBSelect('igw_adm', '*', "WHERE id_member = '".(int)$_GET["u"]."'",'LIMIT 0,1'));
					
				?>
				<i class="fas fa-user"></i> Edit a user
				<?php } ?>
	          </h3>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <?php if(!isset($_GET["a"])){ 
	            
	            /*
		            id
					usr
					pass
					email
					tipo
					activo
					dt
					
					id_adm
					id_member
					nombre
					apellidos
					tlf
					tlf_movil
					correo
				*/
            ?>
				<div class="panel panel-inverse" data-sortable-id="ui-widget-1">
				  <div class="panel-body">
				    <form method="post" action="tags.php">
					    <input type="hidden" name="action" value="crear"/>
					    <div class="row">
							<div class="col-sm-6">
								<strong>Name</strong>
								<input class="form-control" type="text" name="user_name" id="user_name" placeholder="Your name" required="required"/>
							</div>
							<div class="col-sm-6">
								<strong>Surname</strong>
								<input class="form-control" type="text" name="user_surname" id="user_surname" placeholder="Your surname" required="required"/>
							</div>
							
					    </div>
					    
					    <div class="row">
						    <div class="col-sm-4">
								<strong>Telephone</strong>
								<input class="form-control" type="text" name="telephone" id="telephone" placeholder="Phone" required="required"/>
							</div>
						    <div class="col-sm-4">
								<strong>Mobile telephone</strong>
								<input class="form-control" type="text" name="mobile" id="mobile" placeholder="Mobile phone" required="required"/>
							</div>
							<div class="col-sm-4">
								<strong>E-mail</strong>
								<input class="form-control" type="text" name="email" id="email" placeholder="Email address" required="required"/>
							</div>
					    </div>
					    
					    <div class="row">
							<div class="col-sm-4">
								<strong>Username</strong>
								<input class="form-control" type="text" name="username" id="username" placeholder="Your login name" required="required"/>
							</div>
							<div class="col-sm-4">
								<strong>New Password</strong>
								<input class="form-control" type="text" name="password1" id="password1" placeholder="" />
							</div>
							<div class="col-sm-4">
								<strong>Repeat Password</strong>
								<input class="form-control" type="text" name="password2" id="password2" placeholder="" />
							</div>
					    </div>
					    
					    <div class="row">
						    <div class="col-sm-12">
							    <div>&nbsp;</div>
							    <input type="submit" class="pull-right btn btn-secondary" value="Create user">
						    </div>
					    </div>
					    
				    </form>
				  </div>
				</div>
				<?php } ?>
				
				 
				
				<?php if($_GET["a"]=="edit"){ 
				
				/*
		            id
					usr
					pass
					email
					tipo
					activo
					dt
					
					id_adm
					id_member
					nombre
					apellidos
					tlf
					tlf_movil
					correo
				*/
				?>
				<div class="panel panel-inverse" data-sortable-id="ui-widget-1">
				  
				  <div class="panel-body">
				    <form method="post" action="tags.php?t=<?php echo (int)$_GET["t"]; ?>&a=edit">
					    <input type="hidden" name="action" value="editar"/>
					    <input type="hidden" name="ID_TAG" value="<?php echo $datatags_e["ID_TAG"]; ?>"/>
					    <div class="row">
							<div class="col-sm-6">
								<strong>Tag name</strong>
								<input class="form-control" type="text" name="TAG" id="TAG" placeholder="Tag name" value="<?php echo $datatags_e["TAG"]; ?>" required="required"/>
							</div>
							<div class="col-sm-6">
								<strong>Parent tag</strong>
								<select class="form-control" name="ID_TAG_SUP" id="ID_TAG_SUP">
									<option value="0">Select...</option>
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
								<strong>Tag Color</strong>
								<input class="form-control" type="text" name="TAG_COLOR" id="TAG_COLOR" value="<?php echo $datatags_e["TAG_COLOR"]; ?>" placeholder="Tag Color" required="required"/>
							</div>
						    <div class="col-sm-4">
								<strong>Tag Icon</strong>
								<input class="form-control" type="text" name="TAG_ICON" id="TAG_ICON" value="<?php echo $datatags_e["TAG_ICON"]; ?>" placeholder="Tag Icon" required="required"/>
							</div>
							<div class="col-sm-4">
								<strong>Icon fa(x)</strong>
								<select class="form-control" name="ICON_S" id="ICON_S">
									<option value="">NORMAL</option>
									<option value="s" <?php if($datatags_e["ICON_S"]=="s"){ echo 'selected="selected"'; } ?>>SOLID</option>
									<option value="b" <?php if($datatags_e["ICON_S"]=="b"){ echo 'selected="selected"'; } ?>>BRAND</option>
								</select>
							</div>
					    </div>
					    
					    <div class="row">
						    <div class="col-sm-6">
							    <strong>Tag position</strong>
								<input class="form-control" type="text" name="POSICION" value="<?php echo $datatags_e["POSICION"]; ?>" id="POSICION" placeholder="Tag position"/>
						    </div>
						    
						    <div class="col-sm-6">
							    <strong>Tag status</strong>
								<select class="form-control" name="STATUS" id="STATUS">
									<option value="1" <?php if($datatags_e["STATUS"]=="1"){ echo 'selected="selected"'; } ?>>Activa</option>
									<option value="0" <?php if($datatags_e["STATUS"]=="0"){ echo 'selected="selected"'; } ?>>Inactiva</option>
								</select>
						    </div>
					    </div>
					    <div class="row">
						    <div class="col-sm-6">
							    <div>&nbsp;</div>
							    <input type="submit" class="float-left btn btn-secondary" value="Edit user">
						    </div>
						    <div class="col-sm-6">
							    <div>&nbsp;</div>
							    <a href="administrators.php" class="float-right btn btn-danger">Cancelar</a>
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