let selects = document.querySelectorAll("select.form-control");

selects.forEach((select) => {
    select.addEventListener('change', function () {
        if (getAttribute(this, 'data-ajax')) {
            if ($(this).attr("name") == 'department') {
                actualizarListMunicipality(this);
            } else {
                actualizarLista(this);
            }

        }
    });
});

function actualizarLista(element) {

    let dataList = getDataList(element);
    let htmlOption = `<option selected disabled value =""></option>`;
    dataList.then((json) => {
        json.forEach((item, index, object) => {
            let { id, descripcion } = item;
            htmlOption += `<option value ="${id}">${descripcion}</option>`;
        });
        document.querySelector(element.getAttribute('data-search')).innerHTML = htmlOption;
    });
}

function actualizarListMunicipality(element) {

    let dataList = getDataList(element);
    let htmlOption = `<option selected disabled value =""></option>`;
    dataList.then((json) => {
        json.forEach((item, index, object) => {
            let { id, description } = item;
            htmlOption += `<option value ="${id}">${description}</option>`;
        });
        document.querySelector(element.getAttribute('data-search')).innerHTML = htmlOption;
    });
}

function getAttribute(element, attr) {
    return element.getAttribute(attr) !== null;
}

async function getDataList(element) {
    let headerReq = new Headers();
    headerReq.append('Content-Type', 'text/json');
    headerReq.append('X-Requested-With', 'XMLHttpRequest');
    let paramsHeader = {
        method: 'GET',
        headers: headerReq
    };

    let url = `${element.getAttribute('data-url')}/${element.value}`;
    if (getAttribute(element, 'data-depends')) {
        url += `/` + document.querySelector(element.getAttribute('data-depends')).value;
    }
    let response = await fetch(url, paramsHeader);
    let data = await response.json();
    return data.data;
};

function typeFormatSelect(val) {
    var typesFormatSelect = $('#type_format_linkage');
    typesFormatSelect.empty();
    typesFormatSelect.append("<option selected disabled value=''></option>");
    $.ajax({
        url: 'typeFormat',
        type: 'GET',
        data: { val: val },
        dataType: 'json',
        success: function (response) {
            $.each(response.data, function (key, value) {
                typesFormatSelect.append("<option value='" + key + "'>" + value + "</option>");
            });
        },
        error: function () {
            console.log('Hubo un error obteniendo las formatos!');
        }
    });
}

function formatearMoneda($valor) {
    return new Intl.NumberFormat(['ban', 'id']).format($valor);
}

document.addEventListener('DOMContentLoaded', function () {
    // Campo de NIT y dígito de verificación
    let nitInput = document.getElementById('dni');
    let digitoVerificacionInput = document.getElementById('dv');

    // Evento para calcular el dígito de verificación cuando el campo de NIT cambia
    nitInput.addEventListener('input', function () {
        let nitValue = nitInput.value.replaceAll(" ", '');

        // Validar que el NIT sea un número positivo entero
        let isNitValid = /^\d+$/.test(nitValue);

        // Si es un número, calcular el dígito de verificación y actualizar el campo correspondiente
        if (isNitValid) {
            digitoVerificacionInput.value = calcularDigitoVerificacion(nitValue);
            $('#div_dv').removeClass("is-empty");
            $('#div_opt_cliente').removeClass("is-empty");
        } else {
            // Limpiar el campo de dígito de verificación si el NIT no es válido
            $('#div_dv').addClass("is-empty");
            digitoVerificacionInput.value = '';
        }
    });
});

// Función para calcular el dígito de verificación del NIT
function calcularDigitoVerificacion(myNit) {
    var vpri, x, y, z;

    vpri = new Array(16);
    z = myNit.length;

    vpri[1] = 3;
    vpri[2] = 7;
    vpri[3] = 13;
    vpri[4] = 17;
    vpri[5] = 19;
    vpri[6] = 23;
    vpri[7] = 29;
    vpri[8] = 37;
    vpri[9] = 41;
    vpri[10] = 43;
    vpri[11] = 47;
    vpri[12] = 53;
    vpri[13] = 59;
    vpri[14] = 67;
    vpri[15] = 71;

    x = 0;
    y = 0;

    // Ciclo para calcular el producto de cada dígito por su peso
    for (var i = 0; i < z; i++) {
        y = myNit.substr(i, 1);
        x += y * vpri[z - i];
    }

    // Cálculo del residuo
    y = x % 11;

    // Determinar el dígito de verificación
    return y > 1 ? 11 - y : y;
}

