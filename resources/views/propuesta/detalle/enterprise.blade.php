<div class="tab-pane" id="enterprise">
    <div class="row">
        <div class="col-sm-1">
            <img src="{{asset('propuesta/img/icon/Empresa.png')}}" style="width: 70%;">
        </div>
        <div class="col-sm-10"  style="color:#666666;">
            <h4 class="info-text" style="color:#0084CA;">Datos De la empresa</h4>
            <p class="info-text"><b>¡Bienvenido!</b>
            <br>
                Usted ha ingresado al Portal de Compras de The Factory HKA Colombia SAS. Por favor <b>lea las instrucciones y los requisitos previos a diligenciar</b> para un registro satisfactorio y sin contratiempos.
            </p>
        </div>
        
        <div class="col-sm-3 col-sm-offset-1">
            <div id="div_type_person" class="form-group label-floating">
                <input type="hidden" id="id_propuesta" name="id_propuesta" class="hidden" value="{{$datos[0]->id}}">
                <input type="hidden" id="id_type_person" name="id_type_person" class="hidden" value="{{$datos[1]->person_type}}">
                <label class="control-label">Tipo de persona<small class="text-danger"> *</small></label>
                <select name="type_person" id="type_person" class="form-control">
                    <option value="" disabled="" selected=""></option>
                    @foreach ($cat_type_person as $id => $description)
                    <option value="{{$id}}">{{mb_strtoupper($description, 'UTF-8')}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div id="div_dni" class="form-group label-floating">
               <label class="control-label">Número de Identificación Tributaria (NIT)<small class="text-danger"> *</small></label>
                <input id="dni" name="dni" type="text" class="form-control"  maxlength="20" value="{{$datos[1]->company_id}}">
                <input type="hidden" id="exist_client" name="exist_client" value="{{ $listaDocs > 2 ? 'true':'false' }}">
                <input type="hidden" id="user" name="user" value="">
                <input type="hidden" id="doc_valid" name="doc_valid" value="">
            </div>
        </div>
        <div class="col-sm-3">
            <div id="div_dv" class="form-group label-floating">
             <label class="control-label">Digito Verificador <small class="text-danger"> *</small></label>
                <input id="dv" name="dv" type="text" class="form-control" maxlength="1" value="{{$datos[1]->verification_digit}}">
            </div>
        </div>
        <div id="res-search" class="col-sm-10 col-sm-offset-1 "></div>
        <div class="col-sm-5 col-sm-offset-1 OptCliente">
            <div id="div_opt_cliente" class="form-group label-floating">
                <label class="control-label">Código de autenticación<small class="text-danger"> *</small></label>
                <input id="opt_cliente" name="opt_cliente" type="text" class="form-control" maxlength="6">
                <input type="hidden" id="signed" name="signed" value="false">
            </div>
        </div>
    </div>
</div>