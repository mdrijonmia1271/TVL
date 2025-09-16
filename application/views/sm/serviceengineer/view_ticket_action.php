<?php $this->load->view('sm/home/view_header'); ?>

<div class="row">
    <div class="col-lg-12">
        <header class="panel-heading">Ticket Details</header>

        <section class="panel" style="background-color: #fff;">

            <header class="panel-heading tab-bg-dark-navy-blue">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#home">Ticket Info</a>
                    </li>
                    <!--<li class="">
                        <a data-toggle="tab" href="#about">Location Details</a>
                    </li>-->
                    <li class="">
                        <a data-toggle="tab" href="#action">Action Log</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#profile">Comment Log</a>
                    </li>
                </ul>
            </header>

            <div class="panel-body profile-information">
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <div class="col-lg-12">
                            <table class="table table-bordered  table-condensed cf">
                                <tbody>
                                <tr>
                                    <th> Ticket No:</th>
                                    <td>
                                        <?php echo $view->ticket_no; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th> Equipment/Item :</th>
                                    <td>
                                        <?php
                                        $version = $view->insb_version ? ", Version : " . $view->insb_version : '';
                                        $serial = $view->insb_serial ? ", Serial : " . $view->insb_serial : '';
                                        ?>
                                        <?php echo $view->mc_name . " ( Model : " . $view->mc_model  . $version  . $serial . ")"; ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Customer Name:</th>
                                    <td>
                                        <?php $getCustomerName = get_customer_name_by_id($view->send_from);
                                        echo $getCustomerName;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Priority:</th>
                                    <td><?php echo $get_priority_array_dropdown[$view->priority]; ?></td>
                                </tr>
                                <tr>
                                    <th>Support Type:</th>
                                    <td><?php echo $get_service_type_array_dropdown[$view->support_type]; ?></td>
                                </tr>
                                <tr>
                                    <th>Details:</th>
                                    <td><?php echo $view->request_details; ?></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <?php
                                        $ticket_status_array = ticket_status_array();
                                        echo $ticket_status_array[$view->status];
                                        ?>
                                    </td>
                                </tr>

                                <?php $upload_doc = 'upload/job_report/' . $view->srd_id . '/' . $view->job_report;?>
                                <?php if (file_exists($upload_doc)): ?>
                                <tr>
                                    <th>Updated Job Report :</th>
                                    <td>
                                        <a href="<?= base_url('upload/job_report/' . $view->srd_id . '/' . $view->job_report) ?>"
                                           class="btn btn-primary" target="_blank">Download Updated Report</a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </table>
                            <hr>
                        </div>
                    </div>

                    <!--<div id="about" class="tab-pane">
                        <table class="table table-bordered  table-condensed cf">
                            <tbody>
                                <tr>
                                    <th>Support Location  :</th> 
                                    <td><?php /*echo $view->service_add_details; */ ?></td>
                                </tr> 
                                <tr>
                                    <th>Division :</th> 
                                    <td><?php /*echo get_division_by_id($view->service_add_division); */ ?></td>
                                </tr>
                                <tr>
                                    <th>District :</th> 
                                    <td><?php /*echo get_district_by_id($view->service_add_district); */ ?></td>
                                </tr>     
                                <tr>
                                    <th>Upazila  :</th> 
                                    <td><?php /*//echo get_district_by_id($view->service_add_district);  */ ?></td>
                                </tr>                                                                                       
                            </tbody> 
                       </table>     
            </div> -->

                    <div id="action" class="tab-pane">
                        <?php if (!empty($ticket_trans_flow)) { ?>
                            <table class="table table-bordered table-striped table-condensed cf">
                                <thead class="cf">
                                <tr>
                                    <th class="numeric">Date/Owner</th>
                                    <th class="numeric">Action Type</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                foreach ($ticket_trans_flow as $key => $value) {
                                    ?>

                                    <tr>
                                        <td data-title="Date">
                                            <?php
                                            $Name = '';
                                            $created_by_autoId = $value->created_by;
                                            $created_by_type = $value->created_by_type;



                                            print_r($created_by_autoId);

                                            if ($created_by_type == 'admin') {
                                                $Name = get_admin_name_by_id($created_by_autoId);
                                            } elseif ($created_by_type == 'customer') {
                                                $Name = get_customer_name_by_id($created_by_autoId);
                                            } elseif ($created_by_type == 'engineer') {
                                                $Name = get_engineer_name_by_id($created_by_autoId);
                                            }
                                            ?>
                                            <?php echo $Name; ?>
                                            [<?php echo $created_by_type; ?>
                                            ]<br> <?php echo $value->created_date_time; ?>
                                        </td>

                                        <td>
                                            <?php echo $ticket_status_array[$value->status]; ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>


                            <?php
                        } else {
                            echo 'No History Available';
                        }
                        ?>
                    </div>
                    <div id="profile" class="tab-pane">

                        <?php if (!empty($record)) { ?>

                            <table class="table table-bordered table-striped table-condensed cf">
                                <thead class="cf">
                                <tr>
                                    <th class="numeric">Date/Owner</th>
                                    <th class="numeric">Comment</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($record as $key => $value) {
                                    ?>

                                    <tr>

                                        <td data-title="Date">
                                            <?php $getcommenterName = get_commenter_name_by_id($value->comment_from, $value->comments_by);
                                            echo $getcommenterName;
                                            ?>
                                            [<?php echo $value->comment_from ?>
                                            ]<br> <?php echo $value->comments_date_time; ?>
                                        </td>

                                        <td data-title="Comment">
                                            <p><?php echo $value->comments; ?></p>
                                        </td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>

                            <?php
                        }
                        ?>

                    </div>

                </div>
            </div>
        </section>
    </div>
</div>

<?php
$status = $view->status;
if ($status == 'P' || $status == 'W' || $status == 'O') { //pending or working
    ?>
    <div class="row">
        <div class="col-lg-12">
            <header class="panel-heading">Take Action</header>
            <div class="panel" style="background-color: #fff;">

                <div class="panel-body">

                    <form class="cmxform form-horizontal" id="signupForm" enctype="multipart/form-data" method="post"
                          action="<?php echo base_url() . 'sm/serviceengineer/update_ticket_status'; ?>">
                        <input type="hidden" name="srd_id" value="<?php echo $view->srd_id; ?>">
                        <input type="hidden" name="ticket_no" value="<?php echo $view->ticket_no; ?>">
                        <input type="hidden" name="customer" value="<?= $view->send_from; ?>">
                        <input type="hidden" name="machine" value="<?= $view->machine_ref_id; ?>">

                        <div class="form-group required">
                            <label for="status" class="control-label col-lg-3">Update Status</label>
                            <div class="col-lg-6">
                                <?php
                                $dropdown_js_priority = 'id="status" class="form-control";';
                                $ticket_service_en_status = ticket_service_en_status_array();
                                echo form_dropdown('status', $ticket_service_en_status, '', $dropdown_js_priority);
                                ?>
                                <span class="error"><?php echo form_error('status'); ?>
                            </div>
                        </div>

                        <div class="add-field">
                            <div class="form-group">
                                <label for="spare" class="control-label col-lg-3">Spare Parts</label>
                                <div class="col-lg-3">
                                    <select class="form-control" id="spare" name="spare[]">
                                        <option value="">Select</option>
                                        <?php if (!empty($spare)): ?>
                                            <?php foreach ($spare as $sp): ?>
                                                <option value="<?= $sp->sp_id; ?>"><?= $sp->sp_name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <label for="qty" class="control-label col-lg-1">Quantity</label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" id="qty" name="sp_qty[]">
                                </div>

                                <div class="add-more">
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="addrow">Add More</a>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="addi_spare" class="control-label col-lg-3">Other Spare Parts</label>
                            <div class="col-lg-6">
                                <?php

                                $addi_spare_arry = array(
                                    'name' => 'addi_spare',
                                    'id' => 'addi_spare',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Other Spare Parts',
                                    'value' => set_value('addi_spare'),
                                    'cols' => '10',
                                    'rows' => '3'
                                );

                                echo form_textarea($addi_spare_arry);
                                ?>
                                <span class="error"><?php echo form_error('addi_spare'); ?></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="ticketcomment" class="control-label col-lg-3">Problem Details</label>
                            <div class="col-lg-6">
                                <?php
                                $ticketcomment_arry = array(
                                    'name' => 'ticketcomment',
                                    'id' => 'ticketcomment',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Comment on Problem',
                                    'value' => set_value('ticketcomment'),
                                    'cols' => '10',
                                    'rows' => '3'
                                );

                                echo form_textarea($ticketcomment_arry);
                                ?>
                                <span class="error"><?php echo form_error('ticketcomment'); ?></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="action_comment" class="control-label col-lg-3">Action Details</label>
                            <div class="col-lg-6">
                                <?php

                                $action_comment_arry = array(
                                    'name' => 'action_comment',
                                    'id' => 'action_comment',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Comment on Action',
                                    'value' => set_value('action_comment'),
                                    'cols' => '10',
                                    'rows' => '3'
                                );

                                echo form_textarea($action_comment_arry);
                                ?>
                                <span class="error"><?php echo form_error('action_comment'); ?></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="customer_comment" class="control-label col-lg-3">Comment on Customer</label>
                            <div class="col-lg-6">
                                <?php
                                $ticketcomment_arry = array(
                                    'name' => 'customer_comment',
                                    'id' => 'customer_comment',
                                    'class' => "form-control",
                                    'placeholder' => 'Enter Comment on Customer',
                                    'value' => set_value('customer_comment'),
                                    'cols' => '10',
                                    'rows' => '2'
                                );

                                echo form_textarea($ticketcomment_arry);
                                ?>
                                <span class="error"><?php echo form_error('customer_comment'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="rating" class="control-label col-lg-3">Rating on Customer</label>
                            <div class="col-lg-6">
                                <select class="form-control" name="eng_rating" id="rating">
                                    <option value="">Select</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Star</option>
                                    <option value="3">3 Star</option>
                                    <option value="4">4 Star</option>
                                    <option value="5">5 Star</option>
                                </select>
                                <span class="error"><?php echo form_error('rating'); ?></span>
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
<?php } ?>

<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>

<script>
    $(document).ready(function () {

        $("#addrow").on("click", function () {

            var newRow = $('<div class="form-group required">');
            var cols = "";

            cols += '<label for="spare" class="control-label col-lg-3">Spare Parts</label>' +
                '<div class="col-lg-3">' +
                '<select class="form-control" id="spare" name="spare[]">' +
                '<option value="">Select</option>' +
                '<?php if (!empty($spare)){  foreach ($spare as $sp){?>' +
                '<?php  echo '<option value="' . $sp->sp_id . '">' . $sp->sp_name . '</option>';        }} ?>' +
                '</select> </div>';

            cols += '<label for="qty" class="control-label col-lg-1">Quantity</label><div class="col-lg-2">' +
                '<input type="text" id="qty" class="form-control" name="sp_qty[]"/></div>';

            cols += '<div class="delete-more"><a href="javascript:void(0)" class="ibtnDel btn btn-danger btn-sm">Delete</a> </div>';
            newRow.append(cols);
            $(".add-field").append(newRow);

        });

        $(".add-field").on("click", ".ibtnDel", function (event) {
            $(this).closest(".form-group").remove();
        });

    });

</script>