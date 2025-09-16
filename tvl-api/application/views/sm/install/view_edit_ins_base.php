<style>
    .form-group.required .control-label:after {
        color: #d00;
        content: "*";
        position: absolute;
        margin-left: 8px;
        top: 7px;
    }

    .bot-border {
        border-bottom: 1px #f8f8f8 solid;
        margin: 5px 0 5px 0
    }

    .contact-title {
        color: #8B0000;
    }
</style>


<div class="row">
    <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Install Base Edit
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:void(0)"></a>
                    <a class="fa fa-cog" href="javascript:void(0)"></a>
                </span>
            </header>
            <div class="panel-body">
                <div class="position-centercxvcx">
                    <div class="form">
                        <form class="form-horizontal" id="insForm">
                            <input type="hidden" name="hidden_id" value="<?= $install->insb_id; ?>">
                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="customer">Client/Customer Name</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="customer" name="customer"
                                            onchange="trv.install_base.customer_info(this)">
                                        <option value="">select</option>
                                        <?php foreach ($customer as $c): ?>
                                            <option <?php if ($install->insb_customer == $c->customer_id) {
                                                echo 'selected';
                                            } ?> value="<?= $c->customer_id; ?>"><?= $c->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="bArea">Business Area</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="bArea" name="bArea">
                                        <option value="">select</option>
                                        <?php foreach ($business as $b): ?>
                                            <option <?php if ($install->insb_business_area == $b->bu_id) {
                                                echo 'selected';
                                            } ?> value="<?= $b->bu_id; ?>"><?= $b->bu_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="sector">Sector</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="sector" name="sector">
                                        <option value="">select</option>
                                        <option <?php if ($install->insb_sector == 'govt') {
                                            echo 'selected';
                                        } ?> value="govt">Govt
                                        </option>
                                        <option <?php if ($install->insb_sector == 'private') {
                                            echo 'selected';
                                        } ?> value="private">Private
                                        </option>
                                        <option <?php if ($install->insb_sector == 'corporate') {
                                            echo 'selected';
                                        } ?> value="corporate">Corporate
                                        </option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="mc">Equipment/Item Sold</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="mc" name="machine"
                                            onchange="trv.install_base.machine_info(this)">
                                        <option value="">select</option>
                                        <?php foreach ($machine as $m): ?>
                                            <option <?php if ($install->insb_machine == $m->mc_id) {
                                                echo 'selected';
                                            } ?> value="<?= $m->mc_id; ?>"><?= $m->mc_name . ' (Model: ' . $m->mc_model . ')'; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="mcSrial">Serial No.(S/N)</label>
                                <div class="col-lg-8">
                                    <input type="text" name="mcSrial" id="mcSrial"
                                           placeholder="Enter Serial number" class="form-control"
                                           value="<?= $install->insb_serial; ?>">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="version">Version</label>
                                <div class="col-lg-8">
                                    <input type="text" name="version" id="version"
                                           placeholder="Enter version" class="form-control"
                                           value="<?= $install->insb_version; ?>">
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="support">Support Type</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="support" name="supp_type">
                                        <option value="">select</option>
                                        <?php foreach ($support as $sup): ?>
                                            <option <?php if ($su_type->su_type_id == $sup->service_type_id) {
                                                echo 'selected';
                                            } ?> value="<?= $sup->service_type_id; ?>"><?= $sup->service_type_title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <?php if ($su_type->su_type_id == 1 || $su_type->su_type_id == 2): ?>
                                <div id="amc">
                                    <div class="form-group required supp-date">
                                        <label class="col-lg-3 control-label" for="st">Support type Date</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="support_start" id="st"
                                                   placeholder="Star Date" class="form-control"
                                                   value="<?= format_change($su_type->su_start_date); ?>">
                                            <span class="help-block"></span>
                                        </div>

                                        <div class="col-lg-4">
                                            <input type="text" name="support_end" id="stn"
                                                   placeholder="End Date" class="form-control"
                                                   value="<?= format_change($su_type->su_end_date); ?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>


                                    <div class="form-group required supp-date">
                                        <label class="col-lg-3 control-label" for="supp_cyle">Support Cycle</label>
                                        <div class="col-lg-8">
                                            <?php
                                            $id_priority_array = 'id ="supp_cyle" class="form-control"';
                                            echo form_dropdown('supp_cycle', support_cycle(), set_value('supp_cycle', $su_type->su_cycle), $id_priority_array);
                                            ?>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="wcn">Work order/ contract number</label>
                                <div class="col-lg-8">
                                    <input type="text" name="workCn" id="wcn"
                                           value="<?= $install->insb_work_order_contact; ?>"
                                           placeholder="Enter Work order/ contract number" class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="woDate">Work order Date</label>
                                <div class="col-lg-8">
                                    <input type="text" name="woDate" id="woDate" placeholder="Enter Work order Date"
                                           class="form-control woDate" value="<?= $install->insb_work_order_date; ?>">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="insBy"> Installed By</label>
                                <div class="col-lg-8">
                                    <input type="text" name="insBy" id="insBy" placeholder="Enter Installed By"
                                           class="form-control" value="<?= $install->insb_install_by; ?>">
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="insDate">Date of Installation</label>
                                <div class="col-lg-8">
                                    <input type="text" name="insDate" id="insDate"
                                           value="<?= $install->insb_install_date; ?>"
                                           placeholder="Enter Installation Date" class="form-control insDate">
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="wExpire"> Warranty Expire on</label>
                                <div class="col-lg-8">
                                    <input type="text" name="wExpire" id="wExpire"
                                           value="<?= $install->insb_warranty_date; ?>"
                                           placeholder="Enter Warranty Expire date" class="form-control wExpire">
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Special Note: </label>
                                <div class="col-lg-8">
                                        <textarea class="form-control" name="spNote" rows="5" id="comment"
                                                  placeholder="Type spacial note"><?= $install->insb_special_note; ?></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <?php if (!empty($user_tr)): ?>
                                <div class="userTr">
                                    <?php
                                    $field = 0;

                                    foreach ($user_tr as $user):
                                        ?>
                                        <div id="field" class="div-remove">
                                            <div id="field<?php echo $field ?>" class="remove_<?= $user->user_id; ?>">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label" for="uTrain">User Training
                                                        Details: </label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="uName[]" id="uName"
                                                               placeholder="Enter Name" class="form-control" value="<?= $user->user_name; ?>">
                                                        <span class="help-block"></span>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <input type="text" name="uDes[]" id="uDes"
                                                               placeholder="Enter Designation" class="form-control" value="<?= $user->user_designation; ?>">
                                                        <span class="help-block"></span>
                                                    </div>

                                                    <label class="col-lg-3" for="uTrain"> </label>
                                                    <!--<div class="col-lg-4">
                                                        <input type="file" name="utc[]" id="utc" class="form-control">
                                                        <span class="help-block"></span>
                                                    </div>-->
                                                    <div class="col-lg-4">
                                                        <input type="text" name="uCell[]" id="uCell"
                                                               placeholder="Enter Cel Number" class="form-control" value="<?= $user->user_cell_number; ?>"
                                                               maxlength="11">
                                                        <span class="help-block"></span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($field == 0): ?>
                                        <div class="form-group">
                                            <div class="col-md-11">
                                                <div class="pull-right">
                                                    <span id="remove"></span>
                                                    <button id="add-more" type="button" class="btn btn-primary btn-sm ">
                                                        Add
                                                        More
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php elseif ($field !=0): ?>

                                        <div class="form-group">
                                            <div class="col-md-11">
                                                <div class="pull-right">
                                                    <button type="button" id="btnremove_<?= $user->user_id; ?>" onclick="revome_field('<?= $user->user_id; ?>')"  class="btn btn-danger edit-remove" >Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <?php $field++; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label class="col-lg-3 control-label"for="insReport">Installation Report : </label>
                                <div class="col-lg-8">
                                    <input type="file" name="insReport" id="insReport" class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="accepCer">Acceptance Certificate:</label>
                                <div class="col-lg-8">
                                    <input type="file" name="accepCer" id="accepCer" class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <br>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9">
                                    <button type="button" onclick="trv.install_base.update()" class="btn btn-success"
                                            id="btnSave">Update
                                    </button>
                                </div>
                            </div>

                            <div class="text-center res"></div>

                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>


    <div class="col-lg-4">
        <section class="panel">
            <header class="panel-heading">
                Install Base Info
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:void(0)"></a>
                    <a class="fa fa-cog" href="javascript:void(0)"></a>
                </span>
            </header>
            <div class="panel-body">
                <div class="position-centercxvcx">


                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h5>Client/Customer Info</h5></div>
                                <div class="panel-body">

                                    <div class="box box-info">

                                        <div class="box-body">

                                            <div class="col-lg-5 col-xs-6 ">Client Name:</div>
                                            <div class="col-lg-7 col-xs-6 cl-name"><?= $cust->name; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Mobile No:</div>
                                            <div class="col-lg-7 col-xs-6 mob"><?= $cust->mobile; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Flat/House No. :</div>
                                            <div class="col-lg-7 flat"><?= $cust->cust_flat; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Road/Sector :</div>
                                            <div class="col-lg-7 roads"><?= $cust->cust_road; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">P.O :</div>
                                            <div class="col-lg-7 post"><?= $cust->cust_post; ?></div>

                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">P.S :</div>
                                            <div class="col-lg-7 police"><?= $cust->THANA_NAME; ?></div>

                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Dist:</div>
                                            <div class="col-lg-7 dist"><?= $cust->DISTRICT_NAME; ?></div>

                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <br>
                                            <div class="col-sm-12 col-xs-12 contact-title ">Client/Customer Contact
                                                Person :
                                            </div>

                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>


                                            <div class="col-lg-5 col-xs-6 tital ">Name:</div>
                                            <div class="col-lg-7 col-xs-6 ctName "><?= $cust->contact_person_name; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Designation:</div>
                                            <div class="col-lg-7 ctDes"><?= $cust->contact_person_desig; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Email:</div>
                                            <div class="col-lg-7 ctEmail"><?= $cust->contact_person_email; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Mobile:</div>
                                            <div class="col-lg-7 ctMob"><?= $cust->contact_person_phone; ?></div>

                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h6>Equipment/Item Information</h6></div>
                                <div class="panel-body">

                                    <div class="box box-info">

                                        <div class="box-body">

                                            <div class="col-lg-5 col-xs-6 tital ">Item Name :</div>
                                            <div class="col-lg-7 col-xs-6 mc_name "><?= $equipment->mc_name; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Model :</div>
                                            <div class="col-lg-7 col-xs-6 model "><?= $equipment->mc_model; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Manufacturer :</div>
                                            <div class="col-lg-7 manufac"><?= $equipment->mf_name; ?> </div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Particular :</div>
                                            <div class="col-lg-7 particular"><?= $equipment->mc_particular; ?></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <!--<div class="col-lg-5 col-xs-6 tital ">Version :</div>
                                            <div class="col-lg-7 version"></div>-->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </section>

    </div>
