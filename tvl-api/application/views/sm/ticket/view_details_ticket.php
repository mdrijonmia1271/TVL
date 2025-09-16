<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
<div class="col-md-12">
<h3 class="prf-border-head">Ticket Details</h3>
<section class="panel" style="background-color: #fff;">

<div class="panel-body profile-information">
<div class="col-md-3">
<!--<div class="profile-pic text-center">
<img alt="img" width="60" height="40" src="<?php // echo base_url() . 'upload/customer_image/' . $view->customer_id . '/' . $view->picture ?>"/>
</div>-->
</div>
<div class="col-md-6">
<div class="profile-desk">
<h1>Ticket No: <?php echo $view->ticket_no; ?></h1>
<span class="text-muted">Owner:
    <?php $getCustomerName = get_customer_name_by_id($view->send_from);echo$getCustomerName ; ?>
</span>
<br>
<p> Assign To:
<?php  $getServiceEngName = getServiceEngName($view->send_to);echo $getServiceEngName; ?>
</p>
<br>
<p>Subject:
<?php echo $view->subject; ?>
</p>
<br>
<p>Details:
<?php echo $view->request_details; ?>
</p>
<!--<a class="btn btn-primary" href="#">View Profile</a>-->
</div>
</div>
<div class="col-md-3">
<div class="profile-statistics">
<h1><?php echo get_division_by_id($view->service_add_division); ?></h1>
<p>Division</p>
<h1><?php echo get_district_by_id($view->service_add_district); ?></h1>
<p>District</p>

</div>
</div>
</div>
</section>
</div>

</div>








<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>    