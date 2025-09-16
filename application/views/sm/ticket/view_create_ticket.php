<?php
$this->load->view('sm/home/view_header');
$customer_auto_id = $this->session->userdata('customer_auto_id');
?>

    <div class="row">
        <div class="col-lg-8">
            <div class="panel">
                <header class="panel-heading">
                    Create Ticket
                </header>
                <div class="panel-body">
                    <div class="position">
                        <div class="form">
                            <?php
                            if ($this->session->flashdata('flashError')) {
                                echo "<div class=\"text-center alert alert-danger fade in\">";
                                echo $this->session->flashdata('flashError');
                                echo "</div>";
                            }
                            ?>
                            <form class="cmxform form-horizontal" id="signupForm" enctype="multipart/form-data"
                                  method="post" action="<?php echo base_url() . 'sm/ticket/save'; ?>">
                                <input type="hidden" id="hidden_support_type_id" name="hidden_support_type_id" value="">
                                <input type="hidden" id="hidden_machine_id" name="hidden_machine_id" value="">
                                <input type="hidden" id="hidden_insb_id" name="hidden_insb_id" value="">
                                <input type="hidden" id="hidden_insb_serial" name="hidden_insb_serial" value="">
                                <input type="hidden" id="hidden_department" name="department" value="">
                                <div class="form-group required">
                                    <label for="machine" class="control-label col-lg-3">Equipment/Item Sold</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="machine" name="machine"
                                                onchange="trv.ticket.support_type_info()">
                                            <option value="">Select</option>

                                            <?php if (!empty($machine)): ?>

                                                <?php foreach ($machine as $item) : ?>

                                                    <?php
                                                    $version = $item->insb_version ? ", Version : " . $item->insb_version : '';
                                                    $serial = $item->insb_serial ? ", Serial : " . $item->insb_serial : '';
                                                    ?>

                                                    <option value="<?= $item->mc_id . ',' . $item->insb_id . ',' . $item->insb_serial; ?>"><?= $item->mc_name . " ( Model :" . $item->mc_model . $version . $serial . ")"; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                        </select>
                                        <span class="error"><?php echo form_error('machine'); /* print valitation error */ ?></span>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label for="cp_name" class="control-label col-lg-3">Contact Person Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="cp_name" id="cp_name"
                                               placeholder="Enter Contact Person Name">
                                        <span class="error"><?php echo form_error('cp_name'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group required">
                                    <label for="cp_number" class="control-label col-lg-3">Contact Person Mobile</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="cp_number" id="cp_number"
                                               maxlength="11" placeholder="Enter Contact Person Mobile Number">
                                        <span class="error"><?php echo form_error('cp_number'); ?></span>
                                    </div>
                                </div>


                                <div class="form-group required">
                                    <label for="request_details" class="control-label col-lg-3">Problem Details</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control " id="request_details"
                                                  name="request_details"></textarea>
                                        <span class="error"><?php echo form_error('request_details'); /* print valitation error */ ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-info">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <div class="panel">
                <header class="panel-heading">
                    Support Type Information
                </header>
                <div class="panel-body">
                    <div id="support-info"></div>
                </div>
            </div>
        </div>


    </div>

    <!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>