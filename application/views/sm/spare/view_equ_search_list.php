

<table class="table table-bordered spTable">
    <thead>
    <tr>
        <th>Spare Parts Name</th>
        <th>P/N</th>
        <th>Manufacture</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>

    <?php if (!empty($parts)) : ?>

        <?php foreach ($parts as $p): ?>
            <tr>
                <td><?= $p->sp_name; ?></td>
                <td><?= $p->sp_code; ?></td>
                <td><?= $p->mf_name; ?></td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-success btn-sm"
                       onclick="trv.spare.edit_spare('<?= $p->sp_id; ?>')"><span
                            class="glyphicon glyphicon-pencil"></span></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                       onclick="trv.spare.delete_spare('<?= $p->sp_id; ?>')"><span
                            class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>