<?php $this->load->view('sm/home/view_header'); ?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create User
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <div class="form">

                        <?php
                        if ($this->session->flashdata('flashOK')) {
                            echo "<div class=\"alert alert-success fade in\">";
                            echo $this->session->flashdata('flashOK');
                            echo "</div>";
                        }
                        ?>

                        <form class="cmxform form-horizontal" enctype="multipart/form-data" method="post"
                              action="<?php echo base_url() . 'sm/superadmin/save_superadmin'; ?>">

                            <div class="form-group">
                                <label for="contact_add_details" class="control-label col-lg-3">Name<span
                                            style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $superadmin_name_arry = array(
                                        'name' => 'superadmin_name',
                                        'id' => 'superadmin_name',
                                        'class' => "form-control",
                                        'placeholder' => 'Name',
                                        'value' => set_value('superadmin_name'),
                                    );

                                    echo form_input($superadmin_name_arry);
                                    ?>


                                    <span class="error"><?php echo form_error('superadmin_name'); /* print valitation error */ ?></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="contact_add_details" class="control-label col-lg-3">Login ID<span
                                            style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $username_arry = array(
                                        'name' => 'username',
                                        'id' => 'username',
                                        'class' => "form-control",
                                        'placeholder' => 'Enter Login ID',
                                        'value' => set_value('username'),
                                    );

                                    echo form_input($username_arry);
                                    ?>


                                    <span class="error"><?php echo form_error('username'); /* print valitation error */ ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contact_add_details" class="control-label col-lg-3">Password<span
                                            style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $pass_arry = array(
                                        'name' => 'superadmin_pass',
                                        'id' => 'superadmin_pass',
                                        'class' => "form-control",
                                        'placeholder' => 'Enter Password',
                                        'value' => set_value('superadmin_pass'),
                                    );

                                    echo form_password($pass_arry);
                                    ?>


                                    <span class="error"><?php echo form_error('superadmin_pass'); /* print valitation error */ ?></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="mobile" class="control-label col-lg-3">Mobile<span
                                            style="color:red">&nbsp;</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $mobile_arry = array(
                                        'name' => 'mobile',
                                        'id' => 'mobile',
                                        'class' => "form-control",
                                        'placeholder' => 'Enter mobile',
                                        'value' => set_value('mobile'),
                                    );

                                    echo form_input($mobile_arry);
                                    ?>


                                    <span class="error"><?php echo form_error('mobile'); /* print valitation error */ ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="control-label col-lg-3">Email<span
                                            style="color:red">&nbsp;</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $email_arry = array(
                                        'name' => 'email',
                                        'id' => 'email',
                                        'class' => "form-control",
                                        'placeholder' => 'Enter email',
                                        'value' => set_value('email'),
                                    );

                                    echo form_input($email_arry);
                                    ?>


                                    <span class="error"><?php echo form_error('email'); /* print valitation error */ ?></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="photo" class="control-label col-lg-3">Photo<span
                                            style="color:red">&nbsp;</span></label>
                                <div class="col-lg-6">
                                    <input type="file" class="form-control" name="photo" id="photo">
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="uType" class="control-label col-lg-3">User Type<span style="color:red">&nbsp;</span></label>
                                <div class="col-lg-6">
                                    <select class="form-control" name="uType" id="uType">
                                        <option value="">Select</option>
                                        <option value="sm">Service Dept. Manager</option>
                                        <option value="hd">Help Desk</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="control-label col-lg-3">Status<span
                                            style="color:red">&nbsp;</span></label>
                                <div class="col-lg-6">
                                    <select class="form-control" name="status" id="status">
                                        <option value="A">Active</option>
                                        <option value="I">Inactive</option>

                                    </select>
                                </div>
                            </div>


                            <div class="form-group" style="display:none;">
                                <label for="customerarray" class="control-label col-lg-3">Customer List<span
                                            style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $customer_array = get_customer_array_dropdown();

                                    foreach ($customer_array as $key => $value) {
                                        if (!empty($key) || $key != '') {
                                            ?>
                                            <input type="checkbox" checked name="customerarray[]"
                                                   value="<?php echo $key; ?>"> <?php echo $value; ?> &nbsp;&nbsp;&nbsp;
                                            <br>
                                            <?php
                                        }
                                    }
                                    ?>

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
            <?php
            $this->load->view('sm/superadmin/view_supperadmin_list');
            ?>
        </section>
    </div>
</div>

<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>
