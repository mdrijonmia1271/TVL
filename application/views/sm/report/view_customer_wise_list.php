<?php $this->load->view('sm/home/view_header'); ?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <b>Client/Customer Wise Summary Report </b>
                <span class=" pull-right" style="margin-top: -6px">
                    <button class="btn btn-inverse" onclick="trv.exl('customerReport','customer.')"><i
                                class="glyphicon glyphicon-print"></i> Excel Export </button>

                </span>
            </header>
            <div class="panel-body">
                <form role="form" class="form-horizontal bucket-form" enctype="multipart/form-data" method="post"
                      action="<?php echo base_url() . 'sm/report/customer_wise_list_search'; ?>">

                    <div class="form-group">

                        <div class="col-lg-12">

                            <div class="row">
                                <label for="name" class="col-sm-1 control-label col-lg-2"> Customer Name</label>
                                <div class="col-lg-4">
                                    <?php
                                    $dropdown_js_department = 'id="Customer"  class="form-control";';
                                    echo form_dropdown('name', $customer_list, '', $dropdown_js_department);
                                    ?>
                                    <span class="error"><?php echo form_error('name'); /* print valitation error */ ?>
                                </div>

                                <label for="Month" class="col-sm-1 control-label col-lg-1">Department</label>
                                <div class="col-lg-4">
                                   <select class="form-control" name="department">
                                       <option value="">Select</option>
                                       <?php foreach ($department as $d): ?>
                                       <option value="<?= $d->id ?>"><?= $d->name ?></option>
                                       <?php endforeach; ?>
                                   </select>
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <label for="Year" class="col-sm-1 control-label col-lg-2">Year</label>
                                <div class="col-lg-4">
                                    <?php
                                    $dropdown_js1 = 'id="dob_year" style="float:left;" class="form-control";';
                                    echo form_dropdown('dob_year', $year_array, '', $dropdown_js1);
                                    ?>
                                </div>

                                <label for="Month" class="col-sm-1 control-label col-lg-1">Month</label>
                                <div class="col-lg-4">
                                    <?php
                                    $dropdown_js2 = 'id="dob_month" style="float:left;" class="form-control";';
                                    echo form_dropdown('dob_month', $month_array, '', $dropdown_js2);
                                    ?>
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <label for="Date Form" class="col-sm-1 control-label col-lg-2">Date Form</label>
                                <div class="col-lg-4">

                                    <input id="datepicker_from" type="text" name="date_from" placeholder="Date Form"
                                           class="form-control" readonly/>
                                </div>

                                <label for="Date To" class="col-sm-1 control-label col-lg-1">Date To</label>
                                <div class="col-lg-4">

                                    <input id="datepicker_to" type="text" name="date_to" placeholder="Date To"
                                           class="form-control" readonly/>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-offset-2 col-lg-3">
                        <button class="btn btn-success" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<br><br>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Client/Customer Wise: Request List
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                    <a class="fa fa-cog" href="javascript:;"></a>
                    <!--<a class="fa fa-times" href="javascript:;"></a>-->
                </span>
            </header>
            <div class="panel-body">
                <div class="position-center1">


                    <table class="table table-bordered table-striped table-condensed cf" width="100%" border="5">
                        <thead class="cf">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Email</th>
                            <th scope="col">Total Request</th>

                            <th scope="col" colspan="5">Status</th>
                            <th scope="col" colspan="<?php echo $rows_supp_type = num_of_rows_support_type(); ?>">
                                Support Type
                            </th>
                            <!--<th scope="col" colspan="<?php /*echo $rows_priority = num_of_rows_priority(); */ ?>">Priority
                            </th>-->

                            <!--<th scope="col">Completion Time</th>-->
                        </tr>
                        <tr>
                            <th scope="col">&nbsp;</th>
                            <th scope="col">&nbsp;</th>
                            <th scope="col">&nbsp;</th>
                            <th scope="col">&nbsp;</th>


                            <th>Pending</th>
                            <th>Working</th>
                            <th>On Progress</th>
                            <th>Complete</th>
                            <th>Cancel</th>

                            <?php
                            foreach ($support_type_list as $val_supp_head) { ?>

                                <th><?php echo get_support_type_name_by_id($val_supp_head->service_type_id); ?></th>
                            <?php } ?>


                            <?php
                            /*foreach ($priority_list as $val_priority_head) { */ ?><!--

                                <th><?php /*echo get_priority_name_by_id($val_priority_head->priority_id); */ ?></th>
                            --><?php /*} */ ?>


                            <!--<th>&nbsp;</th>-->

                        </tr>
                        </thead>

                        <tbody>
                        <?php

                        //  echo '<pre>';   print_r($record);exit;
                        $total_request_sum = 0;

                        $total_status_pending_sum  = 0;
                        $total_status_working_sum  = 0;
                        $total_status_progress_sum = 0;
                        $total_status_approve_sum  = 0;
                        $total_status_cancel_sum   = 0;

                        $total_support_1  = 0;
                        $total_priority_1 = 0;
                        $supp_arr         = array();
                        $prioraty_arr     = array();

                        if (!empty($record)) {

                            foreach ($record as $key => $value) {
                                ?>
                                <tr>

                                <td><?php echo $value->name; ?>&nbsp;</td>
                                <td><?php echo $value->mobile; ?>&nbsp;</td>
                                <td><?php echo $value->email; ?>&nbsp;</td>
                                <td><?php
                                    echo $total_request_customer = total_request_customer($value->customer_id);
                                    $total_request_sum = $total_request_sum + $total_request_customer;
                                    ?>&nbsp;
                                </td>

                                <td><?php
                                    $get_customer_status_pending = get_customer_status_pending($value->customer_id);
                                    $total_status_pending_sum    = $total_status_pending_sum + $get_customer_status_pending;
                                    ?>&nbsp;
                                </td>
                                <td><?php
                                    echo $get_customer_status_working = get_customer_status_working($value->customer_id);
                                    $total_status_working_sum = $total_status_working_sum + $get_customer_status_working;
                                    ?>&nbsp;
                                </td>
                                <td><?php
                                    echo $get_customer_status_progress = get_customer_status_progress($value->customer_id);
                                    $total_status_progress_sum = $total_status_progress_sum + $get_customer_status_progress;
                                    ?>&nbsp;
                                </td>
                                <td><?php
                                    echo $get_customer_status_approve = get_customer_status_approve($value->customer_id);
                                    $total_status_approve_sum = $total_status_approve_sum + $get_customer_status_approve;
                                    ?>&nbsp;
                                </td>
                                <td><?php
                                    echo $get_customer_status_cancel = get_customer_status_cancel($value->customer_id);
                                    $total_status_cancel_sum = $total_status_cancel_sum + $get_customer_status_cancel;
                                    ?>&nbsp;
                                </td>


                                <?php foreach ($support_type_list as $val_supp_body) { ?>
                                    <td><?php
                                        echo $get_total_support_type1 = get_total_support_type_customer($value->customer_id, $val_supp_body->service_type_id);
                                        $total_support_1                             = $total_support_1 + $get_total_support_type1;
                                        $supp_arr[$val_supp_body->service_type_id][] = $get_total_support_type1;


                                        ?>&nbsp;
                                    </td>
                                <?php } ?>


                                <?php /*foreach ($priority_list as $val_priority_body) { */ ?><!--
                                    <td><?php
                                /*                                        echo $get_total_priority1 = get_total_priority_customer($value->customer_id, $val_priority_body->priority_id);
                                                                        $total_priority_1 = $total_priority_1 + $get_total_priority1;
                                                                        $prioraty_arr[$val_priority_body->priority_id][] = $get_total_priority1;

                                                                        */ ?>&nbsp;
                                    </td>
                                    --><?php
                                /*                                }
                                                                */ ?>

                                <!--<td>&nbsp;</td>-->


                                <?php
                            }
                            ?>
                            </tr>
                            <?php
                        } else {
                            echo "<div class=\"alert alert-warning fade in\">"; //alert alert-block alert-danger fade in
                            echo 'No Data Found.';
                            echo "</div>";
                        }

                        ?>


                        <?php if (!empty($record)) { ?>
                            <tr>
                                <th scope="row">&nbsp;Total</th>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><?php echo $total_request_sum; ?></td>

                                <td><?php echo $total_status_pending_sum; ?></td>
                                <td><?php echo $total_status_working_sum; ?></td>
                                <td><?php echo $total_status_progress_sum; ?></td>
                                <td><?php echo $total_status_approve_sum; ?></td>
                                <td><?php echo $total_status_cancel_sum; ?></td>

                                <?php foreach ($supp_arr as $key_s => $value_s) { ?>
                                    <td>
                                        <?php echo array_sum($value_s); ?>
                                    </td>
                                <?php } ?>


                                <?php foreach ($prioraty_arr as $key_p => $value_p) { ?>
                                    <td>
                                        <?php echo array_sum($value_p); ?>
                                    </td>
                                <?php } ?>


                                <!--<td>SUM&nbsp;</td>-->


                            </tr>

                        <?php } ?>
                        </tbody>

                    </table>


                    <table class="table table-bordered" style="display: none" id="customerReport">
                        <thead class="cf">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Email</th>
                            <th scope="col">Total Request</th>

                            <th scope="col" colspan="5">Status</th>
                            <th scope="col" colspan="<?php echo $rows_supp_type = num_of_rows_support_type(); ?>">
                                Support Type
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">&nbsp;</th>
                            <th scope="col">&nbsp;</th>
                            <th scope="col">&nbsp;</th>
                            <th scope="col">&nbsp;</th>


                            <th>Pending</th>
                            <th>Working</th>
                            <th>On Progress</th>
                            <th>Complete</th>
                            <th>Cancel</th>

                            <?php
                            foreach ($support_type_list as $val_supp_head) { ?>

                                <th><?php echo get_support_type_name_by_id($val_supp_head->service_type_id); ?></th>
                            <?php } ?>

                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $total_request_sum = 0;

                        $total_status_pending_sum  = 0;
                        $total_status_working_sum  = 0;
                        $total_status_progress_sum = 0;
                        $total_status_approve_sum  = 0;
                        $total_status_cancel_sum   = 0;

                        $total_support_1  = 0;
                        $total_priority_1 = 0;
                        $supp_arr         = array();
                        $prioraty_arr     = array();

                        if (!empty($record)) {

                            foreach ($record as $key => $value) {
                                ?>
                                <tr>

                                <td><?php echo $value->name; ?>&nbsp;</td>
                                <td><?php echo $value->mobile; ?>&nbsp;</td>
                                <td><?php echo $value->email; ?>&nbsp;</td>
                                <td><?php
                                    echo $total_request_customer = total_request_customer($value->customer_id);
                                    $total_request_sum = $total_request_sum + $total_request_customer;
                                    ?>&nbsp;
                                </td>

                                <td><?php
                                    echo $get_customer_status_pending = get_customer_status_pending($value->customer_id);
                                    $total_status_pending_sum = $total_status_pending_sum + $get_customer_status_pending;
                                    ?>&nbsp;
                                </td>
                                <td><?php
                                    echo $get_customer_status_working = get_customer_status_working($value->customer_id);
                                    $total_status_working_sum = $total_status_working_sum + $get_customer_status_working;
                                    ?>&nbsp;
                                </td>
                                <td><?php
                                    echo $get_customer_status_progress = get_customer_status_progress($value->customer_id);
                                    $total_status_progress_sum = $total_status_progress_sum + $get_customer_status_progress;
                                    ?>&nbsp;
                                </td>
                                <td><?php
                                    echo $get_customer_status_approve = get_customer_status_approve($value->customer_id);
                                    $total_status_approve_sum = $total_status_approve_sum + $get_customer_status_approve;
                                    ?>&nbsp;
                                </td>
                                <td><?php
                                    echo $get_customer_status_cancel = get_customer_status_cancel($value->customer_id);
                                    $total_status_cancel_sum = $total_status_cancel_sum + $get_customer_status_cancel;
                                    ?>&nbsp;
                                </td>


                                <?php foreach ($support_type_list as $val_supp_body) { ?>
                                    <td><?php
                                        echo $get_total_support_type1 = get_total_support_type_customer($value->customer_id, $val_supp_body->service_type_id);
                                        $total_support_1                             = $total_support_1 + $get_total_support_type1;
                                        $supp_arr[$val_supp_body->service_type_id][] = $get_total_support_type1;


                                        ?>&nbsp;
                                    </td>
                                <?php } ?>

                                <?php
                            }
                            ?>
                            </tr>
                            <?php
                        } else {
                            echo "<div class=\"alert alert-warning fade in\">"; //alert alert-block alert-danger fade in
                            echo 'No Data Found.';
                            echo "</div>";
                        }

                        ?>


                        <?php if (!empty($record)) { ?>
                            <tr>
                                <th scope="row">&nbsp;Total</th>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><?php echo $total_request_sum; ?></td>

                                <td><?php echo $total_status_pending_sum; ?></td>
                                <td><?php echo $total_status_working_sum; ?></td>
                                <td><?php echo $total_status_progress_sum; ?></td>
                                <td><?php echo $total_status_approve_sum; ?></td>
                                <td><?php echo $total_status_cancel_sum; ?></td>

                                <?php foreach ($supp_arr as $key_s => $value_s) { ?>
                                    <td>
                                        <?php echo array_sum($value_s); ?>
                                    </td>
                                <?php } ?>


                                <?php foreach ($prioraty_arr as $key_p => $value_p) { ?>
                                    <td>
                                        <?php echo array_sum($value_p); ?>
                                    </td>
                                <?php } ?>


                                <!--<td>SUM&nbsp;</td>-->


                            </tr>

                        <?php } ?>
                        </tbody>

                    </table>


                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <?php echo $links; ?>
                        </ul>
                    </div>


                </div>

            </div>
        </section>


    </div>
</div>


<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>    