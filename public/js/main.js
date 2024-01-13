function buildErrorsReport(conteiner, errors) {
    if($(conteiner + ' .error-container').length > 0) {
        $(conteiner + ' .error-container').remove();
    }
    if(errors == null) {
        return;
    }
    let html = '<div class="error-container"><ul>Ошибки';
    $.each(errors , function(index, error) {
        if(typeof error.message === 'undefined' && typeof error === 'string') {
            html += '<li>'+ error +'</li>';
        } else if (typeof error.message === 'string') {
            html += '<li>'+ error.message +'</li>';
        }
    });
    html += '</ul></div>';
    $(conteiner).append(html);
    $('div.container-preloader').hide();

    if($(".error-container").length > 0) {
        $('html, body').animate({
            scrollTop: $(".error-container").offset().top
        }, 1000);
    }
}

function submitForm(input) {
    $('div.container-preloader').fadeIn();
    var check = true;
    for (var i = 0; i < input.length; i++) {
        if (validate(input[i]) == false) {
            showValidate(input[i]);
            check = false;
            $('div.container-preloader').hide();
        }
    }
    if($(".alert-validate").length > 0) {
        $('html, body').animate({
            scrollTop: $(".alert-validate").offset().top
        }, 1000);
    }
    return check;
}

function validate(input) {
    if(input  !== null && $(input).is(':visible')) {
        if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if ($(input).length > 0 && $(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        } else {
            if ($(input).length > 0 && $(input).val() !== null && ((typeof ($(input).val()) == 'string' && $(input).val().trim() == '') || (typeof ($(input).val()) == 'object' && $(input).val().length == 0))) {
                return false;
            }
        }
    }
}

function showValidate(input) {
    var thisAlert = $(input).parent();
    $(thisAlert).addClass('alert-validate');
}

function hideValidate(input) {
    var thisAlert = $(input).parent();
    $(thisAlert).removeClass('alert-validate');
}

(function ($) {
    "use strict";
    $('.input100').each(function () {
        $(this).on('blur', function () {
            if ($(this).length > 0 && $(this).val().trim() != "") {
                $(this).addClass('has-val');
            } else {
                $(this).removeClass('has-val');
            }
        })
    })

    $('.validate-form .input100').each(function () {
        $(this).focus(function () {
            hideValidate(this);
        });
    });

    $('.input100').each(function () {
        if($(this).val() != '') {
            $(this).addClass('has-val');
        }
    });

    $('div.container-preloader').hide();
})(jQuery);