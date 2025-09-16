<?php
$this->load->view('sm/home/view_header');
?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Machine List
            </header>
            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal" method="post"
                          action="<?php echo base_url() ?>sm/customer/machine">

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="sub">Equipment/Item :</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="machine" name="machine">
                                    <option value="">Select</option>

                                    <?php if (!empty($customer_machine)): ?>

                                        <?php foreach ($customer_machine as $item) : ?>

                                            <?php
                                            $version = $item->insb_version ? ", Version : " . $item->insb_version : '';
                                            $serial  = $item->insb_serial ? ", Serial : " . $item->insb_serial : '';
                                            ?>

                                            <option value="<?= $item->mc_id; ?>"><?= $item->mc_name . " ( Model :" . $item->mc_model . $version . $serial . ")"; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </select>
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


                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Model</th>
                        <th>Picture</th>
                        <th>Version</th>
                        <th>Serial</th>
                        <th>Support Type</th>
                        <th>Support Star Date</th>
                        <th>Support End Date</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($machine)): ?>
                        <?php foreach ($machine as $i => $f): ?>
                            <?php
                            $customer_id           = $this->session->userdata('customer_auto_id');
                            $customer_support_type = machine_support_info($customer_id, $f->mc_id);
                            if ($customer_support_type) {
                                $start_date = $customer_support_type->su_start_date;
                                $startDate  = date("d M Y", strtotime($start_date));
                            } else {
                                $startDate = '';
                            }
                            if ($customer_support_type) {
                                $end_date = $customer_support_type->su_end_date;
                                $endtDate = date("d M Y", strtotime($end_date));
                            } else {
                                $endtDate = '';
                            }
                            ?>
                            <tr>
                                <td><?= (++$i); ?></td>
                                <td><?= $f->mc_name; ?></td>
                                <td><?= $f->mc_model; ?></td>
                                <td>

                                    <?php $upload_path = 'upload/install_base/' . $f->insb_id . '/' . $f->picture; ?>
                                    <?php if (file_exists($upload_path)): ?>
                                        <a href="<?= base_url($upload_path) ?>" target="_blank">
                                            <img src="<?= base_url($upload_path) ?>" width="50px" height="50px">
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td><?= $f->insb_version; ?></td>
                                <td><?= $f->insb_serial; ?></td>
                                <td><?= ($customer_support_type) ? $customer_support_type->service_type_title : '<span style="color:red;font-weight: 900;">NOT ASSIGN</span>'; ?></td>
                                <td><?= $startDate ? $startDate : ''; ?></td>
                                <td><?= $endtDate ? $endtDate : ''; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>

                <div class="dataTables_paginate paging_bootstrap pagination">
                    <ul>
                        <!-- --><? /*= $links; */ ?>
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