/*!

 =========================================================
 * Material Bootstrap Wizard - v1.0.2
 =========================================================

 * Product Page: https://www.creative-tim.com/product/material-bootstrap-wizard
 * Copyright 2017 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/material-bootstrap-wizard/blob/master/LICENSE.md)

 =========================================================

 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 */

// Material Bootstrap Wizard Functions

var searchVisible = 0;
var transparent = true;
var mobile_device = false;

$(document).ready(function () {

    $("#pCliente")[0].reset();

    $("form").keypress(function (e) {
        if (e.which == 13) {
            return false;
        }
    });
    $("#planes-seleccionados").hide();
    $(".Juridico").hide();
    $(".Natural").hide();
    $(".AttorneyJ").hide();
    $(".AttorneyN").hide();
    $(".Dv").hide();
    $(".OptCliente").hide();
    $(".Opt").hide();
    $(".OptFirma").hide();
    $("assigne").hide();
    $(".DvRep").hide();
    $(".Attorney").hide();
    $(".Integracion").hide();
    $(".Plan_I").hide();
    $(".plan").hide();
    $(".plan_select").hide();
    $(".D_plan").hide();
    $(".DvAttorney").hide();
    $('#documents').hide();
    $("#pre_document").hide();
    $(".tab_edit").hide();
    $("#download").hide();
    $('.insoft').hide();
    $('#captcha').hide();
    $('#valid').hide();
    $('#div_termino_4').hide();
    $('#div_termino_firma_4').hide();
    $("#dv").ForceNumericOnly();
    $("#dv_rep").ForceNumericOnly();
    $("#modal-btn-si_legal").prop("disabled", true);
    $("#cat_method").prop("disabled", true);
    $("#nit_attorney").ForceNumericOnly();
    $("#dv_attorney").ForceNumericOnly();
    $("#phone").ForceNumericOnly();
    $("#phoneClient").ForceNumericOnly();
    $("#cant_folios_e").ForceNumericOnly();
    $("#cant_folios_r").ForceNumericOnly();
    $("#cant_folios_n").ForceNumericOnly();
    $("#phone_attorney").ForceNumericOnly();
    $("#opt").ForceNumericOnly();
    $("#optfirma").ForceNumericOnly();
    $("#opt_cliente").ForceNumericOnly();

    $('#type_person').on('change', function () {
        validarCliente();
        $("#nam_enterprise").val('');
        $("#lastnam_enterprise").val('');
        $("#type_identification").val('');
        if ($("#exist_client").val() == 'false' && $("#doc_valid").val() != 'false') {
            $("#dni").val('');
            $("#dv").val('');
        }
        $("#nam_rep").val('');
        $("#lastnam_rep").val('');
        $("#type_identification_rep").val('');
        $("#dni_rep").val('');
        $("#dv_rep").val('');
        $(".AttorneyCC").hide();
        if (this.value == '1') {
            $(".Natural").hide();
            $(".Juridico").show();
            $(".Dv").show();
            if ($('#type_attorney').val() == '1') {
                $(".AttorneyCC").show();
            }

        } else {

            $(".Juridico").hide();
            $(".Dv").hide();
            $(".Natural").show();
        }
    });
    $("#dni").keyup(function () {
        validarCliente();
    });

    $('#dv').keyup(function () {
        validarCliente();

    });

    function validarCliente() {
        if ($("#exist_client").val() == 'false' && $("#doc_valid").val() != 'false') {
            $("#next").hide();
            $("#valid").hide();
            $("#documents").hide();
            $("#rut_1").trigger("reset");
            $("#chamber_commerce_1").trigger("reset");
            $("#search").show();
            $("#res-search").html('');
        } else if ($("#exist_client").val() == 'true') {
            $("#next").hide();
            $("#valid_opt").hide();
            $("#search").show();
            $("#res-valid_opt").html('');
            $(".OptCliente").hide();
            $('#opt_cliente').val('');

        }
    }

    $('#dni').on('input', function (e) {

        if ($('#type_identification').val() == '7') {
            if (!/^[ a-z0-9ñ]*$/i.test(this.value)) {
                this.value = this.value.replace(/[^ a-z0-9ñ]+/ig, "");
            }
        } else {
            if (!/^[0-9]*$/i.test(this.value)) {
                this.value = this.value.replace(/[^0-9]+/ig, "");
            }
        }

    });

    /*$('#type_identification_rep').on('change', function()
    {
        $("#dni_rep").val('');
        $("#dv_rep").val('');
        if( this.value=='1' ){
            $(".DvRep").show();
        }else{
            $(".DvRep").hide();
        }
    });*/

    $('#dni_rep').on('input', function (e) {
        $("#dni_rep").attr('maxlength', '20');
        if ($('#type_identification_rep').val() == '7') {
            if (!/^[ a-z0-9ñ]*$/i.test(this.value)) {
                this.value = this.value.replace(/[^ a-z0-9ñ]+/ig, "");
            }
        } else if ($('#type_identification_rep').val() == '11') {
            $("#dni_rep").attr('maxlength', '7');
            if (!/^[ 0-9]*$/i.test(this.value)) {
                this.value = this.value.replace(/[^ 0-9]+/ig, "");
            }
        }
        else {
            if (!/^[ 0-9]*$/i.test(this.value)) {
                this.value = this.value.replace(/[^ 0-9]+/ig, "");
            }
        }

    });

    $('#attorney').on('change', function () {
        $("#type_identification_attorney").val('');
        $("#dni_attorney").val('');
        $("#dv_attorney").val('');
        $("#nam_attorney").val('');
        $("#lastnam_attorney").val('');
        $("#email_attorney").val('');
        $("#phone_attorney").val('');
        $("#rut_attorney").trigger("reset");
        $("#chamber_commerce_attorney").trigger("reset");
        $("#power_attorney").trigger("reset");
        $("#trusted_document").trigger("reset");

        if (this.value == '1') {
            $(".Attorney").show();
        } else {
            $(".Attorney").hide();
            $(".AttorneyCC").hide();
        }
    });

    $('#type_attorney').on('change', function () {
        $("#nit_attorney").val('');
        $("#nam_attorney_juridico").val('');
        $("#lastnam_attorney_juridico").val('');
        $("#nam_attorney").val('');
        $("#lastnam_attorney").val('');
        $("#type_identification_attorney").val('');
        $("#dni_attorney").val('');
        $("#dv_attorney").val('');
        $("#email_attorney").val('');
        $("#phone_attorney").val('');
        $("#chamber_commerce_attorney").trigger("reset");

        if (this.value == '1') {
            $(".AttorneyN").hide();
            $(".AttorneyJ").show();
            if ($('#type_person').val() == '1') {
                $(".AttorneyCC").show();
            } else {
                $(".AttorneyCC").hide();
            }

        } else {

            $(".AttorneyJ").hide();
            $(".AttorneyN").show();
            $(".AttorneyCC").hide();
        }

    });



    $('#type_identification_attorney').on('change', function () {
        $("#dni_attorney").val('');
        if (this.value == '1') {
            $(".DvAttorney").show();
        } else {
            $(".DvAttorney").hide();
        }
    });

    $('#dni_attorney').on('input', function (e) {

        if ($('#type_identification_attorney').val() == '7') {
            if (!/^[ a-z0-9ñ]*$/i.test(this.value)) {
                this.value = this.value.replace(/[^ a-z0-9ñ]+/ig, "");
            }
        } else {
            if (!/^[ 0-9]*$/i.test(this.value)) {
                this.value = this.value.replace(/[^ 0-9]+/ig, "");
            }
        }

    });

    $("input[type='file']").bind('change', function () {
        $('#next').hide();
        $('#valid').show();
    });

    $(".fileinput-remove").on("click", function () {
        $('#next').hide();
        $('#valid').show();
    });

    jQuery.validator.addMethod("emailExt", function (value, element, param) {
        return value.match(/^[a-zA-Z0-9_\.%\+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,}$/);
    }, 'Your E-mail is wrong');


    $.material.init();

    /*  Activate the tooltips      */
    $('[rel="tooltip"]').tooltip();

    $.validator.addMethod(
        "phoneValidation",
        function (value, element) {
            // Validar el formato del número de teléfono celular
            var phonePattern = /^3\d{9}$/; // El primer dígito debe ser 3, seguido de 9 dígitos adicionales
            return this.optional(element) || phonePattern.test(value);
        },
        "El número de teléfono celular debe comenzar con el número 3 y tener 10 dígitos en total"
    );

    $.validator.addMethod(
        "phoneValidationCelularFijo",
        function (value, element) {
            // Validar el formato del número de teléfono celular
            var phonePattern = /^(3|6)\d{9}$/; // El primer dígito debe ser 3, seguido de 9 dígitos adicionales
            return this.optional(element) || phonePattern.test(value);
        },
        "El número de teléfono debe comenzar con el número 3 para celular o 6 para fijo y tener 10 dígitos en total"
    );
    // Code for the Validator
    var $validator = $('.wizard-card form').validate({
        rules: {
            accept: {
                required: true,
            },
            p_recepcion: {
                required: true,
            },
            type_person: {
                required: true,
            },
            nam_enterprise: {
                minlength: 2,
                required: function () {
                    return $("#type_person option:selected").val() != ''
                }
            },
            lastnam_enterprise: {
                minlength: 2,
                required: function () {
                    return $("#type_person option:selected").val() == '2'
                }
            },
            type_identification: {
                required: true,
            },
            dni: {
                required: true,
                minlength: 3,
                maxlength: 20
            },
            dv: {
                minlength: 1,
                maxlength: 1,
                required: function () {
                    return $("#type_person option:selected").val() == '1'
                }
            },
            type_identification_rep: {
                required: true,
            },
            opt_cliente: {
                minlength: 6,
                maxlength: 6,
                required: function () {
                    return $("#id_type_person").val() == ''
                }
            },
            dni_rep: {
                required: true,
                minlength: 3,
                maxlength: 20
            },
            dv_rep: {
                minlength: 1,
                maxlength: 1,
                required: function () {
                    return $("#type_identification_rep option:selected").val() == '1'
                }
            },
            nam_rep: {
                required: function () {
                    return $("#type_person option:selected").val() == '1'
                },
                minlength: 2
            },
            lastnam_rep: {
                required: function () {
                    return $("#type_person option:selected").val() == '1'
                },
                minlength: 2
            },
            email: {
                required: true,
                emailExt: true,
                maxlength: 150,
            },
            email_fac: {
                required: true,
                emailExt: true,
                maxlength: 150,
            },
            email_rad: {
                required: true,
                emailExt: true,
                maxlength: 150,
            },
            phone: {
                required: true,
                minlength: 10,
                maxlength: 10,
                phoneValidation: true
            },
            phoneClient: {
                required: true,
                minlength: 10,
                maxlength: 10,
                phoneValidationCelularFijo: true
            },
            attorney: {
                required: true,
            },
            type_attorney: {
                required: true,
                required: function () {
                    return $("#attorney option:selected").val() == '1'
                }
            },
            nit_attorney: {
                required: true,
                minlength: 3,
                maxlength: 20,
                required: function () {
                    return $("#attorney option:selected").val() == '1'
                }
            },
            dv_attorney: {
                minlength: 1,
                maxlength: 1,
                required: function () {
                    return $("#attorney option:selected").val() == '1'
                }
            },
            nam_attorney_juridico: {
                required: true,
                minlength: 3,
                required: function () {
                    return $("#type_attorney option:selected").val() == '1'
                }
            },
            type_identification_attorney: {
                required: true,
                required: function () {
                    return $("#attorney option:selected").val() == '1'
                }
            },
            dni_attorney: {
                required: true,
                minlength: 3,
                maxlength: 20,
                required: function () {
                    return $("#attorney option:selected").val() == '1'
                }
            },
            nam_attorney: {
                required: true,
                minlength: 3,
                required: function () {
                    return $("#attorney option:selected").val() == '1'
                }
            },
            lastnam_attorney: {
                minlength: 3,
                required: function () {
                    return $("#attorney option:selected").val() == '1'
                }
            },
            email_attorney: {
                required: true,
                emailExt: true,
                maxlength: 150,
                required: function () {
                    return $("#attorney option:selected").val() == '1'
                }
            },
            phone_attorney: {
                required: true,
                minlength: 10,
                maxlength: 10,
                phoneValidation: true,
                required: function () {
                    return $("#attorney option:selected").val() == '1'
                }
            },
            department: {
                required: true
            },
            municipality: {
                required: true
            },
            city: {
                required: true
            },
            address_line: {
                required: true,
                minlength: 3,
                maxlength: 100,
            },
            'listProducto[]': {
                required: true,
                minlength: 1,
                required: function () {
                    return $("#conf_plan").val() != 'true'
                }
            },
            p_emision: {
                required: true,
            },
            p_recepcion: {
                required: true,
            },
            p_horas: {
                required: true,
            },
            p_rg: {
                required: true,
            },
            p_rfact: {
                required: true,
            },
            p_rclient: {
                required: true,
            },
            p_rproduct: {
                required: true,
            },
            p_rcliprod: {
                required: true,
            },
            p_rsecuen: {
                required: true,
            },
            p_rtraza: {
                required: true,
            },
            p_dpdf: {
                required: true,
            },
            p_rarch: {
                required: true,
            },
            p_csv: {
                required: true,
            },
            p_gmanual: {
                required: true,
            },
            cant_folios_1: {
                required: function () {
                    return $("#cat_producto_1").prop('checked')
                }
            },
            type_portal_1: {
                required: function () {
                    return $("#cat_producto_1").prop('checked')
                }
            },
            cant_folios_2: {
                required: function () {
                    return $("#cat_producto_2").prop('checked')
                }
            },
            type_portal_2: {
                required: function () {
                    return $("#cat_producto_2").prop('checked')
                }
            },
            cant_folios_3: {
                required: function () {
                    return $("#cat_producto_3").prop('checked')
                }
            },
            type_portal_3: {
                required: function () {
                    return $("#cat_producto_3").prop('checked')
                }
            },
            'listPlan[]': {
                required: true,
                minlength: 1,
                required: function () {
                    return $("#conf_plan").val() != 'true'
                }
            },
            'listTransaccion[]': {
                required: true,
                minlength: 1,
                required: function () {
                    return $("#conf_plan").val() != 'true'
                }
            },
            'listServicio[]': {
                required: true,
                minlength: 1,
                required: function () {
                    return $("#conf_plan").val() != 'true'
                }
            },
            cat_type_taxpayer: {
                required: true,
            },
            cat_method: {
                required: true,
            },
            vendor: {
                required: true,
                minlength: 3,
                maxlength: 100,
            },
            code_agency: {
                required: true,
                minlength: 2,
                maxlength: 10,
            },
            type_format_linkage: {
                required: true,
            },
            time_format_linkage: {
                required: true,
            },
            cant_folios_e: {
                required: true,
                minlength: 1,
                maxlength: 6,
            },
            cant_folios_r: {
                required: true,
                minlength: 1,
                maxlength: 6,
            },
            cant_folios_n: {
                required: true,
                minlength: 1,
                maxlength: 6,
            },

        },
        errorPlacement: function (error, element) {
            $(element).parent('div').addClass('has-error');
        }
    });

    // Wizard Initialization
    $('.wizard-card').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'nextSelector': '.btn-next',
        'previousSelector': '.btn-previous',

        onNext: function (tab, navigation, index) {
            var $valid = $('.wizard-card form').valid();
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
            $(".tab_edit").show();
        },

        onInit: function (tab, navigation, index) {
            //check number of tabs and fill the entire row
            var $total = navigation.find('li').length;
            var $wizard = navigation.closest('.wizard-card');

            $first_li = navigation.find('li:first-child a').html();
            $moving_div = $('<div class="moving-tab">' + $first_li + '</div>');
            $('.wizard-card .wizard-navigation').append($moving_div);

            refreshAnimation($wizard, index);

            $('.moving-tab').css('transition', 'transform 0s');
        },

        onTabClick: function (tab, navigation, index) {
            var $valid = $('.wizard-card form').valid();

            if (!$valid) {
                return false;
            } else {
                return true;
            }
        },

        onTabShow: function (tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;
            var i = 0;
            while (i < $total) {
                if (i < $current) {
                    $('.tab_' + i).addClass("previous-tabs");
                } else {
                    $('.tab_' + i).removeClass("previous-tabs");
                }
                i++;
            }

            var $wizard = navigation.closest('.wizard-card');

            // If it's the last tab then hide the last button and show the finish instead
            $('#captcha').hide();
            $($wizard).find('#firmar').hide();
            $($wizard).find('#edit_propuesta').hide();
            $($wizard).find('#download').hide();
            $($wizard).find('#update').hide();
            $($wizard).find('#valid').hide();
            $($wizard).find('#valid_opt').hide();
            $($wizard).find('#next_cplan').hide();
            if ($current == ($total - 2)) {
                $($wizard).find('#search_plan').hide();
                $($wizard).find('#search').hide();
                if ($('#agency').val() != 'true') {
                    $($wizard).find('#next').hide();
                    $($wizard).find('#valid_vendor').show();
                } else {
                    $($wizard).find('#next').show();
                    $($wizard).find('#valid_vendor').hide();
                }
            } else if ($current == ($total - 1)) {

                $($wizard).find('#enviar').hide();
                if ($('#conf_plan').val() == 'true') {
                    $($wizard).find('#next').show();
                    $($wizard).find('#search_plan').hide();
                } else {
                    $($wizard).find('#next').hide();
                    $($wizard).find('#next_cplan').hide();
                    $($wizard).find('#search_plan').show();
                }
            } else if ($current == ($total - 3)) {
                $($wizard).find('#valid_vendor').hide();
                $($wizard).find('#next').show();
            } else if ($current == ($total - 4)) {
                $($wizard).find('#enviar').hide();
                $($wizard).find('#finish_attorney').hide();
                $($wizard).find('#valid_vendor').hide();
                $($wizard).find('#search_plan').hide();
                if ($('#id_type_person').val() == '') {
                    $($wizard).find('#next').hide();
                    $($wizard).find('#search').show();
                } else {
                    $($wizard).find('#next').show();
                    $($wizard).find('#search').hide();
                }
            } else if ($current >= $total) {
                $($wizard).find('#next').hide();
                $($wizard).find('#search').hide();
                $($wizard).find('#finish_attorney').hide();
                $($wizard).find('#search_plan').hide();
                $('#update').show();
                $('#captcha').show();

                $($wizard).find('#valid_vendor').hide();
                capturar();
            } else {
                $($wizard).find('#edit_propuesta').show();
                $($wizard).find('#enviar').show();
                $('#download').hide();
                $($wizard).find('#next').hide();
                $($wizard).find('#firmar').hide();
                $($wizard).find('#search').hide();
                $($wizard).find('#finish_attorney').hide();
                $($wizard).find('#search_plan').hide();
                $($wizard).find('#next_cplan').hide();
                $($wizard).find('#valid_vendor').hide();
            }

            button_text = navigation.find('li:nth-child(' + $current + ') a').html();

            setTimeout(function () {
                $('.moving-tab').text(button_text);
            }, 150);

            var checkbox = $('.footer-checkbox');

            if (!index == 0) {
                $(checkbox).css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'position': 'absolute'
                });
            } else {
                $(checkbox).css({
                    'opacity': '1',
                    'visibility': 'visible'
                });
            }

            refreshAnimation($wizard, index);
        }
    });


    // Prepare the preview for profile picture
    $("#wizard-picture").change(function () {
        readURL(this);
    });

    $('[data-toggle="wizard-radio"]').click(function () {
        wizard = $(this).closest('.wizard-card');
        wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
        $(this).addClass('active');
        $(wizard).find('[type="radio"]').removeAttr('checked');
        $(this).find('[type="radio"]').attr('checked', 'true');
    });

    $('[data-toggle="wizard-checkbox"]').click(function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).find('[type="checkbox"]').removeAttr('checked');
        } else {
            $(this).addClass('active');
            $(this).find('[type="checkbox"]').attr('checked', 'true');
        }
    });

    $('.set-full-height').css('height', 'auto');

});



