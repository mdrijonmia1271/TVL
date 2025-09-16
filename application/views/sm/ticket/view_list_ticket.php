<?php
$this->load->view('sm/home/view_header');

$customer_auto_id = $this->session->userdata('customer_auto_id');
$ticket_status_array = ticket_status_array();
$priority_array = get_priority_array_dropdown();
$service_type_array = get_service_type_array_dropdown();
$service_task_name_array = get_service_task_name_array_dropdown($customer_auto_id);
?>

<!-- page start-->

<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <header class="panel-heading">
                <b>Search Ticket</b>
            </header>
            <div class="panel-body">
                <form role="form" id="customer_ticket_search" class="form-horizontal bucket-form"
                      enctype="multipart/form-data" method="post" action="#">
                    <div class="form-group">

                        <div class="col-lg-12">
                            <div class="row">
                                <label for="inputSuccess" class="control-label col-lg-1">Ticket No.</label>
                                <div class="col-lg-4">
                                    <input type="text" name="ticket_no" placeholder="Ticket No." class="form-control">
                                </div>

                                <label for="inputSuccess" class="control-label col-lg-2">Support Type</label>
                                <div class="col-lg-4">

                                    <select class="form-control" id="inputSuccess" name="support_type">
                                        <option value="">select</option>
                                        <?php foreach ($support_type as $s): ?>
                                            <option value="<?= $s->su_type_id; ?>"><?= $s->service_type_title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="row">
                                <br>

                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Status</label>
                                <div class="col-lg-4" placeholder="Status">
                                    <select name="status" class="form-control m-bot3">
                                        <option value="">Select</option>
                                        <option value="P">Pending</option>
                                        <option value="W">Working</option>
                                        <option value="A">Complete</option>
                                        <option value="C">Cancel</option>
                                    </select>

                                </div>
                                <br><br><br>
                                <div class="col-lg-offset-1 col-lg-3">
                                    <button class="btn btn-success" type="button" id="btn_customer_ticketsearch"
                                            onclick="return customer_search_ticket();">Search
                                    </button>
                                </div

                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div id="customer_inline_ticket_details"></div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">

        <section class="panel">
            <header class="panel-heading" id="customer_tick_list_header">
                Ticket List | Total Ticket : <span id="customer_ticket_count"><?php echo $total_rows; ?></span>
            </header>
            <div class="panel-body">
                <section id="no-more-tables">
                    <div id="customer_tick_list_holder">
                        <?php
                        if (!empty($record)) {
                            if (!empty($record)) { ?>
                                <table class="table table-bordered  table-condensed cf">
                                <thead class="cf">
                                <tr>
                                    <th>Ticket No</th>
                                    <th>Equipment</th>
                                    <th>Support Type</th>
                                    <th>Contact Person</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Lead Time</th>
                                    <th>Action</th>
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

                                    <tr style="background-color: <?php echo ''; ?>">
                                        <td>
                                            <a onclick="return customer_view_ticket('<?php echo $value->ticket_no; ?>')"
                                               href="javascript:void(0)"><?php echo $value->ticket_no; ?></a>
                                        </td>

                                        <td><?= $value->mc_name . " ( Model :" .  $value->mc_model . $version . $serial . ")"; ?></td>

                                        <td>
                                            <?php
                                            if (!empty($value->support_type)) {
                                                echo $service_type_array[$value->support_type];
                                            }
                                            ?>
                                        </td>

                                        <td><?php echo 'Name : ' .$value->contact_person.'&nbsp & &nbsp'.'Phone : '.$value->contact_person_phn; ?></td>

                                        <td id="customer_tickt_status_<?php echo $value->srd_id; ?>">
                                            <?php
                                            echo $ticket_status_array[$value->status];
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            $timestamp = strtotime($value->created_date_time);
                                            echo get_relative_time($timestamp);
                                            echo "<br>";
                                            echo date_convert($value->created_date_time);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $ticket_created = $value->created_date_time;
                                            $customer_location = $value->DIVISION_NAME;
                                            echo working_lead_time($ticket_created, $customer_location);
                                            ?>
                                        </td>
                                        <td>
                                            <a onclick="return customer_view_ticket('<?php echo $value->ticket_no; ?>')"
                                               class="btn btn-primary" href="javascript:void(0)">VIEW</a>
                                            <?php if ($value->status == 'A' && empty($value->cm_on_eng)) : ?>
                                                <a href="javascript:void()" onclick="trv.customer.cm_eng('<?= $value->srd_id; ?>')"  class="btn btn-success">Comments</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>

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
