<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                Manufacture
            </header>
            <div class="panel-body">

                <div class="edit-data"></div>

                <form class="form-horizontal mrForm">
                    <div class="form-group">
                        <div class="form-group required">
                            <label class="control-label col-lg-2" for="mrName">Manufacture Name :</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="mrName" id="mrName"
                                       placeholder="Enter Manufacture Name">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label col-lg-2" for="mrSt">Status :</label>
                            <div class="col-lg-6">
                                <select class="form-control" id="mrSt" name="mrSt">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="button" onclick="trv.manufacture.create_manufacture()" class="btn btn-success">Submit
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