<?php
$this->load->view('sm/home/view_header');
?>  
<!-- Main Content Wrapper -->
<!-- Main Content Wrapper -->
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<b>Ticket Search </b>
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-cog"></a>
<!--<a href="javascript:;" class="fa fa-times"></a>-->
</span>
</header>
<div class="panel-body">
<form role="form" class="form-horizontal bucket-form" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/ticket/ticketsearch'; ?>">
<div class="form-group">

<div class="col-lg-12">
<div class="row"> 
<label for="inputSuccess" class="col-sm-1 control-label col-lg-1"> Ticket No</label>
<div class="col-lg-3">
<input type="text" name="ticket_no" placeholder="Ticket Name" class="form-control">
</div>

<!--<label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Send from</label>
<div class="col-lg-3">
<input type="text" name="send_from"  placeholder="send from" class="form-control">
</div>-->

<label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Subject</label>
<div class="col-lg-3">
<input type="text" name="subject"  placeholder="subject" class="form-control">
</div>


</div>
</div>

<div class="col-lg-12">
<br>
<div class="row">                                

<label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Status</label>
<div class="col-lg-3"  placeholder="Status">
<select  name="status" class="form-control m-bot3">
<option value="A">Active</option>
<option value="I">InActive</option>

</select>

</div>

<div class="col-lg-3">
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;
<button class="btn btn-success" type="submit">Search</button>
</div>

</div>
</div>
</div>

</form>
</div>
</section>
</div>
</div>


<b>Ticket List (<?php echo $total_rows; ?>)</b>



<div class="row">
<br>
<div class="col-md-12">

<div class="row">
<?php
if (!empty($search)) {

foreach ($search as $key => $value) {
?>
<div class="col-md-3">
<!--widget start-->
<aside class="profile-nav alt">
<section class="panel">
<div class="twt-feed blue-bg">
<div class="corner-ribon black-ribon">
<!--<i class="fa fa-twitter"></i>-->
</div>
<!--<div class="fa fa-twitter wtt-mark"></div>-->
<a href="#">
<!--<img alt="img" width="60" height="40" src="<?php // echo base_url() . 'upload/customer_image/' . $value->customer_id . '/' . $value->picture ?>"/>-->
</a>
<h1><?php echo $value->ticket_no; ?></h1>
<p><?php echo $value->subject; ?></p>
<p><?php echo $value->created_date_time; ?></p>
</div>

<ul class="nav nav-pills nav-stacked">
<li><a href="javascript:;"> <i class="fa fa-envelope-o"></i> Send From <span class="badge label-success pull-right r-activity"><?php echo get_customer_name_by_id($value->send_from); ?></span></a></li>
<li><a href="javascript:;"> <i class="fa fa-comments-o"></i> Subject<span class="badge label-warning pull-right r-activity"><?php echo $value->subject; ?></span></a></li>
<?php if ($value->status == 'A') { ?>

<li><a href="javascript:;"> <i class="fa fa-bell-o"></i> Status <span class="badge label-success pull-right r-activity"><?php echo "Active"; ?></span></a></li>
<?php } else { ?>
<li><a href="javascript:;"> <i class="fa fa-bell-o"></i> Status <span class="badge label-danger pull-right r-activity"><?php echo "InActive"; ?></span></a></li>
<?php } ?>

</ul>

</section>
</aside>
<!--widget end-->
</div>


<?php }
}else{
echo"<div class=\"alert alert-warning fade in\">";//alert alert-block alert-danger fade in
echo 'No Data Found.';
echo"</div>";

} 



?>

</div>

</div>








</div>

<?php
$this->load->view('sm/home/view_footer');
?>    
