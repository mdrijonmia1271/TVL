<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
<div class="col-md-12">
<h3 class="prf-border-head">Ticket Modification Page</h3>
<section class="panel" style="background-color: #fff;">

<div class="panel-body profile-information">

<div class="col-md-4">
<div class="profile-desk">
<h1>Ticket No: <?php echo $view->ticket_no; ?></h1>
<span class="text-muted">Owner:
<?php $getCustomerName = get_customer_name_by_id($view->send_from);echo $getCustomerName ; ?>
</span> || 
<span class="text-muted"> Assign To:
<?php  $getServiceEngName = getServiceEngName($view->send_to);echo $getServiceEngName; ?>
</span>

<hr>
<br>
<p>Subject:<?php echo $view->subject; ?></p>
<span class="text-info"> <p>Details:<?php echo $view->request_details; ?></p><br>
</span>

</div>

<div class="profile-statistics">
<p>Priority:<?php echo $view->priority; ?></p>
<br>
<p>Support type:<?php echo $view->support_type; ?></p>
</div>
    
</div>
    
<div class="col-md-8">
<div class="panel-body">
<section id="no-more-tables">
    <h3>Comment</h3>

<?php if (!empty($record)) { ?>                        

<table class="table table-bordered table-striped table-condensed cf">
<thead class="cf">
<tr>
<th class="numeric">Date/Owner</th>
<th class="numeric">Comment</th>
</tr>
</thead>
<tbody>
<?php
foreach ($record as $key => $value) {
?> 
    
<tr>

<td data-title="Date">
<?php $getcommenterName = get_commenter_name_by_id($value->comment_from,$value->comments_by);echo$getcommenterName ; ?> 
[<?php echo $value->comment_from?>]<br> <?php echo $value->comments_date_time; ?>
</td>

<td data-title="Comment">
<p><?php echo $value->comments; ?></p>
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

</div>
    

    
    
    
    
    
</div>
</section>
</div>

</div>

<div id="row">
     <form  class = "cmxform form-horizontal" id="signupForm" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/customer/save'; ?>">



<div class="form-group">
    <label for="name" class="control-label col-lg-3">Comment on ticket<span style="color:red">&nbsp;*</span></label>
    <div class="col-lg-6">
            <?php
            $ticketcomment_arry = array(
            'name' => 'ticketcomment',
            'id' => 'ticketcomment',
            'class' => "form-control",
            'placeholder' => 'Enter Comment on ticket',
            'value' => set_value('ticketcomment'),
            'cols'=> '10',
            'rows' =>'5'
                    );

            echo form_textarea($ticketcomment_arry);
            ?>						
        <span class="error"><?php echo form_error('ticketcomment'); /* print valitation error */ ?></span>
    </div>
</div>

            <div class="col-lg-offset-3 col-lg-6">
                <button type="submit" class="btn btn-info">Submit</button>                     
            </div>
        </form>
</div>








<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>    