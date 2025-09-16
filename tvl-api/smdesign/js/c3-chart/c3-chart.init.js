$(function () {

var chart = c3.generate({
        data: {
          columns: 
            year_wise_summary_data
          ,
          onclick: function (d, element) { console.log("onclick", d, element); },
          onmouseover: function (d) { console.log("onmouseover", d); },
          onmouseout: function (d) { console.log("onmouseout", d); },
        }
      });
});