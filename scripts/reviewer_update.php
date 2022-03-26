<?php

require "api/backbone.php";

if(!isset($_SESSION['agro_userid']))
{
    header('location: ./');
}

$reviewer = $_SESSION['agro_userid'];
$con=Agromall::conn();
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://theagromall.com/boa/assets/images/fav.png">

    <title>Reviewer Performance - Agromall</title>

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="assets/vendor_components/bootstrap/dist/css/bootstrap.css">

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="assets/vendor_components/bootstrap/dist/css/bootstrap-extend.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="assets/vendor_components/font-awesome/css/font-awesome.css">

    <!-- ionicons -->
    <link rel="stylesheet" href="assets/vendor_components/Ionicons/css/ionicons.css">

    <!-- theme style -->
    <link rel="stylesheet" href="css/master_style.css">

    <!-- mixpro_admin skins. choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="css/skins/_all-skins.css">

    <!-- weather weather -->
    <link rel="stylesheet" href="assets/vendor_components/weather-icons/weather-icons.css">

    <!-- jvectormap -->
    <link rel="stylesheet" href="assets/vendor_components/jvectormap/jquery-jvectormap.css">

    <!-- date picker -->
    <link rel="stylesheet" href="assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">

    <!-- daterange picker -->
    <link rel="stylesheet" href="assets/vendor_components/bootstrap-daterangepicker/daterangepicker.css">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">


</head>

<body class="hold-transition skin-purple-light sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="img/fav.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="img/fav.png"></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <?php
    include_once 'menu.php';
    ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Summary Of Reviewer Performance
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="breadcrumb-item active">Reviewer Performance</li>
            </ol>

            <img src="img/agent.png" style="width: 100%">
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xl-12 connectedSortable">
                    <!-- LINE CHART -->
                    <div class="box box-info">
                        <div class="box-body">
                            <table id="example" class="table table-bordered table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Review Date</th>
                                    <th>Reviewer</th>
                                    <th>Record Count</th>

                                    <!--th>Actions</th-->
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                //$data=json_decode(Agromall::fetch_farm(),true);
                                $data=Agromall::reviewer_performance($reviewer);
                                //print_r(Agromall::fetch_farm());
                                for ($i=0;$i<count($data);$i++){
                                    echo '<tr>
                            <td>'.($i+1).'</td>                        
                                                                  
                            <td>'.$data[$i]['ReviewDate'].'</td>                        
                            <td>'.$data[$i]['Reviewer'].'</td>                        
                            <td>'.$data[$i]['Count'].'</td>                        
                                               
                            ';
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>

                            </table>



                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right d-none d-sm-inline-block">

        </div>Copyright &copy; 2017 <a href="https://www.theagromall.com/">Agromall</a>. All Rights Reserved.
    </footer>



    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->



<!-- jQuery 3 -->
<script src="assets/vendor_components/jquery/dist/jquery.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="assets/vendor_components/jquery-ui/jquery-ui.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- popper -->
<script src="assets/vendor_components/popper/dist/popper.min.js"></script>

<!-- Bootstrap 4.0-->
<script src="assets/vendor_components/bootstrap/dist/js/bootstrap.js"></script>

<!-- ChartJS -->
<script src="assets/vendor_components/chart-js/chart.js"></script>

<!-- Sparkline -->
<script src="assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.js"></script>

<!-- jvectormap -->
<script src="assets/vendor_plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/vendor_plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- jQuery Knob Chart -->
<script src="assets/vendor_components/jquery-knob/js/jquery.knob.js"></script>

<!-- daterangepicker -->
<script src="assets/vendor_components/moment/min/moment.min.js"></script>
<script src="assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- datepicker -->
<script src="assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script>

<!-- Slimscroll -->
<script src="assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js"></script>

<!-- FastClick -->
<script src="assets/vendor_components/fastclick/lib/fastclick.js"></script>

<!-- mixpro_admin App -->
<script src="js/template.js"></script>

<!-- mixpro_admin dashboard demo (This is only for demo purposes) -->
<script src="js/pages/dashboard.js"></script>

<!-- mixpro_admin for demo purposes -->
<script src="js/demo.js"></script>

<!-- weather for demo purposes -->
<script src="assets/vendor_plugins/weather-icons/WeatherIcon.js"></script>

<!-- This is data table -->
<script src="assets/vendor_plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js"></script>

<!-- Modal -->


<!-- start - This is for export functionality only -->
<script src="assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="assets/vendor_plugins/DataTables-1.10.15/ex-js/jszip.min.js"></script>
<script src="assets/vendor_plugins/DataTables-1.10.15/ex-js/pdfmake.min.js"></script>
<script src="assets/vendor_plugins/DataTables-1.10.15/ex-js/vfs_fonts.js"></script>
<script src="assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.print.min.js"></script>

<div class="loader-box">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        <?php

        if($_SESSION['role']!=0){

        ?>

        $('#example').DataTable( {		dom: 'Bfrtip',		buttons: [			'copy', 'csv', 'excel', 'pdf', 'print'		]	} );

        <?php }
        else {
        ?>

        $('#example').DataTable();

        <?php } ?>

    });
</script>

<style>
    table{
        font-size:14px;
    }
</style>
</body>
</html>
