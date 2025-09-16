</section>
</section>
<!--main content end-->


<!--footer start-->
<footer class="footer-section">
    <div class="text-center">
        <?php echo date('Y'); ?> &copy; Trade Vision Ltd. | Developed BY : <a style="color: white !important"
                                                                           href="http://www.bigm-bd.com"
                                                                           target="_blank">Big M Resources Limited</a>
        <a href="#" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
</footer>
<!--footer end-->
</section>


<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script type="text/javascript">
    <!--
    function siteHost() { // Read-only-ish
        return "<?php echo base_url();?>";
    }

    //-->
</script>
<script src="<?php echo base_url() . 'smdesign/'; ?>js/lib/jquery.js"></script>
<script src="<?php echo base_url() . 'smdesign/'; ?>bs3/js/bootstrap.min.js"></script>

<!--jquery-ui datepicker-->
<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
<script src="<?php echo base_url() . 'smdesign/'; ?>js/jquery-ui.js"></script>
<script>

    $(function () {

        $('#datepicker_from, #datepicker_to').datepicker({
            //showOn: "both",
            beforeShow: custom_range,
            dateFormat: 'yy-mm-dd',
        });

    });

    function custom_range(input) {

        if (input.id == 'datepicker_to') {
            var minDate = new Date($('#datepicker_from').val());
            minDate.setDate(minDate.getDate() + 1);

            return {
                minDate: minDate

            };
        }

        return {}

    }
</script>

<!--jquery-ui datepicker-->

<script class="include" type="text/javascript"
        src="<?php echo base_url() . 'smdesign/'; ?>js/accordion-menu/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url() . 'smdesign/'; ?>js/scrollTo/jquery.scrollTo.min.js"></script>


<script type="text/javascript" src="<?php echo base_url() . 'smdesign/'; ?>js/hover-down/hover-dropdown.js"></script>
<script src="<?php echo base_url() . 'smdesign/'; ?>assets/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<!--Easy Pie Chart-->
<script src="<?php echo base_url() . 'smdesign/'; ?>assets/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="<?php echo base_url() . 'smdesign/'; ?>assets/sparkline/jquery.sparkline.js"></script>
<!--jQuery Flot Chart-->
<script src="<?php echo base_url() . 'smdesign/'; ?>assets/flot-chart/jquery.flot.js"></script>
<script src="<?php echo base_url() . 'smdesign/'; ?>assets/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url() . 'smdesign/'; ?>assets/flot-chart/jquery.flot.resize.js"></script>
<script src="<?php echo base_url() . 'smdesign/'; ?>assets/flot-chart/jquery.flot.pie.resize.js"></script>

<script type="text/javascript"
        src="<?php echo base_url() . 'smdesign/'; ?>js/jquery-validate/jquery.validate.min.js"></script>
<!--this page script-->
<!--<script src="<?php echo base_url() . 'smdesign/'; ?>js/jquery-validate/validation-init.js"></script>-->




<!--dynamic table-->
<script type="text/javascript" language="javascript"
        src="<?php echo base_url() . 'smdesign/'; ?>assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'smdesign/'; ?>assets/data-tables/DT_bootstrap.js"></script>


<!--dynamic table initialization -->
<script src="<?php echo base_url() . 'smdesign/'; ?>js/dynamic_table/dynamic_table_init.js"></script>
<script src="<?php echo base_url(); ?>javascripts/jquery.confirm.min.js"></script>
<script src="<?php echo base_url(); ?>javascripts/loadingoverlay.js"></script>
<script src="<?php echo base_url(); ?>javascripts/master.js"></script>
<script src="<?php echo base_url(); ?>javascripts/qpty.js"></script>
<!--common script init for all pages-->
<script src="<?php echo base_url() . 'smdesign/'; ?>js/scripts.js"></script>
<script src="<?php echo base_url() . 'smdesign/'; ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="<?php echo base_url() . 'smdesign/'; ?>js/multiselect.min.js"></script>

</body>
</html>
