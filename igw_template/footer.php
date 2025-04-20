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
if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){
?>
</div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <?php echo '<a title="'.$lang_content_footer_name_title.'" href="https://github.com/Iguannaweb/backupmail">'.$lang_content_footer_name.' <img alt="GitHub milestone" src="https://img.shields.io/github/milestones/progress-percent/Iguannaweb/backupmail/1"></a>'; ?>
    </div>
    <!-- Default to the left -->
    <strong> &copy; <?php echo date('Y');?> <a href="https://www.iguannaweb.com"><?php echo $lang_content_footer_igw_copy; ?></a>.</strong>
  </footer>
</div>
<!-- ./wrapper -->
<?php
}
?> 
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
<!-- Notifications -->
<script src="vendor/almasaeed2010/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="vendor/almasaeed2010/adminlte/plugins/toastr/toastr.min.js"></script>
<!-- ChartJS -->
<script src="vendor/almasaeed2010/adminlte/plugins/chart.js/Chart.min.js"></script>
<?php
if(isset($_SESSION['id']) && isset($activo['activo']) && ($activo['activo']==1) && ($activo['tipo']=="ADM")){
?>
<!-- Page Script -->
<script>
  $(function () {
    //Enable check and uncheck all functionality
    $('.checkbox-toggle').click(function () {
      var clicks = $(this).data('clicks')
      if (clicks) {
        //Uncheck all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
        $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
      } else {
        //Check all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
        $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
      }
      $(this).data('clicks', !clicks)
    })

    //Handle starring for glyphicon and font awesome
    /*$('.mailbox-star').click(function (e) {
      e.preventDefault()
      //detect type
      var $this = $(this).find('a > i')
      var glyph = $this.hasClass('glyphicon')
      var fa    = $this.hasClass('fa')

      //Switch states
      if (glyph) {
        $this.toggleClass('glyphicon-star')
        $this.toggleClass('glyphicon-star-empty')
      }

      if (fa) {
        $this.toggleClass('fa-star')
        $this.toggleClass('fa-star-o')
      }
    })*/
  })
</script>
<script type="text/javascript">
  /*$(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $('.swalDefaultSuccess').click(function() {
      Toast.fire({
        type: 'success',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultInfo').click(function() {
      Toast.fire({
        type: 'info',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultError').click(function() {
      Toast.fire({
        type: 'error',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultWarning').click(function() {
      Toast.fire({
        type: 'warning',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultQuestion').click(function() {
      Toast.fire({
        type: 'question',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });

    $('.toastrDefaultSuccess').click(function() {
      toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultInfo').click(function() {
      toastr.info('Clic one tag from de list to edit at the form on the right.')
    });
    $('.toastrDefaultError').click(function() {
      toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultWarning').click(function() {
      toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });

    $('.toastsDefaultDefault').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultTopLeft').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'topLeft',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultBottomRight').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'bottomRight',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultBottomLeft').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'bottomLeft',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultAutohide').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        autohide: true,
        delay: 750,
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultNotFixed').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        fixed: false,
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultFull').click(function() {
      $(document).Toasts('create', {
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        icon: 'fas fa-envelope fa-lg',
      })
    });
    $('.toastsDefaultFullImage').click(function() {
      $(document).Toasts('create', {
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        image: '../../dist/img/user3-128x128.jpg',
        imageAlt: 'User Picture',
      })
    });
    $('.toastsDefaultSuccess').click(function() {
      $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultInfo').click(function() {
      $(document).Toasts('create', {
        class: 'bg-info', 
        title: 'Tags',
        subtitle: 'Do you want to edit a tag?',
        body: 'Clic one tag from de list to edit at the form on the right.'
      })
    });
    $('.toastsDefaultWarning').click(function() {
      $(document).Toasts('create', {
        class: 'bg-warning', 
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultDanger').click(function() {
      $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultMaroon').click(function() {
      $(document).Toasts('create', {
        class: 'bg-maroon', 
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
  });*/
  
</script>
<!-- AdminLTE for demo purposes -->
<!-- script src="vendor/almasaeed2010/adminlte/dist/js/demo.js"></script -->

<!-- page script -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    <?php $data_stats=get_stats(); ?>

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutData        = {
      labels: [
        <?php 
        foreach($data_stats[2] as $keya=>$anio){
          if(strstr($keya,'-')){ }else{  echo "'".$keya."',"; }
        }
        ?>
      ],
      datasets: [
        {
          data: [<?php 
          foreach($data_stats[2] as $keya=>$anio){
            if(strstr($keya,'-')){ }else{ echo "".(int)$anio.","; }
          }
          ?>],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'], //, '#3c8dbc', '#d2d6de'
        }
      ]
    }
    
    
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })
    
    <?php
    $color_stats=array(
      "0" => "60,141,188",
      "1" => "210, 214, 222",
      "2" => "210, 114, 222",
      "3" => "310, 114, 222",
      "4" => "110, 114, 222",
      "5" => "310, 214, 222",
    );
    ?>
    
    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October','November','December'],
      datasets: [
       <?php 
       $a=0;
       foreach($data_stats[2] as $keya=>$anio){
         if(strstr($keya,'-')){ }else{
           
            echo "{
             label               : '".$keya."',
             backgroundColor     : 'rgba(".$color_stats[$a].",0.9)',
             borderColor         : 'rgba(".$color_stats[$a].",0.8)',
             pointRadius          : false,
             pointColor          : '#3b8bba',
             pointStrokeColor    : 'rgba(".$color_stats[$a].",1)',
             pointHighlightFill  : '#fff',
             pointHighlightStroke: 'rgba(".$color_stats[$a].",1)',
             data                : ["; 
             //5, 20, 30, 19, 86, 27, 11, 20, 30, 19, 86, 27
             for($i=1; $i<=12; $i++){
               echo ''.$data_stats[3]["".$keya."-".str_pad($i,2,"0",STR_PAD_LEFT).""].',';
             }
            echo "]
           },";
           $a++;
         }
       }
       ?>
        /*{
          label               : '2022',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [5, 20, 30, 19, 86, 27, 11, 20, 30, 19, 86, 27]
        },
        {
          label               : '2021',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [45, 59, 80, 81, 56, 55, 65, 59, 80, 81, 56, 55]
        },
        {
          label               : '2020',
          backgroundColor     : 'rgba(210, 114, 222, 1)',
          borderColor         : 'rgba(210, 114, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 114, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 65, 59, 80, 81, 56, 55]
        },*/
      ]
    }
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    var temp2 = areaChartData.datasets[2]
    barChartData.datasets[0] = temp0
    barChartData.datasets[1] = temp1
    barChartData.datasets[2] = temp2

    var barChartOptions = {
      responsive              : false,
      maintainAspectRatio     : false,
      datasetFill             : false,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })
    
    
    var areaChartDatah = {
      labels  : ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
      datasets: [
        <?php 
         $a=0;
         foreach($data_stats[2] as $keya=>$anio){
           if(strstr($keya,'-')){ }else{
             
              echo "{
               label               : '".$keya."',
               backgroundColor     : 'rgba(".$color_stats[$a].",0.9)',
               borderColor         : 'rgba(".$color_stats[$a].",0.8)',
               pointRadius          : false,
               pointColor          : '#3b8bba',
               pointStrokeColor    : 'rgba(".$color_stats[$a].",1)',
               pointHighlightFill  : '#fff',
               pointHighlightStroke: 'rgba(".$color_stats[$a].",1)',
               data                : ["; 
               //5, 20, 30, 19, 86, 27, 11, 20, 30, 19, 86, 27
               for($i=0; $i<=23; $i++){
                 echo ''.$data_stats[4]["".$keya."-".str_pad($i,2,"0",STR_PAD_LEFT).""].',';
               }
              echo "]
             },";
             $a++;
           }
         }
         ?>
        /*{
          label               : '2022',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [5, 20, 30, 19, 86, 27, 11, 20, 30, 19, 86, 27, 5, 20, 30, 19, 86, 27, 11, 20, 30, 19, 86, 27]
        },
        {
          label               : '2021',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [45, 59, 80, 81, 56, 55, 65, 59, 80, 81, 56, 55,45, 59, 80, 81, 56, 55, 65, 59, 80, 81, 56, 55]
        },
        {
          label               : '2020',
          backgroundColor     : 'rgba(210, 114, 222, 1)',
          borderColor         : 'rgba(210, 114, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 114, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 65, 59, 80, 81, 56, 55,45, 59, 80, 81, 56, 55, 65, 59, 80, 81, 56, 55]
        },*/
      ]
    }
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvash = $('#barCharth').get(0).getContext('2d')
    var barChartDatah = jQuery.extend(true, {}, areaChartDatah)
    var temph0 = areaChartDatah.datasets[0]
    var temph1 = areaChartDatah.datasets[1]
    var temph2 = areaChartDatah.datasets[2]
    barChartDatah.datasets[0] = temph0
    barChartDatah.datasets[1] = temph1
    barChartDatah.datasets[2] = temph2
    
    var barChartOptionsh = {
      responsive              : false,
      maintainAspectRatio     : false,
      datasetFill             : false,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
    
    var barCharth = new Chart(barChartCanvash, {
      type: 'bar', 
      data: barChartDatah,
      options: barChartOptionsh
    })

    
  })
</script>
<?php include('./igw_template/js_footer.php'); ?>
<?php
}
?>
</body>
</html>