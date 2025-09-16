<?php $this->load->view('sm/home/view_landing_page_header'); ?> 

<br>
<br>
<br>
<div class="row">
    <div class="col-lg-12">


        <div class="profile-nav alt">
            <section class="panel text-center" style="border-radius: 50px 50px 0 0;">
                <div class="user-heading alt wdgt-row red-bg" style="background: #5cb85c none repeat scroll 0 0; border-radius: 50px 50px 0 0;text-align: center;">
                    <h3 style="font-size:36px;">TRADE VISION SERVICE MANAGEMENT SYSTEM</h3>
                </div>

                <div class="panel-body">
                    <div class="wdgt-value">
                        <h1 class="count">THAT HELP TO BOOST YOUR BUSINESS</h1>
                        <p></p>
                    </div>
                </div>

            </section>
        </div>

    </div>
</div>
<div class="row">
<div class="col-md-4">
    <a style="border:0px!important;" href="<?php echo base_url() . 'sm/login/index'; ?>" target='_blank'>
        <div class="profile-nav alt">
            <section class="panel text-center" style="background: #f1f2f7  none repeat scroll 0 0;">
                <div class="user-heading alt wdgt-row terques-bg" style="border-radius: 50px 50px 50px 0;">
                    <i class="fa fa-user"></i>
                    <h3>User Login</h3>
                </div>

                <div class="panel-body">
                    <div class="wdgt-value">
                        <!--<h1 class="count">25</h1>-->
                        <!--<p>New Users</p>-->
                    </div>
                </div>

            </section>
        </div>
    </a>
</div>

<div class="col-md-4">
    <a style="border:0px!important;" href="<?php echo base_url() . 'sm/login/eng_login'; ?>" target='_blank'>
        <div class="profile-nav alt">
            <section class="panel text-center" style="background: #f1f2f7  none repeat scroll 0 0;">
                <div style="background: #ff6c60 none repeat scroll 0 0; border-radius: 50px 50px 50px 0;"  class="user-heading alt wdgt-row terques-bg">
                    <i class="fa fa-user"></i>
                    <h3>Service Engineer Login</h3>
                </div>

                <div class="panel-body">
                    <div class="wdgt-value">
                        <!--<h1 class="count">25</h1>-->
                        <!--<p>New Users</p>-->
                    </div>
                </div>

            </section>
        </div>
    </a>
</div>

<div class="col-md-4">
    <a style="border:0px!important;" href="<?php echo base_url() . 'sm/login/customer_login'; ?>" target='_blank'>
        <div class="profile-nav alt">
            <section class="panel text-center" style="background: #f1f2f7  none repeat scroll 0 0;">
                <div style="background: #a48ad4  none repeat scroll 0 0; border-radius: 50px 50px 50px 0;" class="user-heading alt wdgt-row terques-bg">
                    <i class="fa fa-user"></i>
                    <h3>Customer Login</h3>
                </div>

                <div class="panel-body">
                    <div class="wdgt-value">
                        <!--<h1 class="count">25</h1>-->
                        <!--<p>New Users</p>-->
                    </div>
                </div>

            </section>
        </div>
    </a>
</div>
</div>
<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>    