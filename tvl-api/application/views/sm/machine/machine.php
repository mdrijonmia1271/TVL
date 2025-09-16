<?php $this->load->view('sm/home/view_header'); ?>


<div class="add-edit-form"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="trv.machine.add_machine()">Add Equipment/Item Sold</a>
            </header>
            <div class="panel-body">
                <form class="form-horizontal" id="mcSearch">

                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="mcName" id="email" placeholder="Enter Equipment/Item Name">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="pwd">Model</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="pwd" name="model" placeholder="Enter Equipment/Item model">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-8">
                            <button type="button" onclick="trv.machine.search()" class="btn btn-success btn-sm">Search</button>
                            <span class="reload"></span>
                        </div>
                    </div>
                </form>


                <table class="table table-bordered mcTable">
                    <thead>
                    <tr>
                        <th>Equipment/Item Sold Name</th>
                        <th>Model</th>
                        <th>Manufacturer</th>
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


            </div>
        </div>
    </div>
</div>


<?php
$this->load->view('sm/home/view_footer');
?>

<script>
    /*$(document).ready(function () {
        $('.mcTable').dataTable({
            "aaSorting": [[2, 'desc']],
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": true,
            "bordering": true,
            "bSortable": true,
            "bRetrieve": true
        });
    });*/
</script>