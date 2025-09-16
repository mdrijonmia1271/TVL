<?php $this->load->view('sm/home/view_header'); ?>


    <div class="add-edit-form"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <header class="panel-heading">
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="trv.temp.add_template()">Add Message Template</a>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal" id="mcSearch">

                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Type</label>
                                <div class="col-sm-10">
                                    <select name="type" class="form-control" id="type" required>
                                        <option selected value="">Select type</option>
                                        <option value="sms">SMS</option>
                                        <option value="email">Email</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="slap">Slap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="slap" name="slap" placeholder="Enter slap name" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-8">
                                <button type="button" onclick="trv.temp.search()" class="btn btn-success btn-sm">Search</button>
                                <span class="reload"></span>
                            </div>
                        </div>
                    </form>


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


                </div>
            </div>
        </div>
    </div>


<?php
$this->load->view('sm/home/view_footer');
?>