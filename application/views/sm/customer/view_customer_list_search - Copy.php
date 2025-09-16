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
                    <a href="javascript:;" class="fa fa-times"></a>
                </span>
            </header>
            <div class="panel-body">
                <form role="form" class="form-horizontal bucket-form" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/customer/search'; ?>">
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
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <b>Customer List (<?php echo $total_rows; ?>)</b>
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                </span>
            </header>
            <div class="panel-body">
                <table class="table  table-hover general-table">
                    <thead>
                        <tr>

                            <th>Name</th>
                            <th>Mobile</th>                                     
                            <th>Address</th> 
							<th>Picture</th> 
                            <th>Email</th>                                     
                            <th>Divishion</th> 

                            <th>Status</th> 
                            <th colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            if (!empty($search)) {

                                foreach ($search as $key => $value) {
                                    ?>
                                <tr>

                                    <td><?php echo $value->name; ?></td>
                                    <td><?php echo $value->mobile; ?></td>                                            
                                    <td><?php echo $value->contact_add_details; ?></td>
									  <td>
                                       <?php if(!empty($value->picture)) {?>
                                       <img alt="img" width="60" height="40" src="<?php echo base_url() . 'upload/customer_image/' .$value->customer_id.'/' .$value->picture ?>"/>
                                    </td>
                                        <?php  }else{ ?>
                                             No  Picture
                                         <?php  } ?>
                                    <td><?php echo $value->email; ?></td>
                                    <td><?php echo $value->contact_add_division; ?></td>
                                    <?php if($value->status=='A'){?>
                                      <td>Active</td>
                                    <?php }else{ ?>
                                      <td>In Active</td>
                                    <?php } ?>

                                    <td>
                                        <p><a class="label label-success label-mini" href="<?php echo base_url() . 'sm/customer/edit/' . $value->customer_id; ?>"><i class="icol-pencil"></i> EDIT</a></p>

                                    </td>
                                    <td>
                                        <p><a class="label label-primary label-mini" href="<?php echo base_url() . 'sm/customer/view/' . $value->customer_id; ?>"><i class="icol-pencil"></i> VIEW</a></p>

                                    </td>

                                    <?php
                                    echo"</tr>";
                                }
                                      
                            } else {
                                echo '<tr><td colspan="10" align="center">No Data Available</td></tr>';
                            }
                            ?>

                        </tr>





                    </tbody>
                </table>
				<div class="dataTables_paginate paging_bootstrap pagination" >
				<ul>

				<?php echo $links; ?>
				
				</ul>
				</div>
            </div>
        </section>
    </div>
</div>

<!-- End Main Content Wrapper -->


<?php
$this->load->view('sm/home/view_footer');
?>    
