<?php
$this->load->view('sm/home/view_dashboard_header');
?> 

<!--page start-->

<div class="row">
    <section class="panel" style="display: none;">
            <div class="panel-body">
                    <div class="top-stats-panel">
                            <div class="daily-visit">
                                    <h4 class="widget-h">Daily Visitors</h4>
                                    <div id="daily-visit-chart" style="width:100%; height: 100px; display: block">

                                    </div>
                                    <ul class="chart-meta clearfix">
                                            <li class="pull-left visit-chart-value">3233</li>
                                            <li class="pull-right visit-chart-title"><i class="fa fa-arrow-up"></i> 15%</li>
                                    </ul>
                            </div>
                    </div>
            </div>
    </section>
    <div class="col-md-8">
        <div class="event-calendar clearfix">
            <div class="col-lg-7 calendar-block">
                <section class="panel">
                    <header class="panel-heading">
                        Todays Summary <span class="tools pull-right">
                        </span>
                    </header>
                    <div class="panel-body" style="padding: 0px !important;">
                        <div class="top-stats-panel">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="javascript:;"> <i class="fa fa-dot-circle-o"></i> <span style="color: #080;">Ticket Pending </span>
                                        <span class="badge label-success pull-right r-activity"><?php echo $ticket_list_daily_pending; ?></span>
                                    </a>
                                </li>
                                <li><a href="javascript:;"> <i class="fa fa-cogs"></i> <span style="color: #a48ad4;">Ticket Working </span>
                                        <span class="badge label-success pull-right r-activity" style="background-color:#a48ad4;"><?php echo $ticket_list_daily_working; ?></span>
                                    </a>
                                </li>
                                <li><a href="javascript:;"> <i class="fa fa-check"></i> <span style="color: #003399;"> Ticket Approve </span>
                                        <span class="badge label-primary pull-right r-activity"><?php echo $ticket_list_daily_approve; ?></span>
                                    </a>
                                </li>
                                <li><a href="javascript:;"> <i class="ico-close"></i> <span style="color: #e51d18;">Ticket Cancel</span> 
                                        <span class="badge label-danger pull-right r-activity"><?php echo $ticket_list_daily_cancel; ?></span>
                                    </a>
                                </li>                                    

                            </ul>
                        </div>
                    </div>
                </section>
                <section class="panel">
                    <header class="panel-heading">
                        Current Month Summary <span class="tools pull-right">
                        </span>
                    </header>
                    <div class="panel-body" style="padding: 0px !important;">
                        <div class="top-stats-panel">
                            <div class="bar-stats">
                                <ul class="progress-stat-bar clearfix">
                                    <?php
                                    $total_ticket_list_monthly = 0;
                                    $total_ticket_list_monthly = $ticket_list_monthly_pending+$ticket_list_monthly_approve+$ticket_list_monthly_cancel;
                                    if(!empty($ticket_list_monthly_pending)){
                                        $ticket_list_monthly_pending_per = round((100*$ticket_list_monthly_pending)/$total_ticket_list_monthly);
                                    }else{
                                        $ticket_list_monthly_pending_per = 0;
                                    }
                                    if(!empty($ticket_list_monthly_approve)){
                                        $ticket_list_monthly_approve_per = round((100*$ticket_list_monthly_approve)/$total_ticket_list_monthly);
                                    }else{
                                        $ticket_list_monthly_approve_per = 0;
                                    }
                                    if(!empty($ticket_list_monthly_cancel)){
                                        $ticket_list_monthly_cancel_per = round((100*$ticket_list_monthly_cancel)/$total_ticket_list_monthly);
                                    }else{
                                        $ticket_list_monthly_cancel_per =0;
                                    }
                                    ?>
                                    <li data-percent="<?php echo $ticket_list_monthly_pending_per;?>%"><span class="progress-stat-percent pink"></span></li>
                                    <li data-percent="<?php echo $ticket_list_monthly_approve_per;?>%"><span class="progress-stat-percent"></span></li>
                                    <li data-percent="<?php echo $ticket_list_monthly_cancel_per;?>%"><span class="progress-stat-percent yellow-b"></span></li>
                                </ul>
                                <ul class="bar-legend">
                                    <li><span class="bar-legend-pointer pink"></span> Pending ( <?php echo $ticket_list_monthly_pending;?> )</li>
                                    <li><span class="bar-legend-pointer green"></span> Approve ( <?php echo $ticket_list_monthly_approve;?> )</li>
                                    <li><span class="bar-legend-pointer yellow-b"></span> Cancel ( <?php echo $ticket_list_monthly_cancel;?> )</li>
                                </ul>
                                <div class="daily-sales-info">
                                    <span class="sales-label">Total Ticket : </span><span class="sales-count"><?php echo $total_ticket_list_monthly;?></span> 
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-lg-5 event-list-block">
                <div class="cal-day">
                    <span>Latest</span>
                    Request List
                </div>
                <ul class="event-list">
                    <?php
                    if(!empty($total_ticket_list_dashboard_notice)){
                            foreach ($total_ticket_list_dashboard_notice as $key_total_ticket_list => $value_total_ticket_list) {
                                    $relative_time = "";
                                    $relative_time = get_relative_time(strtotime($value_total_ticket_list->created_date_time));
                                    $res_customer_details = get_customer_details_customer_id($value_total_ticket_list->send_from);

                                    ?>
                                    <li><?php echo $value_total_ticket_list->ticket_no;?> @ <?php echo $relative_time;?><a href="#" class="event-close"><?php echo isset($res_customer_details->customer_code) ? $res_customer_details->customer_code : ''; ?></a></li>
                                    <?php
                            }
                    }
                    ?>

                </ul>
                <input type="text" class="form-control evnt-input" placeholder="">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="profile-nav alt">
            <section class="panel">
                <div class="user-heading alt clock-row terques-bg" style="min-height:152px;">
                    <h1><?php echo date('F y');?></h1>
                    <p class="text-left"><?php echo date('l');?></p>
                    <p class="text-left"><?php echo date('h:i A');?></p>
                </div>
                <ul id="clock">
                    <li id="sec"></li>
                    <li id="hour"></li>
                    <li id="min"></li>
                </ul>

                <ul class="clock-category">
                    <li>
                        <a href="#" class="active">
                            <i class="ico-clock2"></i>
                            <span>Clock</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ico-alarm2 "></i>
                            <span>Alarm</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="ico-stopwatch"></i>
                            <span>Stop watch</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class=" ico-clock2 "></i>
                            <span>Timer</span>
                        </a>
                    </li>
                </ul>

            </section>
            <!--widget weather start-->
            <section class="weather-widget clearfix">
                <div class="pull-left weather-icon">
                    <canvas id="icon1" width="60" height="60"></canvas>
                </div>
                <div>
                    <ul class="weather-info">
                        <li class="weather-city">Bangladesh <i class="ico-location"></i></li>
                        <li class="weather-cent"><span>28</span></li>
                        <li class="weather-status">Normal</li>
                    </ul>
                </div>
            </section>
            <!--widget weather end-->

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <!--earning graph start-->
        <section class="panel">
            <header class="panel-heading">
                Ticket Summary <span class="tools pull-right">
                </span>
            </header>
            <div class="panel-body">

