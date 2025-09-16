<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Service Priority
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

                        <form  class = "cmxform form-horizontal"  enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/admin_config/update_priority'; ?>">
                         <?php echo form_hidden(array('hidden_priority_id' => $edit->priority_id));?> 
                            <div class="form-group">
                                <label for="contact_add_details" class="control-label col-lg-3">Name<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $priority_arry = array(
                                        'name' => 'priority_name',
                                        'id' => 'priority_name',
                                        'class' => "form-control",
                                        'placeholder' => 'Enter Name',
                                        'value' => $edit->priority_title,
                                    );

                                    echo form_input($priority_arry);
                                    ?>


                                    <span class="error"><?php echo form_error('priority_name'); /* print valitation error */ ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="color_code" class="control-label col-lg-3">Color Code<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <div data-color-format="rgb" data-color="rgb(255, 146, 180)" class="input-append colorpicker-default color">
                                        <?php
                                        $code_arry = array(
                                            'name' => 'color_code',
                                            'id' => "form-control",
                                            'class' => "form-control",
                                            'placeholder' => 'Enter Color Code',
                                            'value' => $edit->color_code,
                                        );

                                        echo form_input($code_arry);
                                        ?>
                                        <span class=" input-group-btn add-on">
                                           &nbsp;&nbsp; <button class="btn btn-white" type="button" style="padding: 8px">
                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                            </button>
                                        </span>
                                        <span class="error"><?php echo form_error('color_code'); /* print valitation error */ ?></span>
                                    </div>           </div>
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
                Service Priority List <?php //echo $total_rows;  ?>
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
                                    <th>Priority Name</th>
                                    <th>Color Code</th>
                                    <th class="numeric">Status</th>
                                    <th class="numeric">Date Time</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($record as $key => $value) {
                                    ?> 
                                    <tr>
                                        <td data-title="Priority Name">
                                            <?php echo $value->priority_title; ?>
                                        </td>
                                        <td data-title="Color Code"><?php echo $value->color_code; ?></td>


                                        <?php if ($value->status == 'A') { ?>
                                            <td class="">Active</td>
                                        <?php } else { ?>
                                            <td class="">In Active</td>
                                        <?php } ?>
                                        <td data-title="Date"><?php echo $value->created_date_time; ?></td>   
                                        <td>
                                                    <p><a href="<?php echo base_url(); ?>sm/admin_config/edit_priority/<?php echo $value->priority_id; ?>" class="label label-success label-mini">
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
