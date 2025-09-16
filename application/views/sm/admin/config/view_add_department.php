<?php $this->load->view('sm/home/view_header'); ?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create Department
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

                        <form  class = "cmxform form-horizontal"   method="post" action="<?php echo base_url() . 'sm/admin_config/create_department'; ?>">


                            <div class="form-group">
                                <label for="colorform-control_code" class="control-label col-lg-3">Department<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $task_name_arry = array(
                                        'name' => 'dep_name',
                                        'id' => 'dep_name',
                                        'class' => "form-control",
                                        'placeholder' => 'Enter Department',
                                        'value' => set_value('dep_name'),
                                    );

                                    echo form_input($task_name_arry);
                                    ?>

                                    <span class="error"><?php echo form_error('dep_name');   ?></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="status" class="control-label col-lg-3">Status<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <select class="form-control" name="status" id="status">
                                        <option value=" ">Select</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>

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
                Departments List <?php //echo $total_rows;  ?>
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
                                <!-- <th>Customer Name</th> -->
                                <th>Department</th>
                                <th class="numeric">Status</th>
                                <th class="numeric">Date Time</th>
                                <th class="numeric">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($record as $key => $value) {
                                ?>
                                <tr>
                                    <!-- <td data-title="Customer Name"><?php echo get_customer_name_by_id($value->ref_custmr_id); ?></td> -->
                                    <td data-title="Priority Name">
                                        <?php echo $value->name; ?>
                                    </td>



                                    <?php if ($value->status == '1') { ?>
                                        <td class="">Active</td>
                                    <?php } else { ?>
                                        <td class="">In Active</td>
                                    <?php } ?>
                                    <td data-title="Date"><?php echo $value->created_date_time; ?></td>
                                    <td>
                                        <p><a href="<?php echo base_url(); ?>sm/admin_config/edit_department/<?php echo $value->id; ?>" class="label label-success label-mini">
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
