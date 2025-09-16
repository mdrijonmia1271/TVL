<?php

$start_date = $support_type->su_start_date;
$startDate = date("d-m-Y", strtotime($start_date));

$end_date = $support_type->su_end_date;
$endtDate = date("d-m-Y", strtotime($end_date));
?>

<div class="box box-info">
    <div class="box-body" id="support_type_display">
        <div class="col-lg-5 col-xs-6 ">Support Type :</div>
        <div class="col-lg-7 col-xs-6"><?= $support_type->service_type_title; ?></div>
        <div class="clearfix"></div>
        <div class="bot-border"></div>

        <?php $now = date('Y-m-d');
        if ($now >= $start_date && $now <= $end_date): ?>
            <div class="col-lg-5 col-xs-6 tital ">Start Date :</div>
            <div class="col-lg-7 col-xs-6"><?= $startDate; ?></div>
            <div class="clearfix"></div>
            <div class="bot-border"></div>

            <div class="col-lg-5 col-xs-6 tital ">End Date:</div>
            <div class="col-lg-7"><?= $endtDate; ?></div>
            <div class="clearfix"></div>
            <div class="bot-border"></div>
        <?php else: ?>
            <div class="support-date" style="border: 1px solid red">
                <div class="col-lg-5 col-xs-6 tital ">Start Date :</div>
                <div class="col-lg-7 col-xs-6"><?= $startDate; ?></div>
                <div class="clearfix"></div>
                <div class="bot-border"></div>

                <div class="col-lg-5 col-xs-6 tital ">End Date:</div>
                <div class="col-lg-7"><?= $endtDate; ?></div>
                <div class="clearfix"></div>
                <div class="bot-border"></div>
                <div class="text-center text-danger">Your Support Time Already Expire !!</div>
            </div>
        <?php endif; ?>
    </div>

</div>
