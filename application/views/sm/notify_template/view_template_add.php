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
                Template Message
            </header>
            <div class="panel-body">
                <div class="edit-form"></div>
                <form class="form-horizontal mForm">
                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="type">Type:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="type" id="type" required>
                                <option selected value="">Select type</option>
                                <option value="sms">SMS</option>
                                <option value="email">Email</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="slap">Slap</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="slap" name="slap" placeholder="Enter slap name" required />
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="message">Manufacture :</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="message" id="message" required></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-sm-2" for="status">Status</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="status" id="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success" onclick="trv.temp.create_template()">
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