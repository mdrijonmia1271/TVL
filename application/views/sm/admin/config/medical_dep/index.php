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

                        <form  class = "cmxform form-horizontal"   method="post" action="<?php echo base_url() . 'sm/admin_config/store'; ?>">


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
               Medical Departments
            </header>
            <div class="panel-body">
                <section id="no-more-tables">
                    <?php if (!empty($department)) : ?>

                        <table class="table table-bordered table-striped table-condensed cf">
                            <thead class="cf">
                            <tr>
                                <th>Sl</th>
                                <th>Department</th>
                                <th class="numeric">Status</th>
                                <th class="numeric">Date Time</th>
                                <th class="numeric">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($department as $key => $value) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td data-title="Priority Name">
                                        <?= $value->name; ?>
                                    </td>

                                    <?php if ($value->status == 1) : ?>
                                        <td class="">Active</td>
                                    <?php else : ?>
                                        <td class="">In Active</td>
                                    <?php endif; ?>
                                    <td data-title="Date"><?= date_convert($value->created_at); ?></td>
                                    <td>
                                        <a href="<?php echo base_url('sm/admin_config/edit/' . $value->id); ?>"
                                           class="btn btn-primary btn-sm">
                                            <i class="icol-pencil"></i>Edit
                                        </a>
                                        <a href="<?php echo base_url('sm/admin_config/delete/' . $value->id); ?>"
                                           class="btn btn-danger btn-sm">
                                            <i class="icol-trash"></i>Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </section>
            </div>
        </section>
    </div>
</div>

<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>
