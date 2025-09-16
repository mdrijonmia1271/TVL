<?php $this->load->view('sm/home/view_header'); ?> 

<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<b>Customer Wise Summary Report</b>
<span class="tools pull-right">
<a href="javascript:;" class="fa fa-chevron-down"></a>
<a href="javascript:;" class="fa fa-cog"></a>
<!--<a href="javascript:;" class="fa fa-times"></a>-->
</span>
</header>
<div class="panel-body">
<form role="form" class="form-horizontal bucket-form" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'sm/report/customerWiseListsearch'; ?>">
<div class="form-group">

<div class="col-lg-12">
<div class="row"> 
    
<label for="name" class="col-sm-1 control-label col-lg-1"> Customer Name</label>
<div class="col-lg-4">
<?php
$dropdown_js_department = 'id="Customer"  class="form-control";';
echo form_dropdown('name', $customer_list, '', $dropdown_js_department);
?>
<span class="error"><?php echo form_error('name'); /* print valitation error */ ?>
</div>

<label for="code" class="col-sm-1 control-label col-lg-1">Customer Code</label>
<div class="col-lg-4">
<input type="text" name="code"  placeholder="code" class="form-control">
</div>

</div>
    
    <div class="row"> 
<label for="Year" class="col-sm-1 control-label col-lg-1">Year</label>
<div class="col-lg-4" >
<?php 
$dropdown_js1 = 'id="dob_year" style="float:left;" class="form-control";';
echo form_dropdown('dob_year', $year_array,'', $dropdown_js1);
?>
</div>

<label for="Month" class="col-sm-1 control-label col-lg-1">Month</label>
<div class="col-lg-4">
<?php 
$dropdown_js2 = 'id="dob_month" style="float:left;"  class="form-control";';
echo form_dropdown('dob_month', $month_array,'', $dropdown_js2);
?>
</div>

</div><div class="row"> 
<label for="Date Form" class="col-sm-1 control-label col-lg-1">Date From</label>
<div class="col-lg-4">
<!--<input type="text" name="date_from"  placeholder="Date Form" class="form-control">-->
   <input id="da-from-datepicker" type="text" name="date_from"   placeholder="Date To" class="form-control" />
</div>

<label for="Date To" class="col-sm-1 control-label col-lg-1">Date To</label>
<div class="col-lg-4">
<!--<input type="text" name="date_to"  placeholder="Date To" class="form-control">-->
   <input id="da-to-datepicker" type="text" name="date_to"   placeholder="Date To" class="form-control"/>
</div>



</div>
</div>

<div class="col-lg-12">
<br>
<div class="row">                                

<label for="inputSuccess" class="col-sm-1 control-label col-lg-1">Status</label>
<div class="col-lg-3"  placeholder="Status">
<select  name="status" class="form-control m-bot3">
<option value="A">Active</option>
<option value="I">InActive</option>

</select>

</div>

<div class="col-lg-3">
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;
<button class="btn btn-success" type="submit">Search</button>
</div>

</div>
</div>
</div>

</form>
</div>
</section>
</div>
</div>



<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Customer Wise: Request List
<span class="tools pull-right">
<a class="fa fa-chevron-down" href="javascript:;"></a>
<a class="fa fa-cog" href="javascript:;"></a>
<!--<a class="fa fa-times" href="javascript:;"></a>-->
</span>
</header>
<div class="panel-body">
<div class="position-center">

<!--<TABLE BORDER>
<TR>
<TD>Item 1</TD>
<TD>Item 1</TD>
<TD COLSPAN=2>Item 2</TD>
</TR>
<TR>
<TD>Item 3</TD>
<TD>Item 3</TD>
<TD>Item 4</TD>
<TD>Item 5</TD>
</TR>
</TABLE>-->
<table width="100%" cellpadding="5" border="1">
<tr>
<th scope="col">Customer Name</th>
<th scope="col">Customer Mobile</th>
<th scope="col">Customer Email</th>
<th scope="col">Total Request</th>
<th scope="col" COLSPAN=3>Status</th>
<th scope="col" COLSPAN=4>Support Type</th>
<th scope="col" COLSPAN=3>Priority</th>
<th scope="col">Completion Time</th>
</tr>
<tr>
<th scope="row">&nbsp;</th>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>




<td>Draft</td>
<td>Approved</td>
<td>Cancel</td>

<td>Free</td>
<td>AMC</td>
<td>Preventive Maintenance </td>
<td>On Call</td>

<td>Normal</td>
<td>Critical</td>
<td>Nice to Have</td>


<td>&nbsp;</td>
<!--<td>&nbsp;</td>
<td>&nbsp;</td>-->
</tr>
<tr>
<th scope="row">&nbsp;</th>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>


<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>

<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>

<td>&nbsp;</td>
<!--<td>&nbsp;</td>
<td>&nbsp;</td>-->


</tr>


</table>




</div>

</div>
</section>







</div>
</div>








<!-- Main Content Wrapper -->
<?php
$this->load->view('sm/home/view_footer');
?>    