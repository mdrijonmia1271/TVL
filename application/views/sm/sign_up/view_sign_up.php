<?php $this->load->view('sm/home/view_login_header'); ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" rel="stylesheet" />

<div class="signup">
    <div class="panel panel-default">
        <div class="panel-heading"><b>Customer Sign-Up</b></div>
        <div class="panel-body">
            <div class="cust-form">
                <form class="form-horizontal" id="signForm" autocomplete="off">

                    <div id="basic-info">
                        <h5 class="text-center">Client/Customer Login Basic</h5>
                        <hr>


                        <div class="form-group required">
                            <label class="control-label col-lg-2" for="cName">Name:</label>
                            <div class="col-lg-4">
                                <?= form_dropdown("cName", $customer_list, '', "class='form-control chosen' data-placeholder='Select a customer' id='cName'")?>
                                <span class="help-block"></span>
                            </div>

                            <label for="cUsername" class="control-label col-lg-2">Username</label>
                            <div class="col-lg-4">
                                <input name="cUsername" class="form-control" id="cUsername" type="text" placeholder="Enter Your Name">
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

                            <label for="cEmail" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="cEmail" id="cEmail"
                                       placeholder="Enter your Email"/>
                                <span class="help-block"></span>
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

                    </div>

                    <br>
                    <div class="cust-contact">
                        <h5 class="text-center">Equipment/Item Details</h5>
                        <hr>

                        <div class="form-group required">
                            <label for="mc" class="col-lg-2 control-label">Equipment/Item</label>
                            <div class="col-lg-4">
                                <select class="form-control chosen" id="mc" name="machine"
                                        onchange="trv.install_base.machine_info(this)" data-placeholder='Select a machine'>
                                    <option value="">Select an Equipment/Item</option>
                                    <?php foreach ($machine as $m): ?>
                                        <option value="<?= $m->mc_id; ?>"><?= $m->mc_name . ' (Model: ' . $m->mc_model . ')'; ?></option>
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
                                            <option value="<?= $c->id; ?>"><?= $c->name; ?></option>
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
                                            <option value="<?= $b->bu_id; ?>"><?= $b->bu_name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span class="help-block"></span>
                            </div>

                            <label class="col-lg-2 control-label" for="sector">Sector</label>
                            <div class="col-lg-4">
                                <select class="form-control chosen" id="sector" name="sector" data-placeholder="Select an sector">
                                    <option value="">Select a Sector</option>
                                    <option value="govt">Govt</option>
                                    <option value="private">Private</option>
                                    <option value="corporate">Corporate</option>
                                </select>
                                <span class="help-block"></span>
                            </div>

                        </div>

                        <div class="form-group required">
                            <label class="col-lg-2 control-label" for="mcSrial">Serial No.(S/N)</label>
                            <div class="col-lg-4">
                                <input type="text" name="mcSrial" id="mcSrial"
                                       placeholder="Enter Serial number" class="form-control">
                                <span class="help-block"></span>
                            </div>

                            <label class="col-lg-2 no-required control-label" for="picture">Equipment Picture : </label>
                            <div class="col-lg-4">
                                <input type="file" name="picture" id="picture" class="form-control">
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

<?php $this->load->view('sm/home/view_login_footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

<script>
    $(function () {
        //$('.chosen').chosen();
    });
</script>



