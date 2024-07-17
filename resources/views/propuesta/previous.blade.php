<div class="tab-pane" id="docPropuesta">
    <div class="row">
        <div class="col-sm-12">
            <a target="_blank" href="https://www.thefactoryhka.com/co/"><img
                    src="{{ asset('propuesta/img/icon/header.png') }}" alt
                    style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
                    width="100%"></a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <h3><b>COTIZACIÓN</b></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Validez desde: </b><strong class="sinn" style="text-transform:uppercase" id="valDesde"></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Validez hasta: </b><strong class="sinn" style="text-transform:uppercase" id="valHasta"></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>NIT: </b><strong class="sinn numNit" style="text-transform:uppercase"></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Razón Social / Nombre: </b><strong class="sinn razonSocial" style="text-transform:uppercase"></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Tipo de Contribuyente: </b><strong class="sinn" style="text-transform:uppercase"
                id="tipoContribuyente"></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Dirección: </b><strong class="sinn direccion" style="text-transform:uppercase"></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-sm-offset-1" style="text-align:right;">
            <b>Municipio: </b><strong class="sinn municipio" style="text-transform:uppercase"></strong>
        </div>
        <div class="col-sm-3" style="text-align:right;">
            <b>Departamento: </b><strong class="sinn departamento" style="text-transform:uppercase"></strong>
        </div>
        <div class="col-sm-3" style="text-align:right;">
            <b>País: </b>COLOMBIA
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Representante legal: </b><strong class="sinn repLegal" style="text-transform:uppercase"></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Nombre contacto de pagos: </b><strong class="sinn repLegal" style="text-transform:uppercase"></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-sm-offset-2" style="text-align:right;">
            <b>Email principal: </b><strong class="sinn emailRepLegal"></strong>
        </div>
        <div class="col-sm-3" style="text-align:right;">
            <b>Email Contacto de Pagos: </b><strong class="sinn" id="emailPagos"></strong>
        </div>
        <div class="col-sm-3" style="text-align:right;">
            <b>Email Radicación Facturas: </b><strong class="sinn" id="emailFacturas"></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Teléfono: </b><strong class="sinn telefono" style="text-transform:uppercase"></strong>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <table style="width:90%;margin-left:5%;margin-right:5%;">
                <tr>
                    <td>

                        <div class="row table-prop-head">
                            <div class="col-sm-2">
                                <b>Producto</b>
                            </div>
                            <div class="col-sm-4">
                                <b>Descripción</b>
                            </div>
                            <div class="col-sm-2">
                                <b>Cantidad</b>
                            </div>
                            <div class="col-sm-2">
                                <b>Precio</b>
                            </div>
                            <div class="col-sm-2">
                                <b>Total</b>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan plan_Emision">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planEmision"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="descPlanEmision"></strong>
                                <br>
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="detallePlanEmision"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPplanEmision">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceEmision"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceEmision"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan plan_Recepcion">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planRecepcion"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="descPlanRecepcion"></strong>
                                <br>
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="detallePlanRecepcion"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanRecepcion">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceRecepcion"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceRecepcion"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan plan_Portal_Recepcion">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="portalRecepcion"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="descPortalRecepcion"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPortalRecepcion">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="pricePortalRecepcion"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPricePortalRecepcion"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan plan_Horas">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planHoras"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="descPlanHoras"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanHoras"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceHoras"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceHoras"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan plan_RG">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planRG"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="descPlanRG"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanRG"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceRG"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceRG"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan plan_RG_plantilla">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="planRgPlantilla"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="descPlanRgPlantilla"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanRgPlantilla"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceRgPlantilla"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceRgPlantilla"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan plan_RG_Mod">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planRgMod"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="descPlanRgMod"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanRgMod">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceRgMod"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceRgMod"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan plan_RFactura">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planRFactura"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="descPlanRFactura"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanRFactura">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceRFactura"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceRFactura"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan plan_RClientes">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planRClientes"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="descPlanRClientes"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanRClientes">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceRClientes"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceRClientes"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan plan_RCliProc">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planRCliProc"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="descPlanRCliProc"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanRCliProc">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceRCliProc"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceRCliProc"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan plan_RProduct">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planRProduct"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="descPlanRProduct"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanRProduct">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceRProduct"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceRProduct"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan plan_RSecuen">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planRSecuen"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="descPlanRSecuen"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanRSecuen">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceRSecuen"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceRSecuen"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan plan_RTraza">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planRTraza"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="descPlanRTraza"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanRTraza">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceRTraza"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceRTraza"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan plan_DPdf">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planDPdf"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="descPlanDPdf"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanDPdf">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceDPdf"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceDPdf"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan plan_RArch">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planRArch"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="descPlanRArch"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanRArch">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceRArch"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceRArch"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan plan_CSV">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planCSV"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="descPlanCSV"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanCSV">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceCSV"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceCSV"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan plan_GManual">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planGManual"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="descPlanGManual"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanGManual">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceGManual"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceGManual"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan plan_Certificado">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="planCert"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="descPlanCert"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="cantPlanCert">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="priceCert"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="tPriceCert"></strong>
                            </div>
                        </div>
        </div>
        </td>
        </tr>
        </table>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-4 col-sm-offset-1">
        <table style="text-align:left;width:80%;margin-left:10%;margin-right:10%;">
            <tr>
                <td>
                    <div class="row table-agency">
                        <div class="col-sm-12" style="margin-top: 10px;">
                            <p style="font-size: 1.5rem;"><b><strong class="sinn"
                                        style="text-transform: uppercase;" id="clienteTipoExpediente"></strong></b>
                            </p>
                            <p class="plan tipoFactura"><b>Facturación: </b><strong class="sinn"
                                    id="tipoFactura"></strong></p>
                            <p class="plan tipoNomina"><b>Nómina: </b><strong class="sinn"
                                    id="tipoNomina"></strong></p>
                            <p class="plan plan_Recepcion"><b>Recepcion: </b><strong class="sinn"
                                    id="tipoRecepcion"></strong></p>
                            <p><b>Medio de adquisición: </b><strong class="sinn" style="text-transform: uppercase;"
                                    id="medioAdquisicion"></strong></p>
                            <p><b>Código Aliado: </b><strong class="sinn" style="text-transform: uppercase;"
                                    id="codeAgencia"></strong></p>
                            <p><b>Vendedor: </b><strong class="sinn" style="text-transform: uppercase;"
                                    id="nameVendor"></strong></p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-sm-6">
        <table style="text-align:left;width:80%;margin-left:10%;margin-right:10%;">
            <tr>
                <td>
                    <div class="row table-prices">
                        <div class="col-sm-12" style="padding: 20px;">
                            <div class="left col-sm-8">
                                <p><b>SUBTOTAL: </b></p>
                            </div>
                            <div class="right col-sm-4"><strong class="sinn" id="subtotal"></strong></div>
                            <!--<div class="left col-sm-8"><p><b>Descuento: </b></p></div><div class="right col-sm-4"><strong class="sinn" id="descuento" ></strong>0.00</div>-->
                            <!--<div class="left col-sm-8"><p><b>Subtotal - Descuento: </b></p></strong></div><div class="right col-sm-4"><strong class="sinn" id="totalCdescuento" ></strong></div>-->
                            <div class="left col-sm-8">
                                <p><b>IVA: </b></p>
                            </div>
                            <div class="right col-sm-4"><strong class="sinn" id="totalIva"></strong></div>
                            <div class="left col-sm-8">
                                <p><b>Retención IVA: </b></p>
                            </div>
                            <div class="right col-sm-4"><strong class="sinn" id="totalReteIva"></strong></div>
                            <div class="left col-sm-8">
                                <p><b>Retención Fuente: </b></p>
                            </div>
                            <div class="right col-sm-4"><strong class="sinn" id="totalReteFuente"></strong></div>
                            <div class="left col-sm-8">
                                <p><b>Retención ICA: </b></p>
                            </div>
                            <div class="right col-sm-4"><strong class="sinn" id="totalReteIca"></strong></div>
                            <div class="left col-sm-8">
                                <p><b>NETO A PAGAR: </b></p>
                            </div>
                            <div class="right col-sm-4"><strong class="sinn" id="totalPagar"></strong></div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">

        <table style="text-align:center;width:50%;">
            <tr style="border-collapse:collapse;">
                <td align="left" class="es-m-txt-l" style="padding:0;Margin:0;padding-top:10px;padding:2%;"
                    colspan="2">
                    <h5><b>Formas de Pago:</b></h5>
                </td>
            </tr>
            <tr>
                <td align="left" class="es-m-txt-l"
                    style="padding:0;Margin:0;padding-top:10px;padding:2%;vertical-align:middle;">
                    <ul
                        style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'Open Sans', sans-serif;line-height:21px;color:#7e7975; text-align: justify;">
                        <li>
                            <p>Clic para realizar el pago a través del Botón PSE </p>
                        </li>
                    </ul>
                </td>
                <td align="left" class="es-m-txt-l" style="padding:0;Margin:0;padding-top:10px;padding:2%;">
                    <a target="_blank" href="https://api.openpay.co/v1/mq779eh0ueqbmlsr468a/open-checkout"><img
                            src="https://ci3.googleusercontent.com/proxy/0Pzl0Y6OcIKKR6G_DNNBKQfGtp64dQwSLbzTKB2VRPU9IAKX_xNIS9A8SPjFH4B9ZTgGhhGD-20PRLqnSA_8m8Xkfi9ETTBs9W3X0VzZWfozTEpItxY7zL0K4Uo9il6UvRgms4eaV6Kjxac052AM5TWTUjAgqw=s0-d-e1-ft#https://mcusercontent.com/6bf40c37473871ae8545c1767/images/ab4fb117-320b-f51f-ab23-8a1a9bbebf46.png"
                            alt
                            style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
                            width="55%"></a>
                </td>
            </tr>
            <tr style="border-collapse:collapse;">
                <td align="left" class="es-m-txt-l"
                    style="padding:0;Margin:0;padding-top:10px;padding:2%;vertical-align:middle;">
                    <ul
                        style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'Open Sans', sans-serif;line-height:21px;color:#7e7975; text-align: justify;">
                        <li>
                            <p><b>BBVA</b> - Convenio de Recaudo # 0030540</p>
                        </li>
                    </ul>
                </td>
                <td align="left" class="es-m-txt-l" style="padding:0;Margin:0;padding-top:10px;padding:2%;">
                    <img src="https://ci3.googleusercontent.com/proxy/Qt8zNHNnMZVOzmb8AzwHC6zwOfDoHr8O86cX6M47ATa1v2cAOhySueqLkwyrXyycdbZxGJlU963PveIa1WprinZ2rzxBKn6d50PjtLco3-VIXrZu3FJoKPR9iehp9oOiBpoVDC7Xe0ESNLwWHIIuYHq-_rf4QA=s0-d-e1-ft#https://mcusercontent.com/6bf40c37473871ae8545c1767/images/61bd2a23-2051-fbe2-2a1d-de34eb072847.png"
                        alt
                        style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
                        width="60%">
                </td>
            </tr>
            <tr style="border-collapse:collapse;">
                <td align="left" class="es-m-txt-l"
                    style="padding:0;Margin:0;padding-top:10px;padding:2%;vertical-align:middle;">
                    <ul
                        style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'Open Sans', sans-serif;line-height:21px;color:#7e7975; text-align: justify;">
                        <li>
                            <p><b>Bancolombia</b> - Convenio de Recaudo # 76849 </p>
                        </li>
                    </ul>
                </td>
                <td align="left" class="es-m-txt-l" style="padding:0;Margin:0;padding-top:10px;padding:2%;">
                    <img src="https://ci5.googleusercontent.com/proxy/i9QFWmqYOOAHXxsQkE-m66G2ZEQXiDLVZFXjfDYrdH_JA7G6yr7XcWu1VTsLc83wGPSMI5SFC8uN8QMfkoTO7TYpazKh2j_fA-XgMUcHSDeiLQ_Y7B9_lk8R_WJtf0OZ6-pkgTS8mBiHKIYpbiv2Hl24LVweLg=s0-d-e1-ft#https://mcusercontent.com/6bf40c37473871ae8545c1767/images/f031da76-1020-8bf4-3de9-add0647dd743.png"
                        alt
                        style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
                        width="90%">
                </td>
            </tr>
        </table>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <p
            style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'Open Sans', sans-serif;line-height:21px;color:#7e7975; text-align: justify;">
            <b>Listado de documentos a Cargar:</b>
        </p>
        <br>
        <ul
            style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'Open Sans', sans-serif;line-height:21px;color:#7e7975; text-align: justify;">
            <div id="listaDocs"></div>
        </ul>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-10 col-sm-offset-1 PropuestaCondiciones" style="font-size: 12px; text-align: justify;">
        <h5><b>CONDICIONES DE COMPRA</b></h5>
        <p>Las siguientes disposiciones rigen las condiciones para la prestación de los servicios de DOCUMENTOS
            ELECTRÓNICOS CON FINES FISCALES por parte de <b>THE FACTORY HKA COLOMBIA S.A.S</b> y <b>EL SUSCRIPTOR</b>.
        </p>
        <br>
        <div id="condicionesCompra"></div>
    </div>