function capturar() {

    $('.PropuestaCondiciones').hide();
    document.getElementById("condicionesCompra").innerHTML = '';
    $('.planSlect').each(function () {
        if ($(this).is(':checked')) {
            var valor = $(this).val();
            $.ajax({
                url: "/condicionesCompra/" + valor,
                method: "GET",
                beforeSend: function () {
                    $('.gift_loading').css('display', 'block');
                },
                complete: function () {
                    $('.gift_loading').css('display', 'none');
                },
                success: function (response) {
                    document.getElementById("condicionesCompra").innerHTML += response;
                    $('.PropuestaCondiciones').show();
                },
                error: function (error) {
                    $('.PropuestaCondiciones').hide();
                    console.log(error);
                }
            });
            console.log(valor);
        }
    });

    $('.signed').show();
    $('.Opt').hide();
    $('#opt').val('');
    const fecha = new Date();
    var year = fecha.getFullYear();
    var month = fecha.getMonth() + 1;
    var meses = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
    var diasMes = new Date(year, month, 0).getDate();


    var clientExist = document.getElementById("exist_client").value;

    var opction = document.getElementById("type_person").value;
    var namemptresa = document.getElementById("nam_enterprise").value;
    var lastnamemptresa = document.getElementById("lastnam_enterprise").value;
    if(opction == 1){
        var namerepres = document.getElementById("nam_rep").value;
        var lastnamerepre = document.getElementById("lastnam_rep").value;
    }else{
        var namerepres = document.getElementById("nam_enterprise").value;
        var lastnamerepre = document.getElementById("lastnam_enterprise").value;
    }

    var rut = +document.getElementById("dni").value;
    var department = $("#department option:selected").html();
    var municipality = $('#municipality option:selected').html();
    var direccion = document.getElementById("address_line").value;
    var medioAdquisicion = document.getElementById("cat_method").value;
    var codeAgencia = document.getElementById("code_agency").value;
    var vendor = document.getElementById("vendor").value;
    var cod_acronym = document.getElementById("type_identification_rep").value;
    var ced = document.getElementById("dni_rep").value;
    var emailRepLegal = document.getElementById("email").value;
    var emailPagos = document.getElementById("email_fac").value;
    var emailFacturas = document.getElementById("email_rad").value;
    var telefono = document.getElementById("phone").value;
    var subtotal = document.getElementById("monto").value;
    var iva = document.getElementById("iva").value;
    var reteICA = document.getElementById("reteICA").value;
    var reteIVA = document.getElementById("reteIVA").value;
    var reteFuente = document.getElementById("reteFuente").value;
    var totalPagar = document.getElementById("aPagar").value;
    var type_taxpayer = $('#cat_type_taxpayer option:selected').html();
    var planEmision = $('#name_plan_emision').html();
    var descPlanEmision = document.getElementById("desc_plan_emision").value;
    var detallePlanFacturacion = document.getElementById("cant_folios_1").value;
    var detallePlanNomina = document.getElementById("cant_folios_2").value;

    var priceEmision = $('#price_plan_emision').html();
    var planRecepcion = $('#name_plan_recepcion').html();
    var descPlanRecepcion = document.getElementById("desc_plan_recepcion").value;
    var detallePlanRecepcion = document.getElementById("cant_folios_3").value;
    var planPortalRecepcion = $('#name_portal_recepcion').html();
    var descPlanPortalRecepcion = document.getElementById("desc_portal_recepcion").value;
    var pricePortalRecepcion = $('#price_portal_recepcion').html();
    var planHoras = $('#name_plan_horas').html();
    var descPlanHoras = document.getElementById('desc_plan_horas').value;
    var priceHoras = $('#price_plan_horas').html();
    var nfpriceHoras = document.getElementById('plan_horas_sin_formato').value;
    var priceRecepcion = $('#price_plan_recepcion').html();

    var planCertificado = $('#name_plan_certificado').html();
    var descPlanCertificado = document.getElementById('desc_plan_certificado').value;
    var priceCertificado = $('#price_plan_certificado').html();

    var planRG = $('#name_plan_rg').html();
    var descPlanRG = document.getElementById('desc_plan_rg').value;
    var priceRG = $('#price_plan_rg').html();
    var nfpriceRG = document.getElementById('plan_rg_sin_formato').value;
    var planRgPlantilla = $('#name_plan_plantilla').html();
    var descPlanRgPlantilla = document.getElementById('desc_plan_plantilla').value;
    var priceRgPlantilla = $('#price_plan_plantilla').html();
    var nfpriceRgPlantilla = document.getElementById('plan_plantilla_sin_formato').value;
    var planRgMod = $('#name_plan_rg_mod').html();
    var descPlanRgMod = document.getElementById('desc_plan_rg_mod').value;
    var priceRgMod = $('#price_plan_rg_mod').html();
    var planRFactura = $('#name_plan_rfact').html();
    var descPlanRFactura = document.getElementById('desc_plan_rfact').value;
    var priceRFactura = $('#price_plan_rfact').html();
    var planRClientes = $('#name_plan_rclient').html();
    var descPlanRClientes = document.getElementById('desc_plan_rclient').value;
    var priceRClientes = $('#price_plan_rclient').html();

    var planRProduct = $('#name_plan_rproduct').html();
    var descPlanRProduct = document.getElementById('desc_plan_rproduct').value;
    var priceRProduct = $('#price_plan_rproduct').html();
    var planRCliProc = $('#name_plan_rcliprod').html();
    var descPlanRCliProc = document.getElementById('desc_plan_rcliprod').value;
    var priceRCliProc = $('#price_plan_rcliprod').html();
    var planRSecuen = $('#name_plan_rsecuen').html();
    var descPlanRSecuen = document.getElementById('desc_plan_rsecuen').value;
    var priceRSecuen = $('#price_plan_rsecuen').html();

    var planRTraza = $('#name_plan_rtraza').html();
    var descPlanRTraza = document.getElementById('desc_plan_rtraza').value;
    var priceRTraza = $('#price_plan_rtraza').html();
    var planDPdf = $('#name_plan_dpdf').html();
    var descPlanDPdf = document.getElementById('desc_plan_dpdf').value;
    var priceDPdf = $('#price_plan_dpdf').html();
    var planRArch = $('#name_plan_rarch').html();
    var descPlanRArch = document.getElementById('desc_plan_rarch').value;
    var priceRArch = $('#price_plan_rarch').html();

    var planCSV = $('#name_plan_csv').html();
    var descPlanCSV = document.getElementById('desc_plan_csv').value;
    var priceCSV = $('#price_plan_csv').html();
    var planGManual = $('#name_plan_gmanual').html();
    var descPlanGManual = document.getElementById('desc_plan_gmanual').value;
    var priceGManual = $('#price_plan_gmanual').html();
    var listaDocs = "";
    var clienteTipoExpediente = "";


    if (clientExist == 'true') {
        clienteTipoExpediente = "Cliente recompra";
        if (opction == 1) {
            if ($('#cat_producto_4').is(":checked")) {
                listaDocs = "<li>Cédula del Representante Legal</li>" +
                    "<li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>" +
                    "<li>Certificado de existencia y representación legal u otro documento que justifique la representación legal de la empresa (fecha de expedición no mayor a 60 días)</li>" +
                    "<li>Soporte de Pago.</li>";
            } else {
                listaDocs = "<li>Soporte de Pago.</li>";
            }
        } else {
            if ($('#cat_producto_4').is(":checked")) {
                listaDocs = "<li>Cédula del Representante Legal</li>" +
                    "<li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>" +
                    "<li>Carta de Solicitud del Certificado Digital notariada (fecha de autenticación no mayor a 60 días)</li>" +
                    "<li>Soporte de Pago.</li>";
            } else {
                listaDocs = "<li>Soporte de Pago.</li>";
            }
        }
    } else {
        clienteTipoExpediente="Cliente nuevo";
        if (opction == 1) {
            listaDocs = " <li>Cédula del Representante Legal</li>" +
                "<li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>" +
                "<li>Certificado de existencia y representación legal u otro documento que justifique la representación legal de la empresa (fecha de expedición no mayor a 60 días)</li>" +
                "<li>Soporte de Pago.</li>";
        } else {
            listaDocs = "<li>Cédula del Representante Legal</li>" +
                "<li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>" +
                "<li>Carta de Solicitud del Certificado Digital notariada (fecha de autenticación no mayor a 60 días)</li>" +
                "<li>Soporte de Pago.</li>";
        }
    }



    var acronym = ''
    if (cod_acronym == 1) {
        var acronym = 'NIT'
    } else if (cod_acronym == 2) {
        var acronym = 'C.C.'
    } else if (cod_acronym == 3) {
        var acronym = 'T.E.'
    } else if (cod_acronym == 4) {
        var acronym = 'R.C.'
    } else if (cod_acronym == 5) {
        var acronym = 'T.I.'
    } else if (cod_acronym == 6) {
        var acronym = 'C.E.'
    } else if (cod_acronym == 7) {
        var acronym = 'P.A.'
    } else if (cod_acronym == 8) {
        var acronym = 'D.E.'
    } else if (cod_acronym == 9) {
        var acronym = 'NIT-E'
    } else if (cod_acronym == 10) {
        var acronym = 'P.C'
    } else if (cod_acronym == 11) {
        var acronym = 'P.P.T'
    }


    if (opction == 2) {
        namemptresa = namemptresa + ' ' + lastnamemptresa
    }

    document.getElementById("valDesde").innerHTML = '1-' + meses[month - 1] + '-' + year;
    document.getElementById("valHasta").innerHTML = diasMes + '-' + meses[month - 1] + '-' + year;
    var razonSocial = document.getElementsByClassName("razonSocial");
    for (var i = 0; i < razonSocial.length; i++) {
        var rs = razonSocial[i];
        rs.innerHTML = namemptresa;
    }
    var numNit = document.getElementsByClassName("numNit");
    for (var i = 0; i < numNit.length; i++) {
        var nit = numNit[i];
        nit.innerHTML = rut;
    }
    var repLegal = document.getElementsByClassName("repLegal");
    for (var i = 0; i < repLegal.length; i++) {
        var rl = repLegal[i];
        rl.innerHTML = namerepres + ' ' + lastnamerepre;
    }
    var correolRepLegal = document.getElementsByClassName("emailRepLegal");
    for (var i = 0; i < correolRepLegal.length; i++) {
        var emailRL = correolRepLegal[i];
        emailRL.innerHTML = emailRepLegal;
    }
    document.getElementById("emailPagos").innerHTML = emailPagos;
    document.getElementById("emailFacturas").innerHTML = emailFacturas;
    var telfRL = document.getElementsByClassName("telefono");
    for (var i = 0; i < telfRL.length; i++) {
        var telRL = telfRL[i];
        telRL.innerHTML = telefono;
    }
    var departamento = document.getElementsByClassName("departamento");
    for (var i = 0; i < departamento.length; i++) {
        var depto = departamento[i];
        depto.innerHTML = department;
    }
    var municipio = document.getElementsByClassName("municipio");
    for (var i = 0; i < municipio.length; i++) {
        var mun = municipio[i];
        mun.innerHTML = municipality;
    }
    var dirEmpresa = document.getElementsByClassName("direccion");
    for (var i = 0; i < dirEmpresa.length; i++) {
        var dir = dirEmpresa[i];
        dir.innerHTML = direccion;
    }

    var typeDoc = document.getElementsByClassName("typeDoc");
    for (var i = 0; i < typeDoc.length; i++) {
        var typeDocRL = typeDoc[i];
        typeDocRL.innerHTML = acronym;
    }
    var docRL = document.getElementsByClassName("docRL");
    for (var i = 0; i < docRL.length; i++) {
        var numDocRL = docRL[i];
        numDocRL.innerHTML = ced;
    }

    document.getElementById("tipoContribuyente").innerHTML = type_taxpayer;
    document.getElementById("clienteTipoExpediente").innerHTML = clienteTipoExpediente;
    document.getElementById("medioAdquisicion").innerHTML = medioAdquisicion;
    document.getElementById("codeAgencia").innerHTML = codeAgencia;
    document.getElementById("nameVendor").innerHTML = vendor;
    document.getElementById("planEmision").innerHTML = planEmision;
    document.getElementById("descPlanEmision").innerHTML = descPlanEmision;
    let detPlanFactura = $('#cat_producto_1').prop('checked');
    let detPlanNomina = $('#cat_producto_2').prop('checked');
    if (detPlanFactura && detPlanNomina) {
        document.getElementById("detallePlanEmision").innerHTML = 'Folios Facturación: ' + detallePlanFacturacion + '<br>Folios Nómina: ' + detallePlanNomina;
    } else if (!detPlanFactura && detPlanNomina) {
        document.getElementById("detallePlanEmision").innerHTML = 'Folios Nómina: ' + detallePlanNomina;
    } else if (detPlanFactura && !detPlanNomina) {
        document.getElementById("detallePlanEmision").innerHTML = 'Folios Facturación: ' + detallePlanFacturacion;
    }
    document.getElementById("priceEmision").innerHTML = priceEmision;
    document.getElementById("tPriceEmision").innerHTML = priceEmision;
    document.getElementById("planRecepcion").innerHTML = planRecepcion;
    document.getElementById("descPlanRecepcion").innerHTML = descPlanRecepcion;
    document.getElementById("detallePlanRecepcion").innerHTML = 'Folios Recepción: ' + detallePlanRecepcion;
    document.getElementById("priceRecepcion").innerHTML = priceRecepcion;
    document.getElementById("portalRecepcion").innerHTML = planPortalRecepcion;
    document.getElementById("descPortalRecepcion").innerHTML = descPlanPortalRecepcion;
    document.getElementById("pricePortalRecepcion").innerHTML = pricePortalRecepcion;
    document.getElementById("tPricePortalRecepcion").innerHTML = pricePortalRecepcion;
    document.getElementById("tPriceRecepcion").innerHTML = priceRecepcion;
    document.getElementById("planHoras").innerHTML = planHoras;
    document.getElementById("descPlanHoras").innerHTML = descPlanHoras;
    document.getElementById("priceHoras").innerHTML = formatearMoneda(nfpriceHoras / $('#cant_folios_serComplentario_1').val());
    document.getElementById("tPriceHoras").innerHTML = priceHoras;
    document.getElementById("planCert").innerHTML = planCertificado;
    document.getElementById("descPlanCert").innerHTML = descPlanCertificado;
    document.getElementById("priceCert").innerHTML = priceCertificado;
    document.getElementById("tPriceCert").innerHTML = priceCertificado;
    document.getElementById("planRG").innerHTML = planRG;
    document.getElementById("descPlanRG").innerHTML = descPlanRG;
    document.getElementById("priceRG").innerHTML = formatearMoneda(nfpriceRG / $('#cant_type_rg_241').val());
    document.getElementById("tPriceRG").innerHTML = priceRG;
    document.getElementById("planRgPlantilla").innerHTML = planRgPlantilla;
    document.getElementById("descPlanRgPlantilla").innerHTML = descPlanRgPlantilla;
    document.getElementById("priceRgPlantilla").innerHTML = formatearMoneda(nfpriceRgPlantilla / $('#cant_type_rg_2').val());
    document.getElementById("tPriceRgPlantilla").innerHTML = priceRgPlantilla;
    document.getElementById("planRgMod").innerHTML = planRgMod;
    document.getElementById("descPlanRgMod").innerHTML = descPlanRgMod;
    document.getElementById("priceRgMod").innerHTML = priceRgMod;
    document.getElementById("tPriceRgMod").innerHTML = priceRgMod;
    document.getElementById("planRFactura").innerHTML = planRFactura;
    document.getElementById("descPlanRFactura").innerHTML = descPlanRFactura;
    document.getElementById("priceRFactura").innerHTML = priceRFactura;
    document.getElementById("tPriceRFactura").innerHTML = priceRFactura;
    document.getElementById("planRClientes").innerHTML = planRClientes;
    document.getElementById("descPlanRClientes").innerHTML = descPlanRClientes;
    document.getElementById("priceRClientes").innerHTML = priceRClientes;
    document.getElementById("tPriceRClientes").innerHTML = priceRClientes;
    document.getElementById("planRProduct").innerHTML = planRProduct;
    document.getElementById("descPlanRProduct").innerHTML = descPlanRProduct;
    document.getElementById("priceRProduct").innerHTML = priceRProduct;
    document.getElementById("tPriceRProduct").innerHTML = priceRProduct;

    document.getElementById("planRCliProc").innerHTML = planRCliProc;
    document.getElementById("descPlanRCliProc").innerHTML = descPlanRCliProc;
    document.getElementById("priceRCliProc").innerHTML = priceRCliProc;
    document.getElementById("tPriceRCliProc").innerHTML = priceRCliProc;

    document.getElementById("planRSecuen").innerHTML = planRSecuen;
    document.getElementById("descPlanRSecuen").innerHTML = descPlanRSecuen;
    document.getElementById("priceRSecuen").innerHTML = priceRSecuen;
    document.getElementById("tPriceRSecuen").innerHTML = priceRSecuen;

    document.getElementById("planRTraza").innerHTML = planRTraza;
    document.getElementById("descPlanRTraza").innerHTML = descPlanRTraza;
    document.getElementById("priceRTraza").innerHTML = priceRTraza;
    document.getElementById("tPriceRTraza").innerHTML = priceRTraza;

    document.getElementById("planDPdf").innerHTML = planDPdf;
    document.getElementById("descPlanDPdf").innerHTML = descPlanDPdf;
    document.getElementById("priceDPdf").innerHTML = priceDPdf;
    document.getElementById("tPriceDPdf").innerHTML = priceDPdf;

    document.getElementById("planRArch").innerHTML = planRArch;
    document.getElementById("descPlanRArch").innerHTML = descPlanRArch;
    document.getElementById("priceRArch").innerHTML = priceRArch;
    document.getElementById("tPriceRArch").innerHTML = priceRArch;
    document.getElementById("planCSV").innerHTML = planCSV;
    document.getElementById("descPlanCSV").innerHTML = descPlanCSV;
    document.getElementById("priceCSV").innerHTML = priceCSV;
    document.getElementById("tPriceCSV").innerHTML = priceCSV;

    document.getElementById("planGManual").innerHTML = planGManual;
    document.getElementById("descPlanGManual").innerHTML = descPlanGManual;
    document.getElementById("priceGManual").innerHTML = priceGManual;
    document.getElementById("tPriceGManual").innerHTML = priceGManual;

    document.getElementById("subtotal").innerHTML = formatearMoneda(subtotal);
    document.getElementById("totalIva").innerHTML = formatearMoneda(iva);
    document.getElementById("totalReteIca").innerHTML = formatearMoneda(reteICA);
    document.getElementById("totalReteIva").innerHTML = formatearMoneda(reteIVA);
    document.getElementById("totalReteFuente").innerHTML = formatearMoneda(reteFuente);
    document.getElementById("totalPagar").innerHTML = formatearMoneda(totalPagar);
    document.getElementById("listaDocs").innerHTML = listaDocs;
};

