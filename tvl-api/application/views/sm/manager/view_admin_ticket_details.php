<?php
$ticket_status_array = ticket_status_array();
$priority_array = get_priority_array_dropdown();
$service_type_array = get_service_type_array_dropdown();
$service_task_name_array = get_service_task_name_array_dropdown($ticket_details_data->send_from);

//print_r($ticket_comment_list);
if (!empty($ticket_details_data)) {
    ?>
    <div class="col-lg-12">
        <header class="panel-heading">
            Ticket Details <a href="#" class="btn btn-default"
                              onclick="return closeCustTickDetais('admin_inline_ticket_details');">X</a>
        </header>
        <!--tab nav start-->
        <section class="panel">
            <header class="panel-heading tab-bg-dark-navy-blue">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#home">Ticket Info And Action</a>
                    </li>
                    <!--<li class="">
                        <a data-toggle="tab" href="#about">Location Details</a>
                    </li>-->
                    <li class="">
                        <a data-toggle="tab" href="#flow">Action Flow</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#profile">Comment Log</a>
                    </li>
                </ul>
            </header>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <table class="table table-bordered  table-condensed cf">
                            <tbody>
                            <tr>
                                <th>Client/Customer :</th>
                                <td>
                                    <b><?= $ticket_details_data->name; ?></b><br><br>
                                    <span>Contact Person</span>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><?= $ticket_details_data->contact_person_name;  ?></td>
                                            <td><?= $ticket_details_data->contact_person_desig; ?></td>
                                            <td><?= $ticket_details_data->contact_person_email; ?></td>
                                            <td><?= $ticket_details_data->contact_person_phone; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>


                            <tr>
                                <th>Ticket Number:</th>
                                <td><b><?= $ticket_details_data->ticket_no; ?></b></td>
                            </tr>
                            <tr>
                                <th>Support Type:</th>
                                <td><?= $service_type_array[$ticket_details_data->support_type]; ?></td>
                            </tr>

                            <tr>
                                <th>Request Details :</th>
                                <td><?= $ticket_details_data->request_details; ?></td>
                            </tr>

                            <tr>
                                <th>Status:</th>
                                <td><b><?= $ticket_status_array[$ticket_details_data->status]; ?></b></td>
                            </tr>
                            <tr>
                                <th>Created Date Time:</th>
                                <td><?= date_convert($ticket_details_data->created_date_time); ?></td>
                            </tr>

                            <tr>
                                <th>Priority:</th>
                                <td><?php echo $priority_array[$ticket_details_data->priority]; ?></td>
                            </tr>

                            </tbody>
                        </table>
                        <hr>
                        <?php
                        $admin_user_type = $this->session->userdata('admin_user_type');

                        if ($admin_user_type != 'hd'){

                        if ($ticket_details_data->status <> 'A' && $ticket_details_data->status <> 'C') {

                            ?>
                            <form class="cmxform form-horizontal" enctype="multipart/form-data" method="post"
                                  id="form_admin_ticket_aciton" action="#">
                                <input type="hidden" name="hidden_ticket_no" id="hidden_ticket_no"
                                       value="<?php echo $ticket_details_data->ticket_no; ?>"/>
                                <input type="hidden" name="hidden_ticket_autoid" id="hidden_ticket_autoid"
                                       value="<?php echo $ticket_details_data->srd_id; ?>"/>
                                <table class="table table-bordered  table-condensed cf">
                                    <tbody>
                                    <tr>
                                        <th colspan="2" class="panel-heading">Update Status / Take Action</th>
                                    </tr>
                                    <tr>
                                        <th>Update Status:</th>
                                        <td>
                                            <?php
                                            $action_ticket_status_array = ticket_status_array();

                                            unset($action_ticket_status_array['P']);//remove pending status
                                            if ($ticket_details_data->status == "W") {
                                                unset($action_ticket_status_array['W']);
                                            }

                                            $dropdown_js_priority = 'id="status" required="" class="form-control";';
                                            echo form_dropdown('status', $action_ticket_status_array, '', $dropdown_js_priority);
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <th>Assign to:</th>
                                        <td>
                                            <?php
                                            $engineer_list = get_service_engineer_array();
                                            $dropdown_js_engineer = 'id="engineer_list" class="form-control" ';
                                            echo form_dropdown('engineer_list', $engineer_list, '', $dropdown_js_engineer, 'required="required"');
                                            ?>
                                        </td>
                                    </tr>


                                    <tr>
                                        <th>Priority :</th>
                                        <td>
                                            <?php
                                            $priority_array = get_priority_array_dropdown();
                                            $id_priority_array = 'id ="priority" class="form-control"';
                                            echo form_dropdown('priority', $priority_array, set_value('priority'), $id_priority_array);
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Comment:</th>
                                        <td>
                                            <?php
                                            $ticketcomment_arry = array(
                                                'name' => 'ticketcomment',
                                                'id' => 'ticketcomment',
                                                'class' => "form-control",
                                                'placeholder' => 'Enter Comment on ticket',
                                                'value' => set_value('ticketcomment'),
                                                'cols' => '10',
                                                'rows' => '3'
                                            );
                                            echo form_textarea($ticketcomment_arry);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            <button type="button" id="btn_admin_aciton"
                                                    onclick="return admin_ticket_action();" class="btn btn-info">Submit
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        <?php } } ?>
                    </div>
                    <!--<div id="about" class="tab-pane">
                        <table class="table table-bordered  table-condensed cf">
                            <tbody>
                            <tr>
                                <th>Support Location :</th>
                                <td><?php /*echo $ticket_details_data->service_add_details; */ ?></td>
                            </tr>
                            <tr>
                                <th>Division :</th>
                                <td><?php /*echo get_division_by_id($ticket_details_data->service_add_division); */ ?></td>
                            </tr>
                            <tr>
                                <th>District :</th>
                                <td><?php /*echo get_district_by_id($ticket_details_data->service_add_district); */ ?></td>
                            </tr>
                            <tr>
                                <th>Upazila :</th>
                                <td><?php /*//echo get_district_by_id($ticket_details_data->service_add_district);  */ ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>-->


                    <!--Flow---------------------------------------------->
                    <div id="flow" class="tab-pane">

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
                                </section>
                            </div>
                        </div>


                    </div>
                    <!--Flow---------------------------------------------->

                    <!--Comment---------------------------------------------->
                    <div id="profile" class="tab-pane">


                        <div class="col-md-12">
                            <div class="panel-body">
                                <section id="no-more-tables">
                                    <?php if (!empty($ticket_comment_list)) { ?>
                                        <table class="table table-bordered table-striped table-condensed cf">
                                            <thead class="cf">
                                            <tr>
                                                <th class="numeric">Date/Owner</th>
                                                <th class="numeric">Comment details</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($ticket_comment_list as $key => $value) {
                                                ?>

                                                <tr>
                                                    <td data-title="Date">
                                                        <?php $getcommenterName = get_commenter_name_by_id($value->comment_from, $value->comments_by);
                                                        echo $getcommenterName; ?>
                                                        [<?php echo $value->comment_from ?>
                                                        ]<br> <?php echo $value->comments_date_time; ?>
                                                    </td>
                                                    <td data-title="Comment"><p><?php echo $value->comments; ?></p></td>
                                                </tr>
                                            <?php } ?>

                                            </tbody>
                                        </table>


                                        <?php
                                    } else {
                                        echo 'No Comment Available';
                                    }
                                    ?>
                                </section>
                            </div>
                        </div>


                    </div>
                    <!--Comment---------------------------------------------->


                </div>
            </div>
        </section>
        <!--tab nav start-->
    </div>
<?php } ?>