<?php
$this->load->view('sm/home/view_header');
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <header class="panel-heading">
                <b>Knowledge Base</b>
            </header>
            <div class="panel-body">
                <form class="form-horizontal" id="kbForm">

                    <input type="hidden" name="ticket_id" value="<?= $ticket->srd_id; ?>">
                    <input type="hidden" name="ticket_no" value="<?= $ticket->ticket_no; ?>">

                    <div class="form-group">
                        <label class="control-label col-lg-2" for="comment">Ticket No:</label>
                        <div class="col-lg-8">
                            <h4><span class="label label-primary"><?= $ticket->ticket_no; ?></span></h4>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="control-label col-lg-2" for="comment">Description:</label>
                        <div class="col-lg-8">
                            <textarea class="form-control" placeholder="Described Problems" name="comment" rows="5" id="comment"></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" onclick="trv.knowledge.save()" class="btn btn-success">Submit</button>
                        </div>
                    </div>

                    <div class="msgg text-center"></div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
$this->load->view('sm/home/view_footer');
?>

<script>
    //===========================================
    $(document).ready(function () {

        $("textarea").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

    });
</script>