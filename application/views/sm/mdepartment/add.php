<?php $this->load->view('sm/home/view_header'); ?>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Add Departments Head Info
            </header>
            <div class="panel-body">
                <div class="col-md-6 col-md-offset-2">

                    <form method="post" action="<?php echo base_url('sm/mdepartment/store'); ?>">
                        <div class="form-group">
                            <label for="customer">Customer :</label>
                            <select class="form-control" id="customer" name="customer">
                                <option>Select</option>
                                <?php if (!empty($customer)): ?>
                                <?php foreach ($customer as $c): ?>
                                    <option value="<?= $c->customer_id ?>"><?= $c->name; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <?php echo form_error('customer'); ?>
                        </div>
                        <div class="form-group">
                            <label for="department">Department:</label>
                            <select class="form-control" id="department" name="department">
                                <option>Select</option>
                                <?php if (!empty($department)): ?>
                                    <?php foreach ($department as $d): ?>
                                        <option value="<?= $d->id ?>"><?= $d->name; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="<?php echo base_url('sm/mdepartment'); ?>" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>

                    <?php
                    if ($this->session->flashdata('flashError')) {
                        echo"<div class=\"alert alert-danger fade in\">";
                        echo $this->session->flashdata('flashError');
                        echo"</div>";
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>
