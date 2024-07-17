<html>

<head>
    <title>Orden de compra</title>
    <link rel="stylesheet" href="{{ asset('propuesta/detalle/css/styles.css') }}">
    <style>
        #watermark {
            position: fixed;
            bottom: 0px;
            left: 0px;
            /** El ancho y la altura pueden cambiar
                según las dimensiones de su membrete
            **/
            width: 21.8cm;
            height: 28cm;
            opacity: 0.5;
            /** Tu marca de agua debe estar detrás de cada contenido **/
            z-index: -1000;
        }
    </style>
</head>

<body>
    @if ($ambiente != 'production')
        <div id="watermark">
            <img src="{{ asset('propuesta/img/no_valido.png') }}" height="100%" width="100%" />
        </div>
    @endif
    @php
        use App\Models\CatTerminos;
        $terminos = json_decode($datos[0]->terminos_aceptados);
    @endphp
    <header>
        <img src="{{ asset('propuesta/img/icon/header.png') }}" alt
            style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
            width="100%" height="100%">
        <table class="datosHeader">
            <tr>
                <td colspan="3" align="right">
                    <h3><b>ORDEN DE COMPRA</b></h3>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="right"><b>Validez desde: </b>
                    {{ date_format($datos[1]->created_at, 'd-m-Y') }}</td>
            </tr>
            <tr>
                <td colspan="3" align="right"><b>Validez hasta: </b>
                    {{ date_format($datos[1]->created_at, 't-m-Y') }}</td>
            </tr>
            <tr>
                <td colspan="3" align="right"><b>NIT: </b>{{ $datos[1]->company_id }}</td>
            </tr>
            <tr>
                <td colspan="3" align="right"><b>
                        @if ($datos[1]->person_type == '1')
                            Razón Social
                        @else
                            Nombre
                        @endif :
                    </b>
                    @if ($datos[1]->person_type == '1')
                        {{ $datos[1]->name_socialreason }}
                    @else
                        {{ $datos[1]->name_socialreason . ' ' . $datos[1]->comercial_name }}
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="3" align="right"><b>Tipo de Contribuyente: </b>{{ $datos[1]->tipo_contribuyente }}</td>
            </tr>
            <tr>
                <td colspan="3" align="right"><b>Dirección: </b>{{ $datos[1]->address }}</td>
            </tr>
            <tr>
                <td width="33%" align="right"><b>Municipio:
                    </b>{{ mb_strtoupper($datos[2]->description, 'UTF-8') }}
                </td>
                <td width="33%" align="right"><b>Departamento:
                    </b>{{ mb_strtoupper($datos[2]->department, 'UTF-8') }}</td>
                <td width="33%" align="right"><b>País: </b>COLOMBIA</td>
            </tr>
            <tr>
                <td colspan="3" align="right"><b>Representante legal:
                    </b>{{ mb_strtoupper($datos[3]->nombre . ' ' . $datos[3]->apellido, 'UTF-8') }}</td>
            </tr>
            <tr>
                <td colspan="3" align="right"><b>Nombre contacto de pagos:
                    </b>{{ mb_strtoupper($datos[3]->nombre . ' ' . $datos[3]->apellido, 'UTF-8') }}</td>
            </tr>
            <tr>
                <td width="33%" align="center"><b>Email principal: </b></td>
                <td width="33%" align="center"><b>Email Contacto de Pagos: </b></td>
                <td width="33%" align="center"><b>Email Radicación Facturas: </b></td>
            </tr>
            <tr>
                <td width="33%" align="center">{{ $datos[3]->email }}</td>
                <td width="33%" align="center">{{ $datos[1]->email_billing_contact }}</td>
                <td width="33%" align="center">{{ $datos[1]->email_invoices }}</td>
            </tr>
            <tr>
                <td colspan="3" align="right"><b>Teléfono: </b>{{ $datos[3]->telefono }}</td>
            </tr>
        </table>
    </header>
    <footer>
        <img src="{{ asset('propuesta/img/icon/footer.png') }}" alt
            style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
            width="100%" height="100%">
    </footer>
    <main>
        <table width="100%">
            <tbody>
                <tr>
                    <td colspan="3" align="right">
                        <table width="100%" style="border-collapse: collapse;">
                            <thead>
                                <tr style="color: #FFFFFF;background-color: #408BC6">
                                    <th width="20%"
                                        style="border-bottom-left-radius: 10px; border-top-left-radius: 10px">Producto
                                    </th>
                                    <th width="46%">Descripción</th>
                                    <th width="10%">Cantidad</th>
                                    <th width="12%">Precio</th>
                                    <th width="12%"
                                        style="border-bottom-right-radius: 10px; border-top-right-radius: 10px">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="tproduct">
                                @php
                                    $row = 2;
                                    $detallePlanFacturacion = 0;
                                    $detallePlanNomina = 0;
                                    $foliosEmision = '';
                                    $tipoFoliosFacturacion = '';
                                    $tipoFoliosNomina = '';
                                    $foliosRecepcion = '';
                                    $tipoFoliosRecepcion = '';
                                    if ($servicioEm) {
                                        foreach ($transacciones as $transaccion) {
                                            if ($transaccion['id_cat_transaccion'] == 1) {
                                                $detallePlanFacturacion = $transaccion['cantidad'];
                                                $tipoFoliosFacturacion = $transaccion['id_cat_application_type'];
                                            } else {
                                                $detallePlanNomina = $transaccion['cantidad'];
                                                $tipoFoliosNomina = $transaccion['id_cat_application_type'];
                                            }
                                        }
                                        if ($detallePlanFacturacion > 0 && $detallePlanNomina > 0) {
                                            $foliosEmision =
                                                'Folios Facturación: ' .
                                                $detallePlanFacturacion .
                                                '<br> Folios Nómina: ' .
                                                $detallePlanNomina;
                                        } elseif ($detallePlanFacturacion == 0 && $detallePlanNomina > 0) {
                                            $foliosEmision = 'Folios Nómina: ' . $detallePlanNomina;
                                        } elseif ($detallePlanFacturacion > 0 && $detallePlanNomina == 0) {
                                            $foliosEmision = 'Folios Facturación: ' . $detallePlanFacturacion;
                                        }
                                    }

                                    if ($servicioRe) {
                                        foreach ($transaccionesR as $transaccion) {
                                            if ($transaccion['id_cat_transaccion'] == 3) {
                                                $detallePlanRecepcion = $transaccion['cantidad'];
                                                $tipoFoliosRecepcion = $transaccion['id_cat_application_type'];
                                            }
                                        }
                                        $foliosRecepcion = 'Folios Recepcion: ' . $detallePlanRecepcion;
                                    }
                                @endphp
                                @foreach ($detallePropuesta as $value)
                                    $row--;
                                    <tr>
                                        <td align="center"
                                            style="border-bottom-left-radius: 10px; border-top-left-radius: 10px">
                                            {{ $value['nombre_producto'] }}</td>

                                        <td>{{ $value['descripcion_producto'] }} <br>
                                            @php
                                                switch ($value['id_cat_servicio']) {
                                                    case 9:
                                                        echo $foliosEmision;
                                                        break;
                                                    case 10:
                                                        echo $foliosEmision;
                                                        break;
                                                    case 11:
                                                        echo $foliosRecepcion;
                                                        break;
                                                    case 12:
                                                        echo $foliosEmision;
                                                        break;
                                                }
                                            @endphp
                                        </td>
                                        <td align="center">{{ $value['cantidad'] }}</td>
                                        <td align="right">
                                            @if ($value['id_plan_producto'] == 248 || $value['id_plan_producto'] == 249 || $value['id_plan_producto'] == 250)
                                                {{ number_format($value['precio'] * ($detallePlanFacturacion + $detallePlanNomina), 2, ',', '.') }}
                                            @else
                                                {{ number_format($value['precio'] / $value['cantidad'], 2, ',', '.') }}
                                            @endif
                                        </td>
                                        <td align="right"
                                            style="border-bottom-right-radius: 10px; border-top-right-radius: 10px">
                                            @if ($value['id_plan_producto'] == 248 || $value['id_plan_producto'] == 249 || $value['id_plan_producto'] == 250)
                                                {{ number_format($value['precio'] * ($detallePlanFacturacion + $detallePlanNomina), 2, ',', '.') }}
                                            @else
                                                {{ number_format($value['precio'], 2, ',', '.') }}
                                        </td>
                                @endif
                </tr>
                @endforeach
                @if ($row > 0)
                    @for ($i = 0; $i < $row; $i++)
                        <tr>
                            <td style="border-bottom-left-radius: 10px; border-top-left-radius: 10px">
                                &nbsp;
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="border-bottom-right-radius: 10px; border-top-right-radius: 10px">
                                &nbsp;
                            </td>
                        </tr>
                    @endfor
                @endif
            </tbody>

        </table>
        </td>
        </tr>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" width="60%" style="padding-left: 20px;">
                    <table width="80%" style="background-color: #E9E8E8;border-radius: 20px;padding: 10px;">
                        <tr>
                            <td style="margin-top: 10px;">
                                <p>
                                    <b>
                                        @if ($datos[0]->tipo == 3)
                                            Cliente Recompra
                                        @else
                                            Cliente Nuevo
                                        @endif
                                    </b>
                                </p>
                            </td>
                        </tr>
                        @if ($tipoFoliosFacturacion != '')
                            <tr>
                                <td><b>Facturación: </b>{{ $tipoFoliosFacturacion == 1 ? 'Portal WEB' : 'Integración' }}
                                </td>
                            </tr>
                        @endif
                        @if ($tipoFoliosNomina != '')
                            <tr>
                                <td><b>Nómina: </b>{{ $tipoFoliosNomina == 1 ? 'Portal WEB' : 'Integración' }}</td>
                            </tr>
                        @endif
                        @if ($tipoFoliosRecepcion != '')
                            <tr>
                                <td><b>Recepcion: </b>{{ $tipoFoliosRecepcion == 1 ? 'Portal WEB' : 'Integración' }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td><b>Medio de adquisición: </b>{{ $datos[0]->aliado->tipoAliado->descripcion }}</td>
                        </tr>
                        <tr>
                            <td><b>Código Aliado: </b>{{ $datos[0]->aliado->codigo_oficina_virtual }}</td>
                        </tr>
                        <tr>
                            <td><b>Vendedor: </b>{{ $datos[0]->aliado->nombre }}</td>
                        </tr>
                    </table>
                </td>
                <td width="40%">
                    <table width="100%"
                        style="color: #FFFFFF;background-color: #408BC6;border-radius: 20px;padding: 10px;">
                        <tr>
                            <td align="left"><b>SUBTOTAL: </b></td>
                            <td align="right">{{ number_format($datos[0]->subtotal, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td align="left"><b>IVA: </b></td>
                            <td align="right">{{ number_format($datos[0]->iva, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td align="left"><b>Retención IVA: </b></td>
                            <td align="right"> {{ number_format($datos[0]->retencion_iva, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td align="left"><b>Retención Fuente: </b></td>
                            <td align="right">{{ number_format($datos[0]->retencion_fuente, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td align="left"><b>Retención ICA: </b></td>
                            <td align="right">{{ number_format($datos[0]->retencion_ica, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td align="left"><b>NETO A PAGAR: </b></td>
                            <td align="right"> {{ number_format($datos[0]->total, 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" width="100%" id="ListaDocumentos">
                    <p><b>Listado de documentos requeridos:</b></p>
                    <ul class="list-unstyled">
                        @if ($tipo == 1)
                            <li>Cédula del Representante Legal</li>
                            <li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>
                            <li>Certificado de existencia y representación legal u otro documento que justifique la
                                representación legal de la empresa (fecha de expedición no mayor a 60 días)</li>
                            <li>Soporte de Pago.</li>
                        @elseif($tipo == 2)
                            <li>Cédula del Representante Legal</li>
                            <li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>
                            <li>Carta de Solicitud del Certificado Digital notariada (fecha de autenticación no
                                mayor a 60
                                días)
                            </li>
                            <li>Soporte de Pago.</li>
                        @elseif($tipo == 3)
                            <li>Cédula del Representante Legal</li>
                            <li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>
                            <li>Certificado de existencia y representación legal u otro documento que justifique la
                                representación legal de la empresa (fecha de expedición no mayor a 60 días)</li>
                            <li>Soporte de Pago.</li>
                        @elseif($tipo == 4)
                            <li>Cédula del Representante Legal</li>
                            <li>RUT (Sin contraseña, descargado directamente de la DIAN)</li>
                            <li>Carta de Solicitud del Certificado Digital notariada (fecha de autenticación no
                                mayor a 60
                                días)
                            </li>
                            <li>Soporte de Pago.</li>
                        @else
                            <li>Soporte de Pago.</li>
                        @endif
                    </ul>
                </td>
            </tr>
        </tfoot>
        </table>
        <br>
        @if (count($condicionesVista) > 0)
            <table width="100%" style="text-align: justify;border-collapse: collapse;">
                <tr>
                    <td>
                        <h5><b>CONDICIONES DE COMPRA</b></h5>
                        <p>Las siguientes disposiciones rigen las condiciones para la prestación de los servicios de
                            DOCUMENTOS ELECTRÓNICOS CON FINES FISCALES por parte de <b>THE FACTORY HKA COLOMBIA
                                S.A.S</b> y <b>EL SUSCRIPTOR</b>.</p>
                    </td>
                </tr>
                @foreach ($condicionesVista as $item)
                    <tr>
                        <td>
                            {{ $item }}
                        </td>
                    </tr>
                @endforeach
            </table>
            <br>
        @endif
        {{--
            Yo <b>{{ mb_strtoupper($datos[3]->nombre . ' ' . $datos[3]->apellido, 'UTF-8') }}</b>,
            identificado con <strong id="typeDoc"
            style="text-transform:uppercase">{{ $acronimoTipoDoc }}</strong> N° <strong
            id="docRL"
            style="text-transform:uppercase">{{ $datos[3]->identificacion }}</strong>,
            dirección de actividad comercial <b>{{ $datos[1]->address }}</b>, domicilio de la
            actividad comercial en la ciudad
            <b>{{ mb_strtoupper($datos[2]->description, 'UTF-8') }}</b>,
            <b>{{ mb_strtoupper($datos[2]->department, 'UTF-8') }}</b>, telefono
            <b>{{ $datos[3]->telefono }}</b>, correo electrónico
            <b>{{ $datos[3]->email }}</b>,
            actuando en nombre propio y/o en la representación legal de la sociedad <b>
            @if ($datos[1]->person_type == '1')
            {{ $datos[1]->name_socialreason }}@else{{ $datos[1]->name_socialreason . ' ' . $datos[1]->comercial_name }}
            @endif
            </b>, identificada con el NIT N° <b>{{ $datos[1]->company_id }}</b> declaro                        expresa,
        --}}
        <table width="100%" style="text-align: center;border-collapse: collapse;">
            <tr>
                <td colspan="3">
                    <table>
                        <tr>
                            <td>
                                <h5>
                                    <b>DECLARACIÓN Y AUTORIZACIÓN DE TRATAMIENTO DE DATOS - HABEAS DATA.</b>
                                </h5>
                                <p style="font-size: 10px; text-align: justify;">
                                    Declaro conocer y autorizar a THE FACTORY HKA COLOMBIA SAS para obtener y reportar
                                    información sobre mi persona y la sociedad que represento a diversas bases de datos,
                                    conforme a la ley 1266/2008. Certifico que los fondos de mi representada provienen
                                    de actividades lícitas y certifico la veracidad de los datos suministrados. Asumo la
                                    responsabilidad exclusiva de cualquier error, exonerando a THE FACTORY HKA COLOMBIA
                                    SAS de responsabilidad legal. La empresa garantiza seguridad y transparencia en el
                                    uso de la información, conforme a la ley 1581 del 2012. Entiendo que firmada la
                                    presente orden de compra, inicia el proceso de prestación del servicio por parte de
                                    THE FACTORY HKA COLOMBIA SAS, sin posibilidad de devolución. Acepto que no realizan
                                    traspasos de transacciones electrónicas entre diferentes NIT. Las transacciones
                                    compradas se mantienen en caso de cambio de razón social o representación legal,
                                    siempre que el NIT permanezca igual.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="2%">&nbsp;</td>
                <td width="96%">
                    <table width="100%"
                        style="background-color: #E9E8E8;border-radius: 20px;padding: 10px;font-size:10px;">
                        @foreach ($terminos as $value)
                            @php
                                $termino = CatTerminos::find($value);
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" value="{{ $termino['id'] }}" name="{{ $termino['id'] }}"
                                        id="{{ $termino['id'] }}" checked>
                                </td>
                                <td width="96%">
                                    <label for="{{ $termino['id'] }}"> {!! $termino['nombre'] !!}</label>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td width="2%">&nbsp;</td>
            </tr>
        </table>
    </main>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $text = "Página $PAGE_NUM de $PAGE_COUNT";
                $x = $pdf->get_width() - $fontMetrics->get_text_width($text, $font, 10);
                $y = $pdf->get_height() - 20;
                $pdf->text($x, $y, $text, $font, 8, array(255, 255, 255));
            ');
        }
    	</script>
</body>

</html>
