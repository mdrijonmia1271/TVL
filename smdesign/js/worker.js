/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */




function getDistricttByAjax(paramUrl) {
   
    var appUrl = paramUrl;
    
    var division_id = $("#division").val();

    $.ajax({
        url: appUrl + "ajax_get_district",
        beforeSend: function(data) {
            //  $("#your_span").show('slow');
        },
        global: false,
        type: "POST",
        //async: false,
        dataType: "html",
        data: "division_id=" + division_id, //the name of the $_POST variable and its value
        success: function(response)         //'response' is the output provided by the controller method prova()
        {   
            $('#show_my_district').html(response);   
        }

    });
    // $("#your_span").hide('slow');// end animation
    return false;

}

function getUpazallaByAjax(paramUrl) {
    var appUrl = paramUrl;
    var valore = $("#district").val();

    $.ajax({
        url: appUrl + "ajax_get_upazila",
        beforeSend: function(data) {
        },
        global: false,
        type: "POST",
        //async: false,
        dataType: "html",
        data: "district_id=" + valore, //the name of the $_POST variable and its value
        success: function(response) //'response' is the output provided by the controller method prova()
        {
            $('#show_my_upazila').html(response);
        }
    });
    return false;
}

function getCustomerByAjax() {   
    var appUrl = siteHost();    
    var customer_id = $("#sendfrom").val();
    $.ajax({
        url: appUrl+'sm/manager/ajax_get_customer_tasklist',
        beforeSend: function(data) {
        },
        global: false,
        type: "POST",        
        dataType: "html",
        data: "customer_id=" + customer_id, 
        success: function(response)
        {   
            $('#show_my_task').html(response);   
        }
    });
    getSupportType();
    return false;
}

function getSupportType(){
    var appUrl = siteHost();    
    var customer_id = $("#sendfrom").val();
    $.ajax({
        url: appUrl+'sm/manager/ajax_get_customer_support_type',
        beforeSend: function(data) {
        },
        global: false,
        type: "POST",        
        dataType: "html",
        data: "customer_id=" + customer_id, 
        success: function(response)
        {   
            $('#show_my_support_type').html(response);   
        }
    });       
}