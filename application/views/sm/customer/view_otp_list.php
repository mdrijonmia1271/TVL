<?php
$this->load->view('sm/home/view_header');
?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Customer OTP
            </header>
            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal" method="post"
                          action="<?php echo base_url() ?>sm/customer/customer_otp">

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
                            <label class="control-label col-sm-2" for="sub">Customer:</label>
                            <div class="col-sm-4">
                                <input type="text" name="customer" class="form-control" id="sub">
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

                <?php if (!empty($customer)): ?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>OTP</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($customer as $i => $f): ?>
                            <tr>
                                <td><?= (++$i); ?></td>
                                <td><?= $f->name; ?></td>
                                <td><?= $f->mobile; ?></td>
                                <td><?= $f->verify_otp; ?></td>
                                <td><?= date_convert($f->created_date_time); ?></td>
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