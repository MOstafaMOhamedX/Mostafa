$(function() {
    'use strict';


    // Confirmation Message On Button

    $('.confirm').click(function() {

        return confirm('Are You Sure?');

    });

    $('.live').keyup(function() {

        $($(this).data('class')).text($(this).val());

    });



    // Switch Between Login & Signup

    $('.login-page h1 span').click(function() {

        $(this).addClass('selected').siblings().removeClass('selected');

        $('.login-page form').hide();

        $('.' + $(this).data('class')).fadeIn(100);

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

    $("select").selectBoxIt({

        autoWidth: false

    });





    $(".fadeout").click(function() {
        $(this).fadeOut(100);
    });

    $(".closebtn").click(function() {
        $(".fadeout").fadeIn();
    });

});

function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("body").style.opacity = "0.5";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("body").style.opacity = "1";
}



function block1() {
    var x = document.getElementById("menu1");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}