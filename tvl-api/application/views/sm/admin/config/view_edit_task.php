<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Task
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

                        <form  class = "cmxform form-horizontal"  enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/admin_config/update_task'; ?>">
                               <?php echo form_hidden(array('hidden_task_id' => $edit->task_name_id));?> 
                            
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
                                <label for="colorform-control_code" class="control-label col-lg-3">Task Name<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $task_name_arry = array(
                                        'name' => 'task_name',
                                        'id' => 'task_name',
                                        'class' => "form-control",
                                        'placeholder' => 'Enter Task',
                                        'value' => $edit->task_title,
                                    );

                                    echo form_input($task_name_arry);
                                    ?>

                                    <span class="error"><?php echo form_error('task_name'); /* print valitation error */ ?></span>
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



<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>
