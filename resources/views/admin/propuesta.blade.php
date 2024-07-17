<div style="padding: 25px">
    <div class="row">
        <div class="col-sm-12">
            <img src="{{ asset('propuesta/img/icon/header.png') }}" alt =''
                style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
                width="100%">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <h3><b>ORDEN DE COMPRA</b></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Validez desde: </b>
            {{ date_format($record->created_at, 'd-m-Y') }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Validez hasta: </b>
            {{ date_format($record->created_at, 't-m-Y') }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>NIT: </b>{{ $record->clienteComercial->company_id }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Razón Social / Nombre: </b>
            @if ($record->clienteComercial->person_type == '1')
                {{ $record->clienteComercial->name_socialreason }}
            @else
                {{ $record->clienteComercial->name_socialreason . ' ' . $record->clienteComercial->comercial_name }}
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Tipo de Contribuyente: </b>
            {{ $record->clienteComercial->tipoContribuyente->descripcion }}

        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Dirección: </b>{{ $record->clienteComercial->address }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-sm-offset-1" style="text-align:right;">
            <b>Municipio: </b>{{ mb_strtoupper($record->clienteComercial->municipio->description, 'UTF-8') }}
            &emsp;&emsp;
            <b>Departamento:
            </b>{{ mb_strtoupper($record->clienteComercial->municipio->departamento->description, 'UTF-8') }}&emsp;
            <b>País: </b>COLOMBIA
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Representante legal: </b>

            {{ $record->relacion->representante->nombre . ' ' . $record->relacion->representante->apellido }}

        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Nombre contacto de pagos: No Posee</b>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-sm-offset-2" style="text-align:right;">
            <b>Email principal: </b>
            {{ $record->relacion->representante->email }}
        </div>
        <div class="col-sm-3" style="text-align:right;">
            <b>Email Contacto de Pagos: </b>
            {{ $record->clienteComercial->email_billing_contact }}
        </div>
        <div class="col-sm-3" style="text-align:right;">
            <b>Email Radicación Facturas: </b>
            {{ $record->clienteComercial->email_invoices }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="text-align:right;">
            <b>Teléfono: </b>{{ $record->relacion->representante->telefono }}
        </div>
    </div>
    <br>
    <table width="100%" style="border-collapse: collapse;">
        <thead>
            <tr style="color: #FFFFFF">
                <th width="20%"
                    style="background-color: #408BC6;border-bottom-left-radius: 10px; border-top-left-radius: 10px">
                    Producto</th>
                <th width="40%" style="background-color: #408BC6;">Descripción</th>
                <th width="10%" style="background-color: #408BC6;">Cantidad</th>
                <th width="6%" style="background-color: #408BC6;">Validez</th>
                <th width="12%" style="background-color: #408BC6;">Precio</th>
                <th width="12%"
                    style="background-color: #408BC6;border-bottom-right-radius: 10px; border-top-right-radius: 10px">
                    Total</th>
            </tr>
        </thead>
        <tbody class="tproduct">
            @php
                use App\Models\VwDetallePropuesta;
                use App\Models\TransaccionDetallePropuesta;
                $detallePropuesta = VwDetallePropuesta::getDPropuesta($record->id);
                $i = 1;
            @endphp
            @foreach ($detallePropuesta as $value)
                <tr>
                    <td class="@if ($i % 2 == 0) td-0 @endif" align="center">
                        {{ $value['nombre_servicio'] }}</td>
                    @if ($value['id_cat_servicio'] == 9 || $value['id_cat_servicio'] == 10 || $value['id_cat_servicio'] == 12)
                        @php
                            $facturacion = '';
                            $nomina = '';
                            $transacciones = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                            foreach ($transacciones as $transaccion) {
                                if ($transaccion['id_cat_transaccion'] == 1) {
                                    $facturacion = 'Folios Facturación: ' . $transaccion['cantidad'];
                                }
                                if ($transaccion['id_cat_transaccion'] == 2) {
                                    $nomina = 'Folios Nómina: ' . $transaccion['cantidad'];
                                }
                            }
                        @endphp
                        <td class="@if ($i % 2 == 0) td-1 @endif">{{ $value['nombre_producto'] }}
                            @if ($facturacion != '')
                                <br> {{ $facturacion }}
                                @endif @if ($nomina != '')
                                    <br> {{ $nomina }}
                                @endif
                        </td>
                    @elseif ($value['id_cat_servicio'] == 11)
                        @php
                            $transacciones = TransaccionDetallePropuesta::getCantidad($value['id']);
                        @endphp
                        <td class="@if ($i % 2 == 0) td-1 @endif">{{ $value['nombre_producto'] }}<br>
                            Folios Recepción: {{ $transacciones['cantidad'] }}</td>
                    @else
                        <td class="@if ($i % 2 == 0) td-1 @endif">{{ $value['nombre_producto'] }}</td>
                    @endif

                    <td class="@if ($i % 2 == 0) td-1 @endif" align="center">{{ $value['cantidad'] }}
                    </td>
                    <td class="@if ($i % 2 == 0) td-1 @endif"></td>
                    <td class="@if ($i % 2 == 0) td-1 @endif" align="right">
                        {{ number_format($value['precio'] / $value['cantidad'], 2, ',', '.') }}</td>
                    <td class="@if ($i % 2 == 0) td-2 @else td-3 @endif" align="right">
                        {{ number_format($value['precio'], 2, ',', '.') }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach

        </tbody>

    </table>
    <hr>
    <br>
    <table width="100%">
        <tr>
            <td width="60%">
                <table width="90%" style="background-color: #E9E8E8;border-radius: 20px;padding: 10px;">
                    <tr>
                        <td style="padding: 10px 10px 5px 10px;"><b>Medio de adquisición:
                            </b>{{ $record->aliado->tipoAliado->descripcion }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 10px 5px 10px;"><b>Código Aliado:
                            </b>{{ $record->aliado->codigo_oficina_virtual }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 10px 10px 10px;"><b>Vendedor: </b>{{ $record->aliado->nombre }}</td>
                    </tr>
                </table>
            </td>
            <td width="40%">
                <table width="100%"
                    style="color: #FFFFFF;background-color: #408BC6;border-radius: 20px;padding: 10px;">
                    <tr>
                        <td align="left" style="padding: 10px 10px 5px 10px;"><b>SUBTOTAL: </b></td>
                        <td align="right" style="padding: 10px 10px 5px 10px;">
                            {{ number_format($record->subtotal, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td align="left" style="padding: 5px 10px 5px 10px;"><b>IVA: </b></td>
                        <td align="right" style="padding: 5px 10px 5px 10px;">
                            {{ number_format($record->iva, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td align="left" style="padding: 5px 10px 5px 10px;"><b>Retención IVA: </b></td>
                        <td align="right" style="padding: 5px 10px 5px 10px;">
                            {{ number_format($record->retencion_iva, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td align="left" style="padding: 5px 10px 5px 10px;"><b>Retención Fuente: </b></td>
                        <td align="right" style="padding: 5px 10px 5px 10px;">
                            {{ number_format($record->retencion_fuente, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td align="left" style="padding: 5px 10px 5px 10px;"><b>Retención ICA: </b></td>
                        <td align="right" style="padding: 5px 10px 5px 10px;">
                            {{ number_format($record->retencion_ica, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td align="left" style="padding: 5px 10px 10px 10px;"><b>NETO A PAGAR: </b></td>
                        <td align="right" style="padding: 5px 10px 10px 10px;">
                            {{ number_format($record->total, 2, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

