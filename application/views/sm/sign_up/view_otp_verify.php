<?php $this->load->view('sm/home/view_login_header'); ?>


<div class="signup" style="max-width: 40%; margin-top: 8%">


    <div class="panel panel-default">
        <div class="panel-heading"><b>OTP Verify</b></div>
        <div class="panel-body">
            <div class="cust-form">
                <form class="form-horizontal" id="otpForm">

                    <div id="basic-info">
                        <h5 class="text-center text-danger">Your OTP has been sent to your mobile phone. Please Enter your Mobile number and OTP below.</h5>
                        <hr>

                        <div class="form-group required">
                            <label for="cName">Mobile :</label>
                            <div>
                                <input type="text" class="form-control" name="cMobile" id="cName"
                                       placeholder="Enter your mobile number">
                                <span class="help-block"></span>
                            </div>

                        </div>
                        <div class="form-group required">
                            <label for="cEmail">OTP :</label>
                            <div>
                                <input type="text" class="form-control" name="otp" id="cEmail"
                                       placeholder="Enter OTP"/>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="text-center text-danger msg"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-4 col-lg-8">
                                <button type="button" onclick="trv.customer.otp_verify()"
                                        class="btn btn-primary btn-md btn-lg">Submit
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<?php
$this->load->view('sm/home/view_login_footer');
?>