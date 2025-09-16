<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                Equipment/Item Sold
            </header>
            <div class="panel-body">

                <form class="form-horizontal editForm">
                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="type">Type:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="type" id="type" required>
                                <option <?=(isset($template) && $template->type == 'sms') ? 'selected' : '';?> value="sms">SMS</option>
                                <option <?=(isset($template) && $template->type == 'email') ? 'selected' : '';?> value="email">Email</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="slap">Slap</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="slap" value="<?=(isset($template)) ? $template->slap : '';?>" name="slap" placeholder="Enter slap name" required />
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="message">Manufacture :</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="message" id="message" required><?=(isset($template)) ? $template->message : '';?></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="status">Status</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="status" id="status" required>
                                <option <?=(isset($template) && $template->status == '1') ? 'selected' : '';?> value="1">Active</option>
                                <option <?=(isset($template) && $template->status == '0') ? 'selected' : '';?> value="0">Inactive</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success" onclick="trv.temp.update_template()">
                                Update
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



