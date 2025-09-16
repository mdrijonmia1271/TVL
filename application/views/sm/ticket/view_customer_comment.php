<div class="col-lg-12">
    <div class="panel">
        <header class="panel-heading">
            Comment
        </header>
        <div class="panel-body">
            <div class="col-lg-offset-1 col-lg-8">
                <form class="form-horizontal" id="cuForm">

                    <input type="hidden" name="ticket_id" value="<?= $ticket; ?>">

                    <div class="form-group required">
                        <label class="control-label col-lg-3" for="comment">Comment on Eng.</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="comment" rows="5" id="comment" placeholder="Comment on Engineer"></textarea>
                         <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3" for="sel1">Rating on Eng.</label>
                        <div class="col-lg-9">
                            <select class="form-control" id="sel1" name="rating">
                                <option value="">Select</option>
                                <option value="1">1 star</option>
                                <option value="2">2 star</option>
                                <option value="3">3 star</option>
                                <option value="4">4 star</option>
                                <option value="5">5 star</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-9">
                            <button type="button" onclick="trv.customer.comments_save()" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="text-center res"></div>
            </div>
        </div>
    </div>
</div>


<script>
    //===========================================
    $(document).ready(function () {

        $("textarea").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

    });
</script>