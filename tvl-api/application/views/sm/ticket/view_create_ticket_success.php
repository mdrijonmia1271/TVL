<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                 Ticket Creation Confirmation
                <span class="tools pull-right">
                    <a class="fa fa-chevron-down" href="javascript:;"></a>
                </span>
            </header>
            <div class="panel-body">
                <div class="position-center">
                    <h3 class="inv-label">Your ticket has been submitted. </h3>
                    <h3 class="inv-label itatic">Check the status later with ticket no: <b><?php  echo $this->session->flashdata('generate_ticket_no'); ?></b></h3>
                    <h4 class="inv-label">Thank You !</h4>
                </div>

            </div>
        </section>


    </div>
</div>

<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>