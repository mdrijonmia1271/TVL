<?php $this->load->view('sm/home/view_header'); ?>

<div class="add-edit"></div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="trv.spare.add_spare()">Add Spare
                    Parts</a>
            </header>
            <div class="panel-body">

                <form class="form-horizontal" id="searchForm">

                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Spare Parts Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="spName" id="email" placeholder="Enter spare parts name">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="pwd">P/N</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pwd" name="spCode" placeholder="Enter P/N">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-8">
                            <button type="button" onclick="trv.spare.search()" class="btn btn-success btn-sm">Search</button>
                            <span class="reload"></span>
                        </div>
                    </div>
                </form>
                <br>
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


            </div>
        </div>
    </div>
</div>

<?php
$this->load->view('sm/home/view_footer');
?>

<script>
    $(document).ready(function () {
        $('.spTable').dataTable({
            "aaSorting": [[2, 'desc']],
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": true,
            "bordering": true,
            "bSortable": true,
            "bRetrieve": true
        });
    });

</script>
