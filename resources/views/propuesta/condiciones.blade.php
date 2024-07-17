@php
    use App\Models\CatDetallePlanCondicionCompra;
    use App\Models\CatDetalleRequisitoCondicionCompra;
@endphp

@if ($pdf)

    <tr>
        <td>
            @if (isset($condiciones['descripcion']) && !empty($condiciones['descripcion']))
                <h3><b>{{ $condiciones['nombre'] }}</b></h3>
                {{ $condiciones['descripcion'] }}
                <br><br>
            @else
                <h3><b>{{ $condiciones['nombre'] }}</b></h3>
            @endif
        </td>
    </tr>
    @if (count($condiciones->catRequisitoCondicionCompra) > 0)
        @foreach ($condiciones->catRequisitoCondicionCompra as $item)
            <tr>
                <td>
                    @if (isset($item['nombre']) && !empty($item['nombre']))
                        <b>{{ $item['nombre'] }}</b><br>
                        {{ $item['descripcion'] }}<br>
                    @endif
                    @php
                        $detalleRequisito = CatDetalleRequisitoCondicionCompra::where('id_cat_requisito_condicion_compra', $item['id'])->get();
                    @endphp
                    @if (isset($detalleRequisito))
                        @foreach ($detalleRequisito as $item)
                            <li>{{ $item['descripcion'] }}</li>
                        @endforeach
                        <br>
                    @endif
                </td>
            </tr>
        @endforeach
    @endif

    @foreach ($condiciones->catPlanCondicionCompra as $item)
        <tr>
            <td>
                @if (isset($item['nombre']) && !empty($item['nombre']))
                    <b>{{ $item['nombre'] }}</b><br>
                    {{ $item['descripcion'] }}<br>
                @endif
                @php
                    $detallePlan = CatDetallePlanCondicionCompra::where('id_cat_plan_condicion_compra', $item['id'])->get();
                @endphp
                @if (isset($detallePlan))
                    @foreach ($detallePlan as $item)
                        @php
                            $descripcion = str_replace('$folios', '<b>' . $transacciones . '</b>', $item['descripcion']);
                            $descripcion = str_replace('$vigencia', '<b>' . $vigencia . '</b>', $descripcion);
                        @endphp
                        <li>{!! html_entity_decode($descripcion) !!}</li>
                    @endforeach
                    <br>
                @endif
            </td>
        </tr>
    @endforeach
@else
    @if (isset($condiciones['descripcion']) && !empty($condiciones['descripcion']))
        <h6><b>{{ $condiciones['nombre'] }}</b></h6>
        {{ $condiciones['descripcion'] }}
        <br><br>
    @else
        <h6><b>{{ $condiciones['nombre'] }}</b></h6>
    @endif

    @if (count($condiciones->catRequisitoCondicionCompra) > 0)
        @foreach ($condiciones->catRequisitoCondicionCompra as $item)
            @if (isset($item['nombre']) && !empty($item['nombre']))
                <b>{{ $item['nombre'] }}</b><br>
                {{ $item['descripcion'] }}<br>
            @endif
            @php
                $detalleRequisito = CatDetalleRequisitoCondicionCompra::where('id_cat_requisito_condicion_compra', $item['id'])->get();
            @endphp
            @if (isset($detalleRequisito))
                @foreach ($detalleRequisito as $item)
                    <li>{{ $item['descripcion'] }}</li>
                @endforeach
                <br>
            @endif
        @endforeach
    @endif
    <br>
    @foreach ($condiciones->catPlanCondicionCompra as $item)
        @if (isset($item['nombre']) && !empty($item['nombre']))
            <b>{{ $item['nombre'] }}</b><br>
            {{ $item['descripcion'] }}<br>
        @endif
        @php
            $detallePlan = CatDetallePlanCondicionCompra::where('id_cat_plan_condicion_compra', $item['id'])->get();
        @endphp
        @if (isset($detallePlan))
            @foreach ($detallePlan as $item)
                @php
                    $descripcion = str_replace('$folios', '<b>' . $transacciones . '</b>', $item['descripcion']);
                    $descripcion = str_replace('$vigencia', '<b>' . $vigencia . '</b>', $descripcion);
                @endphp
                <li>{!! html_entity_decode($descripcion) !!}</li>
            @endforeach
            <br>
        @endif
    @endforeach
@endif
