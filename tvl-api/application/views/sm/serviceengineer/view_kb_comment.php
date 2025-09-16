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

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <span class="label label-info">Post By : <strong><?= $kb_post->name; ?></strong></span>
                                <span class="label label-primary">Date : <?= format_change($kb_post->posted_date); ?></span>
                                <span class="label label-warning">Ticket No: <strong><?= $knowledge->ticket_ref_no; ?></strong> </span>

                            </div>
                            <div class="panel-body">
                                <?= $kb_post->problem_details; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($kb_comments)): ?>
                    <?php foreach ($kb_comments as $c): ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <span class="label label-info">Comments By : <strong><?= $c->name; ?></strong></span>
                                        <span class="label label-primary">Date : <?= format_change($c->comment_date); ?></span>
                                    </div>
                                    <div class="panel-body">
                                        <?= $c->comment; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            <?php if ($this->session->userdata('admin_user_type') != 'sm'): ?>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <form id="kbcForm">
                            <input type="hidden" name="kb_id" value="<?= $knowledge->id; ?>">
                            <div class="form-group">
                                <label for="email">Comments :</label>
                                <textarea class="form-control" placeholder="Comments On Post" name="kb_comment" rows="5"
                                          id="comment"></textarea>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <button type="button" onclick="trv.knowledge.comment_save()"
                                        class="btn btn-success">Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
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