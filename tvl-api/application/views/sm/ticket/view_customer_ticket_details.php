<?php
$customer_auto_id = $this->session->userdata('customer_auto_id');
$ticket_status_array = ticket_status_array();
$priority_array = get_priority_array_dropdown();
$service_type_array = get_service_type_array_dropdown();
$service_task_name_array = get_service_task_name_array_dropdown($customer_auto_id);

if (!empty($ticket_details_data)) {
    ?>
    <div class="col-lg-12">
        <header class="panel-heading">
            Ticket Details <a href="#" class="btn btn-default"
                              onclick="return closeCustTickDetais('customer_inline_ticket_details');">X</a>
        </header>
        <!--tab nav start-->
        <section class="panel">
            <header class="panel-heading tab-bg-dark-navy-blue">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#home">Ticket Info</a>
                    </li>
                    <!--<li class="">
                        <a data-toggle="tab" href="#about">Location Details</a>
                    </li>-->
                    <li class="">
                        <a data-toggle="tab" href="#action">Action Flow</a>
                    </li>
                    <?php if (!empty($service_engineer)): ?>
                    <li class="">
                        <a data-toggle="tab" href="#engineer">Service Engineer Details</a>
                    </li>
                    <?php endif;?>
                    <!--<li class="">
                        <a data-toggle="tab" href="#profile">Comment Log</a>
                    </li>-->
                </ul>
            </header>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <table class="table table-bordered  table-condensed cf">
                            <tbody>
                            <tr>
                                <th>Ticket Number:</th>
                                <td><b><?php echo $ticket_details_data->ticket_no; ?></b></td>
                            </tr>
                            <!--<tr>
                                <th>Priority:</th>
                                <td><?php /*echo $priority_array[$ticket_details_data->priority]; */?></td>
                            </tr>-->
                            <tr>
                                <th>Contact Person Name :</th>
                                <td><?php echo $ticket_details_data->contact_person; ?></td>
                            </tr>

                            <tr>
                                <th>Contact Person Mobile:</th>
                                <td><?php echo $ticket_details_data->contact_person_phn; ?></td>
                            </tr>

                            <tr>
                                <th>Support Type:</th>
                                <td><?php echo $service_type_array[$ticket_details_data->support_type]; ?></td>
                            </tr>
                            <!--<tr>
                                <th>Task :</th>
                                <td><?php /*echo $service_task_name_array[$ticket_details_data->ref_task_id]; */?></td>
                            </tr>-->

                            <tr>
                                <th>Request Details :</th>
                                <td><?php echo $ticket_details_data->request_details; ?></td>
                            </tr>

                            <!--<tr>
                                <th>Support Location :</th>
                                <td><?php /*echo $ticket_details_data->service_add_details; */?></td>
                            </tr>-->

                            <tr>
                                <th>Status:</th>
                                <td><b><?php echo $ticket_status_array[$ticket_details_data->status]; ?></b></td>
                            </tr>
                            <tr>
                                <th>Created Date Time:</th>
                                <td><?=  date_convert($ticket_details_data->created_date_time); ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--<div id="about" class="tab-pane">
                        <table class="table table-bordered  table-condensed cf">
                            <tbody>
                            <tr>
                                <th>Support Location :</th>
                                <td><?php /*echo $ticket_details_data->service_add_details; */?></td>
                            </tr>
                            <tr>
                                <th>Division :</th>
                                <td><?php /*echo get_division_by_id($ticket_details_data->service_add_division); */?></td>
                            </tr>
                            <tr>
                                <th>District :</th>
                                <td><?php /*echo get_district_by_id($ticket_details_data->service_add_district); */?></td>
                            </tr>
                            <tr>
                                <th>Upazila :</th>
                                <td><?php /*//echo get_district_by_id($ticket_details_data->service_add_district);  */?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>-->

                    <div id="action" class="tab-pane">
                        <div class="col-md-12">
                            <div class="panel-body">
                                <section id="no-more-tables">
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
                                                        ]<br> <?php echo date_convert($value->created_date_time); ?>
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
                                </section>
                            </div>
                        </div>
                    </div>



                    <div id="engineer" class="tab-pane">
                        <div class="col-md-12">
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Mobile</th>
                                        <th>Photo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($service_engineer)): ?>
                                    <tr>
                                        <td><?= $service_engineer->name;  ?></td>
                                        <td><?= $service_engineer->email; ?></td>
                                        <td><?= $service_engineer->eng_depart; ?></td>
                                        <td><?= $service_engineer->eng_desig; ?></td>
                                        <td><?= $service_engineer->mobile; ?></td>
                                        <td>
                                            <?php if (!empty($service_engineer->picture)) { ?>
                                                <img alt="img" width="60" height="40" src="<?php echo base_url() . 'upload/service_engineer/' . $service_engineer->ser_eng_id . '/' . $service_engineer->picture ?>"/>
                                            <?php } else { ?>
                                                <img alt="img" width="60" height="40" src="<?php echo base_url() . 'smdesign/images/noimage.png' ?>"/>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <!--Comment---------------------------------------------->
                    <!--<div id="profile" class="tab-pane">


                        <div class="col-md-12">
                            <div class="panel-body">
                                <section id="no-more-tables">
                                    <?php /*if (!empty($ticket_comment_list)) { */?>
                                        <table class="table table-bordered table-striped table-condensed cf">
                                            <thead class="cf">
                                            <tr>
                                                <th class="numeric">Date/Owner</th>
                                                <th class="numeric">Comment details</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
/*                                            foreach ($ticket_comment_list as $key => $value) {
                                                */?>

                                                <tr>
                                                    <td data-title="Date">
                                                        <?php /*$getcommenterName = get_commenter_name_by_id($value->comment_from, $value->comments_by);
                                                        echo $getcommenterName;
                                                        */?>
                                                        [<?php /*echo $value->comment_from */?>
                                                        ]<br> <?php /*echo $value->comments_date_time; */?>
                                                    </td>
                                                    <td data-title="Comment"><p><?php /*echo $value->comments; */?></p></td>
                                                </tr>
                                            <?php /*} */?>

                                            </tbody>
                                        </table>


                                        <?php
/*                                    } else {
                                        echo 'No Comment Available';
                                    }
                                    */?>
                                </section>
                            </div>
                        </div>


                    </div>
-->                    <!--Comment---------------------------------------------->

                </div>
            </div>
        </section>
        <!--tab nav start-->
    </div>
<?php } ?>