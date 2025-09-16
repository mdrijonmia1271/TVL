

<table class="table table-bordered spTable">
    <thead>
    <tr>
        <th>Business Area</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>

    <?php if (!empty($business)) : ?>

        <?php foreach ($business as $b): ?>
            <tr>
                <td><?= $b->bu_name; ?></td>
                <td><?php if ($b->bu_status == 0) {
                        echo "Active";
                    } else {echo "In-Active";} ?>

                </td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-success btn-sm"
                       onclick="trv.business.edit_business('<?= $b->bu_id; ?>')"><span
                            class="glyphicon glyphicon-pencil"></span></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                       onclick="trv.business.delete_business('<?= $b->bu_id; ?>')"><span
                            class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>