//Function to show image before upload

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(window).resize(function () {
    $('.wizard-card').each(function () {
        $wizard = $(this);

        index = $wizard.bootstrapWizard('currentIndex');
        refreshAnimation($wizard, index);

        $('.moving-tab').css({
            'transition': 'transform 0s'
        });
    });
});

function refreshAnimation($wizard, index) {
    $total = $wizard.find('.nav li').length;
    $li_width = 100 / $total;

    total_steps = $wizard.find('.nav li').length;
    move_distance = $wizard.width() / total_steps;
    index_temp = index;
    vertical_level = 0;

    mobile_device = $(document).width() < 600 && $total > 3;

    if (mobile_device) {
        move_distance = $wizard.width() / 2;
        index_temp = index % 2;
        $li_width = 50;
    }

    $wizard.find('.nav li').css('width', $li_width + '%');

    step_width = move_distance;
    move_distance = move_distance * index_temp;

    $current = index + 1;

    if ($current == 1 || (mobile_device == true && (index % 2 == 0))) {
        move_distance -= 8;
    } else if ($current == total_steps || (mobile_device == true && (index % 2 == 1))) {
        move_distance += 8;
    }

    if (mobile_device) {
        vertical_level = parseInt(index / 2);
        vertical_level = vertical_level * 38;
    }

    $wizard.find('.moving-tab').css('width', step_width);
    $('.moving-tab').css({
        'transform': 'translate3d(' + move_distance + 'px, ' + vertical_level + 'px, 0)',
        'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'

    });
}

