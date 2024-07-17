$(document).ready(function () {

    var idProductos = [];
    var form = $('#pCliente').get(0);
    var fd = new FormData(form);
    $.ajax({
        url: '../details',
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
            condionesCompra(idProductos);
        },
        success: function (data) {

            if (data.plan_emision != '') {
                idProductos.push(data.plan_emision['id']);
                document.getElementById("P-planEmision").innerHTML = data.plan_emision['nombre'];
                document.getElementById("P-descPlanEmision").innerHTML = data.plan_emision['descripcion'];
                let detallePlanFacturacion = 0;
                let detallePlanNomina = 0;
                data.transacciones.forEach(function (transaccion) {
                    if (transaccion['id_cat_transaccion'] == 1) {
                        detallePlanFacturacion = transaccion['cantidad'];
                        $('#cat_producto_1').prop('checked', true);
                        $('#div_cant_folios_1').removeClass("is-empty");
                        $('#cant_folios_1').val(transaccion['cantidad']);
                        $('#div_type_portal_1').removeClass("is-empty");
                        if(transaccion['id_cat_application_type']>0){
                            document.getElementById("P-tipoFactura").innerHTML = transaccion['id_cat_application_type'] ==1?'Portal WEB':'Integración';
                            $("#type_portal_1 option[value='" + transaccion['id_cat_application_type'] + "']").attr("selected", true);
                        }else{
                            $("#type_portal_1 option[value='" + 1 + "']").attr("selected", true);
                        }
                        $('.P-tipoFactura').show();
                        $('.cat_producto_1').show();
                    } else {
                        detallePlanNomina = transaccion['cantidad'];
                        $('#cat_producto_2').prop('checked', true);
                        $('#div_cant_folios_2').removeClass("is-empty");
                        $('#cant_folios_2').val(transaccion['cantidad']);
                        $('#div_type_portal_2').removeClass("is-empty");
                        if(transaccion['id_cat_application_type']>0){
                            document.getElementById("P-tipoNomina").innerHTML = transaccion['id_cat_application_type'] ==1?'Portal WEB':'Integración';
                            $("#type_portal_2 option[value='" + transaccion['id_cat_application_type'] + "']").attr("selected", true);
                        }else{
                            $("#type_portal_2 option[value='" + 1 + "']").attr("selected", true);
                        }
                        $('.P-tipoNomina').show();
                        $('.cat_producto_2').show();
                    }
                });
                if (detallePlanFacturacion > 0 && detallePlanNomina > 0) {
                    document.getElementById("P-detallePlanEmision").innerHTML = 'Folios Facturación: ' + detallePlanFacturacion + '<br>Folios Nómina: ' + detallePlanNomina;
                } else if (detallePlanFacturacion == 0 && detallePlanNomina > 0) {
                    document.getElementById("P-detallePlanEmision").innerHTML = 'Folios Nómina: ' + detallePlanNomina;
                } else if (detallePlanFacturacion > 0 && detallePlanNomina == 0) {
                    document.getElementById("P-detallePlanEmision").innerHTML = 'Folios Facturación: ' + detallePlanFacturacion;
                }
                let cantTranEmision = parseInt(detallePlanFacturacion)+parseInt(detallePlanNomina);
                if(data.plan_emision['id']==248||data.plan_emision['id']==249||data.plan_emision['id']==250){

                    document.getElementById("P-priceEmision").innerHTML = formatearMoneda(data.plan_emision_price*cantTranEmision);
                    document.getElementById("P-tPriceEmision").innerHTML = formatearMoneda(data.plan_emision_price*cantTranEmision);
                }else{
                    document.getElementById("P-priceEmision").innerHTML = formatearMoneda(data.plan_emision_price);
                    document.getElementById("P-tPriceEmision").innerHTML = formatearMoneda(data.plan_emision_price);
                }
                $('.plan_selectEmision').show();
                if (data.plan_emision['id_type_servicio'] != '12') {
                    $('#cat_producto_4').prop('checked', true);
                    $('.cat_producto_4').show();
                    switch (data.plan_emision['id_type_servicio']) {
                        case '9':
                            $('#div_time_format_linkage_4').removeClass("is-empty");
                            $("#time_format_linkage option[value='" + 1 + "']").attr("selected", true);
                            break;
                        case '10':
                            $('#div_time_format_linkage_4').removeClass("is-empty");
                            $("#time_format_linkage option[value='" + 2 + "']").attr("selected", true);
                            break;
                    }

                }
            }
            if (data.plan_recepcion != '') {
                $('#cat_producto_3').prop('checked', true);
                idProductos.push(data.plan_recepcion['id']);
                document.getElementById("P-planRecepcion").innerHTML = data.plan_recepcion['nombre'];
                document.getElementById("P-descPlanRecepcion").innerHTML = data.plan_recepcion['descripcion'];
                let detallePlanRecepcion = 0;
                let tipoRecepcion = 0;
                data.transaccionesR.forEach(function (transaccion) {
                    detallePlanRecepcion = transaccion['cantidad'];
                    tipoRecepcion = transaccion['id_cat_application_type'];
                });
                document.getElementById("P-detallePlanRecepcion").innerHTML = 'Folios Recepción: ' + detallePlanRecepcion;
                document.getElementById("P-priceRecepcion").innerHTML = formatearMoneda(data.plan_recepcion_price);
                document.getElementById("P-tPriceRecepcion").innerHTML = formatearMoneda(data.plan_recepcion_price);
                $('.plan_selectRecepcion').show();
                data.plan_portal_recepcion != '' ? $("#no").attr('checked', 'checked') : $("#si").attr('checked', 'checked');
                $('#div_cant_folios_3').removeClass("is-empty");
                $('#cant_folios_3').val(data.plan_recepcion['max_transacion']);
                $('#div_type_portal_3').removeClass("is-empty");
                if(tipoRecepcion>0){
                    document.getElementById("P-tipoRecepcion").innerHTML = tipoRecepcion==1?'Portal WEB':'Integración';
                    $("#type_portal_3 option[value='" + tipoRecepcion + "']").attr("selected", true);
                }else{
                    $("#type_portal_3 option[value='" + 1 + "']").attr("selected", true);
                }
                $('.cat_producto_3').show();
            }
            if (data.plan_portal_recepcion != '') {
                idProductos.push(data.plan_portal_recepcion['id']);
                document.getElementById("P-portalRecepcion").innerHTML = data.plan_portal_recepcion['nombre'];
                document.getElementById("P-descPortalRecepcion").innerHTML = data.plan_portal_recepcion['descripcion'];
                document.getElementById("P-pricePortalRecepcion").innerHTML = formatearMoneda(data.plan_portal_recepcion_price);
                document.getElementById("P-tPricePortalRecepcion").innerHTML = formatearMoneda(data.plan_portal_recepcion_price);
                $('.plan_SelectPortal_Recepcion').show();
            }
            if (data.plan_certificado != '') {
                idProductos.push(data.plan_certificado['id']);
                document.getElementById("P-planCert").innerHTML = data.plan_certificado['nombre'];
                document.getElementById("P-descPlanCert").innerHTML = data.plan_certificado['descripcion'];
                document.getElementById("P-priceCert").innerHTML = formatearMoneda(data.plan_certificado_price);
                document.getElementById("P-tPriceCert").innerHTML = formatearMoneda(data.plan_certificado_price);
                $('.plan_selectCert').show();
                $('#cat_producto_4').prop('checked', true);
                $('.cat_producto_4').show();
                $('#div_time_format_linkage_4').removeClass("is-empty");
                $("#time_format_linkage option[value='" + data.plan_recepcion['max_transacion'] + "']").attr("selected", true);
            }
            if (data.plan_horas != '') {
                idProductos.push(data.plan_horas['id']);
                document.getElementById("P-planHoras").innerHTML = data.plan_horas['nombre'];
                document.getElementById("P-descPlanHoras").innerHTML = data.plan_horas['descripcion'];
                document.getElementById("P-cantPlanHoras").innerHTML = formatearMoneda(data.plan_horas_cant);
                document.getElementById("P-priceHoras").innerHTML = formatearMoneda(data.plan_horas_price);
                document.getElementById("P-tPriceHoras").innerHTML = formatearMoneda(data.plan_horas_cantPrice);
                $('.plan_selectHoras').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_1').prop('checked', true);
                $('.cat_serComplentario_1').show();
                $('#div_cant_folios_serComplentario_1').removeClass("is-empty");
                $('#cant_folios_serComplentario_1').val(data.plan_horas_cant);
            }
            if (data.plan_rg != '') {
                idProductos.push(data.plan_rg['id']);
                document.getElementById("P-planRG").innerHTML = data.plan_rg['nombre'];
                document.getElementById("P-descPlanRG").innerHTML = data.plan_rg['descripcion'];
                document.getElementById("P-cantPlanRG").innerHTML = formatearMoneda(data.plan_rg_cant);
                document.getElementById("P-priceRG").innerHTML = formatearMoneda(data.plan_rg_price);
                document.getElementById("P-tPriceRG").innerHTML = formatearMoneda(data.plan_rg_cantPrice);
                $('.plan_selectRG').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_2').prop('checked', true);
                $('.cat_serComplentario_2').show();
                $('#cat_type_rg_241').prop('checked', true);
                $('.cat_type_rg_241').show();
                $('#div_cant_type_rg_241').removeClass("is-empty");
                $('#cant_type_rg_241').val(data.plan_rg_cant);
                $('#div_termino_firma_4').show();
            }
            if (data.plan_plantilla != '') {
                idProductos.push(data.plan_plantilla['id']);
                document.getElementById("P-planPlRG").innerHTML = data.plan_plantilla['nombre'];
                document.getElementById("P-descPlanPlRG").innerHTML = data.plan_plantilla['descripcion'];
                document.getElementById("P-cantPlanPlRG").innerHTML = formatearMoneda(data.plan_plRg_cant);
                document.getElementById("P-pricePlRG").innerHTML = formatearMoneda(data.plan_plRg_price);
                document.getElementById("P-tPricePlRG").innerHTML = formatearMoneda(data.plan_plRg_cantPrice);
                $('.plan_select_plRG').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_2').prop('checked', true);
                $('.cat_serComplentario_2').show();
                $('#cat_type_rg_2').prop('checked', true);
                $('.cat_type_rg_2').show();
                $('#div_cant_type_rg_2').removeClass("is-empty");
                $('#cant_type_rg_2').val(data.plan_plRg_cant);
                $('#div_termino_firma_4').show();
            }
            if (data.plan_modRg != '') {
                idProductos.push(data.plan_modRg['id']);
                document.getElementById("P-planmodRG").innerHTML = data.plan_modRg['nombre'];
                document.getElementById("P-descPlanmodRG").innerHTML = data.plan_modRg['descripcion'];
                document.getElementById("P-pricemodRG").innerHTML = formatearMoneda(data.plan_modRg_price);
                document.getElementById("P-tPricemodRG").innerHTML = formatearMoneda(data.plan_modRg_price);
                $('.plan_select_modRG').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_2').prop('checked', true);
                $('.cat_serComplentario_2').show();
                $('#cat_type_rg_242').prop('checked', true);
                $('.cat_type_rg_242').show();
                $('#div_cant_type_rg_242').removeClass("is-empty");
                $("#cant_type_rg_242 option[value='" + data.plan_modRg['id'] + "']").attr("selected", true);
                $('#div_termino_firma_4').show();
            }
            if (data.plan_Reporte_facturas != '') {
                idProductos.push(data.plan_Reporte_facturas['id']);
                document.getElementById("P-planRFactura").innerHTML = data.plan_Reporte_facturas['nombre'];
                document.getElementById("P-descPlanRFactura").innerHTML = data.plan_Reporte_facturas['descripcion'];
                document.getElementById("P-priceRFactura").innerHTML = formatearMoneda(data.plan_Reporte_facturas_price);
                document.getElementById("P-tPriceRFactura").innerHTML = formatearMoneda(data.plan_Reporte_facturas_price);
                $('.plan_selectRFactura').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_3').prop('checked', true);
                $('.cat_serComplentario_3').show();
                $('#cat_type_reporte_3').prop('checked', true);
            }
            if (data.plan_Reporte_clientes != '') {
                idProductos.push(data.plan_Reporte_clientes['id'])
                document.getElementById("P-planRClientes").innerHTML = data.plan_Reporte_clientes['nombre'];
                document.getElementById("P-descPlanRClientes").innerHTML = data.plan_Reporte_clientes['descripcion'];
                document.getElementById("P-priceRClientes").innerHTML = formatearMoneda(data.plan_Reporte_clientes_price);
                document.getElementById("P-tPriceRClientes").innerHTML = formatearMoneda(data.plan_Reporte_clientes_price);
                $('.plan_selectRClientes').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_3').prop('checked', true);
                $('.cat_serComplentario_3').show();
                $('#cat_type_reporte_4').prop('checked', true);
            }
            if (data.plan_Reporte_productos != '') {
                idProductos.push(data.plan_Reporte_productos['id'])
                document.getElementById("P-planRProduct").innerHTML = data.plan_Reporte_productos['nombre'];
                document.getElementById("P-descPlanRProduct").innerHTML = data.plan_Reporte_productos['descripcion'];
                document.getElementById("P-priceRProduct").innerHTML = formatearMoneda(data.plan_Reporte_productos_price);
                document.getElementById("P-tPriceRProduct").innerHTML = formatearMoneda(data.plan_Reporte_productos_price);
                $('.plan_selectRProduct').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_3').prop('checked', true);
                $('.cat_serComplentario_3').show();
                $('#cat_type_reporte_5').prop('checked', true);
            }
            if (data.plan_Reporte_clientes__productos != '') {
                idProductos.push(data.plan_Reporte_clientes__productos['id'])
                document.getElementById("P-planRCliProc").innerHTML = data.plan_Reporte_clientes__productos['nombre'];
                document.getElementById("P-descPlanRCliProc").innerHTML = data.plan_Reporte_clientes__productos['descripcion'];
                document.getElementById("P-priceRCliProc").innerHTML = formatearMoneda(data.plan_Reporte_clientes__productos_price);
                document.getElementById("P-tPriceRCliProc").innerHTML = formatearMoneda(data.plan_Reporte_clientes__productos_price);
                $('.plan_selectRCliProc').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_3').prop('checked', true);
                $('.cat_serComplentario_3').show();
                $('#cat_type_reporte_6').prop('checked', true);
            }
            if (data.plan_Reporte_secuenciales != '') {
                idProductos.push(data.plan_Reporte_secuenciales['id'])
                document.getElementById("P-planRSecuen").innerHTML = data.plan_Reporte_secuenciales['nombre'];
                document.getElementById("P-descPlanRSecuen").innerHTML = data.plan_Reporte_secuenciales['descripcion'];
                document.getElementById("P-priceRSecuen").innerHTML = formatearMoneda(data.plan_Reporte_secuenciales_price);
                document.getElementById("P-tPriceRSecuen").innerHTML = formatearMoneda(data.plan_Reporte_secuenciales_price);
                $('.plan_selectRSecuen').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_3').prop('checked', true);
                $('.cat_serComplentario_3').show();
                $('#cat_type_reporte_7').prop('checked', true);
            }
            if (data.plan_Rtraza != '') {
                idProductos.push(data.plan_Rtraza['id']);
                document.getElementById("P-planRTraza").innerHTML = data.plan_Rtraza['nombre'];
                document.getElementById("P-descPlanRTraza").innerHTML = data.plan_Rtraza['descripcion'];
                document.getElementById("P-priceRTraza").innerHTML = formatearMoneda(data.plan_Rtraza_price);
                document.getElementById("P-tPriceRTraza").innerHTML = formatearMoneda(data.plan_Rtraza_price);
                $('.plan_selectRTraza').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_3').prop('checked', true);
                $('.cat_serComplentario_3').show();
                $('#cat_type_reporte_8').prop('checked', true);
                $('#div_cant_reporte_traza').removeClass("is-empty");
                $('.cant_reporte_traza').show();
                $('#cant_reporte_traza').val(data.plan_Rtraza['max_transacion']);
            }
            if (data.plan_Dpdf != '') {
                idProductos.push(data.plan_Dpdf['id']);
                document.getElementById("P-planDPdf").innerHTML = data.plan_Dpdf['nombre'];
                document.getElementById("P-descPlanDPdf").innerHTML = data.plan_Dpdf['descripcion'];
                document.getElementById("P-priceDPdf").innerHTML = formatearMoneda(data.plan_Dpdf_price);
                document.getElementById("P-tPriceDPdf").innerHTML = formatearMoneda(data.plan_Dpdf_price);
                $('.plan_selectDPdf').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_4').prop('checked', true);
                $('.cat_serComplentario_4').show();
                $('#div_cant_folios_serComplentario_4').removeClass("is-empty");
                $('#cant_folios_serComplentario_4').val(data.plan_Dpdf['max_transacion']);
            }
            if (data.plan_Rarch != '') {
                idProductos.push(data.plan_Rarch['id']);
                document.getElementById("P-planRArch").innerHTML = data.plan_Rarch['nombre'];
                document.getElementById("P-descPlanRArch").innerHTML = data.plan_Rarch['descripcion'];
                document.getElementById("P-cantPlanRArch").innerHTML = formatearMoneda(data.plan_Rarch_cant);
                document.getElementById("P-priceRArch").innerHTML = formatearMoneda(data.plan_Rarch_price);
                document.getElementById("P-tPriceRArch").innerHTML = formatearMoneda(data.plan_Rarch_price);
                $('.plan_selectRArch').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_6').prop('checked', true);
                $('.cat_serComplentario_6').show();
                $('#div_cant_folios_serComplentario_6').removeClass("is-empty");
                $('#cant_folios_serComplentario_6').val(data.plan_Rarch_cant);
            }
            if (data.plan_Csv != '') {
                idProductos.push(data.plan_Csv['id']);
                document.getElementById("P-planCSV").innerHTML = data.plan_Csv['nombre'];
                document.getElementById("P-descPlanCSV").innerHTML = data.plan_Csv['descripcion'];
                document.getElementById("P-priceCSV").innerHTML = formatearMoneda(data.plan_Csv_price);
                document.getElementById("P-tPriceCSV").innerHTML = formatearMoneda(data.plan_Csv_price);
                $('.plan_selectCSV').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_7').prop('checked', true);
                $('.cat_serComplentario_7').show();
                $('#div_cant_folios_serComplentario_7').removeClass("is-empty");
                $('#cant_folios_serComplentario_7').val(data.plan_Csv['max_transacion']);
            }
            if (data.plan_Gmanual != '') {
                idProductos.push(data.plan_Gmanual['id']);
                document.getElementById("P-planGManual").innerHTML = data.plan_Gmanual['nombre'];
                document.getElementById("P-descPlanGManual").innerHTML = data.plan_Gmanual['descripcion'];
                document.getElementById("P-priceGManual").innerHTML = formatearMoneda(data.plan_Gmanual_price);
                document.getElementById("P-tPriceGManual").innerHTML = formatearMoneda(data.plan_Gmanual_price);
                $('.plan_selectGManual').show();
                $('#cat_producto_5').prop('checked', true);
                $('.cat_producto_5').show();
                $('#cat_serComplentario_8').prop('checked', true);
                $('.cat_serComplentario_8').show();
                $('#div_cant_folios_serComplentario_8').removeClass("is-empty");
                $('#cant_folios_serComplentario_8').val(data.plan_Csv['max_transacion']);
            }
        },
        error: function (data) {
            console.log(data);
        },
        cache: false,
        contentType: false,
        processData: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $('.gift_loading').css('display', 'none');
        $('.loader-search').fadeOut();
    });

});
function condionesCompra(idProductos) {
    $('.P-PropuestaCondiciones').hide();
    idProductos.forEach(function (valor) {
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
                document.getElementById("P-condicionesCompra").innerHTML += response;
                $('.P-PropuestaCondiciones').show();
                //console.log(response);
            },
            error: function (error) {
                $('.P-PropuestaCondiciones').hide();
                //console.log(error);
            }
        });
        //console.log(valor);
    });
}
