<?php $this->load->view('sm/home/view_header'); ?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Department
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

                        <form  class = "cmxform form-horizontal"   method="post" action="<?php echo base_url() . 'sm/admin_config/update_department/'; ?>">
                            <?php echo form_hidden(array('hidden_dep_id' => $edit->id));?>

                            <div class="form-group">
                                <label for="colorform-control_code" class="control-label col-lg-3">Department<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $task_name_arry = array(
                                        'name' => 'dep_name',
                                        'id' => 'dep_name',
                                        'class' => "form-control",
                                        'value' => $edit->name,
                                    );

                                    echo form_input($task_name_arry);
                                    ?>

                                    <span class="error"><?php echo form_error('dep_name'); /* print valitation error */ ?></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="status" class="control-label col-lg-3">Status<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <select class="form-control" id="status" name="status" >

                                        <option>Select Status..</option>
                                        <option <?php if ($edit->status == '1') { echo 'selected'; }?> value="0">Active</option>
                                        <option <?php if ($edit->status == '0') { echo 'selected'; }?> value="1">In active</option>

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
