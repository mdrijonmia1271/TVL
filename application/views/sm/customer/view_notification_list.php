<?php
$this->load->view('sm/home/view_header');
?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Customer Notification
                <?php if ($this->session->userdata('root_admin') == "yes"): ?>
                    <a href="<?php echo base_url('sm/customer/add_notf') ?>" class="btn btn-danger btn-sm pull-right">Add
                        Notification</a>
                <?php endif; ?>
            </header>
            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal" method="post"
                          action="<?php echo base_url() ?>sm/customer/notification">

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="sub">Title :</label>
                            <div class="col-sm-4">
                                <input type="text" name="title" class="form-control" id="sub">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="std">Start Date:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="std" name="stDate">
                            </div>
                            <label class="control-label col-sm-1" for="end">End Date:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="end" name="endDate">
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <br><br>

                <?php if (!empty($notification)): ?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($notification as $i => $f): ?>
                            <tr>
                                <td><?= (++$i); ?></td>
                                <td><?= $f->title; ?></td>
                                <td><?= $f->description; ?></td>
                                <td><?= date_convert($f->created_at); ?></td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php endif; ?>
                <div class="dataTables_paginate paging_bootstrap pagination">
                    <ul>
                        <?= $links; ?>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
$this->load->view('sm/home/view_footer');
?>

<script>
    $('#std').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });
    $('#end').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });
</script>