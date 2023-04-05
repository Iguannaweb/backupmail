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
<?php 
if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){  }else{ header('Location: index.php'); }
if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){ ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <div class="container-fluid">
		<div class="row mb-2">
		  <div class="col-sm-6">
			<h1>Stats</h1>
		  </div>
		  <div class="col-sm-6">
			<ol class="breadcrumb float-sm-right">
			  <li class="breadcrumb-item"><a href="#">Home</a></li>
			  <li class="breadcrumb-item active">Stats</li>
			</ol>
		  </div>
		</div>
	  </div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
		<div class="col-md-3">
			<div class="card">
				<div class="card-header">
				  <h3 class="card-title">Condition stats list <a href="javascripts:return false;" class="toastrDefaultInfo"><i class="fas fa-info-circle"></i></a></h3>
			
				  <div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
					</button>
				  </div>
				</div>
				<div class="card-body p-0">
				  <ul class="nav nav-pills flex-column">
					  
					  <?php
					  echo '<li class="nav-item"><a class="nav-link" href="stats.php?f=general&view=1"><i class="fas fa-fw f-s-10 m-r-5 fa-chart-bar text-primary"></i> 0 - General</a></li>';
							
							/*$datatags = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '0'",'ORDER BY POSICION ASC');
			
							$i=0;
							
							while($rowt=mysqli_fetch_array($datatags)){
								echo '<li class="nav-item"><a class="nav-link" href="tags.php?t='.$rowt["ID_TAG"].'&a=edit"><i class="fa'.$rowt["ICON_S"].' fa-fw f-s-10 m-r-5 fa-'.$rowt["TAG_ICON"].' text-'.$rowt["TAG_COLOR"].'"></i> '.$rowt["POSICION"].' - '.$rowt["TAG"].' ('.get_tag_count($rowt["ID_TAG"]).')</a></li>';
								$datatags_children[$i] = DBSelect('igw_tags', '*', "WHERE ID_TAG_SUP = '".$rowt["ID_TAG"]."'",'ORDER BY POSICION ASC');
								while($rowt_children[$i]=mysqli_fetch_array($datatags_children[$i])){
								echo '<li class="nav-item m-l-10"><a class="nav-link" href="tags.php?t='.$rowt_children[$i]["ID_TAG"].'&a=edit"><i class="fa'.$rowt_children[$i]["ICON_S"].' fa-fw f-s-10 m-r-5 fa-'.$rowt_children[$i]["TAG_ICON"].' text-'.$rowt_children[$i]["TAG_COLOR"].'"></i> '.$rowt_children[$i]["POSICION"].' - '.$rowt_children[$i]["TAG"].' ('.get_tag_count($rowt_children[$i]["ID_TAG"]).')</a></li>';
								}
							}*/
						?>
				  </ul>
				</div>
				<!-- /.card-body -->
			  </div>
		</div>
		<div class="col-md-9">	
			<div class="row">
				<?php 
				//echo '<pre>';print_r(get_stats());echo '</pre>'; 
				?>
				<div class="col-md-6">
					<!-- AREA CHART -->
					<!-- div class="card card-primary">
					  <div class="card-header">
						<h3 class="card-title">Area Chart</h3>
				
						<div class="card-tools">
						  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						  </button>
						  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
						</div>
					  </div>
					  <div class="card-body">
						<div class="chart">
						  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
						</div>
					  </div>
					 
					</div -->
					<!-- /.card -->
				
					<!-- DONUT CHART -->
					<!--div class="card card-danger">
					  <div class="card-header">
						<h3 class="card-title">Donut Chart</h3>
				
						<div class="card-tools">
						  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						  </button>
						  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
						</div>
					  </div>
					  <div class="card-body">
						<canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
					  </div>
					</div -->
					<!-- /.card -->
				
					<!-- PIE CHART -->
					<div class="card card-dark">
					  <div class="card-header">
						<h3 class="card-title">Year stats</h3>
				
						<div class="card-tools">
						  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						  </button>
						  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
						</div>
					  </div>
					  <div class="card-body">
						<canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
					  </div>
					  <!-- /.card-body -->
					</div>
					<!-- /.card -->
				
				  </div>
				  <!-- /.col (LEFT) -->
				  <div class="col-md-6">
					<!-- LINE CHART -->
					<!-- div class="card card-info">
					  <div class="card-header">
						<h3 class="card-title">Line Chart</h3>
				
						<div class="card-tools">
						  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						  </button>
						  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
						</div>
					  </div>
					  <div class="card-body">
						<div class="chart">
						  <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
						</div>
					  </div>
					</div -->
					<!-- /.card -->
				
					<!-- BAR CHART -->
					<div class="card card-dark">
					  <div class="card-header">
						<h3 class="card-title">Month stats</h3>
				
						<div class="card-tools">
						  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						  </button>
						  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
						</div>
					  </div>
					  <div class="card-body">
						<div class="chart">
						  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
						</div>
					  </div>
					  <!-- /.card-body -->
					</div>
					<!-- /.card -->
				
					<!-- STACKED BAR CHART -->
					<!-- div class="card card-success">
					  <div class="card-header">
						<h3 class="card-title">Stacked Bar Chart</h3>
				
						<div class="card-tools">
						  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						  </button>
						  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
						</div>
					  </div>
					  <div class="card-body">
						<div class="chart">
						  <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
						</div>
					  </div>
					</div -->
					<!-- /.card -->
				
				  </div>
				  <!-- /.col (RIGHT) -->
				  
				  <div class="col-md-12">
					  <div class="card card-dark">
						<div class="card-header">
						  <h3 class="card-title">Hours stats</h3>
					  
						  <div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
						  </div>
						</div>
						<div class="card-body">
						  <div class="chart">
							<canvas id="barCharth" style="min-height: 550px; height: 550px; max-height: 550px; max-width: 100%;"></canvas>
						  </div>
						</div>
						<!-- /.card-body -->
					  </div>
				  </div>
			</div>
			  
		<!-- /.col -->
		</div>
	<!-- /.row -->
	</section>
	<!-- /.content -->
</div>			
						
										
<?php } ?>		
<?php include('./igw_template/footer.php'); ?>