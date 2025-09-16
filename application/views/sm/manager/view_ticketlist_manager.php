<?php
$this->load->view('sm/home/view_header');
$ticket_status_array = ticket_status_array();
$priority_array = get_priority_array_dropdown();
$service_type_array = get_service_type_array_dropdown();
$priority_color_array = get_priority_color_array();
?>
<!-- Main Content Wrapper -->
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <b>Search Ticket</b>
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                </span>
            </header>
            <div class="panel-body">

                <form role="form" id="admin_form_ticket_search" class="form-horizontal bucket-form"
                      enctype="multipart/form-data" method="post" action="#">
                    <div class="form-group">

                        <div class="col-lg-12">
                            <div class="row">
                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1"> Ticket No.</label>
                                <div class="col-lg-3">
                                    <input type="text" name="ticket_no" placeholder="Ticket No." class="form-control">
                                </div>

                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Customer</label>
                                <div class="col-lg-3">
                                    <?php
                                    $customer_list = get_customer_array_dropdown_admin();
                                    $dropdown_js_customer = 'id="sendfrom" class="form-control" onchange="return getCustomerByAjax();"';
                                    echo form_dropdown('customer_list', $customer_list, '', $dropdown_js_customer, 'required="required"');
                                    ?>
                                </div>

                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Support Type</label>
                                <div class="col-lg-3">
                                    <span id="show_my_support_type">
                                        <select class="form-control" name="support_type">
                                            <option value="">Select</option>
                                            <?php foreach ($support_type as $s): ?>
                                                <option value="<?= $s->service_type_id; ?>"><?= $s->service_type_title; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </span> <!-- Important Ajax call-->
                                    <?php
                                    /*  $service_type_array = get_service_type_array_dropdown();
                                      $id_support_type_array = 'id ="support_type" class="form-control"';
                                      echo form_dropdown('support_type', $service_type_array, set_value('support_type'), $id_support_type_array);
                                     *
                                     */
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <br>
                            <div class="row">
                                <label for="status" class="col-sm-1 control-label col-lg-1">Status</label>
                                <div class="col-lg-3" id="status">
                                    <select name="status" class="form-control m-bot3">
                                        <option value="">Select</option>
                                        <option value="P">Pending</option>
                                        <option value="W">Working</option>
                                        <option value="O">On Progress</option>
                                        <option value="A">Complete</option>
                                        <option value="C">Cancel</option>
                                    </select>
                                </div>
                                <label for="inputSuccess" class="col-md-6 control-label col-lg-1">Service
                                    Eng.</label>
                                <div class="col-md-3">
                                    <?php
                                    $engineer_list = get_service_engineer_array();
                                    $dropdown_js_engineer = 'id="engineer_list" class="form-control" ';
                                    echo form_dropdown('engineer_list', $engineer_list, '', $dropdown_js_engineer, 'required="required"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <br>
                            <div class="row">
                                <label for="dateFrom" class="col-sm-1 control-label col-lg-1">Date From</label>
                                <div class="col-lg-3">
                                    <input type="text" name="dateFrom"  class="form-control dateFrom" id="dateFrom" readonly>
                                </div>

                                <label for="dateTo" class="col-sm-1 control-label col-lg-1">Date To</label>
                                <div class="col-lg-3">
                                    <input type="text" name="dateTo"  class="form-control dateTo" id="dateTo" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <br>
                            <div class="row">
                                <div class="col-lg-offset-1 col-lg-12 ">
                                    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-success" type="button"
                                            onclick="return admin_search_ticket();">Search
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div id="admin_inline_ticket_details"></div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div id="admin_ticket_aciton_msg_holder">

        </div>
    </div>
</div>
<!-- page start-->

<div class="row">
    <div class="col-sm-12">

        <section class="panel">
            <header class="panel-heading" id="admin_tick_list_header">
                All Ticket List :: <span id="admin_ticket_count">(<?php echo $total_rows; ?>)</span>
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                </span>
            </header>
            <div class="panel-body">
                <section id="no-more-tables">
                    <?php
                    if (validation_errors()) {
                        echo validation_errors('<div class="alert-warning fade in">', '</div>');
                    }

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
                    <div id="admin_tick_list_holder">
                        <?php if (!empty($record)) { ?>

                            <table class="table table-bordered table-striped table-condensed cf">
                                <thead class="cf">
                                <tr>
                                    <th>Ticket No</th>
                                    <!--<th>Priority</th>-->
                                    <th class="numeric">Customer Name</th>
                                    <th class="numeric">Equipment</th>
                                    <th class="numeric">Complain Date</th>
                                    <th class="numeric">Support Type</th>
                                    <th class="numeric">Contact Person</th>
                                    <th class="numeric">Created</th>
                                    <th class="numeric">Assign To</th>
                                    <th class="numeric">Lead Time</th>
                                    <th class="numeric">Status</th>
                                    <th class="numeric">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($record as $key => $value) {

                                    ?>
                                    <?php
                                    $version = $value->insb_version ? ", Version : " . $value->insb_version : '';
                                    $serial = $value->insb_serial ? ", Serial : " . $value->insb_serial : '';
                                    ?>
                                    <tr id="<?php echo $value->ticket_no; ?>">

                                        <td><a class="btn btn-primary" href="javascript:void(0)"
                                               onclick="return admin_get_ticket_details('<?php echo $value->srd_id; ?>', '<?php echo $value->ticket_no; ?>')"><?php echo $value->ticket_no; ?></a>
                                        </td>
                                        <!--<td style="color: <?php /*echo $priority_color_array[$value->priority]; */ ?>"><?php /*echo $priority_array[$value->priority]; */ ?></td>-->

                                        <td>
                                            <p>
                                                <?php
                                                $getCustomerName = get_customer_name_by_id($value->send_from);
                                                echo $getCustomerName;
                                                ?>
                                            </p>

                                        </td>
                                        <td><?= $value->mc_name . " ( Model :" .  $value->mc_model . $version . $serial . ")"; ?></td>
                                        <td style="white-space: nowrap"><?php echo $value->complain_date; ?></td>
                                        <td><?= array_key_exists($value->support_type, $service_type_array) ? $service_type_array[$value->support_type] : 'Unknown'; ?></td>


                                        <td><?php echo $value->contact_person.'<br>'.$value->contact_person_phn; ?></td>

                                        <td data-title="Date">
                                            <?php
                                            $timestamp = strtotime($value->created_date_time);
                                            echo get_relative_time($timestamp);
                                            echo "<br>";
                                            echo $value->created_date_time;
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            $getServiceEngName = getServiceEngName($value->send_to);
                                            echo $getServiceEngName;
                                            ?>
                                        </td>

                                        <td data-title="lead time">
                                            <?php
                                            $ticket_created = $value->created_date_time;
                                            $customer_location = $value->DIVISION_NAME;
                                            echo working_lead_time($ticket_created, $customer_location);
                                            ?>
                                        </td>


                                        <td>
                                            <span id="ticket_status_grid_<?php echo $value->srd_id; ?>">
                                            <?php
                                            echo $ticket_status_array[$value->status];
                                            ?>
                                                </span>
                                        </td>


                                        <td>
                                            <p><a class="btn btn-primary" href="javascript:void(0)"
                                                  onclick="return admin_get_ticket_details('<?php echo $value->srd_id; ?>', '<?php echo $value->ticket_no; ?>')"><i
                                                            class="icol-pencil"></i>ACTION</a>

                                                <?php if ($value->status <> 'C' && $value->status <> 'A') { ?>
                                                    |
                                                    <a onclick="return admin_cancel_ticket('<?php echo $value->srd_id; ?>','<?php echo $value->ticket_no; ?>')"
                                                       class="btn btn-danger simpleConfirm" href="javascript:void(0)"><i
                                                                class="icol-pencil"></i> CANCEL</a>
                                                <?php } ?>
                                            </p>

                                        </td>

                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>


                            <div class="dataTables_paginate paging_bootstrap pagination">
                                <ul>
                                    <?php echo $links; ?>
                                </ul>
                            </div>

                            <?php
                        }
                        ?>
                    </div>
                </section>
            </div>
        </section>
    </div>
</div>
<!-- page end-->


<!-- End Main Content Wrapper -->

<?php
$this->load->view('sm/home/view_footer');
?>
<script>
    $('.dateFrom').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });

    $('.dateTo').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });
</script>