<?php $this->load->view('sm/home/view_header'); ?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Customer Edit
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
                            echo "<div class=\"alert alert-success fade in\">";
                            echo $this->session->flashdata('flashOK');
                            echo "</div>";
                        }
                        if ($this->session->flashdata('flashError')) {
                            echo "<div class=\"alert alert-warning fade in\">";
                            echo $this->session->flashdata('flashError');
                            echo "</div>";
                        }
                        ?>

                        <form class="cmxform form-horizontal" id="updateSubUser" enctype="multipart/form-data"
                              method="post" action="<?php echo base_url() . 'sm/customer/update_sub_user/' . $this->uri->segment(4); ?>">
                            <?php echo form_hidden(array('hidden_customer_id' => $edit->customer_id)); ?>

                            <fieldset>
                                <!-- Form Name -->
                                <legend class="cl-address">Sub User Edit</legend>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="cname">Username</label>
                                    <div class="col-lg-10">
                                        <?php
                                        $cust_name_arry = array(
                                            'name' => 'username',
                                            'id' => 'username',
                                            'class' => "form-control",
                                            'placeholder' => 'Enter Username',
                                            'value' => $edit->username,
                                            'disabled' => 'disabled'
                                        );

                                        echo form_input($cust_name_arry);
                                        ?>
                                        <span class="error"><?php echo form_error('name'); /* print valitation error */ ?></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label for="email" class="control-label col-lg-2">Email</label>
                                    <div class="col-lg-10">
                                        <?php
                                        $email_arry = array(
                                            'name' => 'cEmail',
                                            'id' => 'email',
                                            'class' => "form-control",
                                            'placeholder' => 'Enter Email',
                                            'value' => $edit->email,
                                        );

                                        echo form_input($email_arry);
                                        ?>
                                        <span class="error"><?php echo form_error('email'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label for="email" class="control-label col-lg-2">Mobile</label>
                                    <div class="col-lg-10">
                                        <?php
                                        $mob_arry = array(
                                            'name' => 'cMobile',
                                            'id' => 'phone',
                                            'class' => "form-control",
                                            'placeholder' => 'Enter Mobile Number',
                                            'value' => $edit->phone,
                                        );

                                        echo form_input($mob_arry);
                                        ?>
                                        <span class="error"><?php echo form_error('mobile'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="control-label col-lg-2">Password</label>
                                    <div class="col-lg-10">
                                        <?php
                                        $mob_arry = array(
                                            'name' => 'password',
                                            'id' => 'password',
                                            'class' => "form-control",
                                            'placeholder' => 'Enter password',
                                            'value' => "",
                                        );

                                        echo form_password($mob_arry);
                                        ?>
                                        <span class="error"><?php echo form_error('password'); /* print valitation error */ ?></span>
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset>
                                <br><br><br>
                                <div class="cust-contact">
                                <legend class="cl-address">Equipment/Item Details</legend>
                                
                                <div class="form-group required">
                                    <label for="mc" class="col-lg-2 control-label">Equipment/Item</label>
                                    <div class="col-lg-4">
                                        <select class="form-control chosen" id="mc" name="machine"
                                                onchange="trv.install_base.machine_info(this)" data-placeholder='Select a machine'>
                                            <option value="">Select an Equipment/Item</option>
                                            <?php foreach ($machine as $m): ?>
                                                <option value="<?= $m->mc_id; ?>" <?= $m->mc_id == $item->insb_machine ? 'selected' : ''?>><?= $m->mc_name . ' (Model: ' . $m->mc_model . ')'; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>


                                    <label class="col-lg-2 control-label" for="dep_ref_id">Department</label>
                                    <div class="col-lg-4">
                                        <select class="form-control chosen" id="dep_ref_id" name="dep_ref_id" data-placeholder='Select a department'>
                                            <option value="">Select a Department</option>
                                            <?php if (!empty($department)): ?>
                                                <?php foreach ($department as $c): ?>
                                                    <option value="<?= $c->id; ?>" <?= $c->id == $item->dep_ref_id ? 'selected' : ''?>><?= $c->name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>

                                </div>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="bArea">Business Area</label>
                                    <div class="col-lg-4">
                                        <select class="form-control chosen" id="bArea" name="bArea" data-placeholder="Select an area">
                                            <option value="">Select a Business Area</option>
                                            <?php if (!empty($business)): ?>
                                                <?php foreach ($business as $b): ?>
                                                    <option value="<?= $b->bu_id; ?>" <?= $b->bu_id == $item->insb_business_area ? 'selected' : ''?>><?= $b->bu_name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>

                                    <label class="col-lg-2 control-label" for="sector">Sector</label>
                                    <div class="col-lg-4">
                                        <select class="form-control chosen" id="sector" name="sector" data-placeholder="Select an sector">
                                            <option value="">Select a Sector</option>
                                            <option value="govt" <?= $item->insb_sector == 'govt' ? 'selected' : ''?>>Govt</option>
                                            <option value="private" <?= $item->insb_sector == 'private' ? 'selected' : ''?>>Private</option>
                                            <option value="corporate" <?= $item->insb_sector == 'corporate' ? 'selected' : ''?>>Corporate</option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>

                                </div>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="mcSrial">Serial No.(S/N)</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="mcSrial" id="mcSrial"
                                            placeholder="Enter Serial number" value="<?= $item->insb_serial?>" class="form-control">
                                        <span class="help-block"></span>
                                    </div>

                                    <label class="col-lg-2 no-required control-label" for="picture">Equipment Picture : </label>
                                    <div class="col-lg-4">
                                        <input type="file" name="picture" id="picture" class="form-control">
                                        <img src="<?= base_url('/upload/install_base/'. $item->insb_id . '/' . $item->picture)?>" alt="..." style="width: 250px; border: 1px solid; margin-top: 2px;"/>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                            </div>

                            </fieldset>


                            <div class="col-lg-offset-2 col-lg-6">
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

<script>
    $(document).ready(function(){
        $("#updateSubUser").on('submit', function(){
            console.log("1");
        });
    });
</script>