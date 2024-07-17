 <div class="Attorney">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="wizard-title info-text">Datos del Apoderado</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-sm-offset-1">
            <div class="form-group label-floating">
                <label class="control-label">Tipo <small class="text-danger"> *</small></label>
                <select name="type_attorney" id="type_attorney" class="form-control" >
                    <option value="" disabled="" selected=""></option>
                    @foreach ($cat_type_person as $id => $description)
                    <option value="{{$id}}">{{$description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group label-floating">
               <label class="control-label"> Número de Identificación Tributaria (NIT)<small class="text-danger"> *</small></label>
                <input id="nit_attorney" name="nit_attorney" type="text" class="form-control"  maxlength="20">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group label-floating">
             <label class="control-label">Digito Verificador <small class="text-danger"> *</small></label>
                <input id="dv_attorney" name="dv_attorney" type="text" class="form-control" maxlength="1">
            </div>
        </div>
    </div>
    <div class="row AttorneyJ">
        <div class="col-sm-5 col-sm-offset-1">
            <div class="form-group label-floating">
                <label class="control-label">Razón Social <small class="text-danger"> *</small></label>
                <input id="nam_attorney_juridico" name="nam_attorney_juridico" type="text" class="form-control AlphabetsOnly"  maxlength="70" >
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group label-floating">
                <label class="control-label">Nombre Comercial</label>
                <input id="lastnam_attorney_juridico" name="lastnam_attorney_juridico" type="text" class="form-control AlphabetsOnly"  maxlength="70">
            </div>
        </div>        
        <div class="col-sm-12">
            <h4 class="wizard-title info-text">Datos del Representante</h4>
        </div>
    </div>
    <div class="row">     
        <div class="col-sm-4 col-sm-offset-1">
        		<div class="form-group label-floating">
                <label class="control-label">Tipo De documento <small class="text-danger"> *</small></label>
                <select id="type_identification_attorney" name="type_identification_attorney" class="form-control">
                    <option value="" disabled="" selected=""></option>
                    @foreach ($cat_type_identificationRep as $code => $description)
                    <option value="{{ $code }}">{{ strtoupper($description) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group label-floating">
               <label class="control-label">Numero de Documento <small class="text-danger"> *</small></label>
                <input id="dni_attorney" name="dni_attorney" type="text" class="form-control"  maxlength="20">
            </div>
        </div>
        <div class="col-sm-5 col-sm-offset-1">
            <div class="form-group label-floating">
                <label class="control-label">Nombres <small class="text-danger"> *</small></label>
                <input id="nam_attorney" name="nam_attorney" type="text" class="form-control AlphabetsOnly"  maxlength="70" >
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group label-floating">
                <label class="control-label">Apellidos <small class="text-danger"> *</small></label>
                <input id="lastnam_attorney" name="lastnam_attorney" type="text" class="form-control AlphabetsOnly"  maxlength="70">
            </div>
        </div>
    </div>
    <div class="row">    
        <div class="col-sm-12"></div>
        <div class="col-sm-5 col-sm-offset-1">
            <div class="form-group label-floating">
                <label class="control-label">Correo Electronico del Apoderado <small class="text-danger"> *</small></label>
                <input id="email_attorney" name="email_attorney" type="email" class="form-control"  maxlength="150">
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group label-floating">
                <label class="control-label">Teléfono <small class="text-danger"> *</small></label>
                <input id="phone_attorney" name="phone_attorney" type="text" class="form-control"   maxlength="15">
            </div>
        </div>
    </div>		                            	
</div>