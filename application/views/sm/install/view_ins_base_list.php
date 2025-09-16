<?php $this->load->view('sm/home/view_header'); ?>

<div id="insb-detail"></div>
<div class="row" id="insb-list">
    <div class="col-lg-12">
        <div class="add-edit"></div>
        <div class="panel install">
            <header class="panel-heading">
                Install Base Info
            </header>
            <div class="panel-body">
                <div class="position-centercxvcx">

                    <form role="form" class="form-horizontal searchForm" method="post"
                          action="<?php echo base_url() ?>sm/install_base/ins_list">

                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="row">
                                    <label for="engineer" class="control-label col-lg-2">Sr. Eng.</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" id="engineer" name="engineer">
                                            <option value="">select</option>
                                            <?php if (!empty($engineer)): ?>
                                                <?php foreach ($engineer as $eng): ?>
                                                    <option value="<?= $eng->ser_eng_id; ?>"><?= $eng->name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <label for="customer" class="control-label col-lg-1">Customer</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" id="customer" name="customer">
                                            <option value="">select</option>
                                            <?php if (!empty($customer)): ?>
                                                <?php foreach ($customer as $c): ?>
                                                    <option value="<?= $c->customer_id; ?>"><?= $c->name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>


                                    <label for="department" class="control-label col-lg-1">Department</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" id="department" name="department">
                                            <option value="">select</option>
                                            <?php if (!empty($department)): ?>
                                                <?php foreach ($department as $d): ?>
                                                    <option value="<?= $d->id; ?>"><?= $d->name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <label for="mc" class="control-label col-lg-2">Equipment/Item</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" id="mc" name="machine" onchange="getComboA(this)">
                                            <option value="">select</option>
                                            <?php if (!empty($machine)): ?>
                                                <?php foreach ($machine as $m): ?>
                                                    <option value="<?= $m->mc_name; ?>"><?= $m->mc_name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>


                                    <label for="model" class="control-label col-lg-1">Model</label>
                                    <div class="col-lg-2">
                                        <select id="model" class="form-control" name="model">
                                            <option value="">select</option>

                                        </select>
                                    </div>


                                    <label for="customer" class="control-label col-lg-1">Support Type</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" id="inputSuccess" name="support_type">
                                            <option value="">select</option>
                                            <?php if (!empty($support)): ?>
                                                <?php foreach ($support as $sup): ?>
                                                    <option value="<?= $sup->service_type_id; ?>"><?= $sup->service_type_title; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <label class="col-lg-2 control-label" for="serial">Serial</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" id="serial" name="serial">
                                            <option value="">select</option>
                                            <?php if (!empty($serial)): ?>
                                                <?php foreach ($serial as $sup): ?>
                                                    <option value="<?= $sup->insb_serial; ?>"><?= $sup->insb_serial; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <label class="col-lg-1 control-label" for="sector">Sector</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" id="sector" name="sector">
                                            <option value="">select</option>
                                            <option value="govt">Govt</option>
                                            <option value="private">Private</option>
                                            <option value="corporate">Corporate</option>
                                        </select>
                                    </div>

                                    <label for="bArea" class="control-label col-lg-1">Business Area</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" id="bArea" name="bArea">
                                            <option value="">select</option>
                                            <?php if (!empty($business)): ?>
                                                <?php foreach ($business as $ba): ?>
                                                    <option value="<?= $ba->bu_id; ?>"><?= $ba->bu_name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <label for="start" class="control-label col-lg-2">Start Date</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" id="start" name="stdate">
                                    </div>

                                    <label for="end" class="control-label col-lg-2">End Date</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" id="end" name="endate">
                                    </div>

                                    <br><br><br>
                                    <div class="col-lg-offset-1 col-lg-3">
                                        <button class="btn btn-success" type="submit" id="btn_customer_ticketsearch">
                                            Search
                                        </button>
                                    </div
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $se_eng_login_id = $this->session->userdata('admin_user_type');

