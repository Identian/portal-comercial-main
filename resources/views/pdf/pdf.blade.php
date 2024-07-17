<html>
<head>
<title></title>
<link rel="stylesheet" href="{{asset('propuesta/detalle/css/styles.css')}}">

</head>
<body>
<header>
    <img src="{{asset('propuesta/img/icon/header.png')}}" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="100%" height="100%">
</header>
<table width="100%">
    <tbody>
        <tr>
            <td  colspan="3" align="right"><h3><b>ORDEN DE COMPRA</b></h3></td>
        </tr>
        <tr>
            <td  colspan="3" align="right"><b>Validez desde: </b> {{date_format($datos[1]->created_at,'d-m-Y')}}</td>
        </tr>
        <tr>
            <td  colspan="3" align="right"><b>Validez hasta: </b> {{date_format($datos[1]->created_at,'t-m-Y')}}</td>
        </tr>
        <tr>
            <td  colspan="3" align="right"><b>NIT: </b>{{$datos[1]->company_id}}</td>
        </tr>
        <tr>
            <td  colspan="3" align="right"><b>@if ($datos[1]->person_type == "1") Razón Social @else Nombre @endif :</b>
                @if ($datos[1]->person_type == "1")
                    {{$datos[1]->name_socialreason}}
                @else
                    {{$datos[1]->name_socialreason. ' '.$datos[1]->comercial_name}}
                @endif
            </td>
        </tr>
        <tr>
            <td  colspan="3" align="right"><b>Tipo de Contribuyente: </b>{{$datos[1]->tipo_contribuyente}}</td>
        </tr>
        <tr>
            <td  colspan="3" align="right"><b>Dirección: </b>{{$datos[1]->address}}</td>
        </tr>
        <tr>
            <td width="33%" align="right"><b>Municipio: </b>{{mb_strtoupper($datos[2]->description, 'UTF-8')}}</td>
            <td width="33%" align="right"><b>Departamento: </b>{{mb_strtoupper($datos[2]->department, 'UTF-8')}}</td>
            <td width="33%" align="right"><b>País: </b>COLOMBIA</td>
        </tr>
        <tr>
            <td  colspan="3" align="right"><b>Representante legal: </b>{{mb_strtoupper($datos[3]->nombre.' '.$datos[3]->apellido, 'UTF-8')}}</td>
        </tr>
        <tr>
            <td  colspan="3" align="right"><b>Nombre contacto de pagos: </b>{{mb_strtoupper($datos[3]->nombre.' '.$datos[3]->apellido, 'UTF-8')}}</td>
        </tr>
        <tr>
            <td width="33%" align="center"><b>Email principal: </b></td>
            <td width="33%" align="center"><b>Email Contacto de Pagos: </b></td>
            <td width="33%" align="center"><b>Email Radicación Facturas: </b></td>
        </tr>
        <tr>
            <td width="33%" align="center">{{$datos[3]->email}}</td>
            <td width="33%" align="center"><b>{{$datos[1]->email_billing_contact}}</td>
            <td width="33%" align="center"><b>{{$datos[1]->email_invoices}}</td>
        </tr>
        <tr>
            <td  colspan="3" align="right"><b>Teléfono: </b>{{$datos[3]->telefono}}</td>
        </tr>
        <tr>
            <td  colspan="3" align="right">
                <table width="100%" style="border-collapse: collapse;">
                <thead>
                    <tr style="color: #FFFFFF;background-color: #408BC6">
                        <th width="20%" style="border-bottom-left-radius: 10px; border-top-left-radius: 10px">Producto</th>
                        <th width="40%" >Descripción</th>
                        <th width="10%" >Cantidad</th>
                        <th width="6%" >Validez</th>
                        <th width="12%" >Precio</th>
                        <th width="12%" style="border-bottom-right-radius: 10px; border-top-right-radius: 10px">Total</th>
                    </tr>
                </thead>
                <tbody class="tproduct">
                @php
                    $row = 14;
                @endphp
                @foreach ($detallePropuesta as $value)
                $row--;
                    <tr>
                        <td align="center" style="border-bottom-left-radius: 10px; border-top-left-radius: 10px">{{$value['nombre_servicio']}}</td>
                        <td >{{$value['nombre_producto']}}</td>
                        <td  align="center">{{$value['cantidad']}}</td>
                        <td ></td>
                        <td  align="right">{{number_format($value['precio']/$value['cantidad'], 2, ',', '.')}}</td>
                        <td  align="right" style="border-bottom-right-radius: 10px; border-top-right-radius: 10px">{{number_format($value['precio'], 2, ',', '.')}}</td>
                    </tr>
                @endforeach
                @if ($row > 0)
                    @for ($i = 0; $i < $row; $i ++)
                        <tr>
                            <td style="border-bottom-left-radius: 10px; border-top-left-radius: 10px">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="border-bottom-right-radius: 10px; border-top-right-radius: 10px">&nbsp;</td>
                        </tr>
                    @endfor 
                @endif
                </tbody>
            
                </table>
            </td>
        </tr>
            
    </tbody>
    <tfoot >
        <tr>
            <td colspan="2" width="60%" style="padding-left: 20px;">
                <table width="80%" style="background-color: #E9E8E8;border-radius: 20px;padding: 10px;">
                    <tr>
                        <td><b>Medio de adquisición: </b>{{$datos[0]->agency->descripcion_tipo_aliado}}</td>
                    </tr>
                    <tr>
                        <td><b>Código Aliado: </b>{{$datos[0]->agency->codigo_oficina_virtual}}</td>
                    </tr>
                    <tr>
                        <td><b>Vendedor: </b>{{$datos[0]->agency->nombre}}</td>
                    </tr>
                </table>
            </td>
            <td width="40%" >
            <table width="100%" style="color: #FFFFFF;background-color: #408BC6;border-radius: 20px;padding: 10px;">
                    <tr>
                        <td align="left"><b>SUBTOTAL: </b></td>
                        <td align="right">{{number_format($datos[0]->subtotal, 2, ',', '.')}}</td>
                    </tr>
                    <tr>
                        <td align="left"><b>IVA: </b></td>
                        <td align="right">{{number_format($datos[0]->iva, 2, ',', '.')}}</td>
                    </tr>
                    <tr>
                        <td align="left"><b>Retención IVA: </b></td>
                        <td align="right"> {{number_format($datos[0]->retencion_iva, 2, ',', '.')}}</td>
                    </tr>
                    <tr>
                        <td align="left"><b>Retención Fuente: </b></td>
                        <td align="right">{{number_format($datos[0]->retencion_fuente, 2, ',', '.')}}</td>
                    </tr>
                    <tr>
                        <td align="left"><b>Retención ICA: </b></td>
                        <td align="right">{{number_format($datos[0]->retencion_ica, 2, ',', '.')}}</td>
                    </tr>
                    <tr>
                        <td align="left"><b>NETO A PAGAR: </b></td>
                        <td align="right"> {{number_format($datos[0]->total, 2, ',', '.')}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tfoot>
</table>
<footer>
      <img src="{{asset('propuesta/img/icon/footer.png')}}" alt width="100%">
</footer>
</body>
</html>