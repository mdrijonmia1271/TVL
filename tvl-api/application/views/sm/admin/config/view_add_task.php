<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create Task
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

                        <form  class = "cmxform form-horizontal"  enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/admin_config/save_task'; ?>">
                            <div class="form-group">
                                 <label for="color_code" class="control-label col-lg-3">Customer Name<span style="color:red">&nbsp;*</span></label>
                                
                                 <div class="col-lg-6">

                                     <?php
                                     $js = 'class="form-control"';
                                     echo form_dropdown('cust_name', $cust_name, set_value('cust_name'), $js);
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
                                        'value' => set_value('task_name'),
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
                                        <option value="A">Active</option>
                                        <option value="I">Inactive</option>

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

<div class="row">
    <div class="col-sm-12">

        <section class="panel">
            <header class="panel-heading">
                Service Task List <?php //echo $total_rows;  ?>
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
                                   <th>Customer Name</th>
                                    <th>Task Name</th>                                  
                                    <th class="numeric">Status</th>
                                    <th class="numeric">Date Time</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($record as $key => $value) {
                                    ?> 
                                    <tr>
                                        <td data-title="Customer Name"><?php echo get_customer_name_by_id($value->ref_custmr_id); ?></td>
                                        <td data-title="Priority Name">
                                            <?php echo $value->task_title; ?>
                                        </td>
                                      
                                <td data-title="Free Paid"> 
                                            <?php echo $value->task_title; ?>
                                        </td>

                                        <?php if ($value->status == 'A') { ?>
                                            <td class="">Active</td>
                                        <?php } else { ?>
                                            <td class="">In Active</td>
                                        <?php } ?>
                                        <td data-title="Date"><?php echo $value->created_date_time; ?></td> 
                                        <td>
                                                    <p><a href="<?php echo base_url(); ?>sm/admin_config/edit_task/<?php echo $value->task_name_id; ?>" class="label label-success label-mini">
                                                            <i class="icol-pencil"></i>Edit
                                                        </a>
                                                    </p>

                                                </td>

                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>

                        <?php
                    }
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
