<?php
$this->load->view('sm/home/view_header');
?>

<div class="row add-notify">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add New Customer Notification
                <a href="<?php echo base_url('sm/customer/notification') ?>" class="btn btn-danger btn-sm pull-right">Back
                    Notification</a>
            </header>
            <div class="panel-body">
                <div class="row">

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
                    <form class="form-horizontal" method="post"
                          action="<?php echo base_url() ?>sm/customer/send_sms_notification">


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <label class="control-label" for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <label class="control-label" for="machine">Equipment/Item</label>
                                <select class="form-control" name="machine" id="machine" onchange="trv.ntf.customer()">
                                    <option value="">Select</option>
                                    <?php if (!empty($machine)): ?>
                                        <?php foreach ($machine as $data): ?>
                                            <option value="<?= $data->mc_id; ?>"><?= $data->mc_name . ' ( Model -'. $data->mc_model .' )'; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('machine'); ?></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <label class="control-label" for="search">Select Customer</label>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <select name="from[]" id="search" class="form-control customer" size="8"
                                                multiple="multiple">
                                            <?php if (!empty($customer)): ?>
                                                <?php foreach ($customer as $data): ?>
                                                    <option value="<?= $data->customer_id; ?>"><?= $data->name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-2">
                                        <br>
                                        <br>
                                        <br>
                                        <button type="button" id="search_rightAll" class="btn btn-primary btn-block"><i
                                                    class="glyphicon glyphicon-forward"></i></button>
                                        <button type="button" id="search_rightSelected" class="btn btn-block"><i
                                                    class="glyphicon glyphicon-chevron-right"></i></button>
                                        <button type="button" id="search_leftSelected" class="btn btn-block"><i
                                                    class="glyphicon glyphicon-chevron-left"></i></button>
                                        <button type="button" id="search_leftAll" class="btn btn-warning btn-block"><i
                                                    class="glyphicon glyphicon-backward"></i></button>
                                    </div>

                                    <div class="col-sm-5">
                                        <select name="to[]" id="search_to" class="form-control" size="8"
                                                multiple="multiple"></select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <br>
                            <div class="col-md-8 col-md-offset-2">
                                <label class="control-label" for="sub">Notification type (General or
                                    SMS):</label><br>
                                <label class="checkbox-inline"><input type="radio" name="ntype"
                                                                      value="1">General</label>
                                <label class="checkbox-inline"><input type="radio" name="ntype" value="0">SMS</label>
                            </div>
                            <br>
                            <br>
                        </div>

                        <div class="form-group" style="display:none" id="another-phone">
                            <div class="col-md-8 col-md-offset-2">
                                <label class="control-label" for="anphone">Another Phone No : </label>
                                <textarea class="form-control" id="anphone" name="anphone" placeholder="Enter another mobile number"
                                          rows="4"></textarea>
                                <span class="label label-primary">Example : 01700000000,01800000000,01900000000</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <label class="control-label" for="sub">Message : <strong><span
                                                id="rchars">160</span> Character(s) Remaining</strong></label>
                                <textarea class="form-control message" id="sub" name="message" maxlength="160"
                                          rows="4"></textarea>
                                <span class="text-danger"><?php echo form_error('message'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success">Submit</button>
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
<script>
    $(document).ready(function () {

        const maxLength = 160;
        $('.message').keyup(function () {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });

        $('#search').multiselect({
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            },
            fireSearch: function (value) {
                return value.length > 3;
            }
        });



        $('input[name="ntype"]').click(function() {

            //alert(this.value);
            if (this.value == 0){

                $('#another-phone').show()
            }else {
                $('#another-phone').hide()
            }



        });


    });
</script>
