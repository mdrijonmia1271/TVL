<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                Spare Parts
            </header>
            <div class="panel-body">
                <form class="form-horizontal eqEdit">
                    <input type="hidden" name="update_id" value="<?= $parts->sp_id; ?>">


                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="itname">Spare Parts Name :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="eqName" id="itname"
                                   value="<?= $parts->sp_name; ?>">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="pwd">P/N :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="pwd" name="Pcode"
                                   value="<?= $parts->sp_code; ?>">
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
                                        <option <?php if ($parts->sp_mnf == $m->mf_id){echo 'selected'; } ?> value="<?= $m->mf_id; ?>"><?= $m->mf_name; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" onclick="trv.spare.update_spare()" class="btn btn-success">Update
                            </button>
                            <button type="button" onclick="trv.spare.reload_table()" class="btn btn-danger">Close
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
    $(document).ready(function() {

        $("input").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("textarea").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

    });
</script>