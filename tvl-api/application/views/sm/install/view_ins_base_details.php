<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading text-center">
                Install Base Details
            </div>
            <div class="panel-body">
                <div class="panel with-nav-tabs">
                    <div class="panel-heading tab-bg-dark-navy-blue" style="padding: 16px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1success" data-toggle="tab">Basic</a></li>
                            <li><a href="#tab2success" data-toggle="tab">Client/Customer</a></li>
                            <li><a href="#tab3success" data-toggle="tab">Equipment/Item Sold</a></li>
                            <li><a href="#tab4success" data-toggle="tab">Support</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1success">
                                <div class="col-md-12 col-lg-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Business Area</th>
                                            <th>Sector</th>
                                            <th>Installed By</th>
                                            <th>Special Note</th>
                                            <th>Work order/ contract number</th>
                                            <th>Work order Date</th>
                                            <th>Date of Installation</th>
                                            <th>Warranty Expire on</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $start_date = $install->insb_install_date;
                                        $startDate = date("d-m-Y", strtotime($start_date));

                                        $end_date = $install->insb_warranty_date;
                                        $endtDate = date("d-m-Y", strtotime($end_date));

                                        $now = date('Y-m-d');
                                        ?>

                                        <tr>
                                            <td><?= $install->bu_name; ?></td>
                                            <td>
                                                <?php if ($install->insb_sector == 'govt'): ?>
                                                    <?= 'Govt.'; ?>
                                                <?php else: ?>
                                                    <?= $install->insb_sector; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $install->insb_install_by; ?></td>
                                            <td><?= $install->insb_special_note; ?></td>
                                            <td><?= $install->insb_work_order_contact; ?></td>
                                            <td><?= format_change($install->insb_work_order_date); ?></td>

                                            <!-- install date and end date -->
                                            <?php if ($now >= $start_date && $now <= $end_date): ?>
                                                <td><?= format_change($install->insb_install_date); ?></td>
                                                <td><?= format_change($install->insb_warranty_date); ?></td>
                                            <?php else: ?>
                                                <td class="text-danger"><?= format_change($install->insb_install_date); ?></td>
                                                <td class="text-danger"><?= format_change($install->insb_warranty_date); ?></td>
                                            <?php endif; ?>



                                        </tr>
                                        </tbody>
                                    </table>


                                    <?php if (!empty($user_training)): ?>

                                        <table class="table table-bordered">
                                            <h4 class="text-center" style="color:#1c72b5">User Training Details</h4>
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Designation</th>
                                                <th>Phone</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($user_training as $ut): ?>
                                                <tr>
                                                    <td><?= $ut->user_name; ?></td>
                                                    <td><?= $ut->user_designation; ?></td>
                                                    <td><?= $ut->user_cell_number; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php endif; ?>
                                    <!--<a href="javascript:void(0)" class="btn btn-danger" onclick="trv.install_base.report_download('<?/*= $install->insb_id.','.$install->insb_report */?>')">Installation Report</a>
                                    <a href="javascript:void(0)" class="btn btn-danger">Acceptance Certificate</a>-->
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab2success">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Clint Name</th>
                                        <th>Mobile</th>
                                        <th>Telephone</th>
                                        <th>Flat/House No.</th>
                                        <th>Road/Sector</th>
                                        <th>P.O</th>
                                        <th>P.S</th>
                                        <th>District</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td><?= $customer->name; ?></td>
                                        <td><?= $customer->mobile; ?></td>
                                        <td><?= $customer->telephone_no; ?></td>
                                        <td><?= $customer->cust_flat; ?></td>
                                        <td><?= $customer->cust_road; ?></td>
                                        <td><?= $customer->cust_post; ?></td>
                                        <td><?= $customer->cust_post_code; ?></td>
                                        <td><?= $customer->DISTRICT_NAME; ?></td>
                                    </tr>
                                    </tbody>
                                </table>


                                <table class="table table-bordered">
                                    <h4 class="text-center" style="color:#1c72b5">Client/Customer Contact Person</h4>
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td><?= $customer->contact_person_name; ?></td>
                                        <td><?= $customer->contact_person_desig; ?></td>
                                        <td><?= $customer->contact_person_email; ?></td>
                                        <td><?= $customer->contact_person_phone; ?></td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="tab-pane fade" id="tab3success">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Model</th>
                                        <th>Serial No.(S/N)</th>
                                        <th>Manufacturer</th>
                                        <th>Particular</th>
                                        <th>Version</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td><?= $equipment->mc_name; ?></td>
                                        <td><?= $equipment->mc_model; ?></td>
                                        <td><?= $equipment->insb_serial; ?></td>
                                        <td><?= $equipment->mf_name; ?></td>
                                        <td><?= $equipment->mc_particular; ?></td>
                                        <td><?= $install->insb_version; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab4success">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Support Type</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Support Cycle</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $start_date = $support->su_start_date;
                                    $startDate = date("d-m-Y", strtotime($start_date));

                                    $end_date = $support->su_end_date;
                                    $endtDate = date("d-m-Y", strtotime($end_date));

                                    $now = date('Y-m-d');
                                    ?>

                                    <tr>
                                        <td><?= $support->service_type_title; ?></td>
                                        <?php if ($now >= $start_date && $now <= $end_date): ?>
                                            <td><?= format_change($support->su_start_date); ?></td>
                                            <td><?= format_change($support->su_end_date); ?></td>
                                        <?php else: ?>
                                            <td class="text-danger"><?= format_change($support->su_start_date); ?></td>
                                            <td class="text-danger"><?= format_change($support->su_end_date); ?></td>
                                        <?php endif; ?>
                                        <td><?= $support->su_cycle . ' Month'; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>