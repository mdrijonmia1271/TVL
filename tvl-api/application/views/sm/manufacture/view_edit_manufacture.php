<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                Manufacture
            </header>
            <div class="panel-body">

                <div class="edit-data"></div>

                <form class="form-horizontal mrFormEdit">
                    <input type="hidden" name="mf_id" value="<?= $edit->mf_id; ?>">
                    <div class="form-group">
                        <div class="form-group required">
                            <label class="control-label col-lg-2" for="mrName">Manufacture Name :</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="mrName" id="mrName"
                                       placeholder="Enter Manufacture Name" value="<?= $edit->mf_name; ?>">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label col-lg-2" for="mrSt">Status :</label>
                            <div class="col-lg-6">
                                <select class="form-control" id="mrSt" name="mrSt">
                                    <option <?php if ($edit->mf_status == 1) echo 'selected'; ?> value="1">Active</option>
                                    <option <?php if ($edit->mf_status == 0) echo 'selected'; ?> value="0">Inactive</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="button" onclick="trv.manufacture.update_manufacture()" class="btn btn-success">Update
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

    });
</script>