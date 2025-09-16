<style>
    .form-group.required .control-label:after {
        content: "*";
        color: red;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                Equipment/Item Sold
            </header>
            <div class="panel-body">
                <div class="edit-form"></div>
                <form class="form-horizontal mForm">
                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="mch">Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mch" name="mName"
                                   placeholder="Enter Name">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="md">Model:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="md" name="model"
                                   placeholder="Enter Model">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="mnf">Manufacture :</label>
                        <div class="col-sm-8">
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
                    <!--<div class="form-group">
                        <label class="control-label col-sm-2" for="mv">Version :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mv" name="mVer"
                                   placeholder="Enter Version">
                        </div>
                    </div>-->

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="mp">Particulars :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mp" name="mPart"
                                   placeholder="Enter Particulars">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="stCon">Standard Configure :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="stCon" name="stCon"
                                   placeholder="Enter Standard Configure">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success" onclick="trv.machine.create_machine()">
                                Submit
                            </button>
                        </div>
                    </div>

                    <div class="col-md-offset-2 col-md-8">
                        <div class="text-center res"></div>
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

        $("select").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

    });
</script>