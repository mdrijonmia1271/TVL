<table class="table table-bordered mcTable">
    <thead>
    <tr>
        <th>Equipment/Item Sold Name</th>
        <th>Model</th>
        <th>Manufacture</th>
        <th>Particulars</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($machine)): ?>

        <?php foreach($machine as $m): ?>
            <tr>
                <td><?= $m->mc_name; ?></td>
                <td><?= $m->mc_model; ?></td>
                <td><?= $m->mf_name; ?></td>
                <td><?= $m->mc_particular; ?></td>
                <td><a href="javascript:void(0)" class="btn btn-success btn-sm"
                       onclick="trv.machine.edit_machine('<?= $m->mc_id; ?>')"><span
                            class="glyphicon glyphicon-pencil"></span></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                       onclick="trv.machine.delete_machine('<?= $m->mc_id; ?>')"><span
                            class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    </tbody>
</table>