materialDesign = {

    checkScrollForTransparentNavbar: debounce(function () {
        if ($(document).scrollTop() > 260) {
            if (transparent) {
                transparent = false;
                $('.navbar-color-on-scroll').removeClass('navbar-transparent');
            }
        } else {
            if (!transparent) {
                transparent = true;
                $('.navbar-color-on-scroll').addClass('navbar-transparent');
            }
        }
    }, 17)

}

function debounce(func, wait, immediate) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        }, wait);
        if (immediate && !timeout) func.apply(context, args);
    };
};

jQuery.fn.ForceNumericOnly =
    function () {
        return this.each(function () {
            $(this).keydown(function (e) {
                var key = e.charCode || e.keyCode || 0;
                // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                // home, end, period, and numpad decimal
                return (
                    key == 8 ||
                    key == 9 ||
                    key == 13 ||
                    key == 46 ||
                    key == 110 ||
                    key == 190 ||
                    (key >= 35 && key <= 40) ||
                    (key >= 48 && key <= 57) ||
                    (key >= 96 && key <= 105));
            });
        });
    };

function validaNumeros(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) return true;
    patron = /\d/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}


$('.AlphabetsOnly').keypress(function (e) {
    var regex = new RegExp(/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/);
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    else {
        e.preventDefault();
        return false;
    }
});

