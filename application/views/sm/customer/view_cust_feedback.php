<?php
$this->load->view('sm/home/view_header');
?>

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Customer Feedback
                </header>
                <div class="panel-body">


                    <form class="form-horizontal" id="feedback">

                        <div class="form-group required">
                            <label class="col-lg-2 control-label" for="dep_ref_id">Department</label>
                            <div class="col-lg-7">
                                <select class="form-control" id="dep_ref_id" name="dep_ref_id">
                                    <option value="">select</option>
                                    <?php if (!empty($department)): ?>
                                        <?php foreach ($department as $c): ?>
                                            <option value="<?= $c->id; ?>"><?= $c->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="control-label col-lg-2" for="sub">Subject:</label>
                            <div class="col-lg-7">
                                <input type="text" name="sub" class="form-control" id="sub" placeholder="Enter subject">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="control-label col-lg-2" for="des">Description:</label>
                            <div class="col-lg-7">
                                <textarea class="form-control" placeholder="Give your feedback" rows="5" id="des"
                                          name="desc"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="button" onclick="trv.customer.feed_back()" class="btn btn-success">
                                    Submit
                                </button>
                            </div>
                        </div>

                        <div class="res text-center"></div>

                    </form>


                </div>
            </section>
        </div>
    </div>


<?php
$this->load->view('sm/home/view_footer');
?>