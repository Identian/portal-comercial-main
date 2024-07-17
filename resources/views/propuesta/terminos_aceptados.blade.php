@php
use App\Models\CatTerminos;
$terminos = json_decode($datos[0]->terminos_aceptados);
@endphp

@if ($terminos !='')
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="input-group bg-terms" style="color:#666666;">
                @foreach ($terminos as $value)
                    @php
                        $termino = CatTerminos::find($value);
                    @endphp
                    <div class="togglebutton" style="display: flex;align-items: flex-start; padding:15px 5px">
                        <img src="{{asset('propuesta/img/icon/Terminos-privacidad.png')}}" style=" height: 30px;width: 30px;margin-right: 10px;margin-top: -10px;">
                        <label style="color: #666666; display: flex; align-items: flex-start; width: 95%; margin-top: -5px;">
                            <input class="cat_type_termino" type="checkbox" value="{{ $termino['id'] }}" id="id_termino_{{ $termino['id'] }}" name="listTermino[]" checked disabled>
                            <span style="width: 95%;">{!! $termino['nombre'] !!}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
        @php
            $terminos = CatTerminos::getTerminosList();
        @endphp
        @include('propuesta.terminos_firma')
    @endif

