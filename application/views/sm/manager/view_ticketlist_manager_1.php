<?php
$this->load->view('sm/home/view_header');
?>  
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
<form role="form" class="form-horizontal bucket-form" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/manager/ticketsearch'; ?>">
<div class="form-group">

<div class="col-lg-12">
<div class="row"> 
<label for="inputSuccess" class="col-sm-1 control-label col-lg-1"> Ticket No</label>
<div class="col-lg-3">
<input type="text" name="ticket_no" placeholder="Ticket Name" class="form-control">
</div>

<label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Send from</label>
<div class="col-lg-3">
<input type="text" name="send_from"  placeholder="send from" class="form-control">
</div>

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


    
    


<!-- page start-->

<div class="row">
<div class="col-sm-12">

<section class="panel">
<header class="panel-heading">
Ticket List (<?php echo $total_rows; ?>)
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-cog"></a>
<!--<a href="javascript:;" class="fa fa-times"></a>-->
</span>
</header>
<div class="panel-body">
<section id="no-more-tables">


<?php if (!empty($record)) { ?>                        

<table class="table table-bordered table-striped table-condensed cf">
<thead class="cf">
<tr>
<th>Ticket No</th>
<th>Subject</th>
<th class="numeric">Date</th>
<th class="numeric">Status</th>
<th class="numeric">Action</th>
<th class="numeric">View</th>

</tr>
</thead>
<tbody>
<?php
foreach ($record as $key => $value) {
?> 
<tr>
<td data-title="Ticket No"><?php echo $value->ticket_no; ?></td>
<td data-title="subject"><?php echo $value->subject; ?></td>
<td data-title="Date"><?php echo $value->created_date_time; ?></td>

<?php if ($value->status == 'A') { ?>
<td class="success">Active</td>
<?php } else { ?>
<td class="alert alert-warning fade in">In Active</td>
<?php } ?>

<td>
<p><a class="label label-success label-mini" href="<?php echo base_url() . 'sm/ticket/edit/' . $value->srd_id; ?>"><i class="icol-pencil"></i> EDIT</a></p>

</td>
<td>
<p><a class="label label-primary label-mini" href="<?php echo base_url() . 'sm/ticket/view/' . $value->srd_id; ?>"><i class="icol-pencil"></i> VIEW</a></p>

</td>


</tr>
<?php } ?>

</tbody>
</table>


<div class="dataTables_paginate paging_bootstrap pagination" >
<ul>
<?php echo $links; ?>
</ul>
</div>    



<?php
}
?>                           
</section>
</div>
</section>
</div>
</div>
<!-- page end-->



    
    
    
    
    
    
    
<!-- End Main Content Wrapper -->


<?php
$this->load->view('sm/home/view_footer');
?>    
