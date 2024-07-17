<div class="tab-pane" id="enterprise">
    <div class="row">
        <div class="col-sm-1">
            <img src="{{ asset('propuesta/img/icon/Empresa.png') }}" style="width: 70%;">
        </div>
        <div class="col-sm-10" style="color:#666666;">
            <h4 class="info-text" style="color:#0084CA;">Datos de la Empresa</h4>
            <p class="info-text"><b>¡Bienvenido!</b>
                <br>
                Usted ha ingresado al Portal de Compras de The Factory HKA Colombia SAS. Por favor <b>lea las
                    instrucciones y los requisitos previos a diligenciar</b> para un registro satisfactorio y sin
                contratiempos.
            </p>
        </div>

        <div class="col-sm-3 col-sm-offset-1">
            <div id="div_type_person" class="form-group label-floating">
                <input type="hidden" id="id_type_person" name="id_type_person" class="hidden"
                    value="{{ $tipo }}">
                <label class="control-label">Tipo de persona<small class="text-danger"> *</small></label>
                <select name="type_person" id="type_person" class="form-control">
                    <option value="" disabled="" selected=""></option>
                    @foreach ($cat_type_person as $id => $description)
                        <option value="{{ $id }}">{{ mb_strtoupper($description, 'UTF-8') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div id="div_dni" class="form-group label-floating">
                <label class="control-label">Número de Identificación Tributaria (NIT)<small class="text-danger">
                        *</small></label>
                <input id="dni" name="dni" type="text" class="form-control" maxlength="20"
                    value={{ $nit }}>
                <input type="hidden" id="exist_client" name="exist_client" value="">
                <input type="hidden" id="user" name="user" value="">
                <input type="hidden" id="doc_valid" name="doc_valid" value="">
            </div>
        </div>
        <div class="col-sm-3">
            <div id="div_dv" class="form-group label-floating">
                <label class="control-label">Digito Verificador <small class="text-danger"> *</small></label>
                <input readonly id="dv" name="dv" type="text" class="form-control" maxlength="1"
                    value={{ $dv }}>
            </div>
        </div>

        <div id="res-search" class="col-sm-10 col-sm-offset-1 "></div>
        <div class="col-sm-10 col-sm-offset-1" id="mensaje-otp-cliente"></div>
        <div class="col-sm-3 col-sm-offset-1 col-md-offset-4 OptCliente">
            <div id="div_opt_cliente" class="form-group label-floating" style="padding: 10px">
                <label class="control-label">Código de autenticación<small class="text-danger"> *</small></label>
                <input id="opt_cliente" name="opt_cliente" type="text" class="form-control" maxlength="6"
                    style="display:none;">
                <div class="codigo-input" id="opt_cliente_cuadros">
                    <div class="codigo-caracter" contenteditable="true" oninput="manejarEntrada(event)"
                        onkeydown="manejarTeclaAbajo(event)" oncopy="return false;" oncut="return false;"
                        onpaste="return false;"></div>
                    <div class="codigo-caracter" contenteditable="true" oninput="manejarEntrada(event)"
                        onkeydown="manejarTeclaAbajo(event)" oncopy="return false;" oncut="return false;"
                        onpaste="return false;"></div>
                    <div class="codigo-caracter" contenteditable="true" oninput="manejarEntrada(event)"
                        onkeydown="manejarTeclaAbajo(event)" oncopy="return false;" oncut="return false;"
                        onpaste="return false;"></div>
                    <div class="codigo-caracter" contenteditable="true" oninput="manejarEntrada(event)"
                        onkeydown="manejarTeclaAbajo(event)" oncopy="return false;" oncut="return false;"
                        onpaste="return false;"></div>
                    <div class="codigo-caracter" contenteditable="true" oninput="manejarEntrada(event)"
                        onkeydown="manejarTeclaAbajo(event)" oncopy="return false;" oncut="return false;"
                        onpaste="return false;"></div>
                    <div class="codigo-caracter" contenteditable="true" oninput="manejarEntrada(event)"
                        onkeydown="manejarTeclaAbajo(event)" oncopy="return false;" oncut="return false;"
                        onpaste="return false;"></div>
                </div>
                <input type="hidden" id="signed" name="signed" value="false">
            </div>
        </div>
        <div id="res-valid_opt" class="col-sm-12"></div>
        <div class="col-sm-10 col-sm-offset-1 gradient-bg-rl OptCliente">
            <div class="col-sm-10 col-sm-offset-1">
                <h6><b>¡Atención! <img height="30px" width="30px"
                            src="{{ asset('propuesta/img/icon/importante.png') }}"></b></h6>
            </div>
            <div class="col-sm-12">
                Si el correo del Representante Legal cambio por favor comunicarse con <b><a
                        href="mailto:mesacontrol_co@thefactoryhka.com">mesacontrol_co@thefactoryhka.com</a></b>
            </div>
        </div>
    </div>
    <div id="documents" class="col-sm-12" style="color:#666666;">
        <h4 class="info-text"> Carga de Documentos </h4>
        <h6 class="info-text">
            Los documentos a ingresar deben ser en formato PDF
        </h6>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div id="rut_1" class=" form-group">
                    <label for=""><b>RUT</b> <small class="text-danger"> *</small> <br><small
                            class="text-muted">(Por
                            favor cargue su RUT original, descargado directamente desde la DIAN)
                        </small></label>
                    <input type="file" class="form-control" class="custom-file-input" id="rut_attachment"
                        name="rut_attachment" required>
                </div>
            </div>

            <div class="col-sm-10 col-sm-offset-1">
                <div id="chamber_commerce_1" class=" form-group">
                    <label class="Juridico" for=""><b>Cámara de Comercio</b> <small class="text-danger">
                            *</small>
                        <br><small class="text-muted"> (Por favor cargue su Camara de Comercio, este documento no debe
                            tener mas de 30 días de emitido. Si no cuenta con Camara de Comercio se debe incluir
                            documentos que justifiquen la Representación Legal, como: Documento de Propiedad Horizontal,
                            Documento de Unión Temporal, Personería Jurídica o similar; en formato PDF.)
                        </small></label>
                    <label class="Natural" for="">Carta Notariada <small class="text-danger"> *</small>
                        <br><small class="text-muted">Por favor ingrese Carta Solicitud de Certificado para Persona
                            natural debidamente Notariada (este documento debió ser enviado en el kit de venta), en
                            formato PDF
                        </small></label>
                    <input type="file" id="chamber_commerce" name="chamber_commerce" class="form-control"
                        max-length="15" required>
                </div>
            </div>

        </div>
    </div>
</div>
