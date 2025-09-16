<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Super Admin Customer List
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                    <a class="fa fa-cog" href="javascript:;"></a>
                    <!--<a class="fa fa-times" href="javascript:;"></a>-->
                </span>
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <div class="form">

                        <?php
                        if ($this->session->flashdata('flashOK')) {
                            echo"<div class=\"alert alert-success fade in\">";
                            echo $this->session->flashdata('flashOK');
                            echo"</div>";
                        }
                        ?>                             

                        <form  class = "cmxform form-horizontal"  enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/superadmin/update_superadmin'; ?>">
                            <?php echo form_hidden(array('hidden_superadmin_id' => $edit->id));?> 
                            <div class="form-group">
                                <label for="Superadmin name" class="control-label col-lg-3">Super admin Name<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $superadmin_name_arry = array(
                                        'name' => 'superadmin_name',
                                        'id' => 'superadmin_name',
                                        'class' => "form-control",
                                        'placeholder' => 'Enter Super admin Name',
                                         'value' => $edit->superadmin_name,
                                    );

                                    echo form_input($superadmin_name_arry);
                                    ?>


                                    <span class="error"><?php echo form_error('superadmin_name'); /* print valitation error */ ?></span>
                                </div>
                            </div>

                              <div class="form-group">
                                <label for="customer" class="control-label col-lg-3">Customer<span style="color:red">&nbsp;*</span></label>
                                <div class="col-lg-6">
        
                                   <?php 
                                $customer_array =   get_customer_array_dropdown();
                                print_r($customer_array);
                                foreach ($customer_array as $key => $value) {?>
                                         <input type="checkbox" name="vehicle" value="Bike"> I have a bike<br>     
                              
                              <?php  }
                                   ?> 
                                    
                                 <!--<input type="checkbox" name="vehicle" value="Bike"> I have a bike<br>-->     
                                </div>


                            </div>

                            <div class="col-lg-offset-3 col-lg-6">
                                <button type="submit" class="btn btn-info">Update</button>                     
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </section>


    </div>
</div>

<div class="row">
    <div class="col-sm-12">

        <section class="panel">
            <header class="panel-heading">
                Customer List <?php //echo $total_rows;  ?>
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <!--<a href="javascript:;" class="fa fa-times"></a>-->
                </span>
            </header>
            <div class="panel-body">
                <section id="no-more-tables">


                    <?php if (!empty($record)) { ?>                        

                        <table class="table table-bordered table-striped table-condensed cf">
                            <thead class="cf">
                                <tr>
                                    <th>Customer Name</th>

                                    <th class="numeric">Status</th>
                                    <th class="numeric">Date Time</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($record as $key => $value) {
                                    ?> 
                                    <tr>
                                        <td data-title="Customer Name">
                                            <?php echo $value->superadmin_name; ?>
                                        </td>

                                        <?php if ($value->status == 'A') { ?>
                                            <td class="">Active</td>
                                        <?php } else { ?>
                                            <td class="">In Active</td>
                                        <?php } ?>
                                        <td data-title="Date"><?php echo $value->created_date_time; ?></td>                

                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>

                        <?php
                    }
                    ?>                           
                </section>
            </div>
        </section>
    </div>
</div>

<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>
