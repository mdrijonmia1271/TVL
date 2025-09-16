<?php
$this->load->view('sm/home/view_header');
?>



<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <header class="panel-heading">
                <b>Job Report Upload</b>
            </header>
            <div class="panel-body">
                <form role="form" class="form-horizontal" id="jobReport">
                    <input type="hidden" name="ticket_id" value="<?= $ticket_id ?>">

                    <div class="form-group">
                        <label class="control-label col-lg-2" id="label-photo">Report Upload </label>
                        <div class="col-lg-6">
                            <input class="form-control" type="file" name="report">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="button" onclick="trv.ticket.job_report_upload()" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="col-lg-offset-2 col-lg-8 res"></div>
            </div>
        </div>

    </div>
</div>


<?php
$this->load->view('sm/home/view_footer');
?>