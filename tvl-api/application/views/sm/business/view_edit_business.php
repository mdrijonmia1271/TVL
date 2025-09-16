<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <header class="panel-heading">
                Business Area
            </header>
            <div class="panel-body">
                <form class="form-horizontal eqEdit">
                    <input type="hidden" name="update_id" value="<?= $business->bu_id; ?>">

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="buArea">Business Area :</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="buArea" name="buArea"
                                   value="<?= $business->bu_name; ?>">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="bust">Status :</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="bust" id="bust">
                                <option <?php if ($business->bu_status == 0){ echo 'selected'; } ?> value="0">Active</option>
                                <option <?php if ($business->bu_status == 1){ echo 'selected'; } ?> value="1">In-Active</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" onclick="trv.business.business_update()" class="btn btn-success">Update
                            </button>
                            <button type="button" onclick="trv.business.reload_table()" class="btn btn-danger">Close
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