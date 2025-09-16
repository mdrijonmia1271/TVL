<table class="table table-bordered mcTable">
    <thead>
    <tr>
        <th width="3%">SL</th>
        <th width="8%">Type</th>
        <th width="15%">Slap</th>
        <th>Template</th>
        <th width="10%">Status</th>
        <th width="10%">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($template)): ?>
        <?php $i = 0;?>
        <?php foreach($template as $m): ?>
            <tr>
                <td><?= ++$i; ?></td>
                <td><?= strtoupper($m->type); ?></td>
                <td><?= $m->slap; ?></td>
                <td><?= $m->message; ?></td>
                <td><?= ($m->status) ? 'Active' : 'In-Active'; ?></td>
                <td><a href="javascript:void(0)" class="btn btn-success btn-sm"
                       onclick="trv.temp.edit_template('<?= $m->id; ?>')"><span
                                class="glyphicon glyphicon-pencil"></span></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm"
                       onclick="trv.temp.delete_template('<?= $m->id; ?>')"><span
                                class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    </tbody>
</table>