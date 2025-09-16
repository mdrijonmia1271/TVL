<?php $this->load->view('sm/home/view_login_header'); ?>


<div class="signup">


    <div class="panel panel-default">
        <div class="panel-heading"><b>Customer Sign-Up</b></div>
        <div class="panel-body">
            <div class="cust-form">
                <form class="form-horizontal" id="signForm">

                    <div id="basic-info">
                        <h5 class="text-center">Client/Customer basic info</h5>
                        <hr>


                        <div class="form-group required">
                            <label class="control-label col-lg-2" for="cName">Name:</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="cName" id="cName"
                                       placeholder="Enter your Name">
                                <span class="help-block"></span>
                            </div>

                            <label for="cEmail" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="cEmail" id="cEmail"
                                       placeholder="Enter your Email"/>
                                <span class="help-block"></span>
                            </div>

                        </div>

                        <div class="form-group required">
                            <label for="cMobile" class="col-lg-2 control-label">Mobile</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="cMobile" id="cMobile"
                                       placeholder="Ex: 01700000000" maxlength="11"/>
                                <span class="help-block"></span>
                            </div>


                            <label for="phn" class="control-label col-lg-2">Telephone</label>
                            <div class="col-lg-4">
                                <input name="cTel" class="form-control" id="phn" type="text" placeholder="EX:020000000">
                            </div>

                        </div>


                        <div class="form-group required">
                            <label for="cPass" class="col-lg-2 control-label">Password</label>
                            <div class="col-lg-4">
                                <input type="password" class="form-control" name="cPass" id="cPass"
                                       placeholder="Enter your Password"/>
                                <span class="help-block"></span>
                            </div>

                            <label for="confirm" class="col-lg-2 control-label">Confirm Pass</label>
                            <div class="col-lg-4">
                                <input type="password" class="form-control" name="confirm" id="confirm"
                                       placeholder="Confirm your Password"/>
                                <span class="help-block"></span>
                            </div>
                        </div>



                        <div class="form-group required">
                            <label for="image" class="control-label col-lg-2"> Photo</label>
                            <div class="col-lg-10">
                                <input name="cPhoto" class="form-control" id="image" type="file">
                            </div>

                        </div>

                    </div>
                    <br>
                    <div class="cust-address">
                        <h5 class="text-center">Client/Customer Address</h5>
                        <hr>

                        <div class="form-group required">
                            <label for="cFlat" class="col-lg-2 control-label">Flat/House No.</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="cFlat" id="cFlat"
                                       placeholder="Enter your Flat or House No"/>
                            </div>

                            <label for="cRoad" class="col-lg-2 control-label">Road/Sector</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="cRoad" id="cRoad"
                                       placeholder="Enter your Road"/>
                            </div>

                        </div>


                        <div class="form-group required">
                            <label for="cPost" class="col-lg-2 control-label">Post Office</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="cPost" id="cPost"
                                       placeholder="Enter your Post Office"/>
                                <span class="help-block"></span>
                            </div>
                            <label for="cPCode" class="col-lg-2 control-label">Post Code</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="cPCode" id="cPCode"
                                       placeholder="Enter your Post Code"/>
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group distr">
                            <label for="division" class="col-lg-2 control-label">Division</label>
                            <div class="col-lg-3">
                                <?php
                                $url = base_url() . 'sm/cust_sign/';
                                $dropdown_js = 'id="division" class="form-control" onchange=getDistricttByAjax("' . $url . '");';
                                echo form_dropdown('contact_add_division', $division_list, '', $dropdown_js);
                                ?>
                                <span class="help-block"></span>
                            </div>


                            <label for="district" class="col-lg-1 control-label">District</label>
                            <div class="col-lg-2">
                                <span id="show_my_district"></span>
                            </div>

                            <label for="thana" class="col-lg-1 control-label">Thana</label>
                            <div class="col-lg-3">
                                <span id="show_my_upazila"> </span>
                            </div>

                        </div>
                    </div>

                    <br>
                    <div class="cust-contact">
                        <h5 class="text-center">Client/Customer Contact Person</h5>
                        <hr>

                        <div class="form-group required">
                            <label for="pName" class="col-lg-2 control-label">Name</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="pName" id="pName"
                                       placeholder="Enter Name"/>
                                <span class="help-block"></span>
                            </div>


                            <label for="pDes" class="col-lg-2 control-label">Designation</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="pDes" id="pDes"
                                       placeholder="Enter Designation"/>
                                <span class="help-block"></span>
                            </div>

                        </div>

                        <div class="form-group required">
                            <label for="pEmail" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="pEmail" id="pEmail"
                                       placeholder="Enter Email Address"/>
                                <span class="help-block"></span>
                            </div>


                            <label for="Mobile" class="col-lg-2 control-label">Mobile</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="pMobile" id="Mobile"
                                       placeholder="Ex: 01700000000" maxlength="11"/>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <div class="col-lg-offset-5 col-lg-10">
                                <button type="button" onclick="trv.customer.sign_up()"
                                        class="btn btn-success btn-md btn-lg">Submit
                                </button>
                            </div>

                        </div>
                        <div class="text-center res"></div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<?php
$this->load->view('sm/home/view_login_footer');
?>




