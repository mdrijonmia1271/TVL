<?php $this->load->view('sm/home/view_header'); ?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                New Customer Creation
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:void(0)"></a>
                    <a class="fa fa-cog" href="javascript:void(0)"></a>
                </span>
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <div class="form">
                            <div class="res"></div>
                        <form class="cmxform form-horizontal" id="signupForm">

                            <fieldset>
                                <!-- Form Name -->
                                <legend class="cl-address">Client/Customer Basic Information</legend>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="cname">Name</label>
                                    <div class="col-lg-10">
                                        <input type="text"  class="form-control"  name="cName" placeholder="Enter client name">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label for="email" class="control-label col-lg-2">Email</label>
                                    <div class="col-lg-10">
                                        <input type="text"  class="form-control" name="cEmail" placeholder="Enter client email address">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label for="email" class="control-label col-lg-2">Mobile</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="cMobile"  class="form-control" placeholder="Enter client mobile number">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cTel" class="control-label col-lg-2">Telephone No.</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="cTel"  class="form-control" placeholder="Enter client Telephone Number">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="image" class="control-label col-lg-2"> Photo</label>
                                    <div class="col-lg-10">
                                        <input name="cPhoto" class="form-control" id="image" type="file">
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>

                                <!-- Form Name -->
                                <legend class="cl-address">Client/Customer Address</legend>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="flat">Flat/House No. </label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="flat" name="cFlat" placeholder="Enter client flat/house no.">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="cRoad">Road/Sector</label>
                                    <div class="col-lg-10">
                                        <input type="text"  class="form-control" id="cRoad" name="cRoad" placeholder="Enter Road/Sector/Village">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="cPost">Post Office</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="cPost" name="cPost" placeholder="Enter details post office">
                                        <span class="help-block"></span>
                                    </div>

                                    <label class="col-lg-2 control-label" for="cPCode">Post Code</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="cPCode" name="cPCode" placeholder="Enter Post Code">
                                        <span class="help-block"></span>
                                    </div>
                                </div>


                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="division">Division </label>
                                    <div class="col-lg-3">
                                        <?php
                                        $url = base_url() . 'sm/customer/';
                                        $dropdown_js = 'id="division" class="form-control" onchange=getDistricttByAjax("' . $url . '");';
                                        echo form_dropdown('contact_add_division', $division_list, '', $dropdown_js);
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
                                        <input type="text" id="pName" name="pName" placeholder="Enter Name" class="form-control">
                                        <span class="help-block"></span>
                                    </div>

                                    <label class="col-lg-2 control-label" for="pDes">Designation</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="pDes" id="pDes" placeholder="Enter Designation" class="form-control">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label class="col-lg-2 control-label" for="pEmail">Email</label>
                                    <div class="col-lg-4">
                                        <input type="text" id="pEmail" name="pEmail" placeholder="Enter Email Address" class="form-control">
                                        <span class="help-block"></span>
                                    </div>

                                    <label class="col-lg-2 control-label" for="Mobile">Mobile</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="pMobile" id="Mobile" placeholder="Enter Mobile Number" class="form-control">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                            </fieldset>
                            <br>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="button" onclick="trv.customer.create()" class="btn btn-success">Submit</button>
                                </div>
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