$('#representative_doc_attach').fileinput({
    showUpload: false,
    language: 'es',
    maxFileSize: 2000,
    browseOnZoneClick: true,
    allowedFileExtensions: ['pdf']
});

$('#attorney_doc_attach').fileinput({
    showUpload: false,
    language: 'es',
    maxFileSize: 2000,
    browseOnZoneClick: true,
    allowedFileExtensions: ['pdf']
});

$('#rut_attachment').fileinput({
    showUpload: false,
    language: 'es',
    maxFileSize: 2000,
    browseOnZoneClick: true,
    allowedFileExtensions: ['pdf']
});

$('#rut_attorney').fileinput({
    showUpload: false,
    language: 'es',
    maxFileSize: 2000,
    browseOnZoneClick: true,
    allowedFileExtensions: ['pdf']
});

$('#payment_support').fileinput({
    showUpload: false,
    language: 'es',
    maxFileSize: 2000,
    browseOnZoneClick: true,
    allowedFileExtensions: ['pdf']
});

$('#chamber_commerce').fileinput({
    showUpload: false,
    language: 'es',
    maxFileSize: 2000,
    browseOnZoneClick: true,
    allowedFileExtensions: ['pdf']
});

$('#chamber_commerce_attorney').fileinput({
    showUpload: false,
    language: 'es',
    maxFileSize: 2000,
    browseOnZoneClick: true,
    allowedFileExtensions: ['pdf']
});

$('#power_attorney').fileinput({
    showUpload: false,
    language: 'es',
    maxFileSize: 2000,
    browseOnZoneClick: true,
    allowedFileExtensions: ['pdf']
});

$('#trusted_document').fileinput({
    showUpload: false,
    language: 'es',
    maxFileSize: 2000,
    browseOnZoneClick: true,
    allowedFileExtensions: ['pdf']
});

$('#link_format').fileinput({
    showUpload: false,
    language: 'es',
    maxFileSize: 2000,
    browseOnZoneClick: true,
    allowedFileExtensions: ['pdf']
});

