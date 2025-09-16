<?php $this->load->view('sm/home/view_login_header'); ?> 



<form class="form-signin" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/customer/verify_login'; ?>">
   <?php
      if ($this->session->flashdata('login_msg') != '') { ?>
        <p style="color:red;">    
          <?php echo $this->session->flashdata('login_msg');?>
       </p>   
    <?php }?>
       
    <h2 class="form-signin-heading"><b>Customer Sign In</b></h2>
    <div class="login-wrap">
        <div class="user-login-info">
            <?php
            $login_ph_arry = array(
                'name' => 'mobile',
                'id' => 'mobile',
                'class' => "form-control",
                'placeholder' => 'Enter Customer Mobile',
                //'required'=> 'required',
                'value' => set_value('mobile'),
            );

            echo form_input($login_ph_arry);
            ?>
            <span class="error"><?php echo form_error('mobile'); /* print valitation error */ ?></span>

            <?php
            $login_password_arry = array(
                'name' => 'password',
                'id' => 'password',
                'class' => "form-control",
                'placeholder' => 'Enter Password',
                //'required'=> 'required',
                'value' => set_value('password'),
            );

            echo form_password($login_password_arry);
            ?>
            <span class="error"><?php echo form_error('password'); /* print valitation error */ ?></span>

        </div>
<!--        <label class="checkbox">

            <span class="pull-right">
                <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

            </span>
        </label>-->
        <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>

        <div class="registration">
            Don't have an account yet?
            <a class="" href="<?php echo base_url() . 'sm/customer/index'; ?>">
                Customer Signup
            </a>
        </div>

    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Forgot Password ?</h4>
                </div>
                <div class="modal-body">
                    <p>Enter your e-mail address below to reset your password.</p>
                    <?php
                    $forget_email_arry = array(
                        'name' => 'email',
                        'id' => 'email',
                        'class' => "form-control placeholder-no-fix",
                        'placeholder' => 'Enter Email Address',
                        //'required'=> 'required',
                        'value' => set_value('mobile'),
                    );

                    echo form_input($forget_email_arry);
                    ?>
                    <span class="error"><?php echo form_error('email'); /* print valitation error */ ?></span>

                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                    <button class="btn btn-success" type="button">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->

</form>










<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_login_footer');
?>    