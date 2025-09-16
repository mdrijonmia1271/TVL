/*===Vertical Bar===*/
$(function () {
    "use strict";
    jQuery('.progress-stat-bar li').each(function () {
        jQuery(this).find('.progress-stat-percent').animate({
            height: jQuery(this).attr('data-percent')
        }, 1000);
    });
});

