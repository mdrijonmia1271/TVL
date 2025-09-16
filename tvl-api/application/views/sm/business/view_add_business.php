<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                Business Area
            </header>
            <div class="panel-body">

                <div class="edit-data"></div>

                <form class="form-horizontal eqForm">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="buArea">Business Area :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="buArea" name="buArea"
                                   placeholder="Enter Business Area Information">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="bust">Status :</label>
                        <div class="col-sm-6">

                            <select class="form-control" name="bust" id="bust">
                                <option value="0">Active</option>
                                <option value="1">In-Active</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" onclick="trv.business.business_save()" class="btn btn-success">Submit
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