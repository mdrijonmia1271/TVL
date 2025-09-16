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
            echo"</div>";
        }
        if ($this->session->flashdata('flashError')) {
            echo"<div class=\"alert-warning fade in\">";
            echo $this->session->flashdata('flashError');
            echo"</div>";
        }
    ?>
                <div class="form">

                    <form  enctype="multipart/form-data"  class="cmxform form-horizontal " id="signupForm" method="post" action="<?php echo base_url() . 'sm/engineer/save'; ?>">
                        <div class="form-group ">
                            
                            <label for="ser_eng_code" class="control-label col-lg-3">ID Number<span style="color:red">&nbsp;*</span></label>
                            <div class="col-lg-6">
                                <?php
                                $eng_code_arry = array(
                                    'name' => 'ser_eng_code',
                                    'id' => 'ser_eng_code',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter ID Number',
                                    'value' => set_value('ser_eng_code'),
                                );

                                echo form_input($eng_code_arry);
                                ?>

                                <span class="error"><?php echo form_error('ser_eng_code'); /* print valitation error */ ?></span>
                            </div> 
                          
                        </div>
                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-3">Name<span style="color:red">&nbsp;*</span></label>
                            <div class="col-lg-6">
                                <?php
                                $eng_fname_arry = array(
                                    'name' => 'name',
                                    'id' => 'name',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Full Name ',
                                    'value' => set_value('name'),
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
                                echo form_dropdown('department', $department_list, '', $dropdown_js_department);
                                ?>
                                <span class="error"><?php echo form_error('department'); /* print valitation error */ ?>
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="designation" class="control-label col-lg-3">Designation<span style="color:red">&nbsp;*</span></label>
                            <div class="col-lg-6">
                                <?php
                                $dropdown_js_designation = 'id="designation" required="" class="form-control";';
                                echo form_dropdown('designation', $designation_list, '', $dropdown_js_designation);
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
                                    'value' => set_value('mobile'),
                                );

                                echo form_input($mobile_arry);
                                ?>						
                                <span class="error"><?php echo form_error('mobile'); /* print valitation error */ ?></span>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="email" class="control-label col-sm-3">Email Address<span style="color:red">&nbsp;*</span></label>
                            <div class="col-lg-6">
                                <?php
                                $email_arry = array(
                                    'name' => 'email',
                                    'id' => 'email',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Email',
                                    'value' => set_value('email'),
                                    //'required'=> 'required',
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
                                    'value' => set_value('telephone_no'),
                                );

                                echo form_input($tel_arry);
                                ?>						
                            
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image" class="control-label col-lg-3">Service Engineer Image</label>
                            <div class="col-lg-6"><input type="file" class="form-control"  name="image" id="exampleInputFile">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="experience" class="control-label col-lg-3">Experience</label>
                            <div class="col-lg-6">
                                <?php
                                $exp_arry = array(
                                    'name' => 'experience',
                                    'id' => 'experience',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter experience',
                                    'value' => set_value('experience'),
                                );

                                echo form_input($exp_arry);
                                ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="training" class="control-label col-lg-3">Training</label>
                            <div class="col-lg-6">
                                <?php
                                $address_arry = array(
                                    'name' => 'training',
                                    'id' => 'training',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter training information',
                                    'value' => set_value('training'),
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
                                    'value' => set_value('contact_add_details'),
                                    'cols' => '10',
                                    'rows' => '5'
                                );

                                echo form_textarea($address_arry);
                                ?>

                            </div>
                        </div>






                        <!--<div class="form-group ">
                            <label for="division" class="control-label col-lg-3">Division</label>
                            <div class="col-lg-6">
                                <?php
/*                                $url = base_url() . 'sm/engineer/';
                                $dropdown_js = 'id="division" class="form-control" onchange=getDistricttByAjax("' . $url . '");';
                                echo form_dropdown('contact_add_division', $division_list, '', $dropdown_js);
                                */?>
                                <span class="error"><?php /*echo form_error('contact_add_division');  */?>

                            </div>
                            
                        </div>  -->

                        <!--<div class="form-group ">
                            <label for="district" class="control-label col-lg-3">District</label>
                            <div class="col-lg-6">
                                <span id="show_my_district"></span>
                                <span class="error"><?php /*echo form_error('contact_add_district');  */?>
                            </div>
                        </div>-->

                        <!--<div class="form-group ">
                            <label for="upazila" class="control-label col-lg-3">Upazila</label>
                            <div class="col-lg-6">
                                <span id="show_my_upazila"> </span>
                                <span class="error"><?php /*echo form_error('contact_add_upazila');  */?>
                            </div>
                        </div>-->



                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Submit</button>

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