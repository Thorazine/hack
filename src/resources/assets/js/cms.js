var URL = window.URL || window.webkitURL;
Dropzone.autoDiscover = false;


$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
});


(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());


$(document).ready(function() {
    $('#cms-loader').fadeOut(200);

    // site switcher
    $('#site-selector').on('change', function(event) {
        window.location.href = $(this).val();
    });

    // set the width of the pagination
    $('ul.pagination').width($('ul.pagination li').length * 34 + 1);

    hideAlert(1000);

    $('.alert-timeout').click(function(event) {
        hideAlert(10000);
    });
});

// hide the notification alert
function hideAlert(timeout)
{
    $('.alert-timeout').css('right', 0);
    setTimeout(function() {
        $('.alert-timeout').animate({
            right: "-="+($('.alert-timeout').width() + 40),
        }, 1000, function() {
        // Animation complete.
        });
    }, timeout);
}