?>
<div class="col-lg-12">
    <div class="panel">
        <header class="panel-heading">
            Install Base List <span class="badge"><?= $total_rows; ?></span>
            <button class="btn btn-inverse btn-xs pull-right" onclick="trv.exl('tblData','install_base')"><i
                        class="glyphicon glyphicon-print"></i> Excel Export
            </button>
        </header>

        <div class="panel-body">
            <div class="position">
                <div id="search-list"></div>

                <?php if (!empty($install)): ?>

                    <table class="table table-bordered install-data">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Client/Customer</th>
                            <th>Department</th>
                            <th>Equipment/Item</th>
                            <th>Support Type</th>
                            <th>PMI Schedule</th>
                            <th>Work order Date</th>
                            <th>Date of Installation</th>
                            <th>Warranty Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($install as $k => $in):

                            $start_date = $in->su_start_date;
                            $end_date = $in->su_end_date;

                            $now = date('Y-m-d');

                            $sl = $this->uri->segment(4) + $k + 1;

                            ?>
                            <tr>
                                <td><?= $sl; ?></td>
                                <td><?= $in->customer; ?></td>
                                <td><?= $in->department; ?></td>
                                <td><?= $in->mc_name . ' (Model-' . $in->mc_model . ')'; ?></td>
                                <td><?= $in->service_type_title; ?></td>
                                <td><span class="label label-danger" style="font-size: 13px"><?= pmi_schedule_date($in->insb_id); ?></span></td>
                                <td><?= format_change($in->insb_work_order_date); ?></td>
                                <td><?= format_change($in->insb_install_date); ?></td>
                                <td><?= format_change($in->insb_warranty_date); ?></td>
                                <td>

                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm"
                                       onclick="trv.install_base.view_install('<?= $in->insb_id;
                                       ?>')">View</a>
                                    <?php if (!empty($se_eng_login_id) && $se_eng_login_id == "sm"): ?>
                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm"
                                           onclick="trv.install_base.edit_ins('<?= $in->insb_id;
                                           ?>')">Edit</a>

                                    <?php endif; ?>

                                    <?php if ($now >= $start_date && $now >= $end_date && !empty($se_eng_login_id) && $se_eng_login_id == "sm"): ?>
                                        <a href="javascript:void(0)" class="btn btn-success btn-sm"
                                           onclick="trv.install_base.renew('<?= $in->insb_id; ?>')">Renew</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>


                    <table class="table table-bordered install-data" id="tblData" border="2"  style="display: none;">
                        <thead>
                        <tr>
                            <th></th>
                            <th rowspan="2" class="bordercell">Client/Customer</th>
                            <th rowspan="2">Equipment/Item</th>
                            <th colspan="3">Support Type</th>
                            <th>Work order Date</th>
                            <th colspan="2">Installation And Warranty Date</th>

                        </tr>

                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th></th>
                            <th>Install</th>
                            <th>Warranty</th>
                        </tr>
                        </thead>

                        <tbody>


                        <?php foreach ($install_export as $sl => $in): ?>
                            <tr>
                                <td><?= (++$sl); ?></td>
                                <td><?= $in->customer; ?></td>
                                <td><?= $in->mc_name; ?></td>
                                <td><?= $in->service_type_title; ?></td>
                                <td><?= string_date($in->su_start_date); ?></td>
                                <td><?= string_date($in->su_end_date); ?></td>
                                <td><?= string_date($in->insb_work_order_date); ?></td>
                                <td><?= string_date($in->insb_install_date); ?></td>
                                <td><?= string_date($in->insb_warranty_date); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>


                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <?php echo $links; ?>
                        </ul>
                    </div>
                <?php endif; ?>


            </div>
        </div>
    </div>
</div>
</div>


<?php
$this->load->view('sm/home/view_footer');
?>

<script>
    $('#start').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });
    $('#end').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });


    function getComboA(selectObject) {
        var value = selectObject.value;

        $.ajax({

            url: BASE_URI + "sm/install_base/get_model",
            type: "POST",
            data: {'equ':value},
            dataType: "json",
            success: function (data) {
                var option = "<option value=''>select</option>";
                for (var i=0; i< data.length; i++) {
                   option += "<option value='" + data[i].mc_model + "'>" + data[i].mc_model + "</option>";
                }
                $('#model').html(option);
            }

        });
    }


</script>
