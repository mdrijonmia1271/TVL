<?php
$ticket_status_array = ticket_status_array();
$priority_array = get_priority_array_dropdown();
$service_type_array = get_service_type_array_dropdown();
$priority_color_array = get_priority_color_array();
?>
<?php if (!empty($record)) { ?>

    <table class="table table-bordered table-striped table-condensed cf">
        <thead class="cf">
        <tr>
            <th>Ticket No</th>
            <!--<th>Priority</th>-->
            <th class="numeric">Customer Name</th>
            <th class="numeric">Equipment</th>
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
                <td><?php echo $service_type_array[$value->support_type]; ?></td>


                <td><?php echo $value->contact_person . '<br>' . $value->contact_person_phn; ?></td>

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
                            <a onclick="return admin_cancel_ticket('<?php echo $value->ticket_no; ?>')"
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

