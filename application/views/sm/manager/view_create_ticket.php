<?php $this->load->view('sm/home/view_header'); ?>

<style>
    .bot-border {
        border-bottom: 1px #f8f8f8 solid;
        margin: 5px 0 5px 0
    }
</style>

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
                        if ($this->session->flashdata('flashOK')) {
                            echo "<div class=\"alert alert-success fade in\">";
                            echo $this->session->flashdata('flashOK');
                            echo "</div>";
                        }
                        ?>

                        <form class="cmxform form-horizontal" id="signupForm" enctype="multipart/form-data"
                              method="post" action="<?php echo base_url() . 'sm/manager/save'; ?>">

                            <input type="hidden" name="hidden_support_type_id" id="hidden_support_type_id" value="">
                            <input type="hidden" name="hidden_machine_id" id="hidden_machine_id" value="">
                            <input type="hidden" name="hidden_insb_id" id="hidden_insb_id" value="">
                            <input type="hidden" name="hidden_insb_serial" id="hidden_insb_serial" value="">
                            <input type="hidden" id="hidden_department" name="department" value="">
                            <div class="form-group required">
                                <label for="send_from" class="control-label col-lg-3">Send From[Customer]</label>
                                <div class="col-lg-8">
                                    <?php
                                    $url = base_url() . 'sm/manager/';
                                    $dropdown_sendfrom_js = 'id="id_customer_list" class="form-control" onchange="trv.ticket.customer_machine();"';
                                    echo form_dropdown('send_from', $customer_list, '', $dropdown_sendfrom_js, 'required="required"');
                                    ?>
                                    <span class="error"><?php echo form_error('send_from'); /* print valitation error */ ?></span>
                                </div>
                            </div>


                            <div class="form-group required">
                                <label for="machine" class="control-label col-lg-3">Equipment/Item Sold</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="machine" name="machine"
                                            onchange="trv.ticket.machine_information()">
                                        <option value="">Select</option>
                                    </select>
                                    <span class="error"><?php echo form_error('machine'); /* print valitation error */ ?></span>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label for="cp_name" class="control-label col-lg-3">Contact Person Name</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="cp_name" id="cp_name"
                                           placeholder="Enter Contact Person Name">
                                    <span class="error"><?php echo form_error('cp_name'); /* print valitation error */ ?></span>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label for="cp_number" class="control-label col-lg-3">Contact Person Mobile</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="cp_number" id="cp_number"
                                           maxlength="11" placeholder="Enter Contact Person Mobile Number">
                                    <span class="error"><?php echo form_error('cp_number'); /* print valitation error */ ?></span>
                                </div>

                            </div>

                            <div class="form-group required">
                                <label for="cp_name" class="control-label col-lg-3">Complain Date</label>
                                <div class="col-lg-8">
                                    <input type="text" name="complain_date" class="form-control dateTo" id="complain_date" readonly="">
                                <span class="error"><?php echo form_error('complain_date'); /* print valitation error */ ?></span>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label for="request_details" class="control-label col-lg-3">Problem Details</label>
                                <div class="col-lg-8">

                                    <textarea class="form-control" id="request_details" rows="5"
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
                Support Type information
            </header>
            <div class="panel-body">
                <div id="support"></div>
            </div>
        </div>
    </div>
</div>


<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>
<script src="<?php echo base_url('/smdesign/assets/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
<script>
    $('#complain_date').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });
</script>
