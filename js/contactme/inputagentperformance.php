<?php

session_start();
require "api/backbone.php";


if(!isset($_SESSION['agro_userid']))
{
    header('location: ./');
}

$con=Agromall::conn();
$records =array();
@$anchor = $_POST['anchor'];
@$project = $_POST['project'];



if(isset($project))
{

    $records=Agromall::fetch_input_performance($project);


}











?>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

    <meta name="author" content="">

    <link rel="icon" href="https://theagromall.com/agmadmin/assets/images/fav.png">



    <title>AgroMall - Input Distribution Agent Performance</title>



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




    <!-- date picker -->

    <link rel="stylesheet" href="assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">



    <!-- daterange picker -->

    <link rel="stylesheet" href="assets/vendor_components/bootstrap-daterangepicker/daterangepicker.css">




    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->



    <!-- google font -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">


    <style>

        table{

            font-size:14px;

        }
        .nav-tabs .nav-link.active{
            border-bottom-color: #3BA403;
            background-color: #3BA403;/*#389af0*/
        }
        .nav-tabs .nav-link.active:hover,.nav-tabs .nav-link.active:focus{
            border-bottom-color: #018D00;
            background-color: #018D00;/*#389af0*/
        }


    </style>

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
    require_once 'menu.php';
    ?>



    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <h1>

                Input Distribution Agent Performance

                <small></small>

            </h1>

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="breadcrumb-item active">Input Distribution Agent Performance</li>

            </ol>



            <img src="img/farmer.png" style="width: 100%">

        </section>



        <!-- Main content -->

        <section class="content">

            <div class="row">

                <div class="col-xl-12 connectedSortable">

                    <form id="form1" action="inputagentperformance" method="post">
                        <div class="row">
                            <div class="col">
                                &nbsp;
                            </div>
                            <div class="col">
                                &nbsp;
                            </div>
                            <div class="col">
                                <label for="second_field">Select Anchor <span style="color: red">*<span>:</label>
                                <select class="form-control" name="anchor" id="anchor">
                                    <option selected disabled>&nbsp;&nbsp;</option>
                                    <?php
                                    $client = Agromall::fetch__client();

                                    for ($j=0;$j<count($client);$j++) {
                                        echo "<option value='".$client[$j]['client_id']."' >".$client[$j]['client_name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col">
                                <label for="project">Select Project: <span style="color: red">*<span>:</label>
                                <select class="form-control" name="project" id="project" required>
                                    <option selected>&nbsp;&nbsp;</option>
                                </select>
                            </div>


                            <div class="col">
                                <label>&nbsp;</label>
                                <input type="submit" name="search" value="Search" class="btn btn-success form-control">
                            </div>
                        </div>
                    </form>

                    <!-- LINE CHART -->
                    <?php
                    if(isset($anchor)){
                        ?>

                        <div class="box box-info">

                            <div class="box-body">



                                <div class="pad">
                                    <h4 class="text-center"><?php echo $anchor_name = Agromall::get_anchor_name($anchor) ?></h4>
                                    <h4 class="text-center"><?php echo @Agromall::get_project_id($con,$project); ?></h4>

                                    <table id="example" class="table table-striped table-bordered table-hover table-responsive">

                                        <thead>

                                        <tr>

                                            <th>#</th>
                                            <th>Agent</th>
                                            <th>Total Farmers</th>
                                            <th>State</th>


                                        </tr>

                                        </thead>

                                        <tbody>

                                        <?php




                                        for ($i=0;$i<count($records);$i++){

                                            ?>
                                            <tr>

                                                <td><?php echo $i+1 ?> </td>
                                                <td><?php echo $records[$i]['agent_id'] ?></td>
                                                <td><?php echo number_format($records[$i]['total']) ?></td>
                                                <td><?php echo @Agromall::get_state_name($records[$i]['state'],$con) ?></td>



                                            </tr>
                                            <?php

                                        }

                                        ?>

                                        </tbody>


                                    </table>
                                </div>
                            </div>


                        </div>

                    <?php  } ?>

                </div>

                <!-- /.box-body -->

            </div>

            <!-- /.box -->

    </div>

    <!-- /.col -->



</div>



</section>



<!-- /.content -->

</div>

<!-- /.content-wrapper -->

<footer class="main-footer">

    <div class="pull-right d-none d-sm-inline-block">



    </div>Copyright &copy; 2017 <a href="https://www.theagromall.com/">AgroMall</a>. All Rights Reserved.

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

<script src="assets/js/loader.js"></script>


<!-- Slimscroll -->

<script src="assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js"></script>




<!-- mixpro_admin App -->

<script src="js/template.js"></script>




<!-- This is data table -->

<script src="assets/vendor_plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js"></script>


<!-- start - This is for export functionality only -->

<script src="assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/dataTables.buttons.min.js"></script>

<script src="assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.flash.min.js"></script>

<script src="assets/vendor_plugins/DataTables-1.10.15/ex-js/jszip.min.js"></script>

<script src="assets/vendor_plugins/DataTables-1.10.15/ex-js/pdfmake.min.js"></script>

<script src="assets/vendor_plugins/DataTables-1.10.15/ex-js/vfs_fonts.js"></script>

<script src="assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.html5.min.js"></script>

<script src="assets/vendor_plugins/DataTables-1.10.15/extensions/Buttons/js/buttons.print.min.js"></script>


<script src="assets/js/spinloader.js"></script>




<script type="text/javascript">



    $(document).ready(function () {



        $(".viewrec").click(function(){

            var ldcontent=$(".loader-box").html();

            $(".modal-body").html(ldcontent);

            $(".modal-body").html('<center style="padding-top: 20%">Please Wait..</center>');



            //data

            var did=$(this).attr("data-id");



            //alert(did);



            //fetch ajax call

            $(".modal-body").load("api/farmerview.php?id="+did, function(response, status, xhr){

                if (status=='success'){

                    //

                }else{

                    $(".modal-body").html('Error loading data, please try again or check your internet connection.');

                    //toastr["error"]("Error Communicating With Server. <br> Please check your internet connection");

                }



            });





            //place data and hide inline loader

        });




        $('.close').click(function() {
            $('#myModal').modal('hide');

            console.log('yes');
        });


        // Append a caption to the table before the DataTables initialisation

        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            "pageLength": 50 } );



        $("#anchor").change(function(){

            $('.content-wrapper').spin("modal");

            var anchor=$(this).val();
            var fd=new FormData();

            fd.append('zid', anchor);

            $.ajax({
                url: 'api/projectloader.php?zid='+anchor,
                data: fd,
                processData: false,
                type: 'GET',
                success: function(data) {
                    $('.content-wrapper').spin("modal");
                    $("#project").html(data);
                    $("#state").html('');
                },error: function (res,f,b){
                    alert(res+f+b);
                }
            });
        });

        $("#project").change(function(){

            $('.content-wrapper').spin("modal");

            var project=$(this).val();
            var fd=new FormData();

            fd.append('pid', project);

            $.ajax({
                url: 'api/projectloader.php?pid='+project,
                data: fd,
                processData: false,
                type: 'GET',
                success: function(data) {
                    $('.content-wrapper').spin("modal");
                    $("#state").html(data);
                },error: function (res,f,b){
                    alert(res+f+b);
                }
            });
        });

    });

</script>



<!-- mixpro_admin for Data Table -->




</body>

</html>

