<?php $this->load->view('sm/home/view_login_header'); ?>


<div class="signup" style="margin-top: 100px">
    <div class="panel panel-default">
        <div class="panel-heading"><b>Customer Forgot Password</b></div>
        <div class="panel-body">
            <div class="cust-form">
                <form class="form-horizontal" id="forgot">

                    <div class="form-group required">
                        <label class="control-label col-lg-3" for="mobile">Mobile:</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="mobile" id="mobile"
                                   placeholder="Enter your Mobile Number">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-lg-3" for="nPass">New Password:</label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control" name="nPass" id="nPass"
                                   placeholder="Enter your New Password">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-lg-3" for="cPass">Confirm Password:</label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control" name="cPass" id="cPass"
                                   placeholder="Enter your Conform Password">
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-lg-offset-5 col-lg-10">
                            <button type="button" onclick="trv.customer.forgot_pass()"
                                    class="btn btn-success btn-md btn-lg">Submit
                            </button>
                        </div>
                    </div>
                    <div class="text-center res"></div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
$this->load->view('sm/home/view_login_footer');
?>




