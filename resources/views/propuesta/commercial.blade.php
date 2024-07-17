<div class="tab-pane" id="commercial" style="color:#666666;">
    <div class="row">
        <div class="col-sm-1">
            <img src="{{asset('propuesta/img/icon/Comercial.png')}}" style="width: 75%;">
        </div>
        <div class="col-sm-10">
            <h4 class="info-text" style="color:#0084CA;">Información Comercial</h4>
            <h6 class="info-text">
                Indique a través de quien ha adquirido los servicios de facturación electrónica correspondientes a la
                emisión de su certificado digital
            </h6>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <div id="div_cat_type_taxpayer" class="form-group label-floating">
                <label class="control-label"><b>Tipo de Contribuyente</b> <small class="text-danger"> *</small></label>
                <select id="cat_type_taxpayer" name="cat_type_taxpayer" class="form-control">
                    <option value="" disabled="" selected=""></option>
                    @foreach ($cat_type_taxpayer as $code => $description)
                    <option value="{{ $code }}">{{mb_strtoupper($description, 'UTF-8')}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 Code col-sm-offset-1 col-md-offset-3">
            <div id="div_code_agency" class="form-group label-floating">
                <label class="control-label"><b>Código Agencia</b></label>
                <input id="code_agency" name="code_agency" type="text" class="form-control" maxlength="10">
                <input type="hidden" id="agency" name="agency" value="">
                <input type="hidden" id="insoft" name="insoft" value="">
                <input type="hidden" id="concesion" name="concesion" value="">
            </div>
        </div>
        <div class="col-sm-4">
            <div id="div_cat_method" class="form-group label-floating">
                <label class="control-label">Medio de Adquisición</label>
                <input id="cat_method" name="cat_method" type="text" class="form-control">
                <input type="hidden" id="vendor" name="vendor" value="">
            </div>
        </div>

    </div>
    <div id="res-vendor" class="col-sm-10 col-sm-offset-1 "></div>
</div>
