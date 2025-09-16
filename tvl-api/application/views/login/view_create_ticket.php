<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Create Ticket
<span class="tools pull-right">
<a class="fa fa-chevron-down" href="javascript:;"></a>
<a class="fa fa-cog" href="javascript:;"></a>
<!--<a class="fa fa-times" href="javascript:;"></a>-->
</span>
</header>
<div class="panel-body">
<div class="position-center">
<div class="form">

<?php

if ($this->session->flashdata('flashOK')) {
echo"<div class=\"alert alert-success fade in\">";
echo $this->session->flashdata('flashOK');
echo"</div>";
}

?>                             

<form  class = "cmxform form-horizontal" id="signupForm" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/ticket/save'; ?>">


<div class="form-group">
<label for="subject" class="control-label col-lg-3">Ticket Subject<span style="color:red">&nbsp;*</span></label>
<div class="col-lg-6">
<?php
$subject_arry = array(
'name' => 'subject',
'id' => 'subject',
'class' => "form-control",
'placeholder' => 'Enter Subject',
//'required'=> 'required',
'value' => set_value('subject'),
);

echo form_input($subject_arry);
?>

<span class="error"><?php echo form_error('subject'); /* print valitation error */ ?></span>
</div>
</div> 

<div class="form-group">
<label for="request_details" class="control-label col-lg-3">Request Details<span style="color:red">&nbsp;*</span></label>
<div class="col-lg-6">
<?php
//$req_arry = array(
//'name' => 'request_details',
//'id' => 'request_details',
//'class' => "form-control",
//'placeholder' => 'Enter Request Details',
//'value' => set_value('request_details'),
////'required'=> 'required',
//);
//
//echo form_input($req_arry);



?>	
<textarea  class="form-control " id="request_details" name="request_details" type="text"></textarea>

<span class="error"><?php echo form_error('request_details'); /* print valitation error */ ?></span>
</div>
</div>

<!--<div class="form-group">
<label for="priority" class="control-label col-lg-3">Priority<span style="color:red">&nbsp;*</span></label>
<div class="col-lg-6">
    <select class="form-control" name="priority" >
<option value=" ">Select Priority..</option>
<option value="low">Low</option>
<option value="medium">Medium</option>
<option value="high">High</option>
</select>
</div>
</div>-->
    

<!--<div class="form-group">
<label for="supportType" class="control-label col-lg-3">Support Type<span style="color:red">&nbsp;*</span></label>
<div class="col-lg-6">
    <select class="form-control" name="supportType">						 
<option value=" ">Support Type</option>
<option value="">----</option>
</select>
</div>
</div>
    -->
    
<!--<div class="form-group">
<label for="send_from" class="control-label col-lg-3">Send From<span style="color:red">&nbsp;*</span></label>
<div class="col-lg-6">
    <?php
$send_from_arry = array(
'name' => 'send_from',
'id' => 'send_from',
'class' => "form-control",
'placeholder' => 'Send From',
'value' => set_value('send_from'),
//'required'=> 'required',
);

echo form_input($send_from_arry);
?>						
<span class="error"><?php echo form_error('send_from'); /* print valitation error */ ?></span>
</div>
</div>-->

<!--<div class="form-group">
<label for="send_to" class="control-label col-lg-3">Send From<span style="color:red">&nbsp;*</span></label>
<div class="col-lg-6"><?php
$send_to_arry = array(
'name' => 'send_to',
'id' => 'send_to',
'class' => "form-control",
'placeholder' => 'Send From',
'value' => set_value('send_to'),
//'required'=> 'required',
);

echo form_input($send_to_arry);
?>						
<span class="error"><?php echo form_error('send_to'); /* print valitation error */ ?></span>
</div>
</div>-->

<!--  <div class="form-group">
<label class="control-label col-md-3">Date</label>
<div class="col-md-4 col-xs-11">
<input class="form-control form-control-inline input-medium default-date-picker" size="16" value="" type="text">
<span class="help-block">Select date</span>
</div>
</div> -->




    
<div class="form-group ">
<label for="contact_add_details" class="control-label col-lg-3">Address</label>
<div class="col-lg-6">
<textarea  class="form-control " id="contact_add_details" name="contact_add_details" type="text"></textarea>
</div>
<span class="error"><?php echo form_error('contact_add_details'); /* print valitation error */ ?></span>
</div> 



<div class="form-group">
<label for="division" class="control-label col-lg-3">Division<span style="color:red">&nbsp;*</span></label>
<div class="col-lg-6">
<?php
$url = base_url() . 'sm/ticket/';
$dropdown_js = 'id="division" class="form-control" onchange=getDistricttByAjax("' . $url . '");';
echo form_dropdown('contact_add_division', $division_list, '', $dropdown_js,'required="required"');
?>
<span class="error"><?php echo form_error('division'); /* print valitation error */ ?>
</div>
</div>


<div class="form-group">
<label for="district" class="control-label col-lg-3">District<span style="color:red">&nbsp;*</span></label>
<div class="col-lg-6">
<span id="show_my_district"></span> <!-- Important Ajax call-->
<span class="error"><?php echo form_error('district'); /* print valitation error */ ?>
</div>
</div>


<div class="form-group">
<label for="upazila" class="control-label col-lg-3">Upazila<span style="color:red">&nbsp;*</span></label>
<div class="col-lg-6">
<span id="show_my_upazila"> </span><!-- Important Ajax call-->
<span class="error"><?php echo form_error('upazila'); /* print valitation error */ ?>
</div>
</div>


<div class="form-group">
    <label for="status" class="control-label col-lg-3">Status<span style="color:red">&nbsp;*</span></label>

<div class="col-lg-6">
<select class="form-control" name="status" >
<!--<option value="">Select Status</option>-->
<option value="A">Active</option>
<option value="I">InActive</option>  
</select>
</div>
</div>


<div class="col-lg-offset-3 col-lg-6">
<button type="submit" class="btn btn-info">Submit</button>                     
</div>
</form>
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