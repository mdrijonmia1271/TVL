<?php $this->load->view('sm/home/view_header'); ?>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Departments Mapping With Customer
                <span class="pull-right">
                    <a href="<?php echo base_url('sm/mdepartment/create'); ?>" class="btn btn-danger btn-sm">Add New</a>
                </span>
            </header>
            <div class="panel-body">
                <section id="no-more-tables">
                    <?php if (!empty($customer)) : ?>

                        <table class="table table-bordered table-condensed cf">
                            <thead class="cf">
                            <tr>
                                <th>Sl</th>
                                <th>Customer</th>
                                <th>Department</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($customer as $key => $value) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>

                                    <td data-title="Priority Name">
                                        <?= $value->customer; ?>
                                    </td>

                                    <td data-title="Priority Name">
                                        <?= $value->department; ?>
                                    </td>

                                    <td data-title="Priority Name">
                                        <?= $value->name; ?>
                                    </td>

                                    <td data-title="Priority Name">
                                        <?= $value->email; ?>
                                    </td>

                                    <td data-title="Priority Name">
                                        <?= $value->phone; ?>
                                    </td>

                                    <td>
                                        <a href="<?php echo base_url('sm/mdepartment/edit/' . $value->id); ?>"
                                           class="btn btn-primary btn-sm">
                                            <i class="icol-pencil"></i>Edit
                                        </a>
                                        <a href="<?php echo base_url('sm/mdepartment/delete/' . $value->id); ?>"
                                           class="btn btn-danger btn-sm">
                                            <i class="icol-trash"></i>Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </section>
            </div>
        </section>
    </div>
</div>
<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>
