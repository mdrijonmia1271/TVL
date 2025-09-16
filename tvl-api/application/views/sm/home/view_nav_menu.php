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
                $sess_admin = $this->session->userdata('is_admin_login'); 

                if ($sess_customer) {
                    $auto_id = $this->session->userdata('customer_auto_id');
                    $name = get_customer_name_by_id($auto_id);
                    $image = get_customer_pic_by_id($auto_id);
                    $img_path = 'upload/customer_image/' . $auto_id . '/' . $image;
                } else if ($sess_engineer) {
                    $auto_id = $this->session->userdata('engineer_auto_id');
                     $name = get_engineer_name_by_id($auto_id);
                } else if ($sess_admin) {
                    $auto_id = $this->session->userdata('admin_auto_id');
                    $name = get_admin_name_by_id($auto_id);
                }
                ?>
              <img src="<?php echo base_url() . 'smdesign/'; ?>images/Logo.png" alt="LOGO" style="width: 230px; margin-left:5px;">
                   
            </a>
        </div>
        <!--logo end-->

        <?php if ($sess_admin) { ?>
            <div class="horizontal-menu navbar-collapse collapse ">
                <ul class="nav navbar-nav">
                    <?php if($this->session->userdata('root_admin') == "yes"){ ?>
                    <li><a href="<?php echo base_url() . 'sm/dashboard/admin'; ?>">Dashboard</a></li>

                    <li class="dropdown">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Service Engineer<b class=" fa fa-angle-down"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . 'sm/engineer/index'; ?>">New Engineer</a></li>
                            <li><a href="<?php echo base_url() . 'sm/engineer/records'; ?>">Engineer List</a></li>

                        </ul>
                    </li>
                    <li class="dropdown">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Customer<b class=" fa fa-angle-down"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . 'sm/customer/index'; ?>">New Customer</a></li>
                            <li><a href="<?php echo base_url() . 'sm/customer/records'; ?>">Customer List</a></li>

                        </ul>
                    </li>

                        <!--<li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Install Base<b class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php /*echo base_url() . 'sm/install_base'; */?>">New Install Base</a></li>
                                <li><a href="<?php /*echo base_url() . 'sm/install_base/ins_list'; */?>">Install Base List</a></li>

                            </ul>
                        </li>-->
                    <?php } ?>

                    <li class="dropdown">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Ticket<b class=" fa fa-angle-down"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . 'sm/manager/index'; ?>">Create Ticket</a></li>
                            <li><a href="<?php echo base_url() . 'sm/manager/ticketlist'; ?>">Ticket List</a></li>                
                        </ul>
                    </li>


                     <?php if($this->session->userdata('root_admin') == "yes"){ ?>    
                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Report<b class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url() . 'sm/report/service_eng_wise_list'; ?>">Service Engineer</a></li>
                                <li><a href="<?php echo base_url() . 'sm/report/customer_wise_list'; ?>">Customer</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Configuration<b class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <!--<li><a href="<?php /*echo base_url() . 'sm/admin_config'; */?>">Service Priority</a></li>-->


                                <li><a href="<?php echo base_url() . 'sm/admin_config/department'; ?>">Department</a></li>
                                <li><a href="<?php echo base_url() . 'sm/admin_config/designation'; ?>">Designation</a></li>

                                <li><a href="<?php echo base_url() . 'sm/admin_config/service_type'; ?>">Support Type</a></li>
                                <!--<li><a href="<?php /*echo base_url() . 'sm/admin_config/add_task'; */?>">Service Task</a></li>-->
                                <li><a href="<?php echo base_url() . 'sm/business'; ?>">Business Area</a></li>
                                <li><a href="<?php echo base_url() . 'sm/manufacture'; ?>">Manufacturer</a></li>
                                <li><a href="<?php echo base_url() . 'sm/spare_parts'; ?>">Spare Parts</a></li>
                                <li><a href="<?php echo base_url() . 'sm/machine'; ?>">Equipment/Item Sold</a></li>
                                <li><a href="<?php echo base_url() . 'sm/superadmin'; ?>">Users</a></li>
                            </ul>
                        </li>
                     <?php } ?>
                </ul>

            </div>

            <div class="top-nav ">
                <ul class="nav pull-right top-menu">
                    <li>
<!--                        <input type="text" class="form-control search" placeholder=" Search">-->
                    </li>
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
<!--                            <li><a href="<?php echo base_url() . '#'; ?>"><i class=" fa fa-picture-o"></i>Profile</a></li>                                  -->
                            <li><a href="<?php echo base_url() . 'sm/login/admin_logout'; ?>"><i class=" fa fa-suitcase"></i>Logout</a></li>                                  

                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
            </div>

        <?php } else if ($sess_engineer) { ?>      

            <div class="horizontal-menu navbar-collapse collapse ">
                <ul class="nav navbar-nav">
<!--                    <li><a href="<?php echo base_url() . 'sm/serviceengineer/records'; ?>">Dashboard</a></li>                           -->

                    <li class="dropdown">
                        <a href="<?php echo base_url() . 'sm/serviceengineer/records'; ?>">Ticket List</a>
                    </li>

                    <li class="dropdown">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Install Base<b class=" fa fa-angle-down"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . 'sm/install_base'; ?>">New Install Base</a></li>
                            <li><a href="<?php echo base_url() . 'sm/install_base/ins_list'; ?>">Install Base List</a></li>

                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="<?php echo base_url() . 'sm/serviceengineer/kb_list'; ?>">Knowledge Base</a>
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
                            <li><a href="<?php echo base_url() . 'sm/engineer/view'; ?>"><i class=" fa fa-suitcase"></i>Profile</a></li>                                  
                            <li><a href="<?php echo base_url() . 'sm/login/eng_logout'; ?>"><i class="fa fa-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
            </div> 

        <?php } else if ($sess_customer) { ?>  
            <div class="horizontal-menu navbar-collapse collapse ">
                <ul class="nav navbar-nav">
<!--                    <li><a href="<?php echo base_url() . 'sm/ticket/records'; ?>">Dashboard</a></li>-->

                    <li class="dropdown">
                        <li><a href="<?php echo base_url() . 'sm/ticket/index'; ?>">New Ticket</a></li>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo base_url() . 'sm/ticket/records'; ?>">Ticket List</a>
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

                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">


                            <img alt="" src="<?php echo base_url() . $img_path; ?>">
                            <span class="username"><?php echo $name; ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
<!--                            <li><a href="<?php echo base_url() . 'sm/customer/view'; ?>"><i class=" fa fa-suitcase"></i>Profile</a></li>                                  -->
                            <li><a href="<?php echo base_url() . 'sm/login/customer_logout'; ?>"><i class="fa fa-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
            </div>  
        <?php } else { ?>  
            <div class="horizontal-menu navbar-collapse collapse ">
                <ul class="nav navbar-nav">

                </ul>

            </div>
            <div class="top-nav ">

            </div> 

        <?php } ?>

    </div>

</header>
<!--header end-->