</div>
<br>
<!--
representante: <strong class="repLegal" style="text-transform:uppercase"></strong>
tipo de documento: <strong class="typeDoc" style="text-transform:uppercase"></strong>
numero de documento rl: <strong class="docRL" style="text-transform:uppercase"></strong>
direccion: <strong class="direccion" style="text-transform:uppercase"></strong>
municipio: <strong class="municipio" style="text-transform:uppercase"></strong>
departamento: <strong class="departamento" style="text-transform:uppercase"></strong>
telefono: <strong class="telefono" style="text-transform:uppercase"></strong>
email rl: <strong class="emailRepLegal"></strong>
razon social: <strong class="razonSocial" style="text-transform:uppercase"></strong>
nit: <strong class="numNit" style="text-transform:uppercase"></strong>
-->
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <h6>
            <b>DECLARACIÓN Y AUTORIZACIÓN DE TRATAMIENTO DE DATOS - HABEAS DATA.</b>
        </h6>
        <p style="font-size: 12px; text-align: justify;">
            Declaro conocer y autorizar a THE FACTORY HKA COLOMBIA SAS para obtener y reportar información sobre mi
            persona y la sociedad que represento a diversas bases de datos, conforme a la ley 1266/2008. Certifico que
            los fondos de mi representada provienen de actividades lícitas y certifico la veracidad de los datos
            suministrados. Asumo la responsabilidad exclusiva de cualquier error, exonerando a THE FACTORY HKA COLOMBIA
            SAS de responsabilidad legal. La empresa garantiza seguridad y transparencia en el uso de la información,
            conforme a la ley 1581 del 2012. Entiendo que firmada la presente orden de compra, inicia el proceso de
            prestación del servicio por parte de THE FACTORY HKA COLOMBIA SAS, sin posibilidad de devolución. Acepto que
            no realizan traspasos de transacciones electrónicas entre diferentes NIT. Las transacciones compradas se
            mantienen en caso de cambio de razón social o representación legal, siempre que el NIT permanezca igual.
        </p>
    </div>
</div>
<br>
@include('propuesta.terminos')
<br>
<div class="row">
    <div class="col-sm-12">
        <a target="_blank" href="https://www.thefactoryhka.com/co/"><img
                src="{{ asset('propuesta/img/icon/footer.png') }}" alt
                style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
                width="100%"></a>
    </div>
</div>
</div>
