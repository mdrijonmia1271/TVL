<?php $this->load->view('sm/home/view_header'); ?>

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
                Install Base Info
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:void(0)"></a>
                    <a class="fa fa-cog" href="javascript:void(0)"></a>
                </span>
            </header>
            <div class="panel-body">
                <div class="position-centercxvcx">
                    <div class="form">
                        <form class="form-horizontal" id="insForm">

                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="sel1">Client/Customer Name</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="sel1" name="customer"
                                            onchange="trv.install_base.customer_info(this)">
                                        <option value="">select</option>
                                        <?php foreach ($customer as $c): ?>
                                            <option value="<?= $c->customer_id; ?>"><?= $c->name; ?></option>
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
                                            <option value="<?= $b->bu_id; ?>"><?= $b->bu_name; ?></option>
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
                                        <option value="govt">Govt</option>
                                        <option value="private">Private</option>
                                        <option value="corporate">Corporate</option>
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
                                            <option value="<?= $m->mc_id; ?>"><?= $m->mc_name.' (Model: '.$m->mc_model.')'; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="mcSrial">Serial No.(S/N)</label>
                                <div class="col-lg-8">
                                    <input type="text" name="mcSrial" id="mcSrial"
                                           placeholder="Enter Serial number" class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="version">Version</label>
                                <div class="col-lg-8">
                                    <input type="text" name="version" id="version"
                                           placeholder="Enter version" class="form-control">
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="support">Support Type</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="support" name="supp_type">
                                        <option value="">select</option>
                                        <?php foreach ($support as $sup): ?>
                                            <option value="<?= $sup->service_type_id; ?>"><?= $sup->service_type_title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group required supp-date" hidden="hidden">
                                <label class="col-lg-3 control-label" for="st">Support type Date</label>
                                <div class="col-lg-4">
                                    <input type="text" name="support_start" id="st"
                                           placeholder="Star Date" class="form-control">
                                    <span class="help-block"></span>
                                </div>

                                <div class="col-lg-4">
                                    <input type="text" name="support_end" id="stn"
                                           placeholder="End Date" class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group required supp-date" hidden="hidden">
                                <label class="col-lg-3 control-label" for="supp_cyle">Support Cycle</label>
                                <div class="col-lg-8">
                                    <?php
                                    $id_priority_array = 'id ="supp_cyle" class="form-control"';
                                    echo form_dropdown('supp_cycle', support_cycle(), set_value('supp_cycle'), $id_priority_array);
                                    ?>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="wcn">Work order/ contract number</label>
                                <div class="col-lg-8">
                                    <input type="text" name="workCn" id="wcn"
                                           placeholder="Enter Work order/ contract number" class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="woDate">Work order Date</label>
                                <div class="col-lg-8">
                                    <input type="text" name="woDate" id="woDate" placeholder="Enter Work order Date"
                                           class="form-control woDate">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="insBy"> Installed By</label>
                                <div class="col-lg-8">
                                    <input type="text" name="insBy" id="insBy" placeholder="Enter Installed By"
                                           class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="insDate">Date of Installation</label>
                                <div class="col-lg-8">
                                    <input type="text" name="insDate" id="insDate"
                                           placeholder="Enter Installation Date" class="form-control insDate">
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group required">
                                <label class="col-lg-3 control-label" for="wExpire"> Warranty Expire on</label>
                                <div class="col-lg-8">
                                    <input type="text" name="wExpire" id="wExpire"
                                           placeholder="Enter Warranty Expire date" class="form-control wExpire">
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="comment">Special Note: </label>
                                <div class="col-lg-8">
                                        <textarea class="form-control" name="spNote" rows="5" id="comment"
                                                  placeholder="Type spacial note"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="userTr">

                                <div id="field">
                                    <div id="field0">

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label" for="uTrain">User Training Details: </label>


                                            <div class="col-lg-4">
                                                <input type="text" name="uName[]" id="uName"
                                                       placeholder="Enter Name" class="form-control">
                                                <span class="help-block"></span>
                                            </div>

                                            <div class="col-lg-4">
                                                <input type="text" name="uDes[]" id="uDes"
                                                       placeholder="Enter Designation" class="form-control">
                                                <span class="help-block"></span>
                                            </div>

                                            <label class="col-lg-3" for="uTrain"> </label>
                                            <!--<div class="col-lg-4">
                                                <input type="file" name="utc[]" id="utc" class="form-control">
                                                <span class="help-block"></span>
                                            </div>-->
                                            <div class="col-lg-4">
                                                <input type="text" name="uCell[]" id="uCell"
                                                       placeholder="Enter Cel Number" class="form-control" maxlength="11">
                                                <span class="help-block"></span>

                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-11">
                                        <div class="pull-right">
                                            <span id="remove"></span>
                                            <button id="add-more" type="button"  class="btn btn-primary btn-sm ">Add More</button>
                                        </div>
                                    </div>
                                </div>



                            </div>


                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="insReport">Installation Report : </label>
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
                                    <button type="button"  onclick="trv.install_base.create()" class="btn btn-success" id="btnSave">Submit</button>
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
                                            <div class="col-lg-7 col-xs-6 cl-name"></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Mobile No:</div>
                                            <div class="col-lg-7 col-xs-6 mob"></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Flat/House No. :</div>
                                            <div class="col-lg-7 flat"></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Road/Sector :</div>
                                            <div class="col-lg-7 roads"></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">P.O :</div>
                                            <div class="col-lg-7 post"></div>

                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">P.S :</div>
                                            <div class="col-lg-7 police"></div>

                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Dist:</div>
                                            <div class="col-lg-7 dist"></div>

                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <br>
                                            <div class="col-sm-12 col-xs-12 contact-title ">Client/Customer Contact
                                                Person :
                                            </div>

                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>


                                            <div class="col-lg-5 col-xs-6 tital ">Name:</div>
                                            <div class="col-lg-7 col-xs-6 ctName "></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Designation:</div>
                                            <div class="col-lg-7 ctDes"></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Email:</div>
                                            <div class="col-lg-7 ctEmail"></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Mobile:</div>
                                            <div class="col-lg-7 ctMob"></div>

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
                                            <div class="col-lg-7 col-xs-6 mc_name "></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Model :</div>
                                            <div class="col-lg-7 col-xs-6 model "></div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Manufacturer :</div>
                                            <div class="col-lg-7 manufac"> </div>
                                            <div class="clearfix"></div>
                                            <div class="bot-border"></div>

                                            <div class="col-lg-5 col-xs-6 tital ">Particular :</div>
                                            <div class="col-lg-7 particular"></div>
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
<?php
$this->load->view('sm/home/view_footer');
?>

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
            $('.supp-date').show();
        } else {
            $('.supp-date').hide();
        }
    });


    $(document).ready(function () {
        //@naresh action dynamic childs

        var next = 0;
        $("#add-more").click(function(){

            var addto = "#field" + next;
            var addRemove = "#field" + (next);
            next = next + 1;
            var newIn = ' <div id="field'+ next +'" name="field'+ next +'">' +
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
            $("#field" + next).attr('data-source',$(addto).attr('data-source'));
            $("#count").val(next);

            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
        });

    });


</script>
