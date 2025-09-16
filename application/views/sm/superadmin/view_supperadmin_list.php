       <header class="panel-heading">
          User List
            </header>
            <div class="panel-body">
                <section id="no-more-tables">


                    <?php if (!empty($record)) { ?>

                        <table class="table table-bordered table-striped table-condensed cf">
                            <thead class="cf">
                                <tr>
                                    <th>Name</th>
                                    <th>Login ID</th>
                                    <th>User Type</th>
                                    <th class="numeric">Status</th>
                                    <th class="numeric">Date Time</th>
                                    <th class="numeric">Action</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($record as $key => $value) {
                                    ?>
                                    <tr>
                                        <td data-title="Super Admin Name">
                                            <?php echo $value->superadmin_name; ?>
                                        </td>
                                        <td data-title="Super Admin Name">
                                            <?php echo $value->username; ?>
                                        </td>

                                        <td data-title="Super Admin Name">
                                            <?php if ($value->user_type =='spa'){
                                                echo 'Super Admin';
                                            }
                                            elseif($value->user_type =='sm'){
                                                echo 'Service Dept. Manager';
                                            }
                                            elseif ($value->user_type =='hd'){
                                                echo 'Help Desk';
                                            }  ?>
                                        </td>

                                        <?php if ($value->status == 'A') { ?>
                                            <td class="">Active</td>
                                        <?php } else { ?>
                                            <td class="">In Active</td>
                                        <?php } ?>
                                        <td data-title="Date"><?php echo $value->created_date_time; ?></td>


                                        <td>
                                            <?php if($value->root_admin == "no"){ ?>
                                            <p><a href="<?php echo base_url(); ?>sm/superadmin/edit_superadmin/<?php echo $value->id; ?>" class="label label-success label-mini">
                                                    <i class="icol-pencil"></i>Edit
                                                </a>
                                            </p>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>

                        <?php
                    }
                    ?>
                </section>
            </div>
