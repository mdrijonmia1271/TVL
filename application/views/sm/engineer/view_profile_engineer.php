<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
            <div class="col-md-12">
                <h3 class="prf-border-head">Profile</h3>
                <section class="panel" style="background-color: #fff;">
                    
                    <div class="panel-body profile-information">
                       <div class="col-md-3">
                           <div class="profile-pic text-center">
                               <!--<img alt="img" width="60" height="40" src="<?php //echo base_url() . 'upload/customer_image/' .$view->customer_id.'/' .$view->picture ?>"/>-->
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="profile-desk">
                               <h1><?php  echo $view->name; ?></h1>
                               <span class="text-muted"><?php  echo $view->email; ?></span>
                               <br>
                               <p>
                                   <?php  echo $view->contact_add_details; ?>
                               </p>
                               <br>
                                <p>
                                   <?php  echo $view->mobile; ?>
                               </p>
                               <!--<a class="btn btn-primary" href="#">View Profile</a>-->
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
            
        </div>

<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>    