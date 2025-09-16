<?php
$this->load->view('sm/home/view_header');
?>

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Customer Feedback
                </header>
                <div class="panel-body">
                    <div class="row">
                        <form class="form-horizontal" method="post" action="<?php echo base_url()?>sm/customer/feedback_list">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sel1">Customer:</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="sel1" name="customer">
                                        <option value="">Select</option>
                                        <?php if (!empty($customer)): ?>
                                            <?php foreach ($customer as $c): ?>
                                                <option value="<?= $c->customer_id; ?>"><?= $c->name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <label class="control-label col-sm-1" for="sub">Subject:</label>
                                <div class="col-sm-4">
                                    <input type="text" name="sub" class="form-control" id="sub" placeholder="Enter Subject">
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


                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Subject</th>
                            <th>Feedback</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if (!empty($feedback)): ?>
                            <?php foreach ($feedback as $f): ?>
                                <tr>
                                    <td><?= $f->name; ?></td>
                                    <td><?= $f->department; ?></td>
                                    <td><?= $f->email; ?></td>
                                    <td><?= $f->mobile; ?></td>
                                    <td><?= $f->f_subject; ?></td>
                                    <td><?= $f->feedback; ?></td>
                                    <td><?= date_convert($f->created); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <?php echo $links; ?>
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