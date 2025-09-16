<!--header start-->
<header class="header fixed-top">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="fa fa-bar">|</span>
            <span class="fa fa-bar">|</span>
            <span class="fa fa-bar">|</span>
        </button>

        <!--logo start-->
        <!--logo start-->
        <div class="brand">
            <a href="#" class="logo">
                <?php
                $sess_customer = $this->session->userdata('is_customer_login');
                $sess_engineer = $this->session->userdata('is_engineer_login');
                $sess_admin    = $this->session->userdata('is_admin_login');

                if ($sess_customer) {
                    $auto_id  = $this->session->userdata('customer_auto_id');
                    $name     = get_customer_name_by_id($auto_id);
                    $image    = get_customer_pic_by_id($auto_id);
                    $img_path = 'upload/customer_image/' . $auto_id . '/' . $image;
                } else if ($sess_engineer) {
                    $auto_id = $this->session->userdata('engineer_auto_id');
                    $name    = get_engineer_name_by_id($auto_id);
                } else if ($sess_admin) {
                    $auto_id = $this->session->userdata('admin_auto_id');
                    $name    = get_admin_name_by_id($auto_id);
                }
                ?>
                <img src="<?php echo base_url() . 'smdesign/'; ?>images/<?=COMPANY_LOGO?>" alt="<?=COMPANY_NAME?>"
                     style="width: 160px; margin-left:5px;">
            </a>
        </div>
        <!--logo end-->
        <?php if ($sess_admin) : ?>
            <div class="horizontal-menu navbar-collapse collapse ">
                <ul class="nav navbar-nav">
                    <?php if ($this->session->userdata('root_admin') == "yes") { ?>
                        <li><a href="<?php echo base_url() . 'sm/dashboard/admin'; ?>">Dashboard</a></li>

                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Service
                                Engineer<b class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url() . 'sm/engineer/index'; ?>">New Engineer</a></li>
                                <li><a href="<?php echo base_url() . 'sm/engineer/records'; ?>">Engineer List</a></li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Customer<b
                                        class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url() . 'sm/customer/index'; ?>">New Customer</a></li>
                                <li><a href="<?php echo base_url() . 'sm/customer/records'; ?>">Customer List</a></li>
                                <li><a href="<?php echo base_url() . 'sm/customer/all_sub_user_list'; ?>">All Sub User List</a></li>
                                <li><a href="<?php echo base_url() . 'sm/customer/customer_otp'; ?>">OTP History</a>
                                </li>
                                <li><a href="<?php echo base_url() . 'sm/customer/notification'; ?>">Notification</a>
                                </li>

                            </ul>
                        </li>

                        <!--<li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Install Base<b class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php /*echo base_url() . 'sm/install_base'; */ ?>">New Install Base</a></li>
                                <li><a href="<?php /*echo base_url() . 'sm/install_base/ins_list'; */ ?>">Install Base List</a></li>

                            </ul>
                        </li>-->
                    <?php } ?>
                    <?php  if ($this->session->userdata('root_admin') == "no" && $this->session->userdata('admin_user_type') == 'hd'): ?>
                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Ticket<b
                                        class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url() . 'sm/manager/index'; ?>">Create Ticket</a></li>
                                <li><a href="<?php echo base_url() . 'sm/manager/ticketlist'; ?>">Ticket List</a></li>
                            </ul>
                        </li>

                    <?php endif; ?>


                    <?php if ($this->session->userdata('root_admin') == "no" && $this->session->userdata('admin_user_type') == 'marketing'): ?>
                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Customer<b
                                        class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url() . 'sm/customer/notification'; ?>">Notification</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>



                    <?php if ($this->session->userdata('root_admin') == "yes") { ?>


                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Ticket<b
                                        class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url() . 'sm/manager/index'; ?>">Create Ticket</a></li>
                                <li><a href="<?php echo base_url() . 'sm/manager/ticketlist'; ?>">Ticket List</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Report<b
                                        class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url() . 'sm/report/service_eng_wise_list'; ?>">Service
                                        Engineer</a></li>
                                <li><a href="<?php echo base_url() . 'sm/report/customer_wise_list'; ?>">Customer</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Configuration<b
                                        class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <!--<li><a href="<?php /*echo base_url() . 'sm/admin_config'; */ ?>">Service Priority</a></li>-->


                                <li><a href="<?php echo base_url() . 'sm/admin_config/medical_dep'; ?>">Medical
                                        Department</a>
                                <li><a href="<?php echo base_url() . 'sm/admin_config/department'; ?>">Department</a>
                                </li>
                                <li><a href="<?php echo base_url() . 'sm/admin_config/designation'; ?>">Designation</a>
                                </li>

                                <li><a href="<?php echo base_url() . 'sm/install_base/ins_list'; ?>">Install Base
                                        List</a></li>
                                <li><a href="<?php echo base_url() . 'sm/customer/feedback_list'; ?>">Customer
                                        Feedback</a></li>

                                <li><a href="<?php echo base_url() . 'sm/admin_config/service_type'; ?>">Support
                                        Type</a></li>
                                <!--<li><a href="<?php /*echo base_url() . 'sm/admin_config/add_task'; */ ?>">Service Task</a></li>-->
                                <li><a href="<?php echo base_url() . 'sm/business'; ?>">Business Area</a></li>
                                <li><a href="<?php echo base_url() . 'sm/manufacture'; ?>">Manufacturer</a></li>
                                <li><a href="<?php echo base_url() . 'sm/spare_parts'; ?>">Spare Parts</a></li>
                                <li><a href="<?php echo base_url() . 'sm/machine'; ?>">Equipment/Item Sold</a></li>
                                <li><a href="<?php echo base_url() . 'sm/notification_temp'; ?>">Notification Template</a></li>
                                <li><a href="<?php echo base_url() . 'sm/superadmin'; ?>">Users</a></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if ($this->session->userdata('root_admin') == "no" && $this->session->userdata('admin_user_type') == 'sm'): ?>

                        <li><a href="<?php echo base_url() . 'sm/manager/ticketlist'; ?>">Ticket List</a>
                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Install
                                Base<b
                                        class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url() . 'sm/install_base/ins_list'; ?>">Install Base
                                        List</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url() . 'sm/customer/feedback_list'; ?>">Customer Feedback</a></li>
                        <li><a href="<?php echo base_url() . 'sm/customer/notification'; ?>">Customer Notification</a>
                        </li>
                        <li><a href="<?php echo base_url() . 'sm/serviceengineer/kb_list'; ?>">Knowledge
                                Base</a></li>


                        <li><a href="<?php echo base_url() . 'sm/pmi/pmi_list'; ?>">PMI List</a>

                        </li>


                    <?php endif; ?>


                </ul>

            </div>

            <div class="top-nav ">
                <ul class="nav pull-right top-menu">
<!--                    <li><input type="text" class="form-control search" placeholder="Search Tickets"></li>-->
                    <li>
                        <a href="<?=site_url('sm/customer/pendinglist')?>" style="padding: 14px 10px;font-size: 14px;">Users<sup style="color: red;font-size: 16px;background: white;padding: 3px;font-weight: 600;position: absolute;top: 2px;right: -3px;height: 12px;"><?=num_total_pending_customer();?></sup></a>
                    </li>
                    <li>
                        <a href="<?=site_url('sm/manager/ticketlist')?>" style="padding: 14px 10px;font-size: 14px;">Tickets<sup style="color: red;font-size: 16px;background: white;padding: 3px;font-weight: 600;position: absolute;top: 2px;right: -3px;height: 12px;"><?=num_total_pending_tickets();?></sup></a>
                    </li>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <?php if (isset($img_path)): ?>
                                <img alt="" src="<?php echo base_url() . $img_path; ?>">
                            <?php else: ?>
                                <img alt="" src="<?=site_url('images/login/sr.eng.png')?>">
                            <?php endif; ?>
                            <span class="username"><?php echo $name; ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="<?php echo base_url() . 'sm/login/admin_logout'; ?>"><i class=" fa fa-suitcase"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        <?php elseif ($sess_engineer) : ?>

            <div class="horizontal-menu navbar-collapse collapse ">
                <ul class="nav navbar-nav">
                    <!--                    <li><a href="<?php echo base_url() . 'sm/serviceengineer/records'; ?>">Dashboard</a></li>                           -->

                    <li class="dropdown">
                        <a href="<?php echo base_url() . 'sm/serviceengineer/records'; ?>">Ticket List</a>
                    </li>

                    <li class="dropdown">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Install Base<b
                                    class=" fa fa-angle-down"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . 'sm/install_base'; ?>">New Install Base</a></li>
                            <li><a href="<?php echo base_url() . 'sm/install_base/ins_list'; ?>">Install Base List</a>
                            <li><a href="<?php echo base_url() . 'sm/mdepartment'; ?>">Department</a>
                            </li>

                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="<?php echo base_url() . 'sm/serviceengineer/kb_list'; ?>">Knowledge Base</a>
                    </li>

                    <li class="dropdown">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">PMI Report<b
                                    class=" fa fa-angle-down"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . 'sm/pmi'; ?>">Add PMI</a></li>
                            <li><a href="<?php echo base_url() . 'sm/pmi/pmi_list'; ?>">PMI List</a>
                            </li>

                        </ul>
                    </li>

                </ul>

            </div>


            <div class="top-nav ">
                <ul class="nav pull-right top-menu">

                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <?php if (isset($img_path)) { ?>
                                <img alt="" src="<?php echo base_url() . $img_path; ?>">
                            <?php } ?>
                            <span class="username"><?php echo $name; ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <!--<li><a href="<?php /*echo base_url() . 'sm/engineer/view'; */ ?>"><i class=" fa fa-suitcase"></i>Profile</a></li>-->
                            <li><a href="<?php echo base_url() . 'sm/login/eng_logout'; ?>"><i class="fa fa-key"></i>
                                    Log Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
            </div>

        <?php elseif ($sess_customer) : ?>
            <div class="horizontal-menu navbar-collapse collapse ">
                <ul class="nav navbar-nav">
                    <!--                    <li><a href="<?php echo base_url() . 'sm/ticket/records'; ?>">Dashboard</a></li>-->

                    <li><a href="<?php echo base_url() . 'sm/ticket/index'; ?>">New Ticket</a></li>

                    <li>
                        <a href="<?php echo base_url() . 'sm/ticket/records'; ?>">Ticket List</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() . 'sm/customer/machine'; ?>">Equipment List</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url() . 'sm/customer/feedback'; ?>">Feedback</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() . 'sm/customer/admin_ntf'; ?>">Notification</a>
                    </li>

                    <!--<li class="dropdown">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Setting <b class=" fa fa-angle-down"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Password</a></li>

                        </ul>
                    </li>-->
                </ul>

            </div>
            <div class="top-nav ">
                <ul class="nav pull-right top-menu">
                    <li>
                        <span class="badge badge-info" style="background: #1fb5ad;padding: 1em;">
                            <?php
                                if ($this->session->has_userdata('sub_customer_id')) {
                                    echo "USER PANEL";
                                } else {
                                    echo "HOSPITAL PANEL";
                                }
                            ?>
                        </span>
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">


                            <img alt="" src="<?php echo base_url() . $img_path; ?>">
                            <span class="username"><?php echo $name; ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="<?php echo base_url() . 'sm/customer/reset'; ?>"><i class="fa fa-eye"></i>Reset
                                    Password</a></li>
                            <li><a href="<?php echo base_url() . 'sm/customer/view'; ?>"><i class=" fa fa-suitcase"></i>My
                                    Profile</a>
                            </li>
                            <li><a href="<?php echo base_url() . 'sm/login/customer_logout'; ?>"><i
                                            class="fa fa-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
            </div>
        <?php else : ?>
            <div class="horizontal-menu navbar-collapse collapse ">
                <ul class="nav navbar-nav">

                </ul>

            </div>
            <div class="top-nav ">

            </div>

        <?php endif; ?>

    </div>

</header>
<!--header end-->
