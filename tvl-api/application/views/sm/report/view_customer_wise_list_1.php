<?php $this->load->view('sm/home/view_header'); ?> 
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <b>Customer Wise Summary Report </b>
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <!--<a href="javascript:;" class="fa fa-times"></a>-->
                </span>
            </header>
            <div class="panel-body">
                <form role="form" class="form-horizontal bucket-form" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/report/customer_wise_list_search'; ?>">
                    <div class="form-group">

                        <div class="col-lg-12">
                            <div class="row"> 

                                <label for="name" class="col-sm-1 control-label col-lg-1"> Customer Name</label>
                                <div class="col-lg-4">
                                    <?php
                                    $dropdown_js_department = 'id="Customer"  class="form-control";';
                                    echo form_dropdown('name', $customer_list, '', $dropdown_js_department);
                                    ?>
                                    <span class="error"><?php echo form_error('name'); /* print valitation error */ ?>
                                </div>

                                <label for="code" class="col-sm-1 control-label col-lg-1">Customer Code</label>
                                <div class="col-lg-4">
                                    <input type="text" name="code"  placeholder="code" class="form-control">
                                </div>

                            </div>

                            <div class="row"> 
                                <label for="Year" class="col-sm-1 control-label col-lg-1">Year</label>
                                <div class="col-lg-4" >
                                    <?php
                                    $dropdown_js1 = 'id="dob_year" style="float:left;" class="form-control";';
                                    echo form_dropdown('dob_year', $year_array, '', $dropdown_js1);
                                    ?>
                                </div>

                                <label for="Month" class="col-sm-1 control-label col-lg-1">Month</label>
                                <div class="col-lg-4">
                                    <?php
                                    $dropdown_js2 = 'id="dob_month" style="float:left;" class="form-control";';
                                    echo form_dropdown('dob_month', $month_array, '', $dropdown_js2);
                                    ?>
                                </div>

                            </div><br>
                            <div class="row"> 
                                <label for="Date Form" class="col-sm-1 control-label col-lg-1">Date Form</label>
                                <div class="col-lg-4">

                                    <input id="datepicker_from" type="text" name="date_from"   placeholder="Date Form" class="form-control" />
                                </div>

                                <label for="Date To" class="col-sm-1 control-label col-lg-1">Date To</label>
                                <div class="col-lg-4">

                                    <input id="datepicker_to" type="text" name="date_to"   placeholder="Date To" class="form-control"/>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <br>
                            <div class="row">                                

                                <label for="status" class="col-sm-1 control-label col-lg-1">Status</label>
                                <div class="col-lg-3"  placeholder="Status">
                                    <select  name="status" class="form-control m-bot3">
                                        <option value="">Select</option>
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

<br><br>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Customer Wise: Request List
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                    <a class="fa fa-cog" href="javascript:;"></a>
                    <!--<a class="fa fa-times" href="javascript:;"></a>-->
                </span>
            </header>
            <div class="panel-body">
                <div class="position-center1">


                    <table class="table table-bordered table-striped table-condensed cf" width="100%" border="5">
                        <thead class="cf">
                            <tr>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Customer Mobile</th>
                                <th scope="col">Customer Email</th>
                                <th scope="col">Total Request</th>

                                <th scope="col" colspan="3">Status</th>
                                <th scope="col" colspan="<?php echo $num_supp_type= num_of_rows_support_type();exit;?>">Support Type</th>
                                <th scope="col"colspan="<?php echo $num_priorit_type= num_of_rows_priority()?>">Priority</th>;

                                <th scope="col">Completion Time</th>
                            </tr>
                            <tr>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>


                                <th>Pending</th>
                                <th>Approved</th>
                                <th>Cancel</th>
                                
                                <?php $initial_support_type = 1; 
                                    // for($initial_support_type = 1; $initial_support_type = $num_supp_type; $initial_support_type++) { ?>               
                                                                        
                                   <th><?php echo get_support_type_name_by_id($id);?></th>
                                <?php //} ?>
                                

                                <th>Critical</th>
                                <th>Nice to Have</th>
                                <th>Low</th>
                                <th>High</th>

