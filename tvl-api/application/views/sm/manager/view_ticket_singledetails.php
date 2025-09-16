<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Ticket Details
<span class="tools pull-right">
<!--<a class="fa fa-chevron-down" href="javascript:;"></a>
<a class="fa fa-cog" href="javascript:;"></a>-->
<!--<a class="fa fa-times" href="javascript:;"></a>-->
</span>
</header>
<div class="panel-body">
<div class="position-center">

      <?php
        if (validation_errors()) {
            echo validation_errors('<div class="alert-warning fade in">', '</div>');
        }

        if ($this->session->flashdata('flashOK')) {
            echo "<div class=\"alert alert-success fade in\">";
            echo $this->session->flashdata('flashOK');
            echo"</div>";
        }
        if ($this->session->flashdata('flashError')) {
            echo"<div class=\"alert-warning fade in\">";
            echo $this->session->flashdata('flashError');
            echo"</div>";
        }
    ?>  

    
    <div class="form">  
 <form  class = "cmxform form-horizontal" id="signupForm" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/manager/save_assign_se_ticket'; ?>">
 <input type="hidden" name="srd_id" value="<?php echo $ticket->srd_id;?>"> 
<div class="form-group">
<label for="Ticket" class="control-label col-lg-3">Ticket No</label>
<div class="col-lg-6"><?php echo $ticket->ticket_no;?>
</div>
</div>    
     
    
<div class="form-group">
<label for="Ticket" class="control-label col-lg-3">Ticket Subject</label>
<div class="col-lg-6"><?php echo $ticket->subject;?>
</div>
</div>

     <div class="form-group">
<label for="Ticket" class="control-label col-lg-3">Ticket Details</label>
<div class="col-lg-6"><?php echo $ticket->request_details;?>
</div>
</div>
     
     <hr>
     
 <div class="form-group">
<label for="Ticket" class="control-label col-lg-3">Ticket liability :Service Engineer</label>
<div class="col-lg-6">
<?php
$dropdown_js_department = 'id="select_servie_eng" required="" class="form-control";';
echo form_dropdown('select_servie_eng', $service_engineer_list, '', $dropdown_js_department);
?>
<span class="error"><?php echo form_error('select_servie_eng'); /* print valitation error */ ?>
</div>
</div> 
   <div class="form-group">
<label for="Ticket" class="control-label col-lg-3">Ticket priority</label>
<div class="col-lg-6">
<?php    
$priority =  array(
            '' => 'Select',
            'normal'=>'Normal',
            'critical'=>'Critical',
            'nice'=>'Nice to Have'
        );
$dropdown_js_priority = 'id="priority" required="" class="form-control";';
echo form_dropdown('priority', $priority, '', $dropdown_js_priority);
?>
<span class="error"><?php echo form_error('priority'); /* print valitation error */ ?>
</div>
</div> 
   <div class="form-group">
<label for="Ticket" class="control-label col-lg-3">Ticket support_type</label>
<div class="col-lg-6">
<?php
$support_type = array(
    '' => 'Select',
    'free' => 'free support',
    'amc' => 'AMC',
    'preventive' => 'Preventive Maintenance',
    'on_call' => 'On Call'
);
$dropdown_js_support_type = 'id="select_servie_eng" required="" class="form-control";';
echo form_dropdown('support_type', $support_type, '', $dropdown_js_support_type);
?>
<span class="error"><?php echo form_error('support_type'); /* print valitation error */ ?>
</div>
</div>    
     
     
     
 <div class="col-lg-offset-3 col-lg-6">
<button type="submit" class="btn btn-info">Submit</button>                     
</div>
</form>   
    
    
    
    
    
    
    
</div>

</div>
</section>







</div>
</div>







<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>    