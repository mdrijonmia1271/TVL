<?php
$this->load->view('sm/home/view_header');
?>
<!-- Main Content Wrapper -->
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <b>Pending Sub Customer User Search </b>
            </header>
            <div class="panel-body">
                <form role="form" class="form-horizontal bucket-form" enctype="multipart/form-data" method="post"
                      action="<?php echo base_url() . 'sm/customer/pendinglist'; ?>">
                    <div class="form-group">

                        <div class="col-lg-12">
                            <div class="row">
                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1"> Username</label>
                                <div class="col-lg-3">
                                    <input type="text" name="name" placeholder="Customer Sub Username" value="<?=$this->input->post('name');?>" class="form-control" />
                                </div>

                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Email</label>
                                <div class="col-lg-3">
                                    <input type="text" name="email" placeholder="Email" class="form-control" value="<?=$this->input->post('email');?>" />
                                </div>

                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Mobile</label>
                                <div class="col-lg-3">
                                    <input type="text" name="mobile" placeholder="Mobile" class="form-control" value="<?=$this->input->post('mobile');?>" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <br>
                            <div class="row">

                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Status</label>
                                <div class="col-lg-3" placeholder="Status">
                                    <?=form_dropdown('status', ['' => 'Select a status', '0' => 'InActive', '1' => 'Active'], $this->input->post('status'), 'class="form-control m-bot3"');?>
                                </div>

                                <div class="col-lg-3">
                                    <button class="btn btn-success" type="submit">Search</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <button class="btn btn-inverse pull-right" onclick="trv.exl('cusTable','customer')"><i
                        class="glyphicon glyphicon-print"></i> Excel Export
                </button>
            </div>
        </section>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <b>Sub User List</b>
            </header>
            <div class="panel-body">
            <?php if (!empty($record)) : ?>
                <table class="table table-bordered" id="cusTable">
                    <thead>
                        <tr>
                            <th class="text-center">SL</th>
                            <th class="text-left">Customer Name</th>
                            <th class="text-left">Username</th>
                            <th class="text-center">Mobile</th>
                            <th class="text-left">Email</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Created</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                    <tbody>
                    <?php foreach ($record as $key => $value): ?>
                        <tr>
                            <td class="text-center"><?= $key+1+$row; ?></td>
                            <td class="text-left"><?= $value->name; ?></td>
                            <td class="text-left"><?= $value->username; ?></td>
                            <td class="text-center"><?= $value->phone; ?></td>
                            <td class="text-left"><?= $value->sub_user_email; ?></td>
                            <td class="text-center"><?=$value->sub_user_status == 1 ? '<span class="badge badge-success">Success</span>' : '<span class="badge badge-info">Pending</span>'; ?></td>
                            <td class="text-center"><?=date('Y-m-d h:i A', strtotime($value->sub_user_created)); ?></td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-xs" onclick="javascript:approvedSuCustomer(this, '<?=$value->sub_user_id;?>')">Approve</button>
                                <button class="btn btn-danger btn-xs" onclick="javascript:cancelSuCustomer(this, '<?=$value->sub_user_id;?>')">Cancel</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="col-md-12">
                    <div class="alert alert-warning fade in">No Data Found</div>
                </div>
            <?php endif; ?>

                <div class="col-md-12 col-lg-12">
                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <?php echo $links; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>

</div>

<!-- End Main Content Wrapper -->
<script>
    function cancelSuCustomer(e, id) {
        if (confirm("Are you sure reject sub user account!")) {
            $.ajax({
                url: '<?=site_url("sm/customer/approved_sub_customer")?>',
                method: 'POST',
                data: {id: id, status: 'reject'},
                success: function (res) {
                    let obj = JSON.parse(res)
                    if (obj?.status) {
                        alert("Successfully Rejected");
                        location.reload();
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        }
    }

    function approvedSuCustomer(e, id) {
        if (confirm("Are you sure approve sub user account!")) {
            $.ajax({
                url: '<?=site_url("sm/customer/approved_sub_customer")?>',
                method: 'POST',
                data: {id: id},
                success: function (res) {
                    let obj = JSON.parse(res)
                    if (obj?.status) {
                        alert("Successfully Approved. Thank You");
                        location.reload();
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        }
    }
</script>

<?php
$this->load->view('sm/home/view_footer');
?>