</div>


<!-- Main Content Wrapper -->


<script>

    $('.woDate').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });

    $('.insDate').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });

    $('.wExpire').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });

    $('#st').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });

    $('#stn').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });


    $("#support").change(function () {
        var selected_option = $('#support').val();

        if (selected_option === '1' || selected_option === '2') {
            $('#amc').show();
        } else {
            $('#amc').hide();
        }
    });


    $(document).ready(function () {
        //@naresh action dynamic childs


        var next = 0;
        $("#add-more").click(function () {

            var addto = "#field" + next;
            var addRemove = "#field" + (next);
            next = next + 1;
            var newIn = ' <div id="field' + next + '" name="field' + next + '">' +
                '<div class="form-group"> ' +
                '<label class="col-lg-3 control-label" for="uTrain">User Training Details </label> ' +
                '<div class="col-lg-4"> <input id="uName" name="uName[]" type="text" placeholder="Enter Name" class="form-control"> </div>' +
                '<div class="col-lg-4"> <input id="desig" name="uDes[]" type="text" placeholder="Enter Designation" class="form-control"> <span class="help-block"></span></div> ' +
                '<label class="col-lg-3" for="uTrain"> </label>' +
                //'<div class="col-lg-4"> <input type="file" name="utc[]" id="utc" class="form-control"><span class="help-block"></span></div>' +
                '<div class="col-lg-4"> <input type="text" name="uCell[]" id="uCell" placeholder="Enter Cell Number" maxlength="11"  class="form-control"><span class="help-block"></span></div>' +
                '</div>';

            var newInput = $(newIn);
            var removeBtn = '<div class="form-group"><div class="col-md-11"><div class="pull-right"><button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >Remove</button></div></div></div><div id="field">';
            var removeButton = $(removeBtn);
            $(addto).after(newInput);
            $(addRemove).after(removeButton);
            $("#field" + next).attr('data-source', $(addto).attr('data-source'));
            $("#count").val(next);

            $('.remove-me').click(function (e) {
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length - 1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
        });


    });


    function revome_field(id) {

            $('.remove_'+id).remove();
            $('#btnremove_'+id).remove();
    }

</script>
