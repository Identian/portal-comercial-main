<!doctype html>
<html lang="en">

<head>
    <title>CERTIFICADO DE RETENCION</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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

<body style="font-size: 0.8em">
    @if ($ambiente != 'production')
        <div id="watermark">
            <img src="{{ asset('propuesta/img/no_valido.png') }}" height="100%" width="100%" />
        </div>
    @endif
    <div class="row">
        <div class="col">
            <p>
                <b>{{ $propuesta->clienteComercial->name_socialreason }}</b>
                <br>
                {{ $propuesta->clienteComercial->company_id . '-' . $propuesta->clienteComercial->verification_digit }}
                <br>
                {{ $propuesta->clienteComercial->address }}
                <br>
                {{ mb_strtoupper($propuesta->clienteComercial->municipio->departamento->description, 'UTF-8') }}
            </p>
        </div>
    </div>
    <blockquote class="text-center">
        <b>CERTIFICADO DE RETENCION</b><br>
       Periodo de vigencia del {{date_format(date_create(date_format($propuesta->created_at, 'Y-m-01')), 'd/m/Y')}} al {{ date_format($propuesta->created_at, 't/m/Y') }}
    </blockquote>
    <table width="100%">
        <thead class="border-top border-bottom">
            <tr>
                <td colspan="5">
                    <dl class="row">
                        <dt class="col-sm-12">Razón social a quien se le practicó la retencion</dt>
                        <dd class="col-sm-12">THE FACTORY HKA COLOMBIA S.A.S. <br>Nit 900390126-6</dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td colspan="1">
                    <dl class="row">
                        <dt class="col-sm-3">Dirección:</dt>
                    </dl>
                </td>
                <td colspan="4">
                    <dl class="row">
                        <dd class="col-sm-9">AC 80 69 70 BG 20 Bogotá, D.C.</dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <dl class="row">
                        <dt class="col-sm-7">Ciudad donde se practicó la retención:</dt>
                    </dl>
                </td>
                <td colspan="2">
                    <dl class="row">
                        <dd class="col-sm-5">
                            {{ mb_strtoupper($propuesta->clienteComercial->municipio->departamento->description, 'UTF-8') }}
                        </dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <dl class="row">
                        <dt class="col-sm-7">Ciudad donde se consignó la retención:</dt>
                    </dl>
                </td>
                <td colspan="2">
                    <dl class="row">
                        <dd class="col-sm-5">
                            {{ mb_strtoupper($propuesta->clienteComercial->municipio->departamento->description, 'UTF-8') }}
                        </dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <th scope="col" colspan="2">CONCEPTO</th>
                <th style="text-align: center" scope="col">TASA%</th>
                <th style="text-align: right" scope="col">VR. BASE</th>
                <th style="text-align: right" scope="col">VR. RETENIDO</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $totalR = 0;
                $groupedData = [];
            @endphp
            @foreach ($productos as $value)
                @php
                    $total += $value['precio'];
                    if (!is_null($value['retencion'])) {
                        $datos = json_decode($value['retencion'], true);

                        foreach ($datos as $key => $item) {
                            if ($key !== 'iva') {
                                $groupedKey = $item[0];
                                $checkSameValue = true;
                                if (isset($groupedData[$groupedKey])) {
                                    $checkSameValue = $groupedData[$groupedKey]['items'][0][0] === $item[0];
                                }

                                if ($checkSameValue) {
                                    if (!isset($groupedData[$groupedKey])) {
                                        $groupedData[$groupedKey] = [
                                            'concepto' => $key,
                                            'precio' => 0,
                                            'retencion' => 0,
                                            'items' => [],
                                        ];
                                    }
                                    $groupedData[$groupedKey]['items'][] = $item;
                                    $groupedData[$groupedKey]['precio'] += $value['precio'];
                                    $groupedData[$groupedKey]['retencion'] += $item[1];
                                } else {
                                    $groupedData[$groupedKey]['items'][] = $item;
                                    $groupedData[$groupedKey]['precio'] = $value['precio'];
                                    $groupedData[$groupedKey]['retencion'] = $item[1];
                                }
                            }
                        }
                    }
                @endphp
            @endforeach
            @foreach ($groupedData as $key => $groupedItems)
                @if ($groupedItems['retencion'] > 0)
                    <tr>
                        <td colspan="2">{{ $groupedItems['concepto'] }}</td>
                        <td align="center">{{ $key }}</td>
                        <td align="right">${{ number_format($groupedItems['precio'], 2, ',', '.') }}</td>
                        <td align="right">${{ number_format($groupedItems['retencion'], 2, ',', '.') }}</td>
                    </tr>
                @endif
                @php
                    $totalR += $groupedItems['retencion'];
                @endphp
            @endforeach
            <tr>
                <th scope="row" colspan="3">TOTAL</th>
                <th style="text-align: right" scope="row" class="border-top">
                    ${{ number_format($total, 2, ',', '.') }}</th>
                <th style="text-align: right" scope="row" class="border-top">
                    ${{ number_format($totalR, 2, ',', '.') }}</th>
            </tr>
            <tr>
                <th scope="row" colspan="3">TOTAL ABONO EN CUENTA</th>
                <th style="text-align: right" scope="row" colspan="2">$0.00</th>
            </tr>
        </tbody>
    </table>
    <dl class="row" style="margin-top: 100px;">
        @php
            use Luecano\NumeroALetras\NumeroALetras;
            $formatter = new NumeroALetras();
            $formatter->apocope = true;
        @endphp
        <dd class="col-sm-11"><b style="margin-right: 10px">Valor:
            </b>{{ $formatter->toMoney($totalR, 2, 'PESOS', 'CENTAVOS') }} M/CTE* * * * * * * * * * * * *</dd>
        <dd class="col-sm-12">Notas: </dd>
        <br><br>
        <dd class="col-sm-12"><b style="margin-right: 20px">Fecha de expedición: </b>{{ date('d/m/Y') }}</dd>
    </dl>
</body>

</html>
