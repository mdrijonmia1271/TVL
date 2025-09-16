<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="icon" type="text/css" href="<?= base_url('images/favicon.ico'); ?>">

    <title>myTVL</title>

    <!--Core CSS -->
    <link href="<?php echo base_url(); ?>smdesign/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>smdesign/css/bootstrap-reset.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>smdesign/assets/font-awesome/css/font-awesome.css" rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>smdesign/landing/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>smdesign/css/style-responsive.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>-->
    <![endif]-->
</head>

<body class="">

<div class="login-body">
    <div class="container landing">


        <div class="row">
            <div>

                <h2>
                    <img src="<?= base_url('smdesign/images/Logo.png') ?>" alt="school logo">
                        <br>
                        <br>

                    myTVL SERVICE MANAGEMENT SYSTEM
                </h2>
            </div>

        </div>


        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="row login-block">
                    <div class="col-sm-3"><a href="<?= site_url('sm/login/index') ?>" target="_blank"><img class="img-responsive" src="<?= base_url('images/login/admin.png') ?>" alt="Admin Login"><span class="btn btn-primary btn-lg">User Login</span></a></div>
                    <div class="col-sm-3"><a href="<?= site_url('sm/login/eng_login') ?>" target="_blank"><img class="img-responsive" src="<?= base_url('images/login/engn.jpg') ?>" alt="Eng. Login"><span class="btn btn-primary btn-lg">Service Eng. Login</span></a></div>
                    <div class="col-sm-3"><a href="<?= site_url('sm/login/customer_login') ?>" target="_blank"><img class="img-responsive" src="<?= base_url('images/login/parents.png') ?>" alt="Customer Login"><span class="btn btn-primary btn-lg">Customer Login</span></a></div>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script src="<?php echo base_url(); ?>smdesign/js/lib/jquery.js"></script>
<script src="<?php echo base_url(); ?>smdesign/bs3/js/bootstrap.min.js"></script>

</body>
</html>
