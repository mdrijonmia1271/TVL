<?php
$this->load->view('sm/home/view_header');
?>  
<!-- Main Content Wrapper -->
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <b>Service Engineer Search </b>
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <!--<a href="javascript:;" class="fa fa-times"></a>-->
                </span>
            </header>
            <div class="panel-body">
                <form role="form" class="form-horizontal bucket-form" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/engineer/search'; ?>">
                    <div class="form-group">
                        
                        <div class="col-lg-12">
                            <div class="row"> 
                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1"> Name</label>
                                <div class="col-lg-3">
                                    <input type="text" name="name" placeholder="Service Engineer Name" class="form-control">
                                </div>
                                
                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Email</label>
                                <div class="col-lg-3">
                                    <input type="text" name="email"  placeholder="Email" class="form-control">
                                </div>
                                
                                 <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Mobile</label>
                                <div class="col-lg-3">
                                    <input type="text" name="mobile"  placeholder="Mobile" class="form-control">
                                </div>
                                
                                
                            </div>
                        </div>
                        
                         <div class="col-lg-12">
                             <br>
                            <div class="row">                                
                                
                                <label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Status</label>
                                <div class="col-lg-3"  placeholder="Status">
                                    <select  name="status" class="form-control m-bot3">
                                        <option value="A">Active</option>
                                        <option value="I">InActive</option>
                                      
                                    </select>
                                    
                                </div>
                               
                                <div class="col-lg-3">
                                    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-success" type="submit">Search</button>
                                </div>

                            </div>
                        </div>
                    </div>
                            
                        </form>
            </div>
        </section>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <?php
            if (!empty($search)) {

                foreach ($search as $key => $value) { 
                    ?>
                    <div class="col-md-3">
                        <!--widget start-->
                        <aside class="profile-nav alt">
                            <section class="panel">
                                <div class="twt-feed blue-bg" style="background:#2b4266!important;">
                                    <div class="corner-ribon black-ribon">
                                        <!--<i class="fa fa-twitter"></i>-->
                                    </div>
                                    <!--<div class="fa fa-twitter wtt-mark"></div>-->
                                   <a href="#">
                                          
                                                <?php if (!empty($value->picture)) { ?>
                                                    <img alt="img" width="60" height="40" src="<?php echo base_url() . 'upload/service_engineer/' . $value->ser_eng_id . '/' . $value->picture ?>"/>
                                                <?php } else { ?>
                                                    <img alt="img" width="60" height="40" src="<?php echo base_url() . 'smdesign/images/noimage.png' ?>"/>
                                            <?php } ?>
                                        
                                    </a>
                                              <h1><?php echo $value->name; ?></h1>
                                    <p>Mobile: <?php echo $value->mobile; ?></p>
                                    <p>Password: <?php echo $value->password; ?></p>
                                    <p>Email: <?php echo $value->email; ?></p>
                                </div>

                               <ul class="nav nav-pills nav-stacked">
                                    <li><a href="javascript:;"> <i class="fa fa-check"></i> <span style="color: #080;">Ticket Approve </span>
                                            <span class="badge label-success pull-right r-activity"><?php echo get_engineer_status_approve($value->ser_eng_id); ?></span>
                                        </a>
                                    </li>
                                    <li><a href="javascript:;"> <i class="fa fa-comments-o"></i> <span style="color: #003399;"> Ticket Pending  </span>
                                            <span class="badge label-primary pull-right r-activity"><?php echo get_engineer_status_pending($value->ser_eng_id); ?></span>
                                        </a>
                                    </li>
                                    <li><a href="javascript:;"> <i class="ico-close"></i> <span style="color: #e51d18;">Ticket Cancel</span> 
                                            <span class="badge label-danger pull-right r-activity"><?php echo get_engineer_status_cancel($value->ser_eng_id); ?></span>
                                        </a>
                                    </li> 
                                           <li><a href="javascript:;"> <i class="fa fa-bell-o"></i> <span style="color: #963996;">Ticket Working</span> 
                                    <span class="badge label-info pull-right r-activity"><?php echo get_engineer_status_working($value->ser_eng_id); ?></span>
                                    </a>
                                    </li> 

                                        
                                        <li><a style="color: #fff;" class="btn btn-compose" href="<?php echo base_url(); ?>sm/engineer/edit/<?php echo $value->ser_eng_id; ?>">Edit</a></li>

                                </ul>

                            </section>
                        </aside>
                        <!--widget end-->
                    </div>


                    <?php
                }
            } else {
                echo"<div class=\"alert alert-warning fade in\">"; //alert alert-block alert-danger fade in
                echo 'No Data Found.';
                echo"</div>";
            }
            ?>

        </div>
    </div>

</div>



<!-- End Main Content Wrapper -->


<?php
$this->load->view('sm/home/view_footer');
?>    
