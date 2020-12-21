$(function() {

    'use strict';


    // Dashboard 

    $('.toggle-info').click(function() {

        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

        if ($(this).hasClass('selected')) {

            $(this).html('<i class="fa fa-plus fa-lg"></i>');

        } else {

            $(this).html('<i class="fa fa-minus fa-lg"></i>');

        }

    });

    // Add Asterisk On Required Field

    $('input').each(function() {

        if ($(this).attr('required') === 'required') {

            $(this).after('<span class="asterisk">*</span>');

        }

    });

    // Hide Placeholder On Form Focus

    $('[placeholder]').focus(function() {

        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placeholder', '');

    }).blur(function() {

        $(this).attr('placeholder', $(this).attr('data-text'));

    });

    // Convert Password Field To Text Field On Hover

    var passField = $('.password');

    $('.show-pass').hover(function() {

        passField.attr('type', 'text');

    }, function() {

        passField.attr('type', 'password');

    });

    // Confirmation Message On Button

    /*
    $('.confirm').click(function() {

        return confirm('Are You Sure?');

    });
     */

    // Calls the selectBoxIt method on your HTML select box
    $("select").selectBoxIt({

        // Uses the jQueryUI 'shake' effect when opening the drop down
        showEffect: "shake",

        // Sets the animation speed to 'slow'
        showEffectSpeed: 'slow',

        // Sets jQueryUI options to shake 1 time when opening the drop down
        showEffectOptions: { times: 1 },

        // Uses the jQueryUI 'explode' effect when closing the drop down
        hideEffect: "explode",

        autoWidth: false

    });

});