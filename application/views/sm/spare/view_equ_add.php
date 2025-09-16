<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                Spare Parts
            </header>
            <div class="panel-body">

                <div class="edit-data"></div>

                <form class="form-horizontal eqForm">
                    <div class="form-group">
                        <div class="form-group required">
                            <label class="control-label col-lg-2" for="itname">Spare Parts Name :</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="eqName" id="itname"
                                       placeholder="Enter Spare Parts Name">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group required">
                            <label class="control-label col-lg-2" for="Pcode">P/N :</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="Pcode" name="Pcode"
                                       placeholder="Enter P/N">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="control-label col-lg-2" for="mnf">Manufacturer :</label>
                            <div class="col-lg-6">
                                <select class="form-control" id="mnf" name="mnf">
                                    <option value="">Select</option>
                                    <?php if ($manufacture): ?>
                                        <?php foreach ($manufacture as $m): ?>
                                            <option value="<?= $m->mf_id; ?>"><?= $m->mf_name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>


                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="button" onclick="trv.spare.create_spare()" class="btn btn-success">Submit
                            </button>
                        </div>
                    </div>

                    <div class="col-md-offset-2 col-md-8">
                        <div class="text-center msg"></div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    //===========================================
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