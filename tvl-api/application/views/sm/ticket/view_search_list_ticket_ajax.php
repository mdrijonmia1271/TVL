<?php
$customer_auto_id = $this->session->userdata('customer_auto_id');
$ticket_status_array = ticket_status_array();
$priority_array = get_priority_array_dropdown();
$service_type_array = get_service_type_array_dropdown();
$service_task_name_array = get_service_task_name_array_dropdown($customer_auto_id);
?>
<table class="table table-bordered  table-condensed cf">
    <thead class="cf">
    <tr>
        <th>Ticket No</th>
        <th>Support Type</th>
        <th>Contact Person</th>
        <th>Status</th>
        <th>Created At</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($record)) {
        foreach ($record as $key => $value) {
            ?>
            <tr style="background-color: <?php echo ''; ?>">
                <td>
                    <a onclick="return customer_view_ticket('<?php echo $value->ticket_no; ?>')"
                       href="javascript:void(0)"><?php echo $value->ticket_no; ?></a>
                </td>

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
                    <a onclick="return customer_view_ticket('<?php echo $value->ticket_no; ?>')"
                       class="btn btn-primary" href="javascript:void(0)"><i
                                class="icol-pencil"></i> VIEW</a>
                    <?php if ($value->status <> 'C') { ?>
                    <?php } ?>
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