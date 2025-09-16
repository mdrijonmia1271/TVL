<?php
$this->load->view('sm/home/view_header');
?>
<!-- Main Content Wrapper -->
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <b>Customer Search </b>
            </header>
            <div class="panel-body">
                <form role="form" class="form-horizontal bucket-form" enctype="multipart/form-data" method="post"
                      action="<?php echo base_url() . 'sm/customer/search'; ?>">
                    <div class="form-group">

                        <div class="col-lg-12">
                            <div class="row">
                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1"> Name</label>
                                <div class="col-lg-3">
                                    <input type="text" name="name" placeholder="Customer Name" class="form-control">
                                </div>

                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Email</label>
                                <div class="col-lg-3">
                                    <input type="text" name="email" placeholder="Email" class="form-control">
                                </div>

                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Mobile</label>
                                <div class="col-lg-3">
                                    <input type="text" name="mobile" placeholder="Mobile" class="form-control">
                                </div>


                            </div>
                        </div>

                        <div class="col-lg-12">
                            <br>
                            <div class="row">

                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Status</label>
                                <div class="col-lg-3" placeholder="Status">
                                    <select name="status" class="form-control m-bot3">
                                        <option value="A">Active</option>
                                        <option value="I">InActive</option>

                                    </select>

                                </div>

                                <div class="col-lg-3">
                                    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
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

        <div class="row">
            <?php if (!empty($record)) : ?>
                <table class="table table-bordered" id="cusTable" style="display: none">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th colspan="4">Address</th>
                        <th colspan="4">Contact Person</th>
                        <th colspan="4">Status</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Flat/House No.</th>
                        <th>Road/Sector</th>
                        <th>Post Office</th>
                        <th>Thana</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Mobile</th>
                        <th>Pending</th>
                        <th>Working</th>
                        <th>Complete</th>
                        <th>Cancel</th>

                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($record as $key => $value): ?>
                        <tr>
                            <td><?= $value->name; ?></td>
                            <td><?= $value->email; ?></td>
                            <td><?= $value->mobile; ?></td>
                            <td><?= $value->cust_flat; ?></td>
                            <td><?= $value->cust_road; ?></td>
                            <td><?= $value->cust_post; ?></td>
                            <td><?= $value->THANA_NAME; ?></td>
                            <td><?= $value->contact_person_name; ?></td>
                            <td><?= $value->contact_person_email; ?></td>
                            <td><?= $value->contact_person_desig; ?></td>
                            <td><?= $value->contact_person_phone; ?></td>
                            <td><?= get_customer_status_pending($value->customer_id); ?></td>
                            <td><?= get_customer_status_working($value->customer_id); ?></td>
                            <td><?= get_customer_status_progress($value->customer_id); ?></td>
                            <td><?= get_customer_status_approve($value->customer_id); ?></td>
                            <td><?= get_customer_status_cancel($value->customer_id); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <b>Total Customers : <?= $total_rows; ?> </b>
                    </header>
                </section>
            </div>
            <?php
            if (!empty($record)) : ?>
                <?php foreach ($record as $key => $value) : ?>
                    <div class="col-md-3">
                        <!--widget start-->
                        <aside class="profile-nav alt">
                            <section class="panel">
                                <div class="twt-feed blue-bg" style="background:#712b71!important">
                                    <div class="corner-ribon black-ribon">
                                        <!--<i class="fa fa-twitter"></i>-->
                                    </div>
                                    <!--<div class="fa fa-twitter wtt-mark"></div>-->
                                    <a href="#">
                                        <?php if (!empty($value->picture)) { ?>
                                            <?php
                                            $image = base_url() . 'upload/customer_image/' . $value->customer_id . '/' . $value->picture;
                                            if (is_file($image) && file_exists($image)):
                                                ?>
                                                <img alt="img" width="60" height="40" src="<?=base_url() . 'upload/customer_image/' . $value->customer_id . '/' . $value->picture?>"/>
                                            <?php else: ?>
                                                <img alt="img" width="60" height="40" src="<?php echo base_url() . 'smdesign/images/noimage.png' ?>"/>
                                            <?php endif; ?>
                                        <?php } else { ?>
                                            <img alt="img" width="60" height="40" src="<?php echo base_url() . 'smdesign/images/noimage.png' ?>"/>
                                        <?php } ?>

                                    </a>
                                    <h1 style="margin: 0;"><?php echo $value->name; ?></h1>
                                    <p style="margin: 0;">Mobile: <?php echo $value->mobile; ?></p>
                                    <p style="margin: 0;">Email: <?php echo $value->email; ?></p>
                                    <p style="margin: 0;">Password: <?php echo $value->password; ?></p>
                                </div>

                                <ul class="nav nav-pills nav-stacked">

                                    <li><a href="javascript:;"> <i class="fa fa-comments-o"></i> <span
                                                    style="color: #2F4F4F;"> Ticket Pending  </span>
                                            <span class="badge label-default pull-right r-activity"><?php echo get_customer_status_pending($value->customer_id); ?></span>
                                        </a>
                                    </li>

                                    <li><a href="javascript:;"> <i class="fa fa-bell-o"></i> <span
                                                    style="color:#191970;">Ticket Working</span>
                                            <span class="badge label-primary pull-right r-activity"><?php echo get_customer_status_working($value->customer_id); ?></span>
                                        </a>
                                    </li>


                                    <li><a href="javascript:;"> <i class="fa fa-bell-o"></i> <span
                                                    style="color: #712b71;">Ticket Progress</span>
                                            <span class="badge label-info pull-right r-activity"><?php echo get_customer_status_progress($value->customer_id); ?></span>
                                        </a>
                                    </li>

                                    <li><a href="javascript:;"> <i class="fa fa-check"></i> <span style="color: #080;">Ticket Complete </span>
                                            <span class="badge label-success pull-right r-activity"><?php echo get_customer_status_approve($value->customer_id); ?></span>
                                        </a>
                                    </li>

                                    <li><a href="javascript:;"> <i class="ico-close"></i> <span style="color: #e51d18;">Ticket Cancel</span>
                                            <span class="badge label-danger pull-right r-activity"><?php echo get_customer_status_cancel($value->customer_id); ?></span>
                                        </a>
                                    </li>

                                </ul>


                                <?php $row = 6;?>
                                <div class="col-sm-12" style="padding: 0;">
                                    <?php if ($value->status === "I"): ?>
                                        <div class="col-sm-4" style="padding: 6px 2px 0 0;">
                                            <a style="color: #fff;" class="btn btn-success btn-block"
                                               href="<?php echo base_url(); ?>sm/customer/approved/<?php echo $value->customer_id; ?>">Approved</a>
                                        </div>
                                        <?php $row = 4;?>
                                    <?php endif; ?>

                                    <div class="col-sm-<?=$row;?>" style="padding: 6px 2px;">
                                        <a style="color: #fff;" class="btn btn-warning btn-block"
                                           href="<?php echo base_url(); ?>sm/customer/edit/<?php echo $value->customer_id; ?>">Edit</a>
                                    </div>

                                    <div class="col-sm-<?=$row;?>" style="padding: 6px 0 0 2px;">
                                        <a style="color: #fff;" class="btn btn-info btn-block"
                                           href="<?php echo base_url(); ?>sm/customer/sub_user_list/<?php echo $value->customer_id; ?>">Sub User List</a>
                                    </div>
                                </div>

                            </section>
                        </aside>
                        <!--widget end-->
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="alert alert-warning fade in">No Data Found</div>
            <?php endif; ?>
            <div class="col-md-12 col-lg-12">
                <div class="dataTables_paginate paging_bootstrap pagination">
                    <ul>
                        <?php echo $links; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- End Main Content Wrapper -->


<?php
$this->load->view('sm/home/view_footer');
?>