<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Service Type
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

                        <form  class = "cmxform form-horizontal"  enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/admin_config/update_service_type'; ?>">
                            <?php echo form_hidden(array('hidden_service_type_name' => $edit->service_type_id));?> 
                            
                            <div class="form-group">
                                 <label for="color_code" class="control-label col-lg-3">Customer Name<span style="color:red">&nbsp;*</span></label>
                                
                                 <div class="col-lg-6">

                                     <?php
                                     $js = 'class="form-control"';

                                     echo form_dropdown('cust_name', $cust_name, $edit->ref_custmr_id, $js);
                                     ?>
                                     <span id="cust_name" class="error"><?php echo form_error('cust_name'); /* print valitation error */ ?></span>
                                 </div>
                            </div>   
                            
                            <div class="form-group">
                                <label for="contact_add_details" class="control-label col-lg-3">Service Type Name<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $service_type_name_arry = array(
                                        'name' => 'service_type_name',
                                        'id' => 'service_type_name',
                                        'class' => "form-control",
                                        'placeholder' => 'Enter Service Type Name',
                                         'value' => $edit->service_type_title,
                                    );

                                    echo form_input($service_type_name_arry);
                                    ?>


                                    <span class="error"><?php echo form_error('service_type_name'); /* print valitation error */ ?></span>
                                </div>
                            </div>
                            
                        <div class="form-group">
                                 <label for="color_code" class="control-label col-lg-3">Service Start Date</label>                                
                                 <div class="col-lg-6">
                                    <?php
                                    $service_start_date_arry = array(
                                        'name' => 'service_start_date',
                                        'id' => 'service_start_date',
                                        'class' => "form-control",
                                        'placeholder' => 'Service Start Date',
                                        'value' => $edit->service_end_date,
                                    );

                                    echo form_input($service_start_date_arry);
                                    ?>
                                      (YY-m-d, 2016-01-10)
                                 </div>
                            </div>

                        <div class="form-group">
                                 <label for="color_code" class="control-label col-lg-3">Service End Date</label>                                
                                 <div class="col-lg-6">
                                    <?php
                                    $service_end_date_arry = array(
                                        'name' => 'service_end_date',
                                        'id' => 'service_end_date',
                                        'class' => "form-control",
                                        'placeholder' => 'Service End Date',
                                        'value' => $edit->service_end_date,
                                    );

                                    echo form_input($service_end_date_arry);
                                    ?> 
                                     (YY-m-d, 2016-11-10)
                                 </div>
                            </div>     
                            
                            <div class="form-group">
                                <label for="status" class="control-label col-lg-3">Paid/Free<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    if($edit->free_paid == "free"){
                                        ?>
                                    <input type="radio" name="free_paid"  value="free" checked="" /> Free
                                    <?php
                                    }else{
                                        ?>
                                    <input type="radio" name="free_paid"  value="free" /> Free
                                    <?php
                                    }
                                    ?>
                                    
                                    <br>
                                <?php
                                    if($edit->free_paid == "paid"){
                                        ?>
                                    <input type="radio" name="free_paid" value="paid" checked="" /> Paid
                                    <?php
                                    }else{
                                        ?>
                                    <input type="radio" name="free_paid" value="paid" /> Paid
                                    <?php
                                    }
                                    ?>                                    
                                    
                                </div>


                            </div>                            

                              <div class="form-group">
                                <label for="status" class="control-label col-lg-3">Status<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <select class="form-control" name="status" >
                                        <option value=" ">Select Status..</option>
                                        <?php if ($edit->status == 'A') { ?>
                                            <option selected="" value="A">Active</option>
                                            <option value="I">Inactive</option>
                                        <?php } else { ?>
                                            <option  value="A">Active</option>
                                            <option selected="" value="I">Inactive</option>
                                        <?php } ?>
                                    </select>
                                </div>


                            </div>

                            <div class="col-lg-offset-3 col-lg-6">
                                <button type="submit" class="btn btn-info">Update</button>                     
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </section>


    </div>
</div>

<div class="row">
    <div class="col-sm-12">

        <section class="panel">
            <header class="panel-heading">
                Service Type List <?php //echo $total_rows;  ?>
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <!--<a href="javascript:;" class="fa fa-times"></a>-->
                </span>
            </header>
            <div class="panel-body">
                <section id="no-more-tables">
                    <?php
                    $this->load->view('sm/admin/config/view_service_type_list');
                    ?>                        
                </section>
            </div>
        </section>
    </div>
</div>

<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>
