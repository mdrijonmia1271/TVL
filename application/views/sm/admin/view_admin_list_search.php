    <?php
    $this->load->view('sm/home/view_header');
    ?>  
    <!-- Main Content Wrapper -->
    <div class="row">
    <div class="col-sm-12">
    <section class="panel">
    <header class="panel-heading">
    <b>Customer Search </b>
    <span class="tools pull-right">
    <a href="javascript:;" class="fa fa-chevron-down"></a>
    <a href="javascript:;" class="fa fa-cog"></a>
    <!--                    <a href="javascript:;" class="fa fa-times"></a>-->
    </span>
    </header>
    <div class="panel-body">
    <form role="form" class="form-horizontal bucket-form" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/admin/search'; ?>">
    <div class="form-group">

    <div class="col-lg-12">
    <div class="row"> 
    <label for="inputSuccess" class="col-sm-1 control-label col-lg-1"> Name</label>
    <div class="col-lg-3">
    <input type="text" name="name" placeholder="Customer Name" class="form-control">
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
    <b>Customer List (<?php echo $total_rows; ?>)</b>
    <?php
    if (!empty($search)) {

    foreach ($search as $key => $value) {
    ?>
    <div class="row">
    <div class="col-md-4" style="float: left;"><!--    <div class="col-sm-12">-->
    <div class="col-md-6">
    <!--widget start-->
    <aside class="profile-nav alt">
    <section class="panel">
    <div class="twt-feed blue-bg">
    <a href="#">
    <img alt="img" width="60" height="40" src="<?php echo base_url() . 'upload/customer_image/' .$value->customer_id.'/' .$value->picture ?>"/>
    </a>
    <h1><?php echo $value->name; ?></h1>
    <p><?php  echo $value->mobile; ?></p>
    <p><?php echo $value->contact_add_details; ?></p>

    </div>

    <ul class="nav nav-pills nav-stacked">
    <li><a href="javascript:;"> <i class="fa fa-envelope-o"></i> Email <span class="badge label-success pull-right r-activity"><?php echo $value->email; ?></span></a></li>
    <li><a href="javascript:;"> <i class="fa fa-comments-o"></i> Division<span class="badge label-warning pull-right r-activity"><?php echo get_division_by_id($value->contact_add_division); ?></span></a></li>
    <?php if($value->status=='A'){ ?>

    <li><a href="javascript:;"> <i class="fa fa-bell-o"></i> Status <span class="badge label-success pull-right r-activity"><?php  echo "Active";?></span></a></li>
    <?php } else{?>
    <li><a href="javascript:;"> <i class="fa fa-bell-o"></i> Status <span class="badge label-danger pull-right r-activity"><?php  echo "InActive";?></span></a></li>
    <?php } ?>
    <li><a href="javascript:;"> <i class="fa fa-tasks"></i> Message <span class="badge label-danger pull-right r-activity">03</span></a></li>
    </ul>

    </section>
    </aside>
    <!--widget end-->




    </div>
    </div>

    </div>
    <?php } }?>


    <!-- End Main Content Wrapper -->
    <div class="row">
        
        
        
        
        
        
    <div class="col-md-8">

    <div class="row">

    <div class="col-md-6">
    <!--widget start-->
    <aside class="profile-nav alt">
    <section class="panel">
    <div class="user-heading alt gray-bg">
    <a href="#">
    <img alt="" src="images/lock_thumb.jpg">
    </a>
    <h1>Jim Doe</h1>
    <p>Project Manager</p>
    </div>

    <ul class="nav nav-pills nav-stacked">
    <li><a href="javascript:;"> <i class="fa fa-envelope-o"></i> Mail Inbox <span class="badge label-success pull-right r-activity">10</span></a></li>
    <li><a href="javascript:;"> <i class="fa fa-tasks"></i> Recent Activity <span class="badge label-danger pull-right r-activity">15</span></a></li>
    <li><a href="javascript:;"> <i class="fa fa-bell-o"></i> Notification <span class="badge label-success pull-right r-activity">11</span></a></li>
    <li><a href="javascript:;"> <i class="fa fa-comments-o"></i> Message <span class="badge label-warning pull-right r-activity">03</span></a></li>
    </ul>

    </section>
    </aside>
    <!--widget end-->
    </div>

    <div class="col-md-6">
    <section class="panel">
    <div class="twt-feed blue-bg">
    <div class="corner-ribon black-ribon">
    <i class="fa fa-twitter"></i>
    </div>
    <div class="fa fa-twitter wtt-mark"></div>
    <a href="#">
    <img alt="" src="images/lock_thumb.jpg">
    </a>
    <h1>Jim Doe</h1>
    <p>dRojormilan@gmail.com</p>

    </div>
    <div class="weather-category twt-category">
    <ul>
    <li class="active">
    <h5>750</h5>
    Tweets
    </li>
    <li>
    <h5>865</h5>
    Following
    </li>
    <li>
    <h5>3645</h5>
    Followers
    </li>
    </ul>
    </div>
    <div class="twt-write col-sm-12">
    <textarea placeholder="Write your Tweet and Enter" rows="1" class="form-control t-text-area"></textarea>
    </div>
    <footer class="twt-footer">
    <a href="#"><i class="fa fa-camera"></i></a>
    <a href="#"><i class="fa fa-map-marker"></i></a>
    New Castle, UK
    <span class="pull-right">
    32
    </span>
    </footer>
    </section>
    </div>

    </div>


    </div>






    <div class="col-md-4">
    <div class="feed-box text-center">
    <section class="panel">
    <div class="panel-body">
    <div class="corner-ribon blue-ribon">
    <i class="fa fa-twitter"></i>
    </div>
    <a href="#">
    <img alt="" src="images/lock_thumb.jpg">
    </a>
    <h1>Kanye West</h1>
    <p>Just got a pretty neat project via <a href="#">@ooomf</a> - Give it a try <a href="#">http://t.co/e02DwGEeOJ</a></p>
    </div>
    </section>
    </div>
    </div>
        
        
        
        
        
        
    </div>

    <?php
    $this->load->view('sm/home/view_footer');
    ?>    
