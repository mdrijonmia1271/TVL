<?php
$this->load->view('sm/home/view_dashboard_header');
?>

<!--page start-->
<!--mini statistics start-->
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
    <?php
    //print_r($customer_list_for_dashboard);
    if (!empty($customer_list_summary)) {
        foreach ($customer_list_summary as $key_customer_list => $value_customer_list) {
            //echo ">>>".$value_customer_list->customer_id;
            $cus_total_ticket = 0;

            $cus_total_ticket_pending = get_cus_total_ticket_status_wise($value_customer_list->customer_id, 'P');
            $cus_total_ticket_working = get_cus_total_ticket_status_wise($value_customer_list->customer_id, 'W');
            $cus_total_ticket_progress = get_cus_total_ticket_status_wise($value_customer_list->customer_id, 'O');
            $cus_total_ticket_approve = get_cus_total_ticket_status_wise($value_customer_list->customer_id, 'A');
            $cus_total_ticket_cancel = get_cus_total_ticket_status_wise($value_customer_list->customer_id, 'C');


            $cus_total_ticket = $cus_total_ticket_pending + $cus_total_ticket_working + $cus_total_ticket_progress + $cus_total_ticket_approve + $cus_total_ticket_cancel;

            if (!empty($cus_total_ticket_pending)) {
                $cus_total_ticket_pending_per = round((100 * $cus_total_ticket_pending) / $cus_total_ticket);
            } else {
                $cus_total_ticket_pending_per = 0;
            }
            if (!empty($cus_total_ticket_working)) {
                $cus_total_ticket_working_per = round((100 * $cus_total_ticket_working) / $cus_total_ticket);
            } else {
                $cus_total_ticket_working_per = 0;
            }

            if (!empty($cus_total_ticket_progress)) {
                $cus_total_ticket_progress_per = round((100 * $cus_total_ticket_progress) / $cus_total_ticket);
            } else {
                $cus_total_ticket_progress_per = 0;
            }

            if (!empty($cus_total_ticket_approve)) {
                $cus_total_ticket_approve_per = round((100 * $cus_total_ticket_approve) / $cus_total_ticket);
            } else {
                $cus_total_ticket_approve_per = 0;
            }
            if (!empty($cus_total_ticket_cancel)) {
                $cus_total_ticket_cancel_per = round((100 * $cus_total_ticket_cancel) / $cus_total_ticket);
            } else {
                $cus_total_ticket_cancel_per = 0;
            }


            //exit();
            ?>
            <div class="col-md-3">
                <section class="panel">
                    <div class="panel-body">
                        <div class="top-stats-panel">
                            <h4 class="widget-h"><?php echo $value_customer_list->name ?></h4>
                            <div class="bar-stats">
                                <ul class="progress-stat-bar clearfix">
                                    <li data-percent="<?php echo $cus_total_ticket_pending_per; ?>%"><span
                                                class="progress-stat-percent pink"></span></li>
                                    <li data-percent="<?php echo $cus_total_ticket_working_per; ?>%"><span
                                                class="progress-stat-percent yellow-b"></span></li>
                                    <li data-percent="<?php echo $cus_total_ticket_progress_per; ?>%"><span
                                                class="progress-stat-percent progress_ch"></span></li>
                                    <li data-percent="<?php echo $cus_total_ticket_approve_per; ?>%"><span
                                                class="progress-stat-percent green"></span></li>
                                    <li data-percent="<?php echo $cus_total_ticket_cancel_per; ?>%"><span
                                                class="progress-stat-percent red-bg"></span></li>
                                </ul>
                                <ul class="bar-legend">
                                    <li><span class="bar-legend-pointer pink"></span> Pending
                                        ( <?php echo $cus_total_ticket_pending; ?> )
                                    </li>
                                    <li><span class="bar-legend-pointer yellow-b "></span> Working
                                        ( <?php echo $cus_total_ticket_working; ?> )
                                    </li>
                                    <li><span class="bar-legend-pointer progress_ch"></span> On Progress
                                        ( <?php echo $cus_total_ticket_progress; ?> )
                                    </li>
                                    <li><span class="bar-legend-pointer green"></span> Complete
                                        ( <?php echo $cus_total_ticket_approve; ?> )
                                    </li>
                                    <li><span class="bar-legend-pointer red-bg"></span> Cancel
                                        ( <?php echo $cus_total_ticket_cancel; ?> )
                                    </li>
                                </ul>
                                <div class="daily-sales-info">
                                    <span class="sales-label">Total Ticket : </span><span
                                            class="sales-count"><?php echo $cus_total_ticket; ?> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php
        }
    }
    ?>

</div>
<!--mini statistics end-->


<div class="col-md-12 col-lg-12">
    <div class="dataTables_paginate paging_bootstrap pagination">
        <ul>
            <?php echo $links; ?>
        </ul>
    </div>
</div>

<!--page end-->

<?php
$this->load->view('sm/home/view_dashboard_footer');
?>    