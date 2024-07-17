@php
use App\Models\CatTerminos;
$terminos = json_decode($datos[0]->terminos_aceptados);
@endphp

<div class="tab-pane" id="Propuesta">
    <div class="row">
        <div class="col-sm-12">
            <a target="_blank" href="https://www.thefactoryhka.com/co/"><img
                    src="{{asset('propuesta/img/icon/header.png')}}" alt
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
            <b>Validez desde: </b><strong class="sinn" style="text-transform:uppercase">
                {{date_format($datos[1]->created_at,'d-m-Y')}}</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Validez hasta: </b><strong class="sinn" style="text-transform:uppercase">
                {{date_format($datos[1]->created_at,'t-m-Y')}}</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>NIT: </b><strong class="sinn" style="text-transform:uppercase">{{$datos[1]->company_id}}</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Razón Social / Nombre: </b><strong class="sinn" style="text-transform:uppercase">
                @if ($datos[1]->person_type == "1")
                {{$datos[1]->name_socialreason}}
                @else
                {{$datos[1]->name_socialreason. ' '.$datos[1]->comercial_name}}
                @endif
            </strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Tipo de Contribuyente: </b>
            <strong class="sinn" style="text-transform:uppercase">
                @foreach ($cat_type_taxpayer as $code => $description)
                @if ($code == $datos[1]->id_listaDocs_contribuyente)
                {{mb_strtoupper($description, 'UTF-8')}}
                @endif
                @endforeach
            </strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Dirección: </b><strong class="sinn" style="text-transform:uppercase">{{$datos[1]->address}}</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-sm-offset-1" style="text-align:right;">
            <b>Municipio: </b><strong class="sinn"
                style="text-transform:uppercase">{{mb_strtoupper($datos[2]->description, 'UTF-8')}}</strong>
        </div>
        <div class="col-sm-3" style="text-align:right;">
            <b>Departamento: </b>
            <strong class="sinn" style="text-transform:uppercase">
                @foreach ($cat_department as $code => $description)
                @if (intval($code) == $datos[2]->id_department)
                {{mb_strtoupper($description, 'UTF-8')}}
                @endif
                @endforeach
            </strong>
        </div>
        <div class="col-sm-3" style="text-align:right;">
            <b>País: </b>COLOMBIA
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Representante legal: </b>
            <strong class="sinn" style="text-transform:uppercase">
                {{$datos[3]->nombre.' '.$datos[3]->apellido}}
            </strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Nombre contacto de pagos: </b><strong class="sinn" style="text-transform:uppercase"></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-sm-offset-2" style="text-align:right;">
            <b>Email principal: </b><strong class="sinn">{{$datos[3]->email}}</strong>
        </div>
        <div class="col-sm-3" style="text-align:right;">
            <b>Email Contacto de Pagos: </b><strong class="sinn">{{$datos[1]->email_billing_contact}}</strong>
        </div>
        <div class="col-sm-3" style="text-align:right;">
            <b>Email Radicación Facturas: </b><strong class="sinn">{{$datos[1]->email_invoices}}</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Teléfono: </b><strong class="sinn" style="text-transform:uppercase">{{$datos[3]->telefono}}</strong>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <table style="text-align:center;width:90%;margin-left:5%;margin-right:5%;text-align:center;">
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
                        <div class="row table-prop-1 plan_select plan_selectCert">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planCert"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanCert"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPplanCert">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceCert"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceCert"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan_select plan_selectEmision">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planEmision"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanEmision"></strong>
                                <br>
                                <strong class="sinn" style="text-transform:uppercase" id="P-detallePlanEmision"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPplanEmision">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceEmision"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceEmision"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan_select plan_selectRecepcion">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planRecepcion"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanRecepcion"></strong>
                                <br>
                                <strong class="sinn" style="text-transform:uppercase" id="P-detallePlanRecepcion"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanRecepcion">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceRecepcion"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceRecepcion"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan_select plan_SelectPortal_Recepcion">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-portalRecepcion"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase"
                                    id="P-descPortalRecepcion"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPortalRecepcion">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-pricePortalRecepcion"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPricePortalRecepcion"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan_select plan_selectHoras">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planHoras"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanHoras"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanHoras"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceHoras"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceHoras"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan_select plan_selectRG">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planRG"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanRG"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanRG"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceRG"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceRG"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan_select plan_select_plRG">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planPlRG"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanPlRG"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanPlRG"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-pricePlRG"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPricePlRG"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan_select plan_select_modRG">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planmodRG"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanmodRG"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanmodRG">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-pricemodRG"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPricemodRG"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan_select plan_selectRFactura">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planRFactura"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanRFactura"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanRFactura">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceRFactura"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceRFactura"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan_select plan_selectRClientes">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planRClientes"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanRClientes"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanRClientes">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceRClientes"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceRClientes"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan_select plan_selectRCliProc">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planRCliProc"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanRCliProc"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanRCliProc">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceRCliProc"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceRCliProc"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan_select plan_selectRProduct">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planRProduct"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanRProduct"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanRProduct">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceRProduct"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceRProduct"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan_select plan_selectRSecuen">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planRSecuen"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanRSecuen"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanRSecuen">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceRSecuen"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceRSecuen"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan_select plan_selectRTraza">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planRTraza"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanRTraza"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanRTraza">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceRTraza"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceRTraza"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan_select plan_selectDPdf">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planDPdf"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanDPdf"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanDPdf">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceDPdf"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceDPdf"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan_select plan_selectRArch">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planRArch"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanRArch"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanRArch"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceRArch"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceRArch"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-1 plan_select plan_selectCSV">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planCSV"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanCSV"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanCSV">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceCSV"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceCSV"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan_select plan_selectGManual">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planGManual"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanGManual"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-cantPlanGManual">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceGManual"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceGManual"></strong>
                            </div>
                        </div>
                        <div class="row table-prop-2 plan plan_Certificado">
                            <div class="col-sm-2">
                                <strong class="sinn" style="text-transform:uppercase" id="P-planCert"></strong>
                            </div>
                            <div class="col-sm-4 table-prop-desc">
                                <strong class="sinn" style="text-transform:uppercase" id="P-descPlanCert"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn"  id="P-cantPlanCert">1</strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-priceCert"></strong>
                            </div>
                            <div class="col-sm-2">
                                <strong class="sinn" id="P-tPriceCert"></strong>
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
                                <p style="font-size: 1.5rem;"><b><strong class="sinn" style="text-transform: uppercase;" id="P-clienteTipoExpediente">
                                @if($clienteTipoExpediente==3)
                                    Cliente recompra
                                @else
                                    Cliente nuevo
                                @endif
                                <p class="plan_select P-tipoFactura"><b>Facturación: </b><strong class="sinn" id="P-tipoFactura"></strong></p>
                                <p class="plan_select P-tipoNomina"><b>Nómina: </b><strong class="sinn" id="P-tipoNomina"></strong></p>
                                <p class="plan_select plan_selectRecepcion"><b>Recepcion: </b><strong class="sinn" id="P-tipoRecepcion"></strong></p>
                                </strong></b></p>
                                <p><b>Medio de adquisición: </b>
                                    <strong class="sinn" style="text-transform:uppercase">
                                        @foreach ($cat_method as $code => $description)
                                        @if ($code == $aliado->tipo_aliado)
                                        {{mb_strtoupper($description, 'UTF-8')}}
                                        @endif
                                        @endforeach
                                    </strong>
                                </p>
                                <p><b>Código Aliado: </b><strong class="sinn" style="text-transform:uppercase"
                                        id="P-codeAgencia">{{$datos[0]->agency->codigo_oficina_virtual}}</strong></p>
                                <p><b>Vendedor: </b><strong class="sinn"
                                        style="text-transform:uppercase">{{$datos[0]->agency->nombre}}</strong></p>
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
                                <div class="left col-sm-7">
                                    <p><b>SUBTOTAL: </b></p>
                                </div>
                                <div class="right col-sm-5"><strong
                                        class="sinn"></strong>{{number_format($datos[0]->subtotal, 2, ',', '.')}}</div>
                                <div class="left col-sm-7">
                                    <p><b>IVA: </b></p>
                                </div>
                                <div class="right col-sm-5"><strong
                                        class="sinn">{{number_format($datos[0]->iva, 2, ',', '.')}}</strong></div>
                                <div class="left col-sm-7">
                                    <p><b>Retención IVA: </b></p>
                                </div>
                                <div class="right col-sm-5"><strong
                                        class="sinn">{{number_format($datos[0]->retencion_iva, 2, ',', '.')}}</strong>
                                </div>
                                <div class="left col-sm-7">
                                    <p><b>Retención Fuente: </b></p>
                                </div>
                                <div class="right col-sm-5"><strong
                                        class="sinn">{{number_format($datos[0]->retencion_fuente, 2, ',', '.')}}</strong>
                                </div>
                                <div class="left col-sm-7">
                                    <p><b>Retención ICA: </b></p>
                                </div>
                                <div class="right col-sm-5"><strong
                                        class="sinn">{{number_format($datos[0]->retencion_ica, 2, ',', '.')}}</strong>
                                </div>
                                <div class="left col-sm-7">
                                    <p><b>NETO A PAGAR: </b></p>
                                </div>
                                <div class="right col-sm-5"><strong
                                        class="sinn">{{number_format($datos[0]->total, 2, ',', '.')}}</strong></div>
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
            <ul id="pListaDocs" style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:'Open Sans', sans-serif;line-height:21px;color:#7e7975; text-align: justify;">
                @if ($listaDocs == 1)
                    <li>Cédula del Representante Legal</li>
                    <li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>
                    <li>Certificado de existencia y representación legal u otro documento que justifique la
                        representación legal de la empresa (fecha de expedición no mayor a 60 días)</li>
                    <li>Soporte de Pago.</li>
                    @elseif($listaDocs == 2)
                    <li>Cédula del Representante Legal</li>
                    <li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>
                    <li>Carta de Solicitud del Certificado Digital notariada (fecha de autenticación no mayor a 60 días)
                    </li>
                    <li>Soporte de Pago.</li>
                    @elseif($listaDocs == 3)
                    <li>Cédula del Representante Legal</li>
                    <li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>
                    <li>Certificado de existencia y representación legal u otro documento que justifique la
                        representación legal de la empresa (fecha de expedición no mayor a 60 días)</li>
                    <li>Soporte de Pago.</li>
                    @elseif($listaDocs == 4)
                    <li>Cédula del Representante Legal</li>
                    <li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>
                    <li>Carta de Solicitud del Certificado Digital notariada (fecha de autenticación no mayor a 60 días)
                    </li>
                    <li>Soporte de Pago.</li>
                    @else
                    <li>Soporte de Pago.</li>

                    @endif
            </ul>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 P-PropuestaCondiciones" style="font-size: 12px; text-align: justify;">
            <h5><b>CONDICIONES DE COMPRA</b></h5>
            <p>Las siguientes disposiciones rigen las condiciones para la prestación de los servicios de DOCUMENTOS ELECTRÓNICOS CON FINES FISCALES por parte de <b>THE FACTORY HKA COLOMBIA S.A.S</b> y <b>EL SUSCRIPTOR</b>.</p>
            <br>
            <div id="P-condicionesCompra" style="font-size: 12px; text-align: justify;"></div>
        </div>
    </div>
    {{--
        Yo <b><strong  style="text-transform:uppercase">{{$datos[3]->nombre.' '.$datos[3]->apellido}}</strong></b>, identificado con <strong id="typeDoc" style="text-transform:uppercase">{{$acronym}}</strong> N° <strong id="docRL" style="text-transform:uppercase">{{$datos[3]->identificacion}}</strong>, dirección de actividad comercial <b><strong  style="text-transform:uppercase">{{$datos[1]->address}}</strong></b>, domicilio de la actividad comercial en la ciudad <b><strong  style="text-transform:uppercase">{{mb_strtoupper($datos[2]->description, 'UTF-8')}}</strong></b>, <b><strong  style="text-transform:uppercase">@foreach ($cat_department as $code => $description) @if (intval($code) == $datos[2]->id_department){{mb_strtoupper($description, 'UTF-8')}} @endif @endforeach</strong></b>, telefono <b><strong  style="text-transform:uppercase">{{$datos[3]->telefono}}</strong></b>, correo electrónico <b><strong >{{$datos[3]->email}}</strong></b>,
                actuando en nombre propio y/o en la representación legal de la sociedad <b><strong  style="text-transform:uppercase">@if ($datos[1]->person_type == "1"){{$datos[1]->name_socialreason}}@else{{$datos[1]->name_socialreason. ' '.$datos[1]->comercial_name}} @endif</strong></b>, identificada con el NIT N° <b><strong  style="text-transform:uppercase">{{$datos[1]->company_id}}</strong></b>
    --}}
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <h6>
                <b>DECLARACIÓN Y AUTORIZACIÓN DE TRATAMIENTO DE DATOS - HABEAS DATA.</b>
            </h6>
            <p style="font-size: 12px; text-align: justify;">
                Declaro conocer y autorizar a THE FACTORY HKA COLOMBIA SAS para obtener y reportar información sobre mi persona y la sociedad que represento a diversas bases de datos, conforme a la ley 1266/2008. Certifico que los fondos de mi representada provienen de actividades lícitas y certifico la veracidad de los datos suministrados. Asumo la responsabilidad exclusiva de cualquier error, exonerando a THE FACTORY HKA COLOMBIA SAS  de responsabilidad legal. La empresa garantiza seguridad y transparencia en el uso de la información, conforme a la ley 1581 del 2012. Entiendo que firmada la presente orden de compra, inicia el proceso de prestación del servicio por parte de THE FACTORY HKA COLOMBIA SAS, sin posibilidad de devolución. Acepto que no realizan traspasos de transacciones electrónicas entre diferentes NIT. Las transacciones compradas se mantienen en caso de cambio de razón social o representación legal, siempre que el NIT permanezca igual.
            </p>
        </div>
    </div>
<br>

    @include('propuesta.terminos_aceptados')

    <br>
    <div class="row">
        <div class="col-sm-12">
            <a target="_blank" href="https://www.thefactoryhka.com/co/"><img
                    src="{{asset('propuesta/img/icon/footer.png')}}" alt
                    style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
                    width="100%"></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12"></div>
    <div class="col-sm-5 col-sm-offset-1 OptFirma">
        <div class="form-group label-floating">
            <label class="control-label">Código de autenticación<small class="text-danger"> *</small></label>
            <input id="optfirma" name="optfirma" type="text" class="form-control" maxlength="6">
            <input type="hidden" id="encriptado" name="encriptado" value="{{ $encrypt }}">
            <input type="hidden" id="terminoRg" name="terminoRg" value="false">
            <input type="hidden" id="terminosAceptados" name="terminosAceptados" value="{{ $datos[0]->terminos_aceptados!=''? 'true':'false' }}">
            <input type="hidden" id="userfirma" name="userfirma" value="">
        </div>
    </div>
</div>
