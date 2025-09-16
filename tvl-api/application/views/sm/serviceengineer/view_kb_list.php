<?php
$this->load->view('sm/home/view_header');
?>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <header class="panel-heading">
                    <b>Knowledge Base</b>
                </header>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Ticket No.</th>
                                <th>Service Eng.</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php if (!empty($knowledge)): ?>
                                <?php foreach ($knowledge as $kb): ?>
                                    <tr>
                                        <td><?= $kb->ticket_ref_no; ?></td>
                                        <td><?= $kb->name; ?></td>
                                        <td width="60%"><?= $kb->problem_details; ?></td>
                                        <td><?= $kb->posted_date; ?></td>
                                        <td>
                                            <a href="<?php echo base_url() . 'sm/serviceengineer/comments/' . $kb->id; ?>"
                                               class="btn btn-success">Details</a>
                                            <!--<a href="<?php /*echo base_url() . 'sm/serviceengineer/details/' . $kb->id; */?>"
                                               class="btn btn-primary">Details</a>-->

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