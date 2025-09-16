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
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                </span>
            </header>
            <div class="panel-body">
                <form role="form" class="form-horizontal bucket-form" enctype="multipart/form-data" method="post"
                      action="<?php echo base_url() . 'sm/serviceengineer/ticketsearch'; ?>">
                    <div class="form-group">

                        <div class="col-lg-12">
                            <div class="row">
                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1"> Ticket No.</label>
                                <div class="col-lg-3">
                                    <input type="text" name="ticket_no" placeholder="Ticket No." class="form-control">
                                </div>

                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Priority</label>
                                <div class="col-lg-3">
                                    <?php
                                    $id_priority_array = 'id ="priority" class="form-control"';
                                    echo form_dropdown('priority', $priority_array, set_value('priority'), $id_priority_array);
                                    ?>
                                </div>

                                <!--   <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Support Type</label>
                                <div class="col-lg-3"  placeholder="Status">
                                    <?php
                                /*    $service_type_array = get_service_type_array_dropdown();
                                    $id_support_type_array = 'id ="support_type" class="form-control"';
                                    echo form_dropdown('support_type', $service_type_array, set_value('support_type'), $id_support_type_array);
                                 */
                                ?>
                                </div> -->
                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Status</label>
                                <div class="col-lg-3" placeholder="Status">
                                    <select name="status" class="form-control m-bot3">
                                        <option value="">Select</option>
                                        <!--<option value="P">Pending</option> -->
                                        <option value="W">Working</option>
                                        <option value="O">On Progress</option>
                                        <option value="A">Complete</option>
                                        <!--<option value="C">Cancel</option>-->
                                    </select>

                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label for="dep_ref_id" class="col-sm-1 control-label col-lg-1">Department</label>
                                <div class="col-lg-3" placeholder="Status">
                                    <select class="form-control" id="dep_ref_id" name="dep_ref_id">
                                        <option value="">select</option>
                                        <?php if (!empty($department)): ?>
                                            <?php foreach ($department as $c): ?>
                                                <option value="<?= $c->id; ?>"><?= $c->name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>

                                </div>

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
                            <div class="row">
                                <br>
                                <div class="col-lg-3">
                                    <button class="btn btn-success" type="submit">Search</button>
                                </div

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

        <section class="panel">
            <header class="panel-heading">
                Ticket List | Total Ticket : <?php echo $total_rows; ?>
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                </span>
            </header>
            <div class="panel-body">
                <section id="no-more-tables">

                    <?php if (!empty($record)) { ?>
                        <table class="table table-bordered  table-condensed cf">
                            <thead class="cf">
                            <tr>
                                <th>Ticket No</th>
                                <th>Priority</th>
                                <th>Support Type</th>
                                <th>Contact Person</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="numeric">Lead Time</th>
                                <th colspan="4">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($record as $key => $value) {
                                ?>
                                <tr class="">
                                    <td>
                                        <a class="btn btn-primary"
                                           href="<?php echo base_url() . 'sm/serviceengineer/action/' . $value->srd_id; ?>"><?php echo $value->ticket_no; ?></a>
                                    </td>
                                    <td><?php echo $priority_array[$value->priority]; ?></td>
                                    <td>
                                        <?php
                                        if (!empty($value->support_type)) {
                                            echo $service_type_array[$value->support_type];
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $value->contact_person . '<br>' . $value->contact_person_phn; ?></td>

                                    <td>
                                        <?= get_department_name_by_id($value->dep_ref_id); ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $ticket_status_array[$value->status];
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $timestamp = strtotime($value->created_date_time);
                                        echo get_relative_time($timestamp);
                                        echo "<br>";
                                        echo date('Y-m-d h:i a', strtotime($value->created_date_time));
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
                                        <a class="btn btn-primary"
                                           href="<?php echo base_url() . 'sm/serviceengineer/action/' . $value->srd_id; ?>"><i
                                                    class="icol-pencil"></i>VIEW</a>
                                    </td>

                                    <td>
                                        <?php if (!empty($value->ticket_ref_id) && $value->ticket_ref_id == $value->srd_id): ?>
                                            <?= 'KB Posted' ?>
                                        <?php else: ?>
                                            <a class="btn btn-primary"
                                               href="<?php echo base_url() . 'sm/serviceengineer/knowledge_base/' . $value->srd_id; ?>"><i
                                                        class="icol-pencil"></i>Post KB</a>
                                        <?php endif; ?>


                                    </td>

                                        <td>
                                            <?php if ($ticket_status_array[$value->status] == "Complete"): ?>
                                            <a class="btn btn-success"
                                               href="<?php echo site_url('sm/serviceengineer/job_report/') . $value->srd_id; ?>"><i
                                                        class="icol-pencil"></i>Report Download</a>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php if ($ticket_status_array[$value->status] == "Complete"): ?>
                                            <a class="btn btn-danger"
                                               href="<?php echo site_url('sm/serviceengineer/upload_job_report/') . $value->srd_id; ?>"><i
                                                        class="icol-pencil"></i>Report Upload</a>
                                            <?php endif; ?>
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