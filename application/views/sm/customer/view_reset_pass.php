<?php $this->load->view('sm/home/view_header'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                Customer Password Reset
            </header>
            <div class="panel-body">
                <div class="col-lg-offset-2">
                    <form class="form-horizontal passForm">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="newPass">New Password:</label>
                            <div class="col-sm-6">
                                <input type="password" name="cuPass" class="form-control" id="newPass" placeholder="Enter New password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="confirm">Confirm Password:</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="conPass" id="confirm" placeholder="Enter Confirm password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" onclick="trv.customer.reset_pass()" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                    <div class="text-center res"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>