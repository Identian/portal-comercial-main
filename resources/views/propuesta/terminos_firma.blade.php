<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="input-group bg-terms" style="color:#666666;" id="terminos_firma_aceptados">
            @foreach ($terminos as $cod_termino => $nombre)
                <div class="togglebutton" id="div_termino_firma_{{ $cod_termino }}" style="display: flex;align-items: flex-start; padding:15px 5px">
                    <img src="{{ asset('propuesta/img/icon/Terminos-privacidad.png') }}"
                        style=" height: 30px;width: 30px;margin-right: 10px;margin-top: -10px;">
                    <label style="color: #666666; display: flex; align-items: flex-start; width: 95%; margin-top: -5px;">
                        <input class="cat_termino_firma" type="checkbox" value="{{ $cod_termino }}"
                            id="id_termino_firma_{{ $cod_termino }}" name="listTerminoFirma[]">
                        <span style="width: 95%;">{!! $nombre !!}</span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
