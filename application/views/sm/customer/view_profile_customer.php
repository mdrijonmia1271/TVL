<?php $this->load->view('sm/home/view_header'); ?>

<div class="row">
    <div class="col-md-12">
        <section class="panel" style="background-color: #fff;">
            <div class="panel-body profile-information">
                <div class="col-md-3">
                    <div class="profile-pic text-center">
                        <?php if (!empty($view->picture)) { ?>
                            <img alt="img" width="60" height="40"
                                 src="<?php echo base_url() . 'upload/customer_image/' . $view->customer_id . '/' . $view->picture ?>"/>
                        <?php } else { ?>
                            <img alt="img" width="60" height="40"
                                 src="<?php echo base_url() . 'smdesign/images/noimage.png' ?>"/>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="profile-desk">
                        <h1><?php echo $view->name; ?></h1>
                        <span class="text-muted"><?php echo $view->email; ?></span>
                        <br>
                        <p>
                            Mobile: <?php echo $view->mobile; ?>
                        </p>
                        <br>
                        <?php if(!isset($sub_customer)):?>
                        <a href="<?php echo base_url('sm/customer/edit_profile/'.$view->customer_id);?>" class="btn btn-primary">Edit Profile</a>
                        <?php endif;?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="profile-statistics">
                        <h1><?php echo get_division_by_id($view->contact_add_division); ?></h1>
                        <p>Division</p>
                        <h1><?php echo get_district_by_id($view->contact_add_district); ?></h1>
                        <p>District</p>

                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading tab-bg-dark-navy-blue">
                <ul class="nav nav-tabs nav-justified ">
                    <li class="active">
                        <a data-toggle="tab" href="#address">
                            Address
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#ctp">
                            Contact Person Info.
                        </a>
                    </li>
                </ul>
            </header>
            <div class="panel-body">
                <div class="tab-content tasi-tab">
                    <div id="address" class="tab-pane active">
                        <div class="col-md-4">
                            <div class="prf-box">
                                <br>
                                <div class=" wk-progress">
                                    <div class="col-md-5">Flat/House No. :</div>
                                    <div class="col-md-7">
                                        <?= $view->cust_flat; ?>
                                    </div>
                                </div>
                                <div class=" wk-progress">
                                    <div class="col-md-5">Road/Sector</div>
                                    <div class="col-md-7">
                                        <?= $view->cust_road; ?>
                                    </div>
                                </div>
                                <div class=" wk-progress">
                                    <div class="col-md-5">Post Office</div>
                                    <div class="col-md-7">
                                        <?= $view->cust_post; ?>
                                    </div>

                                </div>
                                <div class=" wk-progress">
                                    <div class="col-md-5">Thana</div>
                                    <div class="col-md-5">
                                        <?= $view->THANA_NAME; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="ctp" class="tab-pane">

                        <div class="col-md-6 col-md-offset-3">
                            <div class="prf-box">
                                <br>
                                <div class=" wk-progress">
                                    <div class="col-md-5">Name :</div>
                                    <div class="col-md-7">
                                        <?= (isset($sub_customer)) ? $sub_customer->username : $view->contact_person_name; ?>
                                    </div>
                                </div>
                                <div class=" wk-progress">
                                    <div class="col-md-5">Email</div>
                                    <div class="col-md-7">
                                        <?= (isset($sub_customer)) ? $sub_customer->email : $view->contact_person_email; ?>
                                    </div>
                                </div>

                                <?php if(!isset($sub_customer)): ?>
                                <div class=" wk-progress">
                                    <div class="col-md-5">Designation</div>
                                    <div class="col-md-7">
                                        <?= $view->contact_person_desig; ?>
                                    </div>
                                </div>
                                <?php endif;?>

                                <div class=" wk-progress">
                                    <div class="col-md-5">Phone</div>
                                    <div class="col-md-5">
                                        <?= (isset($sub_customer)) ? $sub_customer->phone : $view->contact_person_phone; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </section>
    </div>
</div>


<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>    