function search() {
    $("#res-search").html('');
    $("#res-valid_opt").html('');
    $('.orders_exist').hide();
    $('.client').hide();
    $(".OptCliente").hide();
    $('#opt_cliente').val('');
    $('.producto_4').show();
    if ($('#id_type_person').val() == '') {
        $('.hidden').val('');
    }
    if ($('#type_person option:selected').val() == '') {
        $('#div_type_person').addClass('has-error');
        $("#type_person").focus();
        return false;
    }
    if ($('#dni').val() == '') {
        $('#div_dni').addClass('has-error');
        $("#dni").focus();
        return false;
    }
    if ($('#dv').val() == '') {
        $('#div_dv').addClass('has-error');
        $("#dv").focus();
        return false;
    }
    var form = $('#cliente').get(0);
    console.log(form);
    var fd = new FormData(form);
    $.ajax({

        url: 'search',
        type: 'POST',
        dataType: 'json',
        data: fd,
        beforeSend: function () {
            $('#search').hide();
            $('.gift_loading').css('display', 'block');
            $('.loader-search').fadeIn();
        },
        complete: function () {
            $('.gift_loading').css('display', 'none');
            $('.loader-search').fadeOut();
        },
        success: function (data) {
            if (data.result == 0) {
                if (data.code != 403) {
                    $('.client').show();
                    $('#exist_client').val('false');
                    $('#documents').show();
                    if (data.code == 200) {
                        $("#res-search").html(data.errors);
                    }
                    $('#valid').show();
                } else {
                    $("#res-search").html(data.errors);
                }
            } else {
                $('#user').val(data.otp_user_key);
                $("#documents").hide();
                $('#exist_client').val('true');
                $("#rut_1").trigger("reset");
                $("#chamber_commerce_1").trigger("reset");
                $('.change_rep').prop("readonly", true);
                $('#type_identification_rep').attr("style", "pointer-events: none;");
                $('#id_client').val(data.enterprise.id);
                if (data.detalles != '') {
                    $('#next').hide();
                    $('.orders_exist').show();
                    $("#res-detalles").html(data.detalles);
                } else {
                    $('.client').show();
                }
                if (data.enterprise.person_type == 1) {
                    $(".Juridico").show();
                    $(".Natural").hide();
                    $('#nam_enterprise').val(data.enterprise.name_socialreason);
                    $('#enterprise_nam').removeClass("is-empty");
                    if (data.enterprise.comercial_name) {
                        $('#lastnam_enterprise').val(data.enterprise.comercial_name);
                        $('#enterprise_lastnam').removeClass("is-empty");
                    } else {
                    }
                    $('#nam_rep').val(data.Representative.nombre);
                    $('#rep_nam').removeClass("is-empty");
                    $('#lastnam_rep').val(data.Representative.apellido);
                    $('#rep_lastnam').removeClass("is-empty");
                } else {
                    $(".Juridico").hide();
                    $(".Natural").show();
                    $('#nam_enterprise').val(data.Representative.nombre);
                    $('#enterprise_nam').removeClass("is-empty");
                    $('#lastnam_enterprise').val(data.Representative.apellido);
                    $('#enterprise_lastnam').removeClass("is-empty");
                }
                $("#type_identification_rep").val(data.Representative.tipo_identificacion);
                $('#rep_type_identification').removeClass("is-empty");
                $('#dni_rep').val(data.Representative.identificacion);
                $('#id_rep').val(data.Representative.id);
                $('#rep_dni').removeClass("is-empty");
                $('#email').val(data.Representative.email);
                $('#rep_email').removeClass("is-empty");
                $('#email_fac').val(data.enterprise.email_billing_contact);
                $('#fac_email').removeClass("is-empty");
                $('#email_rad').val(data.enterprise.email_invoices);
                $('#rad_email').removeClass("is-empty");
                if (data.enterprise.email_optional) {
                    $('#email_op').val(data.enterprise.email_optional);
                    $('#op_email').removeClass("is-empty");
                } else {
                    $('#email_op').val('');
                }
                $('#phone').val(data.Representative.telefono);
                $('#rep_phone').removeClass("is-empty");
                $('#phoneClient').val(data.enterprise.phone);
                $('#client_phone').removeClass("is-empty");
                if (data.Attorney) {
                    $("#remove_attorney").show();
                    $('#id_attorney').val(data.Attorney.id);
                    $('.remove_attorney').prop("readonly", true);
                    $('#type_attorney').attr("style", "pointer-events: none;");
                    $('#type_identification_attorney').attr("style", "pointer-events: none;");
                    $("#attorney").val('1');
                    $('#is_attorney').removeClass("is-empty");
                    $("#type_attorney").val(data.Attorney.tipo_persona);
                    $('#attorney_type').removeClass("is-empty");
                    $('#nit_attorney').val(data.Attorney.nit);
                    $('#attorney_nit').removeClass("is-empty");
                    $('#dv_attorney').val(data.Attorney.digito_verificacion.trim());
                    $('#attorney_dv').removeClass("is-empty");
                    if (data.Attorney.tipo_persona == 1) {
                        $(".AttorneyN").hide();
                        $(".AttorneyJ").show();
                        $('#nam_attorney_juridico').val(data.Attorney.razon_social);
                        $('#juridico_nam_attorney').removeClass("is-empty");
                        if (data.Attorney.nombre_comercial) {
                            $('#lastnam_attorney_juridico').val(data.Attorney.nombre_comercial);
                            $('#juridico_lastnam_attorney').removeClass("is-empty");
                        } else {
                            $('#lastnam_attorney_juridico').val('');
                        }
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
                    $("#type_identification_attorney").val(data.Attorney.tipo_identificacion);
                    $('#attorney_type_identification').removeClass("is-empty");
                    $('#dni_attorney').val(data.Attorney.identificacion);
                    $('#attorney_dni').removeClass("is-empty");

                    $('#nam_attorney').val(data.Attorney.nombre);
                    $('#attorney_nam').removeClass("is-empty");
                    $('#lastnam_attorney').val(data.Attorney.apellido);
                    $('#attorney_lastnam').removeClass("is-empty");
                    $('#email_attorney').val(data.Attorney.email);
                    $('#attorney_email').removeClass("is-empty");
                    $('#phone_attorney').val(data.Attorney.telefono);
                    $('#attorney_phone').removeClass("is-empty");
                    $(".Attorney").show();
                } else {
                    $("#attorney option[value='2']").attr("selected", true);
                    $('#is_attorney').removeClass("is-empty");
                    $(".Attorney").hide();
                }
                if (data.derpament != '') {
                    $("#department option[value='" + data.derpament + "']").attr("selected", true);
                    $('#cod_department').removeClass("is-empty");
                }
                if (data.municipality != '') {
                    $("#municipality").prepend("<option value='" + data.municipality + "' selected='selected'>" + data.enterprise.city + "</option>");
                    $('#cod_municipality').removeClass("is-empty");
                }
                $('#address_line').val(data.enterprise.address);
                $('#line_address').removeClass("is-empty");
                $('#div_cat_method').removeClass("is-empty");
                $('#div_code_agency').removeClass("is-empty");
                $('#code_agency').val(data.enterprise.code_agency);
                $('#cat_method').val(data.enterprise.origin_medium);
                $('#vendor').val(data.enterprise.origin_vendor);
                if ($('#id_type_person').val() != '' && $('#code_agency').val() == "D87581") {
                    $('.insoft').show();
                    $('#insoft').val('true');
                }
                $('#id_vendor').val(data.vendorr);
                $('#client').val('true');
                if ($('#id_type_person').val() == '') {
                    $("#res-valid_opt").html('<div class="alert alert-success" role="alert" style="text-align: center;">Por favor ingrese el código autenticación enviado al correo <b>' + data.correo + '</b> y presione "VALIDAR" para continuar con el proceso.</div>');
                    $(".OptCliente").show();
                    $('#valid_opt').show();
                }

            }

        },

        error: function (data) {
            console.log(data);
        },
        cache: false,
        contentType: false,
        processData: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $("#modal-fail").modal("show");
        $('#search').show();
        $('.gift_loading').css('display', 'none');
        $('.loader-search').fadeOut();
    });
};

$(document).ready(function () {

    $("input[type=text]").keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });

    $('.tab').click(function () {
        return false;
    });

    $('.form-product').on('input', function (e) {
        if (!/^[ 0-9]*$/i.test(this.value)) {
            this.value = this.value.replace(/[^ 0-9]+/ig, "");
        }
    });

    if ($('#id_type_person').val() != '') {
        $('#type_person > option[value=' + $('#id_type_person').val() + ']').attr('selected', 'selected');
        $('#type_person').attr("style", "pointer-events: none;");
        $('#dni').attr("style", "pointer-events: none;");
        $('#dv').attr("style", "pointer-events: none;");
    }

    $('#doc').click(function () {
        if ($('#agency').val() == 'true') {
            return true;
        } else {
            return false;
        }


    });

    $('#next_order').click(function () {
        $('#next_order').hide();
        $('.orders_exist').hide();
        $('#next').show();
        $('.client').show();
    });


    $('#next_cplan').click(function () {
        $("#select-plan").html('');
        let check = 0;
        $('.transacciones').each(function () {
            if (this.checked) {
                check++
            }
        });
        if (check > 0) {
            $("#select-plan").html('<div class= "alert alert-danger">Por favor, seleccione el o los planes para continuar con el proceso de compra.</div>');
        } else {
            $("#select-plan").html('<div class= "alert alert-danger">Por favor, seleccione el Plan que desea contratar para continuar con el proceso de compra.</div>');
        }
    });

    $('.planSlect').change(function () {
        $("#select-plan").html('');
        let cant = $("#totalPlanes").val();
        let check = 0;
        $('.planSlect').each(function () {
            if (this.checked) {
                check++
            }
        });
        if (check == cant) {
            $('#conf_plan').val('true');
            $('#next_cplan').hide();
            $('#next').show();
            $('#search_plan').hide();
        } else {
            $('#conf_plan').val('');
            $('#next_cplan').show();
            $('#search_plan').hide();
            $('#next').hide();
        }
    });

    $("#code_agency").keyup(function () {
        $('#agency').val('');
        $("#res-vendor").html('');
        $('#valid_vendor').show();
        $('#next').hide();
    });

    $(".btn-help").on("click", function () {
        $("#modal-help").modal("show");
    });
    $(".btn-close").on("click", function () {
        $("#modal-manual").modal("hide");
        $("#modal-help").modal("hide");
        $("#modal-register").modal('hide');
        $("#modal-notification").modal('hide');
        $("#modal-message").modal('hide');
        $("#modal-errors").modal('hide');
        $("#modal-fail").modal('hide');
    });
    $('#accept').change(function () {
        if (this.checked) {
            $("#modal-requirements").modal("show");
        }
    });
    $('#accept_legal').change(function () {
        if (this.checked) {
            $("#modal-btn-si_legal").prop("disabled", false);
        }
    });
    $(".cat_servicio").change(function () {
        if ($('#cat_servicio_4').prop('checked')) {
            $(".Integracion").show();
        } else {
            $(".Integracion").hide();
        }
    });
    $(".cat_plan").change(function () {
        $(".D_plan").hide();
        if ($('#cat_plan_1').prop('checked')) {
            $("#D_plan_1").show();
            $("#cat_plan_2").attr('disabled', 'disabled');
            $("#cat_plan_3").attr('disabled', 'disabled');
            $("#cat_plan_4").attr('disabled', 'disabled');
        } else if ($('#cat_plan_2').prop('checked')) {
            $("#D_plan_2").show();
            $("#cat_plan_1").attr('disabled', 'disabled');
            $("#cat_plan_3").attr('disabled', 'disabled');
            $("#cat_plan_4").attr('disabled', 'disabled');
        } else if ($('#cat_plan_3').prop('checked')) {
            $("#D_plan_3").show();
            $("#cat_plan_1").attr('disabled', 'disabled');
            $("#cat_plan_2").attr('disabled', 'disabled');
            $("#cat_plan_4").attr('disabled', 'disabled');
        } else if ($('#cat_plan_4').prop('checked')) {
            $("#D_plan_4").show();
            $("#cat_plan_1").attr('disabled', 'disabled');
            $("#cat_plan_3").attr('disabled', 'disabled');
            $("#cat_plan_2").attr('disabled', 'disabled');
        } else {
            $(".cat_plan").removeAttr('disabled');
        }

    });

    $(".transacciones").change(function () {
        if ($("#exist_client").val() == 'false') {
            let check = 0;
            $('.transacciones').each(function () {
                if (this.checked) {
                    check++
                }
            });
            if (check > 0) {
                $("#cat_producto_4").prop('checked', true);
                $(".cat_producto_4").show();
            } else {
                $("#cat_producto_4").prop('checked', false);
                $("#time_format_linkage").val('');
                $(".cat_producto_4").hide();
            }
        }

    });

    $(".cat_producto").change(function () {
        let check = 0;
        $('#search_plan').show();
        $('.planSlect').removeAttr('checked');
        $('#next').hide();
        $('#next_cplan').hide();
        $('.cat_producto').each(function () {
            if (this.checked && this.value <= 5) {
                check++
            }
        });
        if (check > 0) {
            $('#next').hide();
        } else {
            $('.plan').hide();
        }
        $('.Plan_I').hide();
        $("." + this.id).val('');
        $("." + this.id).ForceNumericOnly();
        $(".is-empty_" + this.id).addClass('is-empty');
        if ($('#' + this.id).prop('checked')) {
            $("." + this.id).show();
        } else {
            if (this.id == 'cat_producto_5') {
                $(".limpiarCantSC").val('');
                $(".ocultarSC").hide();
                $(".planSc").hide();
                $(".ckSc").prop('checked', false);
                $(".cat_serComplentario").prop('checked', false);
                $(".cat_type_rg").prop('checked', false);
                $(".cat_type_reporte").prop('checked', false);
            }
            if (this.id == 'cat_producto_3') {
                $('input[name="RecepContratRta"]').prop('checked', false);
            }
            $("." + this.id).hide();
        }
    });

    $(".cat_serComplentario").change(function () {
        let check = 0;
        $('.cat_serComplentario').each(function () {
            if (this.checked && this.value <= 4) {
                check++
            }
        });
        if (check > 0) {
            $('#search_plan').show();
            $('.planSlect').removeAttr('checked');
            $('#next').hide();
            $('#next_cplan').hide();
        }
        $("." + this.id).val('');
        $("." + this.id).ForceNumericOnly();
        $(".is-empty_" + this.id).addClass('is-empty');
        if ($('#' + this.id).prop('checked')) {
            $("." + this.id).show();
        } else {
            $("." + this.id).hide();
        }
    });

    $("#cat_serComplentario_2").change(function () {
        if (!$(this).is(":checked")) {
            $(".cat_type_rg").prop('checked', false);
            $(".cant_rg").hide();
            $(".limpiarCantRG").val('');

        }
    });
    $(".cat_type_rg").change(function () {
        if ($(this).is(":checked")) {
            $(".cat_type_rg_" + this.value).show();
        } else {
            $(".cat_type_rg_" + this.value).hide();
            $('#cant_type_rg_' + this.value).val('');
        }
    });

    $(".cat_type_reporte").change(function () {
        let check = 0;
        $('.cat_type_reporte').each(function () {
            if (this.checked && this.value <= 4) {
                check++
            }
        });
        if (check > 0) {
            $('#search_plan').show();
            $('.planSlect').removeAttr('checked');
            $('#next').hide();
            $('#next_cplan').hide();
        }

    });

    $(".form-product").change(function () {
        $('#search_plan').show();
        $('.planSlect').removeAttr('checked');
        $('#next').hide();
        $('#next_cplan').hide();
    });

    $('#p_emision').change(function () {
        if ($(this).is(":checked")) {
            let cantTrans = 0;
            if (parseInt($("#max_trans_emision").val()) == 0) {
                $(this).prop('checked', true);
                return;
            }
            if ($("#cant_folios_1").val() != '') {
                cantTrans += parseInt($("#cant_folios_1").val());
            }
            if ($("#cant_folios_2").val() != '') {
                cantTrans += parseInt($("#cant_folios_2").val());
            }
            if (cantTrans == parseInt($("#max_trans_emision").val())) {
                $("#mensaje-plan-emision").html('');
                if ($('#cat_producto_1').prop('checked')) {
                    $('.producto_1').attr("style", "pointer-events: none;background-color: #f0f0f0;padding: 10px; border-radius: 10px;");
                    $('.tipoFactura').show();
                    document.getElementById("tipoFactura").innerHTML = $("#type_portal_1").val() ==1?'Portal WEB':'Integración';
                }
                if ($('#cat_producto_2').prop('checked')) {
                    $('.producto_2').attr("style", "pointer-events: none;background-color: #f0f0f0;padding: 10px; border-radius: 10px;");
                    $('.tipoNomina').show();
                    document.getElementById("tipoNomina").innerHTML = $("#type_portal_2").val() ==1?'Portal WEB':'Integración';
                }
                $(this).prop('checked', true);
            } else {
                $('#div_cant_folios_1').addClass('has-error is-focused');
                $('#div_cant_folios_2').addClass('has-error is-focused');
                $("#mensaje-plan-emision").html('<div class= "alert alert-warning">El plan que ha seleccionado incluye <b>' + $("#max_trans_emision").val() + ' transacciones </b>de documentos electrónicos. Por favor, <b>en la sección de arriba, distribuya esta cantidad entre los productos que desea comprar</b>:  <i>factura electrónica y nómina electrónica.</i> Una vez hecho esto,  haga clic en el botón <b>"SIGUIENTE"</b> para continuar con el proceso de compra. </div>');
                $(this).prop('checked', false);
                $('#next').hide();
            }
        } else {
            if ($('#cat_producto_1').prop('checked')) {
                $('.producto_1').attr("style", "pointer-events: block; ");
                $('#div_cant_folios_1').removeClass('has-error ');
            }
            if ($('#cat_producto_2').prop('checked')) {
                $('.producto_2').attr("style", "pointer-events: block;");
                $('#div_cant_folios_2').removeClass('has-error ');
            }
        }
    });

    $("#p_recepcion").change(function () {
        if ($('#p_recepcion').prop('checked')) {
            $('.producto_3').attr("style", "pointer-events: none;background-color: #f0f0f0;padding: 10px; border-radius: 10px;");
            document.getElementById("tipoRecepcion").innerHTML = $("#type_portal_3").val() ==1?'Portal WEB':'Integración';
            $("#cant_folios_3").val($("#max_trans_recepcion").val());
        } else {
            $('.producto_3').attr("style", "pointer-events: block;");
        }
    });

    $("#cat_type_reporte_8").change(function () {
        $("#cant_reporte_traza").val('');
        if ($('#cat_type_reporte_8').prop('checked')) {
            $(".cant_reporte_traza").show();
        } else {
            $(".cant_reporte_traza").hide();

        }
    });

    $('#email').keyup(function () {
        if (!$('#accept_legal').prop('checked')) {
            $("#modal-email_representative").modal({ backdrop: 'static', keyboard: false });
        }
    });
    $('#email').change(function () {
        if (!$('#accept_legal').prop('checked')) {
            $("#modal-email_representative").modal({ backdrop: 'static', keyboard: false });
        }
    });
    $("#conf-btn-si").on("click", function () {

        if ($('#nam_enterprise_edit').val() == '') {
            $('#nam_enterprise_edit').parent('div').addClass('has-error');
            $('#nam_enterprise_edit').parent('div').addClass('is-focused');
            return false;
        }
        if ($('#type_person').val() == '2') {
            if ($('#lastnam_enterprise_edit').val() == '') {
                $('#lastnam_enterprise_edit').parent('div').addClass('has-error');
                $('#lastnam_enterprise_edit').parent('div').addClass('is-focused');
                return false;
            }
            if ($('#dni_enterprise_edit').val() == '') {
                $('#dni_enterprise_edit').parent('div').addClass('has-error');
                $('#dni_enterprise_edit').parent('div').addClass('is-focused');
                return false;
            }
        } else {
            if ($('#dni_rep_edit').val() == '') {
                $('#dni_rep_edit').parent('div').addClass('has-error');
                $('#dni_rep_edit').parent('div').addClass('is-focused');
                return false;
            }
            if ($('#nam_rep_edit').val() == '') {
                $('#nam_rep_edit').parent('div').addClass('has-error');
                $('#nam_rep_edit').parent('div').addClass('is-focused');
                return false;
            }
            if ($('#lastnam_rep_edit').val() == '') {
                $('#lastnam_rep_edit').parent('div').addClass('has-error');
                $('#lastnam_rep_edit').parent('div').addClass('is-focused');
                return false;
            }
        }
        $('#nam_enterprise').val($('#nam_enterprise_edit').val());
        if ($('#type_person').val() == '2') {
            $('#lastnam_enterprise').val($('#lastnam_enterprise_edit').val());
            $('#dni_rep').val($('#dni_enterprise_edit').val());
        } else {
            $('#dni_rep').val($('#dni_rep_edit').val());
            $('#nam_rep').val($('#nam_rep_edit').val());
            $('#lastnam_rep').val($('#lastnam_rep_edit').val());
        }
        $("#modal-conf").modal('hide');
        $('#doc_valid').val('true');
        $('#search').hide();
        if ($('#attorney').val() == '1') {
            $('#finish_attorney').show();
        } else {
            $('#next').show();
        }

    });

    $("#conf-btn-no").on("click", function () {
        $("#modal-conf").modal('hide');
        $('#doc_valid').val('false');
    });

    $("#modal-btn-no_conf-docs").on("click", function () {
        $("#modal-conf-docs").modal('hide');
        $('#valid').show();
    });

    $("#modal-btn-si_conf-docs").on("click", function () {
        $("#modal-conf-docs").modal('hide');
        $('#doc_valid').val('false');
        $('#next').show();
    });


    var modalConfirm = function (callback) {

        $("#modal-btn-si").on("click", function () {
            callback(true);
            $("#modal-requirements").modal('hide');
        });

        $("#modal-btn-no").on("click", function () {
            callback(false);
            $("#modal-requirements").modal('hide');
        });

        $("#modal-btn-close").on("click", function () {
            callback(false);
        });
    };

    modalConfirm(function (confirm) {
        $('#accept').prop("checked", confirm);
    });

    var modalConfirmEmail = function (callback) {

        $("#modal-btn-si_legal").on("click", function () {
            callback(true);
            $("#modal-email_representative").modal('hide');
        });

        $("#modal-btn-no_legal").on("click", function () {
            callback(false);
            $("#modal-email_representative").modal('hide');
        });

        $("#modal-btn-close_legal").on("click", function () {
            callback(false);
        });
    };

    modalConfirmEmail(function (confirm) {
        if (confirm == false) {
            $("#email").val('');
        }
        $('#accept_legal').prop("checked", confirm);

    });

    $('#enviar').on('click', function () {
        var allCheckboxe = $('.cat_termino_firma').length;
        if (!$('#cat_serComplentario_2').prop('checked') && allCheckboxe>0) {
            allCheckboxe--;
        }
        var allCheckboxesChecked = $('.cat_termino_firma:checked').length === allCheckboxe;

        if (!allCheckboxesChecked) {
            $("#modal-message").modal("show");
            $("#modal-message .modal-body").html('Por favor, complete la seccion de términos y condiciones para continuar');
            $("#modal-message").modal({ 'show': true, backdrop: 'static', keyboard: false });
            return false;
        }
        if ($('#signed').val() == 'true') {
            $("#modal-message").modal("show");
            $("#modal-message .modal-body").html('Este Documento ya fue firmado');
            $("#modal-message").modal({ 'show': true, backdrop: 'static', keyboard: false });
            return false;
        }
        var form = $('form').get(0);
        console.log(form);
        var fd = new FormData(form);
        $.ajax({

            url: 'optfirma',
            type: 'POST',
            dataType: 'json',
            data: fd,
            beforeSend: function () {
                $('#enviar').hide();
                $('.gift_loading').css('display', 'block');
                $('.loader-send').fadeIn();
            },
            complete: function () {
                $('.gift_loading').css('display', 'none');
                $('.loader-send').fadeOut();
            },
            success: function (data) {
                console.log(data.id_enterprise);
                if (data.result == 0) {
                    $("#modal-errors").modal("show");
                    $("#modal-errors .modal-body").html(data.errors);
                    $("#modal-errors").modal({ 'show': true, backdrop: 'static', keyboard: false });
                } else {

                    $("#modal-message").modal("show");
                    $("#modal-message .modal-body").html('Por favor ingrese el código autenticación enviado al correo ' + data.email + ' y presione "Validar" para proceder al firmado electrónico');
                    $("#modal-message").modal({ 'show': true, backdrop: 'static', keyboard: false });
                    $('#userfirma').val(data.otp_user_key);
                    $('#edit_propuesta').hide();
                    $('#firmar').show();
                    $('.OptFirma').show();
                    $('#terminos_firma_aceptados').attr("style", "pointer-events: none;");

                }

            },

            error: function (data) {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $("#modal-fail").modal("show");
            $('#enviar').show();
            $('.gift_loading').css('display', 'none');
            $('.loader-send').fadeOut();
        });
    });

    $('#firmar').on('click', function () {

        var allCheckboxe = $('.cat_termino_firma').length;
        if (!$('#cat_serComplentario_2').prop('checked') && allCheckboxe>0) {
            allCheckboxe--;
        }
        var allCheckboxesChecked = $('.cat_termino_firma:checked').length === allCheckboxe;

        if (!allCheckboxesChecked) {
            $("#modal-message").modal("show");
            $("#modal-message .modal-body").html('Por favor, complete la seccion de términos y condiciones para continuar');
            $("#modal-message").modal({ 'show': true, backdrop: 'static', keyboard: false });
            return false;
        }
        let opt = $('#optfirma').val();
        if (opt == '') {
            $('#optfirma').parent('div').addClass('has-error');
            $('#optfirma').parent('div').addClass('is-focused');
            return false;
        }

        var form = $('form').get(0);
        console.log(form);
        var fd = new FormData(form);
        $.ajax({
            url: 'firmado',
            type: 'POST',
            dataType: 'json',
            data: fd,
            beforeSend: function () {
                $('.btn-finish').hide();
                $('.gift_loading').css('display', 'block');
                $('.loader-p').fadeIn();
            },
            complete: function () {
                $('.gift_loading').css('display', 'none');
                $('.loader-p').fadeOut();
            },
            success: function (data) {
                console.log(data.id_enterprise);
                if (data.result == 0) {
                    $("#modal-errors").modal("show");
                    $("#modal-errors .modal-body").html(data.errors);
                    $("#modal-errors").modal({ 'show': true, backdrop: 'static', keyboard: false });
                    $('#firmar').show();

                } else {
                    $("#modal-message").modal("show");
                    $("#modal-message .modal-body").html('El documento se firmo exitosamente, fue enviado al correo ' + data.email);
                    $("#modal-message").modal({ 'show': true, backdrop: 'static', keyboard: false });
                    $('.OptFirma').hide();
                }
            },
            error: function (data) {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $("#modal-fail").modal("show");
            $('#btn-finish').show();
            $('.gift_loading').css('display', 'none');
            $('.loader-p').fadeOut();
        });
    });

    $("#valid_opt").on("click", function () {
        $("#mensaje-otp-cliente").html('');
        var optClienteCuadros = document.getElementById("opt_cliente_cuadros");
        var optCliente = document.getElementById("opt_cliente");

        // Obtiene el valor de cada cuadro y concatena
        var valorOptCliente = "";
        for (var i = 0; i < optClienteCuadros.children.length; i++) {
            valorOptCliente += optClienteCuadros.children[i].innerText;
        }

        if (valorOptCliente.length < 6) {
            $("#mensaje-otp-cliente").html('<div class= "alert alert-danger">Debe diligenciar todos los digitos del código OTP</div>');
            return false;
        }
        // Establece el valor en el campo opt_cliente
        optCliente.value = valorOptCliente;

        var form = $('form').get(0);
        console.log(form);
        var fd = new FormData(form);
        $.ajax({

            url: 'valid_opt',
            type: 'POST',
            dataType: 'json',
            data: fd,
            beforeSend: function () {
                $('#valid_opt').hide();
                $('.loader-valid_vendor').html('<span class="text_gift" style="font-size: medium;color: #007bff;font-weight: 900;">Validando Código de Autenticación, por favor espere ...</span>');
                $('.gift_loading').css('display', 'block');
                $('.loader-valid_vendor').fadeIn();
            },
            complete: function () {
                $('.gift_loading').css('display', 'none');
                $('.loader-valid_vendor').fadeOut();
            },
            success: function (data) {
                if (data.result == 0) {
                    $("#modal-errors").modal("show");
                    $("#modal-errors .modal-body").html(data.errors);
                    $("#modal-errors").modal({ 'show': true, backdrop: 'static', keyboard: false });
                    $('#valid_opt').show();

                } else {
                    $(".OptCliente").hide();
                    $("#res-valid_opt").html('');
                    $("#res-valid_opt").html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                    $('#next').show();
                }

            },

            error: function (data) {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $("#modal-fail").modal("show");
            $('#valid_opt').show();
            $('.gift_loading').css('display', 'none');
            $('.loader-valid_vendor').fadeOut();
        });

    });

    $('#valid_vendor').on('click', function () {

        if ($('#code_agency').val() == '') {
            $('#div_code_agency').addClass('has-error');
            $("#code_agency").focus();
            return false;
        }
        $('#insoft').val('');
        $('#time_format_linkage').val('');
        $('#cant_folios_e').val('');
        $('#cant_folios_r').val('');
        $('#cant_folios_n').val('');
        var form = $('form').get(0);
        let route = 'valid_vendor'
        if ($('#id_type_person').val() != '') {
            route = '../valid_vendor';
        }
        var fd = new FormData(form);
        $.ajax({

            url: route,
            type: 'POST',
            dataType: 'json',
            data: fd,
            beforeSend: function () {
                $('#valid_vendor').hide();
                $('.loader-valid_vendor').html('<span class="text_gift" style="font-size: medium;color: #007bff;font-weight: 900;">Validando Código de Agencia, por favor espere ...</span>');
                $('.gift_loading').css('display', 'block');
                $('.loader-valid_vendor').fadeIn();
            },
            complete: function () {
                $('.gift_loading').css('display', 'none');
                $('.loader-valid_vendor').fadeOut();
            },
            success: function (data) {
                if (data.result == 0) {
                    $("#modal-errors").modal("show");
                    $("#modal-errors .modal-body").html(data.errors);
                    $("#modal-errors").modal({ 'show': true, backdrop: 'static', keyboard: false });
                    $('#valid_vendor').show();

                } else {

                    if (data.insoft == 1) {
                        $('.insoft').show();
                        $('#insoft').val('true');

                    } else {
                        $('.insoft').hide();
                        $('#insoft').val('false');
                    }
                    $("#res-vendor").html(data.message);
                    $('#div_cat_method').removeClass("is-empty");
                    $('#cat_method').val(data.cat_method);
                    $('#vendor').val(data.vendor);
                    $('#agency').val('true');
                    $("#concesion").val(data.concesion);
                    $('#next').show();
                }

            },

            error: function (data) {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $("#modal-fail").modal("show");
            $('#valid_vendor').show();
            $('.gift_loading').css('display', 'none');
            $('.loader-valid_vendor').fadeOut();
        });
    });

    $('#search').on('click', function () {
        search();
    });

    $('#valid').on('click', function () {
        $('#doc_valid').val('false');
        $("#res-vendor").html('');
        if ($('#rut_attachment').get(0).files.length === 0) {
            $('#rut_1').addClass('has-error');
            $("#rut_attachment").focus();
            return false;
        }
        if ($('#chamber_commerce').get(0).files.length === 0) {
            $('#chamber_commerce_1').addClass('has-error');
            $("#chamber_commerce").focus();
            return false;
        }

        var form = $('form').get(0);
        console.log(form);
        var fd = new FormData(form);
        $.ajax({

            url: 'valid',
            type: 'POST',
            dataType: 'json',
            data: fd,
            beforeSend: function () {
                $('#valid').hide();
                $('.gift_loading').css('display', 'block');
                $('.loader-valid').fadeIn();
            },
            complete: function () {
                $('.gift_loading').css('display', 'none');
                $('.loader-valid').fadeOut();
            },
            success: function (data) {
                if (data.result == 0) {
                    $("#modal-errors").modal("show");
                    $("#modal-errors .modal-body").html(data.errors);
                    $("#modal-errors").modal({ 'show': true, backdrop: 'static', keyboard: false });
                    $('#doc_valid').val('false');
                    $('#valid').show();
                } else {
                    if (data.result == 1) {

                        if (data.mesagge == '') {
                            $('#next').show();
                            $('#doc_valid').val('true');
                            $('#nam_enterprise').val(data.reazon);
                            $('#dni_rep_edit').val(data.numero);
                            $('#nam_rep_edit').val(data.nombre);
                            $('#lastnam_rep_edit').val(data.apellido);

                            if ($('#type_person').val() == '1') {

                                data.mesagge = 'RUT y Camara de Comercio han sido validados, presione "Siguiente" para continuar con el proceso'

                            } else {

                                data.mesagge = 'RUT ha sido validado, presione "Siguiente" para continuar con el proceso'

                            }
                        }
                        $('.form-group').removeClass("is-empty");
                        $('#nam_enterprise').val(data.nam_enterprise);
                        $('#lastnam_enterprise').val(data.comercial_name);
                        $("#type_identification").prepend("<option value='1' selected='selected'>NIT</option>");
                        $('#dni_rep').val(data.dni_rep);
                        $('#nam_rep').val(data.nam_rep);
                        $('#lastnam_rep').val(data.lastnam_rep);
                        $('#email').val(data.email);
                        $('#email_fac').val(data.email_invoices);
                        $('#email_rad').val(data.email_billing_contact);
                        $('#phoneClient').val(data.phone);
                        $('#email_op').val(data.email_optional);
                        $("#department option[value='" + data.department + "']").attr("selected", true);
                        $("#municipality").prepend("<option value='" + data.cod_municipality + "' selected='selected'>" + data.municipality + "</option>");
                        $('#address_line').val(data.address_line);
                        $("#cat_method option[value='']").attr("selected", true);
                        $("#cat_method option:selected").removeAttr("selected");
                        $('#div_vendor').addClass("is-empty");
                        $('#div_code_agency').addClass("is-empty");
                        $('#vendor').val('');
                        $('#code_agency').val('');
                        if ($('#id_type_person').val() != '' && $('#code_agency').val() == "D87581") {
                            $('.insoft').show();
                            $('#insoft').val('true');
                        }
                        $("#modal-message").modal("show");
                        $("#modal-message .modal-body").html(data.mesagge);
                        $("#modal-message").modal({ 'show': true, backdrop: 'static', keyboard: false });
                        $('#next').show();
                    } else {
                        $("#modal-conf-docs").modal('show');
                    }
                }

            },

            error: function (data) {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $("#modal-fail").modal("show");
            $('#valid').show();
            $('.gift_loading').css('display', 'none');
            $('.loader-valid').fadeOut();
        });
    });


    $('#search_plan').on('click', function () {
        let selected = 0;
        let selectedSC = 0;
        let selectedScRg = 0;
        let selectedScTr = 0;
        let i = 1;
        let j = 1;
        let input = 0;
        $("#mensaje-plan").html('');
        $("#mensaje-planSC").html('');
        $("#mensaje-planRG").html('');
        $("#mensaje-planR").html('');
        $(".planSlect").prop('checked', false);
        $('.cat_producto').each(function () {
            if (this.checked) {
                selected++;
                if (this.id == 'cat_producto_1' || this.id == 'cat_producto_2' || this.id == 'cat_producto_3') {
                    if ($('#cant_folios_' + i).val() == '') {
                        input++;
                        $('#div_cant_folios_' + i).addClass('has-error');
                        $('#cant_folios_' + i).focus();
                        return false;
                    }
                    if ($('#type_portal_' + i + ' option:selected').val() == '') {
                        input++;
                        $('#div_type_portal_' + i).addClass('has-error');
                        $('#type_portal_' + i).focus();
                        return false;
                    }
                    if (this.id == 'cat_producto_3' && !$('input[name="RecepContratRta"]').is(':checked')) {
                        input++;
                        $('#span_recepContract').addClass('text-danger');
                        $('#span_recepContract').focus();
                        return false;
                    }

                }
            }
            i++;
        });

        if (selected == 0) {
            $("#mensaje-plan").html('<div class= "alert alert-danger">Es necesario que elija al menos un producto para poder continuar con el proceso de compra.</div>');
            return false;
        } else if ($('#exist_client').val() == 'false' && !$('#cat_producto_4').prop('checked')) {
            $("#mensaje-plan").html('<div class= "alert alert-danger">Es necesario que elija Certifidado Digital para poder continuar con el proceso de compra.</div>');
            return false;
        } else if (($('#concesion').val() == 'false' && $('#cat_producto_4').prop('checked')) && (!$('#cat_producto_1').prop('checked') && !$('#cat_producto_2').prop('checked') && !$('#cat_producto_3').prop('checked'))) {
            $("#mensaje-plan").html('<div class= "alert alert-danger">Es necesario que elija Folios de Emisión y/o Nómina o Folios de Recepción para poder continuar con el proceso de compra.</div>');
            return false;
        } else {
            $("#mensaje-plan").html('');
        }
        if ($('#cat_producto_4').prop('checked')) {
            if ($('#time_format_linkage option:selected').val() == '') {
                $('#div_time_format_linkage_4').addClass('has-error');
                $('#time_format_linkage').focus();
                return false;
            }
        }
        if ($('#cat_producto_5').prop('checked')) {
            $('.cat_serComplentario').each(function () {
                if (this.checked) {
                    selectedSC++;
                    if ($('#cant_folios_serComplentario_' + j).val() == '') {
                        input++;
                        $('#div_cant_folios_serComplentario_' + j).addClass('has-error');
                        $('#cant_folios_serComplentario_' + j).focus();
                        return false;
                    }
                }
                j++;
            });
            if (selectedSC == 0) {
                $("#mensaje-planSC").html('<div class= "alert alert-danger">Es necesario que elija al menos un Servicio Complentario para poder continuar con el proceso de compra.</div>');
                return false;
            }
        }
        if ($('#cat_serComplentario_2').prop('checked')) {
            $('.cat_type_rg').each(function () {
                if (this.checked) {
                    selectedScRg++;
                    if ($('#cat_type_rg_' + this.value).prop('checked')) {
                        if ($('#cant_type_rg_' + this.value).val() == '' || $('#cant_type_rg_' + this.value + ' option:selected').val() == '') {
                            input++;
                            $('#div_cant_type_rg_' + this.value).addClass('has-error');
                            $('#cant_type_rg_' + this.value).focus();
                            return false;
                        }
                    }
                }
            });
            if (selectedScRg == 0) {
                $("#mensaje-planRG").html('<div class= "alert alert-danger">Es necesario que elija al menos un Tipo de Representacion Gráfica para poder continuar con el proceso de compra.</div>');
                return false;
            }
        }
        if ($('#cat_serComplentario_3').prop('checked')) {
            $('.cat_type_reporte').each(function () {
                if (this.checked) {
                    selectedScTr++;
                    if ($('#cat_type_reporte_8').prop('checked')) {
                        if ($('#cant_reporte_traza').val() == '') {
                            input++;
                            $('#div_cant_reporte_traza').addClass('has-error');
                            $('#cant_reporte_traza').focus();
                            return false;
                        }
                    }
                }
            });
            if (selectedScTr == 0) {
                $("#mensaje-planR").html('<div class= "alert alert-danger">Es necesario que elija al menos un Tipo de reporte para poder continuar con el proceso de compra.</div>');
                return false;
            }
        }
        if (input != 0) {
            return false;
        }
        var form = $('form').get(0);
        let route = 'search_plan'
        if ($('#id_type_person').val() != '') {
            route = '../search_plan';
        } var fd = new FormData(form);
        $.ajax({

            url: route,
            type: 'POST',
            dataType: 'json',
            data: fd,
            beforeSend: function () {
                $("#planes-seleccionados").hide();
                $('#search_plan').hide();
                $('.plan').hide();
                $('#div_termino_4').hide();
                $('.cat_termino').prop("checked", false);
                $('.gift_loading').css('display', 'block');
                $('.loader-search_plan').fadeIn();
            },
            complete: function () {
                $('.gift_loading').css('display', 'none');
                $('.loader-search_plan').fadeOut();
            },
            success: function (data) {

                if (data.result == 0) {
                    $("#modal-errors").modal("show");
                    $("#modal-errors .modal-body").html(data.errors);
                    $("#modal-errors").modal({ 'show': true, backdrop: 'static', keyboard: false });
                    $('#search_plan').show();
                    $('.planSlect').removeAttr('checked');
                    $('#next').hide();
                    $('#next_cplan').hide();

                } else {
                    $("#planes-seleccionados").show();
                    let totalPlanes = 0;
                    let monto = 0;
                    let iva = 0;
                    let reteICA = 0;
                    let reteIVA = 0;
                    let reteFuente = 0;
                    let aPagar = 0;
                    if (data.plan_emision != '') {
                        totalPlanes++
                        $('#p_emision').val(data.plan_emision['id']);
                        $('#max_trans_emision').val(data.plan_emision['max_transacion']);
                        $('#cat_retencion_plan_e').val(data.plan_emision['retencion']);
                        iva += data.plan_emision['retencion']['porcentaje_iva'];
                        reteICA += data.plan_emision['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_emision['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_emision['retencion']['porcentaje_retefuente'];
                        monto += data.plan_emision['precio'];
                        document.getElementById("name_plan_emision").innerHTML = data.plan_emision['nombre'];
                        $('#desc_plan_emision').val(data.plan_emision['descripcion']);
                        document.getElementById("price_plan_emision").innerHTML = formatearMoneda(data.plan_emision['precio']);

                        $('.plan_Emision').show();
                    }
                    if (data.plan_recepcion != '') {
                        console.log(data.plan_recepcion['portal']);
                        if (data.plan_recepcion['portal'] != '') {
                            totalPlanes++
                            $('#portal_recepcion').val(data.plan_recepcion['portal']['id']);
                            $('#max_trans_portal_recepcion').val(data.plan_recepcion['portal']['max_transacion']);
                            iva += data.plan_recepcion['portal']['retencion']['porcentaje_iva'];
                            reteICA += data.plan_recepcion['portal']['retencion']['porcentaje_reteICA'];
                            reteIVA += data.plan_recepcion['portal']['retencion']['porcentaje_reteIVA'];
                            reteFuente += data.plan_recepcion['portal']['retencion']['porcentaje_retefuente'];
                            monto += data.plan_recepcion['portal']['precio'];
                            document.getElementById("name_portal_recepcion").innerHTML = data.plan_recepcion['portal']['nombre'];
                            $('#desc_portal_recepcion').val(data.plan_recepcion['portal']['descripcion']);
                            document.getElementById("price_portal_recepcion").innerHTML = formatearMoneda(data.plan_recepcion['portal']['precio']);
                            $('.plan_Portal_Recepcion').show();
                        }
                        totalPlanes++
                        $('#p_recepcion').val(data.plan_recepcion['id']);
                        $('#max_trans_recepcion').val(data.plan_recepcion['max_transacion']);
                        iva += data.plan_recepcion['retencion']['porcentaje_iva'];
                        reteICA += data.plan_recepcion['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_recepcion['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_recepcion['retencion']['porcentaje_retefuente'];
                        monto += data.plan_recepcion['precio'];
                        document.getElementById("name_plan_recepcion").innerHTML = data.plan_recepcion['nombre'];
                        $('#desc_plan_recepcion').val(data.plan_recepcion['descripcion']);
                        document.getElementById("price_plan_recepcion").innerHTML = formatearMoneda(data.plan_recepcion['precio']);
                        $('.plan_Recepcion').show();
                    }
                    if (data.plan_certificado != '') {
                        totalPlanes++
                        $('#p_certificado').val(data.plan_certificado['id']);
                        $('#max_trans_certificado').val(data.plan_certificado['max_transacion']);
                        iva += data.plan_certificado['retencion']['porcentaje_iva'];
                        reteICA += data.plan_certificado['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_certificado['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_certificado['retencion']['porcentaje_retefuente'];
                        monto += data.plan_certificado['precio'];
                        document.getElementById("name_plan_certificado").innerHTML = data.plan_certificado['nombre'];
                        $('#desc_plan_certificado').val(data.plan_certificado['descripcion']);
                        document.getElementById("price_plan_certificado").innerHTML = formatearMoneda(data.plan_certificado['precio']);
                        $('.plan_Certificado').show();
                    }
                    if (data.plan_horas != '') {
                        totalPlanes++
                        $('#p_horas').val(data.plan_horas['id']);
                        $('#max_trans_horas').val(data.plan_horas['max_transacion']);
                        iva += data.plan_horas['retencion']['porcentaje_iva'];
                        reteICA += data.plan_horas['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_horas['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_horas['retencion']['porcentaje_retefuente'];
                        monto += data.plan_horas['precio'];
                        document.getElementById("cantPlanHoras").innerHTML = $('#cant_folios_serComplentario_1').val();
                        document.getElementById("name_plan_horas").innerHTML = data.plan_horas['nombre'];
                        $('#desc_plan_horas').val(data.plan_horas['descripcion']);
                        document.getElementById("price_plan_horas").innerHTML = formatearMoneda(data.plan_horas['precio']);
                        $('#plan_horas_sin_formato').val(data.plan_horas['precio']);
                        $('.plan_Horas').show();
                    }
                    if (data.plan_rg != '') {
                        totalPlanes++
                        $('#p_rg').val(data.plan_rg['id']);
                        $('#max_trans_rg').val(data.plan_rg['max_transacion']);
                        iva += data.plan_rg['retencion']['porcentaje_iva'];
                        reteICA += data.plan_rg['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_rg['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_rg['retencion']['porcentaje_retefuente'];
                        monto += data.plan_rg['precio'];
                        document.getElementById("cantPlanRG").innerHTML = $('#cant_type_rg_241').val();
                        document.getElementById("name_plan_rg").innerHTML = data.plan_rg['nombre'];
                        $('#desc_plan_rg').val(data.plan_rg['descripcion']);
                        document.getElementById("price_plan_rg").innerHTML = formatearMoneda(data.plan_rg['precio']);
                        $('#plan_rg_sin_formato').val(data.plan_rg['precio']);
                        $('.plan_RG').show();
                        $('#div_termino_4').show();
                    }
                    if (data.plan_plantilla != '') {
                        totalPlanes++
                        $('#p_pl').val(data.plan_plantilla['id']);
                        $('#max_trans_plantilla').val(data.plan_plantilla['max_transacion']);
                        iva += data.plan_plantilla['retencion']['porcentaje_iva'];
                        reteICA += data.plan_plantilla['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_plantilla['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_plantilla['retencion']['porcentaje_retefuente'];
                        monto += data.plan_plantilla['precio'];
                        document.getElementById("cantPlanRgPlantilla").innerHTML = $('#cant_type_rg_2').val();
                        document.getElementById("name_plan_plantilla").innerHTML = data.plan_plantilla['nombre'];
                        $('#desc_plan_plantilla').val(data.plan_plantilla['descripcion']);
                        document.getElementById("price_plan_plantilla").innerHTML = formatearMoneda(data.plan_plantilla['precio']);
                        $('#plan_plantilla_sin_formato').val(data.plan_plantilla['precio']);
                        $('.plan_RG_plantilla').show();
                        $('#div_termino_4').show();
                    }
                    if (data.plan_rg_mod != '') {
                        totalPlanes++
                        $('#p_rg_mod').val(data.plan_rg_mod['id']);
                        $('#max_trans_rg_mod').val(data.plan_rg_mod['max_transacion']);
                        iva += data.plan_rg_mod['retencion']['porcentaje_iva'];
                        reteICA += data.plan_rg_mod['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_rg_mod['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_rg_mod['retencion']['porcentaje_retefuente'];
                        monto += data.plan_rg_mod['precio'];
                        document.getElementById("name_plan_rg_mod").innerHTML = data.plan_rg_mod['nombre'];
                        $('#desc_plan_rg_mod').val(data.plan_rg_mod['descripcion']);
                        document.getElementById("price_plan_rg_mod").innerHTML = formatearMoneda(data.plan_rg_mod['precio']);
                        $('.plan_RG_Mod').show();
                        $('#div_termino_4').show();
                    }
                    if (data.plan_Rfactura != '') {
                        totalPlanes++
                        $('#p_rfact').val(data.plan_Rfactura['id']);
                        $('#max_trans_rfact').val(data.plan_Rfactura['max_transacion']);
                        iva += data.plan_Rfactura['retencion']['porcentaje_iva'];
                        reteICA += data.plan_Rfactura['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_Rfactura['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_Rfactura['retencion']['porcentaje_retefuente'];
                        monto += data.plan_Rfactura['precio'];
                        document.getElementById("name_plan_rfact").innerHTML = data.plan_Rfactura['nombre'];
                        $('#desc_plan_rfact').val(data.plan_Rfactura['descripcion']);
                        document.getElementById("price_plan_rfact").innerHTML = formatearMoneda(data.plan_Rfactura['precio']);
                        $('.plan_RFactura').show();
                    }
                    if (data.plan_Rclientes != '') {
                        totalPlanes++
                        $('#p_rclient').val(data.plan_Rclientes['id']);
                        $('#max_trans_rclient').val(data.plan_Rclientes['max_transacion']);
                        iva += data.plan_Rclientes['retencion']['porcentaje_iva'];
                        reteICA += data.plan_Rclientes['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_Rclientes['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_Rclientes['retencion']['porcentaje_retefuente'];
                        monto += data.plan_Rclientes['precio'];
                        document.getElementById("name_plan_rclient").innerHTML = data.plan_Rclientes['nombre'];
                        $('#desc_plan_rclient').val(data.plan_Rclientes['descripcion']);
                        document.getElementById("price_plan_rclient").innerHTML = formatearMoneda(data.plan_Rclientes['precio']);
                        $('.plan_RClientes').show();
                    }
                    if (data.plan_Rproductos != '') {
                        totalPlanes++
                        $('#p_rproduct').val(data.plan_Rproductos['id']);
                        $('#max_trans_rproduct').val(data.plan_Rproductos['max_transacion']);
                        iva += data.plan_Rproductos['retencion']['porcentaje_iva'];
                        reteICA += data.plan_Rproductos['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_Rproductos['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_Rproductos['retencion']['porcentaje_retefuente'];
                        monto += data.plan_Rproductos['precio'];
                        document.getElementById("name_plan_rproduct").innerHTML = data.plan_Rproductos['nombre'];
                        $('#desc_plan_rproduct').val(data.plan_Rproductos['descripcion']);
                        document.getElementById("price_plan_rproduct").innerHTML = formatearMoneda(data.plan_Rproductos['precio']);
                        $('.plan_RProduct').show();
                    }
                    if (data.plan_Rcli_proc != '') {
                        totalPlanes++
                        $('#p_rcliprod').val(data.plan_Rcli_proc['id']);
                        $('#max_trans_rcliprod').val(data.plan_Rcli_proc['max_transacion']);
                        iva += data.plan_Rcli_proc['retencion']['porcentaje_iva'];
                        reteICA += data.plan_Rcli_proc['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_Rcli_proc['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_Rcli_proc['retencion']['porcentaje_retefuente'];
                        monto += data.plan_Rcli_proc['precio'];
                        document.getElementById("name_plan_rcliprod").innerHTML = data.plan_Rcli_proc['nombre'];
                        $('#desc_plan_rcliprod').val(data.plan_Rcli_proc['descripcion']);
                        document.getElementById("price_plan_rcliprod").innerHTML = formatearMoneda(data.plan_Rcli_proc['precio']);
                        $('.plan_RCliProc').show();
                    }
                    if (data.plan_Rsecuenciales != '') {
                        totalPlanes++
                        $('#p_rsecuen').val(data.plan_Rsecuenciales['id']);
                        $('#max_trans_rsecuen').val(data.plan_Rsecuenciales['max_transacion']);
                        iva += data.plan_Rsecuenciales['retencion']['porcentaje_iva'];
                        reteICA += data.plan_Rsecuenciales['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_Rsecuenciales['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_Rsecuenciales['retencion']['porcentaje_retefuente'];
                        monto += data.plan_Rsecuenciales['precio'];
                        document.getElementById("name_plan_rsecuen").innerHTML = data.plan_Rsecuenciales['nombre'];
                        $('#desc_plan_rsecuen').val(data.plan_Rsecuenciales['descripcion']);
                        document.getElementById("price_plan_rsecuen").innerHTML = formatearMoneda(data.plan_Rsecuenciales['precio']);
                        $('.plan_RSecuen').show();
                    }
                    if (data.plan_Rtraza != '') {
                        totalPlanes++
                        $('#p_rtraza').val(data.plan_Rtraza['id']);
                        $('#max_trans_rtraza').val(data.plan_Rtraza['max_transacion']);
                        iva += data.plan_Rtraza['retencion']['porcentaje_iva'];
                        reteICA += data.plan_Rtraza['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_Rtraza['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_Rtraza['retencion']['porcentaje_retefuente'];
                        monto += data.plan_Rtraza['precio'];
                        document.getElementById("name_plan_rtraza").innerHTML = data.plan_Rtraza['nombre'];
                        $('#desc_plan_rtraza').val(data.plan_Rtraza['descripcion']);
                        document.getElementById("price_plan_rtraza").innerHTML = formatearMoneda(data.plan_Rtraza['precio']);
                        $('.plan_RTraza').show();
                    }
                    if (data.plan_Dpdf != '') {
                        totalPlanes++
                        $('#p_dpdf').val(data.plan_Dpdf['id']);
                        $('#max_trans_dpdf').val(data.plan_Dpdf['max_transacion']);
                        iva += data.plan_Dpdf['retencion']['porcentaje_iva'];
                        reteICA += data.plan_Dpdf['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_Dpdf['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_Dpdf['retencion']['porcentaje_retefuente'];
                        monto += data.plan_Dpdf['precio'];
                        document.getElementById("name_plan_dpdf").innerHTML = data.plan_Dpdf['nombre'];
                        $('#desc_plan_dpdf').val(data.plan_Dpdf['descripcion']);
                        document.getElementById("price_plan_dpdf").innerHTML = formatearMoneda(data.plan_Dpdf['precio']);
                        $('.plan_DPdf').show();
                    }
                    if (data.plan_Rarch != '') {
                        totalPlanes++
                        $('#p_rarch').val(data.plan_Rarch['id']);
                        $('#max_trans_rarch').val(data.plan_Rarch['max_transacion']);
                        iva += data.plan_Rarch['retencion']['porcentaje_iva'];
                        reteICA += data.plan_Rarch['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_Rarch['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_Rarch['retencion']['porcentaje_retefuente'];
                        monto += data.plan_Rarch['precio'];
                        document.getElementById("name_plan_rarch").innerHTML = data.plan_Rarch['nombre'];
                        $('#desc_plan_rarch').val(data.plan_Rarch['descripcion']);
                        document.getElementById("price_plan_rarch").innerHTML = formatearMoneda(data.plan_Rarch['precio']);
                        $('.plan_RArch').show();
                    }
                    if (data.plan_Csv != '') {
                        totalPlanes++
                        $('#p_csv').val(data.plan_Csv['id']);
                        $('#max_trans_csv').val(data.plan_Csv['max_transacion']);
                        iva += data.plan_Csv['retencion']['porcentaje_iva'];
                        reteICA += data.plan_Csv['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_Csv['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_Csv['retencion']['porcentaje_retefuente'];
                        monto += data.plan_Csv['precio'];
                        document.getElementById("name_plan_csv").innerHTML = data.plan_Csv['nombre'];
                        $('#desc_plan_csv').val(data.plan_Csv['descripcion']);
                        document.getElementById("price_plan_csv").innerHTML = formatearMoneda(data.plan_Csv['precio']);
                        $('.plan_CSV').show();
                    }
                    if (data.plan_Gmanual != '') {
                        totalPlanes++
                        $('#p_gmanual').val(data.plan_Gmanual['id']);
                        $('#max_trans_gmanual').val(data.plan_Gmanual['max_transacion']);
                        iva += data.plan_Gmanual['retencion']['porcentaje_iva'];
                        reteICA += data.plan_Gmanual['retencion']['porcentaje_reteICA'];
                        reteIVA += data.plan_Gmanual['retencion']['porcentaje_reteIVA'];
                        reteFuente += data.plan_Gmanual['retencion']['porcentaje_retefuente'];
                        monto += data.plan_Gmanual['precio'];
                        document.getElementById("name_plan_gmanual").innerHTML = data.plan_Gmanual['nombre'];
                        $('#desc_plan_gmanual').val(data.plan_Gmanual['descripcion']);
                        document.getElementById("price_plan_gmanual").innerHTML = formatearMoneda(data.plan_Gmanual['precio']);
                        $('.plan_GManual').show();
                    }

                    aPagar = parseFloat(monto - (reteICA + reteIVA + reteFuente) + iva).toFixed(2);
                    monto = parseFloat(monto).toFixed(2);
                    iva = parseFloat(iva).toFixed(2);
                    reteICA = parseFloat(reteICA).toFixed(2);
                    reteIVA = parseFloat(reteIVA).toFixed(2);
                    reteFuente = parseFloat(reteFuente).toFixed(2);
                    $('#totalPlanes').val(totalPlanes);
                    $('#monto').val(monto);
                    $('#aPagar').val(aPagar);
                    $('#iva').val(iva);
                    $('#reteICA').val(reteICA);
                    $('#reteIVA').val(reteIVA);
                    $('#reteFuente').val(reteFuente);
                    $('#next_cplan').show();
                    $('#search_plan').hide();
                }

            },

            error: function (data) {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $("#modal-fail").modal("show");
            $('#search_plan').show();
            $('.planSlect').removeAttr('checked');
            $('#next').hide();
            $('#next_cplan').hide();
            $('.gift_loading').css('display', 'none');
            $('.loader-search_plan').fadeOut();
        });
    });

    $('#finish').on('click', function () {

        let opt = $('#opt').val();
        if (opt == '') {
            $('#opt').parent('div').addClass('has-error');
            $('#opt').parent('div').addClass('is-focused');
            return false;
        }

        var allCheckboxe = $('.cat_termino').length;
        if (!$('#cat_serComplentario_2').prop('checked')) {
            allCheckboxe--;
        }
        console.log(allCheckboxe);
        var allCheckboxesChecked = $('.cat_termino:checked').length === allCheckboxe;

        if (!allCheckboxesChecked) {
            $("#modal-message").modal("show");
            $("#modal-message .modal-body").html('Por favor, complete la seccion de términos y condiciones para continuar');
            $("#modal-message").modal({ 'show': true, backdrop: 'static', keyboard: false });
            return false;
        }


        var form = $('form').get(0);
        console.log(form);
        var fd = new FormData(form);
        $.ajax({
            url: 'store',
            type: 'POST',
            dataType: 'json',
            data: fd,
            beforeSend: function () {
                $('.btn-finish').hide();
                $('.gift_loading').css('display', 'block');
                $('.loader-p').fadeIn();
            },
            complete: function () {
                $('.gift_loading').css('display', 'none');
                $('.loader-p').fadeOut();
            },
            success: function (data) {
                console.log(data.id_enterprise);
                if (data.result == 0) {
                    if (data.used != '') {
                        if (data.used == 1) {
                            $('.Opt').hide();
                            $('#opt').val('');
                            $('#enviar').show();
                        } else {

                            $('#finish').show();
                        }
                    }
                    $("#modal-errors").modal("show");
                    $("#modal-errors .modal-body").html(data.errors);
                    $("#modal-errors").modal({ 'show': true, backdrop: 'static', keyboard: false });

                } else {
                    $('.btn-previous').hide();
                    $("#modal-message").modal("show");
                    $("#modal-message .modal-body").html('La Propuesta Comercial se guardo exitosamente, fue enviado correo a ' + data.email);
                    $("#modal-message").modal({ 'show': true, backdrop: 'static', keyboard: false });
                    setTimeout(function () {
                        location.reload(true);
                    }, 3200);
                }

            },
            error: function (data) {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $("#modal-fail").modal("show");
            $('#btn-finish').show();
            $('.gift_loading').css('display', 'none');
            $('.loader-p').fadeOut();
        });
    });

    $('#update').on('click', function () {
        var allCheckboxe = $('.cat_termino').length;
        if (!$('#cat_serComplentario_2').prop('checked')) {
            allCheckboxe--;
        }
        console.log(allCheckboxe);
        var allCheckboxesChecked = $('.cat_termino:checked').length === allCheckboxe;

        if (!allCheckboxesChecked) {
            $("#modal-message").modal("show");
            $("#modal-message .modal-body").html('Por favor, complete la seccion de términos y condiciones para continuar');
            $("#modal-message").modal({ 'show': true, backdrop: 'static', keyboard: false });
            return false;
        }

        var form = $('form').get(0);
        console.log(form);
        var fd = new FormData(form);
        $.ajax({
            url: '../update',
            type: 'POST',
            dataType: 'json',
            data: fd,
            beforeSend: function () {
                $('.btn-finish').hide();
                $('.gift_loading').css('display', 'block');
                $('.loader-p').fadeIn();
            },
            complete: function () {
                $('.gift_loading').css('display', 'none');
                $('.loader-p').fadeOut();
            },
            success: function (data) {
                console.log(data.id_enterprise);
                if (data.result == 0) {
                    if (data.used != '') {
                        if (data.used == 1) {
                            $('.Opt').hide();
                            $('#opt').val('');
                            $('#enviar').show();
                        } else {

                            $('#finish').show();
                        }
                    }
                    $("#modal-errors").modal("show");
                    $("#modal-errors .modal-body").html(data.errors);
                    $("#modal-errors").modal({ 'show': true, backdrop: 'static', keyboard: false });

                } else {
                    $('.btn-previous').hide();
                    $("#modal-message").modal("show");
                    $("#modal-message .modal-body").html('La Propuesta Comercial se actualizo exitosamente, fue enviado correo a ' + data.email);
                    $("#modal-message").modal({ 'show': true, backdrop: 'static', keyboard: false });

                }

            },
            error: function (data) {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $("#modal-fail").modal("show");
            $('#btn-finish').show();
            $('.gift_loading').css('display', 'none');
            $('.loader-p').fadeOut();
        });
    });

    $('#finish_attorney').on('click', function () {

        var form = $('form').get(0);
        console.log(form);
        var fd = new FormData(form);
        $.ajax({
            url: 'store_attorney',
            type: 'POST',
            dataType: 'json',
            data: fd,
            beforeSend: function () {
                $('.btn-finish').hide();
                $('.gift_loading').css('display', 'block');
                $('.loader-p').fadeIn();
            },
            complete: function () {
                $('.gift_loading').css('display', 'none');
                $('.loader-p').fadeOut();
            },
            success: function (data) {
                if (data.result == 0) {
                    $('#finish_attorney').show();
                    $("#modal-errors").modal("show");
                    $("#modal-errors .modal-body").html(data.errors);
                    $("#modal-errors").modal({ 'show': true, backdrop: 'static', keyboard: false });
                } else {
                    $("#modal-message").modal("show");
                    $("#modal-message .modal-body").html(data.message);
                    $("#modal-message").modal({ 'show': true, backdrop: 'static', keyboard: false });
                    setTimeout(function () {
                        location.reload(true);
                    }, 1600);

                }

            },
            error: function (data) {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $("#modal-fail").modal("show");
            $('#btn-finish').show();
            $('.gift_loading').css('display', 'none');
            $('.loader-p').fadeOut();
        });
    });


});
