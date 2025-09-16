<?php $this->load->view('sm/home/view_header'); ?>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Service Engineer Insertion
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                    <a class="fa fa-cog" href="javascript:;"></a>
                    <!--<a class="fa fa-times" href="javascript:;"></a>-->
                </span>
            </header>
            <div class="panel-body">

                <?php

                if ($this->session->flashdata('flashOK')) {
                    echo "<div class=\"alert alert-success fade in\">";
                    echo $this->session->flashdata('flashOK');
                    echo "</div>";
                }
                if ($this->session->flashdata('flashError')) {
                    echo "<div class=\"alert-warning fade in\">";
                    echo $this->session->flashdata('flashError');
                    echo "</div>";
                }
                ?>

                <div class="form">

                    <form enctype="multipart/form-data" class="cmxform form-horizontal " id="signupForm" method="post"
                          action="<?php echo base_url() . 'sm/engineer/update'; ?>">
                        <?php echo form_hidden(array('hidden_ser_eng_id' => $edit->ser_eng_id)); ?>


                        <div class="form-group">
                            <label for="Service Engineer code" class="control-label col-lg-3">ID Number<span
                                        style="color:red">&nbsp;*</span></label>
                            <div class="col-lg-6">
                                <?php
                                $code_arry = array(
                                    'name' => 'ser_eng_code',
                                    'id' => 'ser_eng_code',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Service Engineer Code',
                                    'value' => $edit->ser_eng_code,
                                    //'required'=> 'required',
                                );

                                echo form_input($code_arry);
                                ?>
                                <span class="error"><?php echo form_error('ser_eng_code'); /* print valitation error */ ?></span>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-3"> Name<span style="color:red">&nbsp;*</span></label>
                            <div class="col-lg-6">
                                <?php
                                $eng_fname_arry = array(
                                    'name' => 'name',
                                    'id' => 'name',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Full Name ',
                                    'value' => $edit->name,
                                );

                                echo form_input($eng_fname_arry);
                                ?>
                                <span class="error"><?php echo form_error('name'); /* print valitation error */ ?></span>
                            </div>

                        </div>


                        <div class="form-group ">
                            <label for="department" class="control-label col-lg-3">Department<span style="color:red">&nbsp;*</span></label>
                            <div class="col-lg-6">
                                <?php
                                $dropdown_js_department = 'id="department" required="" class="form-control";';
                                echo form_dropdown('department', $department_list, $edit->department, $dropdown_js_department);
                                ?>
                                <span class="error"><?php echo form_error('department'); /* print valitation error */ ?>
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="designation" class="control-label col-lg-3">Designation<span style="color:red">&nbsp;*</span></label>
                            <div class="col-lg-6">
                                <?php
                                $dropdown_js_designation = 'id="designation" required="" class="form-control";';
                                echo form_dropdown('designation', $designation_list, $edit->designation, $dropdown_js_designation);
                                ?>
                                <span class="error"><?php echo form_error('designation'); /* print valitation error */ ?>
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="mobile" class="control-label col-lg-3">Mobile Number<span style="color:red">&nbsp;*</span></label>
                            <div class="col-lg-6">
                                <?php
                                $mobile_arry = array(
                                    'name' => 'mobile',
                                    'id' => 'mobile',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Mobile Number',
                                    'value' => $edit->mobile,
                                );

                                echo form_input($mobile_arry);
                                ?>
                                <span class="error"><?php echo form_error('mobile'); /* print valitation error */ ?></span>
                            </div>

                        </div>

                        <div class="form-group ">

                            <label for="email" class="control-label col-lg-3">Email Address<span style="color:red">&nbsp;*</span></label>
                            <div class="col-lg-6">
                                <?php
                                $email_arry = array(
                                    'name' => 'email',
                                    'id' => 'email',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Email',
                                    'value' => $edit->email,

                                );

                                echo form_input($email_arry);
                                ?>
                                <span class="error"><?php echo form_error('email'); /* print valitation error */ ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="telephone_no" class="control-label col-lg-3">Telephone Number</label>
                            <div class="col-lg-6">
                                <?php
                                $tel_arry = array(
                                    'name' => 'telephone_no',
                                    'id' => 'telephone_no',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Telephone Number',
                                    'value' => $edit->telephone_no,
                                );

                                echo form_input($tel_arry);
                                ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image" class="control-label col-lg-3">Service Engineer Image</label>
                            <div class="col-lg-6">
                                <input name="image" id="exampleInputFile" type="file">

                                <br>&nbsp;
                                <?php if (!empty($edit->picture)) { ?>
                                    <img alt="img" width="60" height="40"
                                         src="<?php echo base_url() . 'upload/service_engineer/' . $edit->ser_eng_id . '/' . $edit->picture ?>"/>
                                <?php } else { ?>
                                    <img alt="img" width="60" height="40"
                                         src="<?php echo base_url() . 'smdesign/images/noimage.png' ?>"/>
                                <?php } ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="experience" class="control-label col-lg-3">Experience</label>
                            <div class="col-lg-6">
                                <?php
                                $tel_arry = array(
                                    'name' => 'experience',
                                    'id' => 'experience',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter experience',
                                    'value' => $edit->experience,
                                );

                                echo form_input($tel_arry);
                                ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_add_details" class="control-label col-lg-3">Training</label>
                            <div class="col-lg-6">
                                <?php
                                $address_arry = array(
                                    'name' => 'training',
                                    'id' => 'training',
                                    'class' => "form-control",
                                    'value' => $edit->training,
                                    'cols' => '10',
                                    'rows' => '5'
                                );
                                echo form_textarea($address_arry);
                                ?>

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="contact_add_details" class="control-label col-lg-3">Address</label>
                            <div class="col-lg-6">
                                <?php
                                $address_arry = array(
                                    'name' => 'contact_add_details',
                                    'id' => 'contact_add_details',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Address',
                                    'value' => $edit->contact_add_details,
                                    'cols' => '10',
                                    'rows' => '5'
                                );

                                echo form_textarea($address_arry);
                                ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Update</button>

                                <!--<button class="btn btn-default" type="button">Cancel</button>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>


<?php
$this->load->view('sm/home/view_footer');
?>    