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
                            echo "<div class=\"alert-warning fade in\">";
                            echo $this->session->flashdata('flashError');
                            echo "</div>";
                        }
                        ?>


                        <form class="cmxform form-horizontal" id="signupForm" enctype="multipart/form-data"
                              method="post" action="<?php echo base_url() . 'sm/customer/update_profile'; ?>">
                            <?php echo form_hidden(array('hidden_customer_id' => $edit->customer_id)); ?>


                            <fieldset>
                                <!-- Form Name -->
                                <legend class="cl-address">Client/Customer Basic Information</legend>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="cname">Name</label>
                                    <div class="col-lg-10">
                                        <?php
                                        $cust_name_arry = array(
                                            'name' => 'name',
                                            'id' => 'name',
                                            'class' => "form-control",
                                            'placeholder' => 'Enter Customer Name',
                                            'value' => $edit->name,
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

                                <div class="form-group required">
                                    <label for="email" class="control-label col-lg-2">Mobile</label>
                                    <div class="col-lg-10">
                                        <?php
                                        $mob_arry = array(
                                            'name' => 'mobile',
                                            'id' => 'mobile',
                                            'class' => "form-control",
                                            'placeholder' => 'Enter Mobile Number',
                                            'value' => $edit->mobile,
                                        );

                                        echo form_input($mob_arry);
                                        ?>
                                        <span class="error"><?php echo form_error('mobile'); /* print valitation error */ ?></span>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="cTel" class="control-label col-lg-2">Telephone No.</label>
                                    <div class="col-lg-10">
                                        <?php
                                        $mob_arry = array(
                                            'name' => 'cTel',
                                            'id' => 'cTel',
                                            'class' => "form-control",
                                            'placeholder' => 'Enter Telephone Number',
                                            'value' => $edit->telephone_no,
                                        );

                                        echo form_input($mob_arry);
                                        ?>
                                        <span class="error"><?php echo form_error('cTel'); /* print valitation error */ ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="image" class="control-label col-lg-2"> Photo</label>
                                    <div class="col-lg-10">
                                        <input name="image" id="exampleInputFile" type="file" class="form-control">

                                        <br>
                                        &nbsp;
                                        <?php if (!empty($edit->picture)) { ?>
                                            <img alt="img" width="60" height="40"
                                                 src="<?php echo base_url() . 'upload/customer_image/' . $edit->customer_id . '/' . $edit->picture ?>"/>
                                        <?php } else { ?>
                                            <img alt="img" width="60" height="40"
                                                 src="<?php echo base_url() . 'smdesign/images/noimage.png' ?>"/>
                                        <?php } ?>
                                    </div>
                                </div>
                            </fieldset>



                            <fieldset>
                                <!-- Form Name -->
                                <legend class="cl-address">Client/Customer Address</legend>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="flat">Flat/House No. </label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="flat" name="cFlat"
                                               value="<?= $edit->cust_flat; ?>">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="cRoad">Road/Sector</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="cRoad" name="cRoad"
                                               value="<?= $edit->cust_road; ?>">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="cPost">Post Office</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="cPost" name="cPost"
                                               value="<?= $edit->cust_post; ?>">
                                        <span class="help-block"></span>
                                    </div>

                                    <label class="col-lg-2 control-label" for="cPCode">Post Code</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="cPCode" name="cPCode"
                                               value="<?= $edit->cust_post_code; ?>">
                                        <span class="help-block"></span>
                                    </div>
                                </div>


                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="division">Division </label>
                                    <div class="col-lg-3">
                                        <?php
                                        $url = base_url() . 'sm/customer/';
                                        $dropdown_js = 'id="division" class="form-control" onchange=getDistricttByAjax("' . $url . '");';
                                        echo form_dropdown('contact_add_division', $division_list, $edit->contact_add_division, $dropdown_js);
                                        ?>
                                        <span class="help-block"></span>
                                    </div>

                                    <label class="col-lg-1 control-label" for="District">District</label>
                                    <div class="col-lg-3">
                                        <span id="show_my_district"></span>
                                    </div>

                                    <label class="col-lg-1 control-label" for="Thana">Thana</label>
                                    <div class="col-lg-2">
                                        <span id="show_my_upazila"> </span>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <!-- Form Name -->
                                <legend class="cl-address">Contact Person Information</legend>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="pName">Name</label>
                                    <div class="col-lg-4">
                                        <input type="text" id="pName" name="pName" value="<?= $edit->contact_person_name; ?>"
                                               class="form-control">
                                        <span class="help-block"></span>
                                    </div>

                                    <label class="col-lg-2 control-label" for="pDes">Designation</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="pDes" id="pDes" value="<?= $edit->contact_person_desig; ?>"
                                               class="form-control">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="pEmail">Email</label>
                                    <div class="col-lg-4">
                                        <input type="text" id="pEmail" name="pEmail" value="<?= $edit->contact_person_email; ?>"
                                               class="form-control">
                                        <span class="help-block"></span>
                                    </div>

                                    <label class="col-lg-2 control-label" for="Mobile">Mobile</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="pMobile" id="Mobile" value="<?= $edit->contact_person_phone; ?>"
                                               class="form-control">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                            </fieldset>


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