<!--<th>&nbsp;<th>-->

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            //  echo '<pre>';   print_r($record);exit;
                            $total_request_sum = 0;
                            $get_customer_status_pending = 0;
                            $get_customer_status_approve = 0;
                            $get_customer_status_cancel = 0;
                            $get_customer_status_working =0;

                            $total_status_pending_sum = 0;
                            $total_status_approve_sum = 0;
                            $total_status_cancel_sum = 0;
                            $total_status_working_sum =0;

                            $total_support_1 = 0;
                            $total_support_2 = 0;
                            $total_support_3 = 0;
                            $total_support_4 = 0;
                            
                            $total_priority_1 = 0;
                            $total_priority_2 = 0;
                            $total_priority_3 = 0;
                            $total_priority_4 = 0;
                            if (!empty($record)) {

                                foreach ($record as $key => $value) {
                                    ?>
                                    <tr>

                                        <td><?php echo $value->name; ?>&nbsp;</td>
                                        <td><?php echo $value->mobile; ?>&nbsp;</td>
                                        <td><?php echo $value->email; ?>&nbsp;</td>
                                        <td><?php
                                            echo $total_request_enginner = total_request_customer($value->customer_id);
                                            $total_request_sum = $total_request_sum + $total_request_enginner;
                                            ?>&nbsp;
                                        </td>

                                        <td><?php
                                            echo $get_customer_status_pending = get_customer_status_pending($value->customer_id);
                                            $total_status_pending_sum = $total_status_pending_sum + $get_customer_status_pending;
                                            ?>&nbsp;
                                        </td>
                                        <td><?php
                                            echo $get_customer_status_approve = get_customer_status_approve($value->customer_id);
                                            $total_status_approve_sum = $total_status_approve_sum + $get_customer_status_approve;
                                            ?>&nbsp;
                                        </td>
                                        <td><?php
                                            echo $get_customer_status_cancel = get_customer_status_cancel($value->customer_id);
                                            $total_status_cancel_sum = $total_status_cancel_sum + $get_customer_status_cancel;
                                            ?>&nbsp;
                                        </td>
                                          <td><?php
                                            echo $get_customer_status_working = get_customer_status_working($value->customer_id);
                                            $total_status_working_sum = $total_status_working_sum + $get_customer_status_working;
                                            ?>&nbsp;
                                        </td>


                                        <td><?php
                                            echo $get_total_support_type1 = get_total_support_type_customer($value->customer_id, 1);
                                            $total_support_1 = $total_support_1 + $get_total_support_type1;
                                            ?>&nbsp;</td>
                                        <td><?php
                                            echo $get_total_support_type2 = get_total_support_type_customer($value->customer_id, 2);
                                            $total_support_2 = $total_support_2 + $get_total_support_type2;
                                            ?>&nbsp;</td>
                                        <td><?php
                                            echo $get_total_support_type3 = get_total_support_type_customer($value->customer_id, 3);
                                            $total_support_3 = $total_support_3 + $get_total_support_type3;
                                            ?>&nbsp;</td>
                                        <td><?php
                                            echo $get_total_support_type4 = get_total_support_type_customer($value->customer_id, 4);
                                            $total_support_4 = $total_support_4 + $get_total_support_type4;
                                            ?>&nbsp;</td>


                                        <td><?php
                                            echo $get_total_priority1 = get_total_priority_customer($value->customer_id, 1);
                                            $total_priority_1 = $total_priority_1 + $get_total_priority1;
                                            ?>&nbsp;</td>
                                        <td><?php
                                            echo $get_total_priority2 = get_total_priority_customer($value->customer_id, 2);
                                            $total_priority_2 = $total_priority_2 + $get_total_priority2;
                                            ?>&nbsp;</td>
                                        <td><?php
                                            echo $get_total_priority3 = get_total_priority_customer($value->customer_id, 3);
                                            $total_priority_3 = $total_priority_3 + $get_total_priority3;
                                            ?>&nbsp;</td>
                                        <td><?php
                                            echo $get_total_priority4 = get_total_priority_customer($value->customer_id, 4);
                                            $total_priority_4 = $total_priority_4 + $get_total_priority4;
                                            ?>&nbsp;</td>

                                        <td>&nbsp;</td>



                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            } else {
                                echo"<div class=\"alert alert-warning fade in\">"; //alert alert-block alert-danger fade in
                                echo 'No Data Found.';
                                echo"</div>";
                            }
                            ?>



<?php if (!empty($record)) { ?>
                                <tr>
                                    <th scope="row">&nbsp;Total</th>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><?php echo $total_request_sum; ?></td>

                                    <td><?php echo $total_status_pending_sum; ?></td>
                                    <td><?php echo $total_status_approve_sum; ?></td>
                                    <td><?php echo $total_status_cancel_sum; ?></td>


                                    <td><?php echo $total_support_1; ?></td>
                                    <td><?php echo $total_support_2; ?></td>
                                    <td><?php echo $total_support_3; ?></td>
                                    <td><?php echo $total_support_4; ?></td>

                                    <td><?php echo $total_priority_1; ?></td>
                                    <td><?php echo $total_priority_2; ?></td>
                                    <td><?php echo $total_priority_3; ?></td>
                                    <td><?php echo $total_priority_4; ?></td>

                                    <td>SUM&nbsp;</td>



                                </tr>

<?php } ?>
                        </tbody>

                    </table>


                    <div class="dataTables_paginate paging_bootstrap pagination" >
                        <ul>
<?php echo $links; ?>
                        </ul>
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