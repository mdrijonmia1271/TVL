<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>TVL Service Management</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- CUSTOM STYLE  -->
    <link href="<?php echo base_url(); ?>smdesign/job/css/custom-style.css" rel="stylesheet"/>
    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'/>

</head>
<body>
<div class="container">

    <div class="row">
        <table class="table">
            <tr>
                <td width="60%"><img width="374px" src="<?php echo base_url(); ?>smdesign/job/img/tvl4.png"
                                     style="padding-bottom:20px;"/></td>
                <td width="40%">
                    <div class="address">
                        <div class="reg">
                            <b>Registered Office</b>
                            <br>
                            <span>15/17 Shantinagar Bazar Road</span>
                            <br/>
                            <span>Dhaka- 1217 , Bangladesh</span>
                        </div>

                        <div class="sales" style="padding-top: 5px">
                            <b>Sales Office & Mailing Address</b>
                            <br>
                            <span>House #B-141, Halim Villa, Lane # 22</span>
                            <br/>
                            <span>New DOHS, Mohakhali, Dhaka-1206, Bangladesh.</span>
                            <br/>
                            <span>Phone : 88 02 8711840-2 ,</span>&nbsp; <span>Fax: 880 2 8711940</span>
                            <br/>
                            <span>Hotline : 0175-5245555</span>
                            <br/>
                            <span>Email: info@tradevision.com.bd</span>
                            <br>
                            <span>www.tvlbd.com</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="row">
        <h4 class="text-center">Service Report</h4>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h5><b>Client/Customer Problem :</b></h5>
            <p><?= $comments->request_details; ?></p>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <h5><b>Service Eng. Comments  :</b></h5>
            <table class="table">
                <tbody>
                <tr>
                    <td><b>Problem Details :</b> <?= $comments->eng_comment; ?></td>
                    <td><b>Action Details :</b> <?= $comments->action_comment; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered" cellpadding="10">
                    <tbody>
                    <tr>
                        <td width="60%"><b>Ticket No :</b> &nbsp; <?= $report->ticket_no; ?>  </td>
                        <td width="40%"><b>Ticket Date:</b> &nbsp; <?= date('d M Y',strtotime($report->created_date_time)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="60%"><b>Name Of Institution :</b> &nbsp; <?= $report->name; ?>  </td>
                        <td width="40%"><b>Order No:</b> &nbsp; <?= $report->insb_work_order_contact; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Name Of The Equipment : </b> <?= $machine->mc_name; ?></td>
                        <?php if (!empty($report->insb_work_order_date)): ?>
                        <td><b>Order Date :</b> <?= date('d M Y',strtotime($report->insb_work_order_date)); ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td><b>Model No :</b> &nbsp; <?= $machine->mc_model; ?></td>
                        <td><b>Date Of Installation :</b> &nbsp; <?php $install_date =  date('d M Y',strtotime($report->insb_install_date));
                        if (!empty($install_date)){ echo $install_date; }
                        ?></td>
                    </tr>

                    <tr>
                        <td><b>Serial No. : </b> <?= $report->insb_serial; ?></td>
                        <td><b>Manufacturer : </b>&nbsp; <?= $machine->mf_name; ?></td>
                    </tr>


                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table  table-bordered ">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name Of Engineer</th>
                        <th width="20%">No. of working days @(7 hrs. a day)</th>
                        <th width="10%">Total Working hours</th>
                        <th width="20%">Name of spares supplied from our stock/Govt. stock</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?= date('d M Y',strtotime($report->updated_date_time)); ?></td>
                        <td><?= $report->eng; ?></td>
                        <td></td>
                        <td></td>
                        <td>
                            <?php if (!empty($spare)): ?>
                                <ol>
                                    <?php foreach ($spare as $p): ?>
                                        <li><?= $p->sp_name; ?></li>
                                    <?php endforeach; ?>
                                </ol>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($spare)): ?>
                                <?php
                                $val = 0;
                                foreach ($spare as $p):
                                    ?>
                                    <?php $val += $p->sp_quantity; ?>
                                <?php endforeach; ?>
                                <?= $val; ?>
                            <?php endif; ?>
                        </td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br> <br>
    <!-- footer -->
    <?php if ($report->insb_sector == 'private'): ?>
        <!-- privet -->
        <table class="table">
            <tr>
                <td colspan="2"><span><img width="32px" src="<?php echo base_url(); ?>smdesign/job/img/chk.png"></span>
                    Certified that, the Installation has been made to our
                    entire satisfaction and machine has been handed over to user in good working condition.
                </td>
            </tr>

            <tr>
                <td colspan="2" height="200px"></td>
            </tr>

            <tr>
                <td><b class="signature">Signature & Seal of User Dept. & Date</b></td>
                <td class="text-right"><b class="signature">Signature of Service Engineer & Date</b></td>
            </tr>
        </table>

    <?php endif; ?>
    <?php if ($report->insb_sector == 'govt'): ?>
        <!-- Govt -->

        <table class="table sector-sig">

            <tr>
                <td colspan="3"><span><img width="32px" src="<?php echo base_url(); ?>smdesign/job/img/chk.png"></span>
                    Certified that, the Installation has been made to our
                    entire satisfaction and machine has been handed over to user in good working condition.
                </td>
            </tr>

            <tr>
                <td colspan="3" height="50px"></td>
            </tr>

            <tr>
                <td colspan="3" class="text-right"><b class="signature">Signature of Service Engineer & Date</b></td>
            </tr>

            <tr>
                <td colspan="3" height="70px"></td>
            </tr>

            <tr>
                <td width="33%">___________________________________</td>
                <td width="33%">___________________________________</td>
                <td width="33%">___________________________________</td>
            </tr>

            <tr>
                <td><b>Signature and Seal of User/ store Keeper/ICT/EME & Date</b></td>
                <td><b>Signature and seal of head of the dept/
                        RMO & Date.</b></td>

                <td><b>Signature and seal of head of the Institute /Hospital /Dept & Date</b></td>
            </tr>
        </table>

    <?php endif; ?>

    <?php if ($report->insb_sector == 'corporate'): ?>
        <!-- Corporate -->
        <table class="table sector-sig">

            <tr>
                <td colspan="3"><span><img width="32px" src="<?php echo base_url(); ?>smdesign/job/img/chk.png"></span>
                    Certified that, the Installation has been made to our
                    entire satisfaction and machine has been handed over to user in good working condition.
                </td>
            </tr>

            <tr>
                <td colspan="3" height="50px"></td>
            </tr>

            <tr>
                <td colspan="3" class="text-right"><b class="signature">Signature of Service Engineer & Date</b></td>
            </tr>

            <tr>
                <td colspan="3" height="70px"></td>
            </tr>

            <tr>
                <td width="33%">___________________________________</td>
                <td class="text-center">___________________________________</td>
                <td class="text-right">________________________________________</td>
            </tr>

            <tr>
                <td><b>Signature and Seal of User Dept.</b></td>
                <td class="text-center"><b>Signature and seal of EME Dept.</td>
                <td class="text-right"><b>Signature and seal head of the Dept.</b></td>
            </tr>
        </table>

    <?php endif; ?>

</div>
</body>
</html>