<?php $this->load->view('sm/home/view_header'); ?>

<div class="add-edit"></div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="trv.business.add_business()">Add
                    Business
                    Area</a>
            </header>
            <div class="panel-body">

                <form class="form-horizontal" id="searchForm">

                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="control-label col-lg-4" for="email">Business Area</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="bu_area" id="email"
                                       placeholder="Enter Business Area">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="pwd">Status</label>
                            <div class="col-lg-8">

                                <select class="form-control" id="pwd" name="bu_st">
                                    <option value="">Select</option>
                                    <option value="0">Active</option>
                                    <option value="1">In-Active</option>
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-10">
                            <button type="button" onclick="trv.business.search()" class="btn btn-success btn-sm">
                                Search
                            </button>
                            <span class="reload"></span>
                        </div>
                    </div>
                </form>
                <br>
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
