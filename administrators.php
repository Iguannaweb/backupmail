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
<?php if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){ ?>
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
			if($_POST["action"]=="crear"){
				//¿Existe el usuario? 
				$datauser_exist = mysqli_fetch_array(DBSelect('igw_members', '*', "WHERE usr = '".clear($_POST["username"])."'",'LIMIT 0,1'));
				
				if(isset($_POST["password1"]) && isset($_POST["password2"]) && ($_POST["password1"]==$_POST["password2"]) && ($datauser_exist["usr"]=="") && !empty($_POST["username"])){
					
				$opciones = [
				    'cost' => 11,
				    'salt' => openssl_random_pseudo_bytes(22),
				];
				$password_hash=password_hash($_POST["password1"], PASSWORD_BCRYPT, $opciones);
				$form_data = array(
				    'usr' => clear($_POST["username"]),
				    'pass' => clear($password_hash),
				    'email' => clear($_POST["email"]),
				    'tipo' => clear('ADM'),
				    'activo' => clear('1'),
				    'dt' => clear(date('Y-m-d H:i:s'))
				);
				
				
				if(DBInsert('igw_members', $form_data)){
						$last = mysqli_fetch_array(DBSelect('igw_members', '*', "",'ORDER BY id DESC','LIMIT 0,1'));
						
						$form_data = array(
							'id_member' => clear((int)$last["id"]),
						    'nombre' => clear($_POST["user_name"]),
						    'apellidos' => clear($_POST["user_surname"]),
						    'tlf' => clear($_POST["telephone"]),
						    'tlf_movil' => clear($_POST["mobile"]),
						    'correo' => clear($_POST["email"]),
						);
						
						
						if(DBInsert('igw_adm', $form_data)){
							echo '<div class="row"><div class="col-md-12"><div class="alert alert-success fade show">
								  <span class="close" data-dismiss="alert">×</span>
								  <strong>¡Felicidades!</strong>
								  Se ha creado la nueva cuenta de administrador 
								</div></div></div>';
						}else{
							echo '<div class="row"><div class="col-md-12"><div class="alert alert-danger fade show">
								  <span class="close" data-dismiss="alert">×</span>
								  <strong>¡Error!</strong>
								  Hubo un problema al crear la nueva cuenta de administrador. 
								</div></div></div>';
						}
				}else{
					echo '<div class="row"><div class="col-md-12"><div class="alert alert-danger fade show">
						  <span class="close" data-dismiss="alert">×</span>
						  <strong>¡Error!</strong>
						  Hubo un problema al crear la nueva cuenta de administrador. 
						</div></div></div>';
				}
				
				}else{
					echo '<div class="row"><div class="col-md-12"><div class="alert alert-danger fade show">
						  <span class="close" data-dismiss="alert">×</span>
						  <strong>¡Error!</strong>
						  Hubo un problema al crear la nueva cuenta de administrador. Por favor, revisa que las contraseñas sean iguales.
						</div></div></div>';
				}
					
				
				
			
			}
			
			if($_POST["action"]=="editar"){
				
				if(isset($_POST["password1"]) && isset($_POST["password2"]) && ($_POST["password1"]==$_POST["password2"])){
					
				$opciones = [
				    'cost' => 11,
				    'salt' => openssl_random_pseudo_bytes(22),
				];
				$password_hash=password_hash($_POST["password1"], PASSWORD_BCRYPT, $opciones);
				$form_data = array(
				    'usr' => clear($_POST["username"]),
				    'pass' => clear($password_hash),
				    'email' => clear($_POST["email"]),
				    'activo' => clear((int)$_POST["activo"]),
				    'dt' => clear(date('Y-m-d H:i:s'))
				);
				
				}else{
				
				$form_data = array(
				    'usr' => clear($_POST["username"]),
				    'email' => clear($_POST["email"]),
				    'activo' => clear('1'),
				    'dt' => clear(date('Y-m-d H:i:s'))
				);
				
				}
				
				//echo '<pre>';print_r($form_data);echo '</pre>';
				//echo ''.clear((int)$_POST["ID_TAG"]).'';
				if(DBUpdate('igw_members', $form_data,"WHERE id='".clear((int)$_POST["id"])."'")){
					$form_data = array(
							'id_member' => clear((int)$_POST["id"]),
						    'nombre' => clear($_POST["user_name"]),
						    'apellidos' => clear($_POST["user_surname"]),
						    'tlf' => clear($_POST["telephone"]),
						    'tlf_movil' => clear($_POST["mobile"]),
						    'correo' => clear($_POST["email"]),
						);
					if(DBUpdate('igw_adm', $form_data,"WHERE id_member='".clear((int)$_POST["id"])."'")){
						echo '<div class="row"><div class="col-md-12"><div class="alert alert-success fade show">
							  <span class="close" data-dismiss="alert">×</span>
							  <strong>¡Felicidades!</strong>
							  Se ha editado la cuenta correctamente 
							</div></div></div>';
					}else{
						echo '<div class="row"><div class="col-md-12"><div class="alert alert-danger fade show">
							  <span class="close" data-dismiss="alert">×</span>
							  <strong>¡Error!</strong>
							  Hubo un problema al editar la cuenta. 
							</div></div></div>';
					}
						
						
				}else{
					echo '<div class="row"><div class="col-md-12"><div class="alert alert-danger fade show">
						  <span class="close" data-dismiss="alert">×</span>
						  <strong>¡Error!</strong>
						  Hubo un problema al editar la cuenta. 
						</div></div></div>';
				}
			
			}
			
			if($_GET["sms"]=="OK"){
				
			echo '<div class="row"><div class="col-md-12"><div class="alert alert-success fade show">
							  <span class="close" data-dismiss="alert">×</span>
							  <strong>¡Felicidades!</strong>
							  La cuenta se ha borrado correctamente 
							</div></div></div>';
			}elseif($_GET["sms"]=="ERROR"){
				echo '<div class="row"><div class="col-md-12"><div class="alert alert-danger fade show">
					  <span class="close" data-dismiss="alert">×</span>
					  <strong>¡Error!</strong>
					  Hubo un problema al borrar la cuenta. 
					</div></div></div>';
			}
				
			
			
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
						$datauser = DBSelect('igw_members', '*', "",'ORDER BY usr ASC');
	
						$i=0;
						
						while($rowt=mysqli_fetch_array($datauser)){
							$datauser_children[$i] = mysqli_fetch_array(DBSelect('igw_adm', '*', "WHERE id_member = '".$rowt["id"]."'",' LIMIT 0,1'));
							echo '<li class="nav-item"><a class="nav-link" href="administrators.php?u='.$rowt["id"].'&a=edit"><i class="fa fa-user"></i> '.$datauser_children[$i]["nombre"].' '.$datauser_children[$i]["apellidos"].' ('.$rowt["usr"].')</a></li>';
							
						}
					?>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          
        </div>
        <!-- /.col -->
        <div class="col-md-9">
	        <?php if($_GET["a"]=="edit"){ 
					
					$datauser_e = mysqli_fetch_array(DBSelect('igw_members', '*', "WHERE id = '".(int)$_GET["u"]."'",'LIMIT 0,1'));
					$datauser_ed = mysqli_fetch_array(DBSelect('igw_adm', '*', "WHERE id_member = '".(int)$_GET["u"]."'",'LIMIT 0,1'));
					}
					
				?>
          <div class="card card-secondary card-outline">
            <div class="card-header">
	          <?php if($_GET["a"]=="edit"){ ?><a onclick="return confirm('¿Estás seguro que quieres borrar este usuario?');" href="./administrators.php?u=<?php echo $datauser_e["id"]; ?>&a=delete" class="text-red float-right">Delete this user</a> <?php } ?>
              <h3 class="card-title">
	              <?php if(!isset($_GET["a"])){ ?><i class="fas fa-user"></i> Add new user<?php } ?>
	              <?php if($_GET["a"]=="edit"){ 
					
					
					
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
				    <form method="post" action="administrators.php">
					    <input type="hidden" name="action" value="crear"/>
					    <div class="row">
							<div class="col-sm-6">
								<strong>Name</strong>
								<input class="form-control" type="text" name="user_name" id="user_name" placeholder="Your name" />
							</div>
							<div class="col-sm-6">
								<strong>Surname</strong>
								<input class="form-control" type="text" name="user_surname" id="user_surname" placeholder="Your surname"/>
							</div>
							
					    </div>
					    
					    <div class="row">
						    <div class="col-sm-4">
								<strong>Telephone</strong>
								<input class="form-control" type="text" name="telephone" id="telephone" placeholder="Phone" />
							</div>
						    <div class="col-sm-4">
								<strong>Mobile telephone</strong>
								<input class="form-control" type="text" name="mobile" id="mobile" placeholder="Mobile phone" />
							</div>
							<div class="col-sm-4">
								<strong>E-mail</strong>
								<input class="form-control" type="text" name="email" id="email" placeholder="Email address" />
							</div>
					    </div>
					    
					    <div class="row">
							<div class="col-sm-4">
								<strong>Username</strong>
								<input class="form-control" type="text" name="username" id="username" placeholder="Your login name" required="required"/>
							</div>
							<div class="col-sm-4">
								<strong>New Password</strong>
								<input class="form-control" type="text" name="password1" id="password1" placeholder=""  required="required"/>
							</div>
							<div class="col-sm-4">
								<strong>Repeat Password</strong>
								<input class="form-control" type="text" name="password2" id="password2" placeholder=""  required="required"/>
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
				    <form method="post" action="administrators.php?u=<?php echo (int)$_GET["u"]; ?>&a=edit">
					    <input type="hidden" name="action" value="editar"/>
					    <input type="hidden" name="id" value="<?php echo $datauser_e["id"]; ?>"/>
					   
					    
					    
					    <div class="row">
							<div class="col-sm-4">
								<strong>Name</strong>
								<input class="form-control" type="text" name="user_name" id="user_name" placeholder="Your name" value="<?php echo $datauser_ed["nombre"]; ?>"/>
							</div>
							<div class="col-sm-4">
								<strong>Surname</strong>
								<input class="form-control" type="text" name="user_surname" id="user_surname" placeholder="Your surname" value="<?php echo $datauser_ed["apellidos"]; ?>"/>
							</div>
							
							<div class="col-sm-4">
							    <strong>Estado de usuario</strong>
								<select class="form-control" name="activo" id="activo">
									<option value="1" <?php if($datauser_e["activo"]=="1"){ echo 'selected="selected"'; } ?>>Activa</option>
									<option value="0" <?php if($datauser_e["activo"]=="0"){ echo 'selected="selected"'; } ?>>Inactiva</option>
								</select>
						    </div>
							
					    </div>
					    
					    <div class="row">
						    <div class="col-sm-4">
								<strong>Telephone</strong>
								<input class="form-control" type="text" name="telephone" id="telephone" placeholder="Phone"  value="<?php echo $datauser_ed["tlf"]; ?>"/>
							</div>
						    <div class="col-sm-4">
								<strong>Mobile telephone</strong>
								<input class="form-control" type="text" name="mobile" id="mobile" placeholder="Mobile phone"  value="<?php echo $datauser_ed["tlf_movil"]; ?>"/>
							</div>
							<div class="col-sm-4">
								<strong>E-mail</strong>
								<input class="form-control" type="text" name="email" id="email" placeholder="Email address"  value="<?php echo $datauser_e["email"]; ?>" />
							</div>
					    </div>
					    
					    <div class="row">
							<div class="col-sm-4">
								<strong>Username</strong>
								<input class="form-control" type="text" name="username" id="username" placeholder="Your login name" required="required" value="<?php echo $datauser_e["usr"]; ?>"/>
							</div>
							<div class="col-sm-4">
								<strong>New Password</strong>
								<input class="form-control" type="text" name="password1" id="password1" placeholder=""  />
							</div>
							<div class="col-sm-4">
								<strong>Repeat Password</strong>
								<input class="form-control" type="text" name="password2" id="password2" placeholder=""  />
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
			
							
<?php } ?>		
<?php include('./igw_template/footer.php'); ?>