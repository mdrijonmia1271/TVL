<?php $this->load->view('sm/home/view_header'); ?>

<div id="insb-detail"></div>
<div class="row">
<?php $se_eng_login_id = $this->session->userdata('admin_user_type'); ?>
<div class="col-lg-12">
    <div class="panel">
        <header class="panel-heading">
            PMI List <span class="badge"><?= $total_rows; ?></span>
        </header>

        <div class="panel-body">
            <div class="position">
                <div id="search-list"></div>

                <?php if (!empty($pmi)):?>

                    <table class="table table-bordered install-data">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Client/Customer</th>
                            <th>Department</th>
                            <th>Equipment/Item</th>
                            <th>Date of PMI</th>
                            <th>Eng.</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($pmi as $k => $in):
                            $sl = $this->uri->segment(4) + $k + 1;
                            ?>
                            <tr>
                                <td><?= $sl; ?></td>
                                <td><?= $in->customer; ?></td>
                                <td><?= $in->department; ?></td>
                                <td><?= $in->mc_name . ' (Model-' . $in->mc_model .', Serial- '. $in->insb_serial.')'; ?></td>

                                <td><?= date_convert($in->created); ?></td>
                                <td><?= $in->engineer; ?></td>
                                <td>
                                    <?php $upload_path = 'upload/pmi/' . $in->id . '/' . $in->pmi_report;?>
                                    <?php if (file_exists($upload_path)): ?>
                                        <a href="<?= base_url('upload/pmi/' . $in->id . '/' . $in->pmi_report) ?>"
                                           class="btn btn-primary btn-sm" target="_blank">Download</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <?php echo $links; ?>
                        </ul>
                    </div>
                <?php endif; ?>


            </div>
        </div>
    </div>
  </div>
</div>


<?php
$this->load->view('sm/home/view_footer');
?>

