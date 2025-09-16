
<?php if (!empty($record)) { ?>                        

    <table class="table table-bordered table-striped table-condensed cf">
        <thead class="cf">
            <tr>
                <!--<th>Customer Name</th>-->
                <th>Support Type Name</th>
                <!--<th>Free/Paid</th>-->
                <th class="numeric">Status</th>
                <th class="numeric">Date Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($record as $key => $value) {
                ?> 
                <tr>
                    <!--<td data-title="Customer Name">
                        <?php /*echo get_customer_name_by_id($value->ref_custmr_id); */?>
                    </td> -->
                    <td data-title="Service Type Name">
                        <?php echo $value->service_type_title; ?>
                    </td>
                    <!--<td data-title="">
                        <?php /*echo $value->free_paid; */?>
                    </td> -->

                    <?php if ($value->status == 'A') { ?>
                        <td class="">Active</td>
                    <?php } else { ?>
                        <td class="">In Active</td>
                    <?php } ?>
                    <td data-title="Date"><?php
                        $newDate = date("d-m-Y H:i:s", strtotime($value->created_date_time));

                        echo $newDate;
                        ?></td>
                    <td>
                        <p><a href="<?php echo base_url(); ?>sm/admin_config/edit_service_type/<?php echo $value->service_type_id; ?>" class="label label-success label-mini">
                                <i class="icol-pencil"></i>Edit
                            </a>
                        </p>

                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>

    <?php
}
?>   