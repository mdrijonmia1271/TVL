<div class="panel">
    <header class="panel-heading">
        Install Base Renew
    </header>
    <div class="panel-body">
        <div class="position-centercxvcx">
            <div class="form">
                <form class="form-horizontal" id="renForm">

                    <input type="hidden" name="ins_id" value="<?= $install->insb_id; ?>">
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

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="comment">Special Note: </label>
                        <div class="col-lg-8">
                                        <textarea class="form-control" name="spNote" rows="5" id="comment"
                                                  placeholder="Type spacial note"></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <br>
                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-9">
                            <button type="button" onclick="trv.install_base.renew_update()" class="btn btn-success">
                                Renew
                            </button>
                        </div>
                    </div>

                    <div class="text-center res"></div>

                </form>
            </div>
        </div>

    </div>
</div>

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
        var selected_option = $('#support :selected').val();

        if (selected_option === '1' || selected_option === '2') {
            $('.supp-date').show();
        } else {
            $('.supp-date').hide();
        }
    });


    $(document).ready(function () {

        $("input").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

        $("textarea").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

        $("select").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

    });

</script>