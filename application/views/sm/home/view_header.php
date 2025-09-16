<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="BIGM Service Management">
        <meta name="author" content="BIGM">
        <link rel="icon" type="text/css" href="<?= base_url('images/favicon.ico'); ?>">

        <title>myTVL</title>



        <!--Core CSS -->
        <link href="<?php echo base_url() . 'smdesign/'; ?>bs3/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() . 'smdesign/'; ?>css/bootstrap-reset.css" rel="stylesheet">
        <link href="<?php echo base_url() . 'smdesign/'; ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'smdesign/'; ?>assets/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'smdesign/'; ?>assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'smdesign/'; ?>assets/bootstrap-datetimepicker/css/datetimepicker.css" />




        <!-- Custom styles for this template -->
        <link href="<?php echo base_url() . 'smdesign/'; ?>css/style.css" rel="stylesheet">
        <link href="<?php echo base_url() . 'smdesign/'; ?>css/style-responsive.css" rel="stylesheet" />
        <!--responsive table-->
       <link href="<?php echo base_url() . 'smdesign/'; ?>css/table-responsive.css" rel="stylesheet" />


        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]><script src="js/ie8/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo base_url() . 'smdesign/'; ?>js/worker.js"></script>
        <style>
            .error{color:red!important;}
        </style>

        <script>
            var BASE_URI = '<?php echo base_url(); ?>'
        </script>

    </head>

    <body class="full-width">

        <section id="container" class="">


             <?php $this->load->view('sm/home/view_nav_menu');?>



            <!--main content start-->
            <section id="main-content">
                <section class="wrapper">