<!--                <div id="graph-area" class="main-chart">
                </div>-->
                <?php
                $year_wise_summary_data =  array(
                    array(
                        'Pending',0,$total_ticket_list_pending
                    ),array(
                        'Working',0,$total_ticket_list_working
                    ),array(
                        'Approve',0,$total_ticket_list_approve
                    ),array(
                        'Cancel',0,$total_ticket_list_cancel
                    ),
                );
                ?>
                <script type="text/javascript">
                    var year_wise_summary_data = JSON.parse('<?php echo json_encode($year_wise_summary_data); ?>');
                </script>
                <div class="chart">
                    <div id="chart"></div>
                </div>
                <div class="region-stats">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="region-earning-stats" style="padding-top: 6px;padding-bottom: 0px;">
                                Total Ticket <span><?php echo $total_ticket_list_pending+$total_ticket_list_working+$total_ticket_list_approve+$total_ticket_list_cancel;?></span>
                            </div>
                            
                        </div>
                        <div class="col-md-8">
                            <div class="region-earning-stats" style="padding-top: 6px;padding-bottom: 0px;">
                                <ul class="clearfix location-earning-stats">
                                    <li class="stat-divider">
                                        <span class="first-city"><?php echo $total_ticket_list_pending;?></span>
                                        Pending </li>
                                    <li class="stat-divider">
                                        <span class="first-city"><?php echo $total_ticket_list_working;?></span>
                                        Working </li>
                                    <li class="stat-divider">
                                        <span class="second-city"><?php echo $total_ticket_list_approve;?></span>
                                        Approve </li>
                                    <li>
                                        <span class="third-city"><?php echo $total_ticket_list_cancel;?></span>
                                        Cancel </li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--earning graph end-->
    </div>
    <div class="col-md-4">
        <section class="panel">
            <header class="panel-heading">
                Year Wise Summary <span class="tools pull-right">
                </span>
            </header>
            <div class="panel-body" style="height: 425px;">
                <table class="table  table-hover general-table">
                    <thead>
                    <tr>
                        <th>Year</th>
                        <th class="hidden-phone">Pending</th>
                        <th>Working</th>
                        <th>Approve</th>
                        <th>Cancel</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        unset($year_array[""]);
                        
                        foreach ($year_array as $key => $value) {
                            
                            ?>
                            <tr>
                                <td><?php echo $value; ?></td>
                                <td><?php echo get_year_status_wise_total_ticket_for_cus($value,'P');?></td>
                                <td><?php echo get_year_status_wise_total_ticket_for_cus($value,'W');?></td>
                                <td><?php echo get_year_status_wise_total_ticket_for_cus($value,'A');?></td>
                                <td><?php echo get_year_status_wise_total_ticket_for_cus($value,'C');?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        
                    </tbody>
                </table>
                
            </div>
        </section>
    </div>
</div>
<!--page end-->

<?php
$this->load->view('sm/home/view_dashboard_footer');
?>    