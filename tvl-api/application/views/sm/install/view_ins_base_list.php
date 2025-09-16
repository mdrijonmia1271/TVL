<?php $this->load->view('sm/home/view_header'); ?>

    <div id="insb-detail"></div>
    <div class="row" id="insb-list">
        <div class="col-lg-12">
            <div class="add-edit"></div>
            <div class="panel install">
                <header class="panel-heading">
                    Install Base Info
                </header>
                <div class="panel-body">
                    <div class="position-centercxvcx">

                        <form role="form" class="form-horizontal searchForm" method="post" action="<?php echo base_url()?>sm/install_base/ins_list">

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <label for="engineer" class="control-label col-lg-2">Sr. Eng.</label>
                                        <div class="col-lg-3">
                                            <select class="form-control" id="engineer" name="engineer">
                                                <option value="">select</option>
                                                <?php if (!empty($engineer)): ?>
                                                    <?php foreach ($engineer as $eng): ?>
                                                        <option value="<?= $eng->ser_eng_id; ?>"><?= $eng->name; ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <label for="customer" class="control-label col-lg-2">Client/Customer</label>
                                        <div class="col-lg-3">
                                            <select class="form-control" id="customer" name="customer">
                                                <option value="">select</option>
                                                <?php if (!empty($customer)): ?>
                                                    <?php foreach ($customer as $c): ?>
                                                        <option value="<?= $c->customer_id; ?>"><?= $c->name; ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label for="mc" class="control-label col-lg-2">Equipment/Item</label>
                                        <div class="col-lg-3">
                                            <select class="form-control" id="mc" name="machine">
                                                <option value="">select</option>
                                                <?php foreach ($machine as $m): ?>
                                                    <option value="<?= $m->mc_id; ?>"><?= $m->mc_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>



                                        <label for="customer" class="control-label col-lg-2">Support Type</label>
                                        <div class="col-lg-3">
                                            <select class="form-control" id="inputSuccess" name="support_type">
                                                <option value="">select</option>
                                                <?php foreach ($support as $sup): ?>
                                                    <option value="<?= $sup->service_type_id; ?>"><?= $sup->service_type_title; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                </div>
                                <br>
                                <div class="row">
                                    <label for="start" class="control-label col-lg-2">Start Date</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" id="start" name="stdate">
                                    </div>

                                    <label for="end" class="control-label col-lg-2">End Date</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" id="end" name="endate">
                                    </div>

                                    <br><br><br>
                                    <div class="col-lg-offset-1 col-lg-3">
                                        <button class="btn btn-success" type="submit" id="btn_customer_ticketsearch">Search
                                        </button>
                                    </div
                                </div>
                            </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $se_eng_login_id = $this->session->userdata('engineer_auto_id'); ?>
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                Install Base List
            </header>
            <div class="panel-body">
                <div class="position">
                    <div id="search-list"></div>
                    <table class="table table-bordered install-data">
                        <thead>
                        <tr>
                            <th>Client/Customer</th>
                            <th>Equipment/Item</th>
                            <th>Support Type</th>
                            <th>Work order Date</th>
                            <th>Date of Installation</th>
                            <th>Warranty Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php if (!empty($install)): ?>
                            <?php foreach ($install as $in):

                                $start_date = $in->su_start_date;
                                $end_date = $in->su_end_date;

                                $now = date('Y-m-d');

                                ?>
                                <tr>
                                    <td><?= $in->customer; ?></td>
                                    <td><?= $in->mc_name; ?></td>
                                    <td><?= $in->service_type_title; ?></td>
                                    <td><?= format_change($in->insb_work_order_date); ?></td>
                                    <td><?= format_change($in->insb_install_date); ?></td>
                                    <td><?= format_change($in->insb_warranty_date); ?></td>
                                    <td>

                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm"
                                           onclick="trv.install_base.view_install('<?= $in->insb_id;
                                           ?>')">View</a>
                                        <?php if ($in->ser_eng_ref_id == $se_eng_login_id): ?>
                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm"
                                               onclick="trv.install_base.edit_ins('<?= $in->insb_id;
                                               ?>')">Edit</a>

                                        <?php endif; ?>

                                        <?php if ($now >= $start_date && $now >= $end_date && $in->ser_eng_ref_id == $se_eng_login_id): ?>
                                            <a href="javascript:void(0)" class="btn btn-success btn-sm"
                                               onclick="trv.install_base.renew('<?= $in->insb_id; ?>')">Renew</a>
                                        <?php endif; ?>
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
    </div>


<?php
$this->load->view('sm/home/view_footer');
?>

<script>
    $('#start').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });
    $('#end').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });
</script>
