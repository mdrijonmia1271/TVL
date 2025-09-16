<?php $this->load->view('sm/home/view_header'); ?>

    <div class="add-edit"></div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <header class="panel-heading">
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="trv.manufacture.add_manu()">Create
                        Manufacture</a>
                </header>
                <div class="panel-body">
                    <div class="list-show"></div>

                    <div id="manu-list">
                        <form class="form-horizontal" id="searchForm">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="manu">Manufacturer Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="mfName" id="manu"
                                               placeholder="Enter Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="st">Status</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="st" name="mfStatus">
                                            <option value="">Select</option>
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-8">
                                    <button type="button" onclick="trv.manufacture.search()"
                                            class="btn btn-success btn-sm">
                                        Search
                                    </button>
                                    <span class="reload"></span>
                                </div>
                            </div>
                        </form>
                        <br>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Manufacture</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($manufacture)): ?>
                                <?php foreach ($manufacture as $m): ?>
                                    <tr>
                                        <td><?= $m->mf_name; ?></td>
                                        <td>
                                            <?php
                                            if ($m->mf_status == 1) {
                                                echo 'Active';
                                            } else {
                                                echo 'In-Active';
                                            }
                                            ?></td>
                                        <td><?= date_convert($m->created); ?></td>
                                        <td><a href="javascript:void(0)" class="btn btn-success btn-sm"
                                               onclick="trv.manufacture.edit_manufacture('<?= $m->mf_id; ?>')"><span
                                                        class="glyphicon glyphicon-pencil"></span></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$this->load->view('sm/home/view_footer');
?>