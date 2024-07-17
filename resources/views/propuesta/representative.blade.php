<div class="tab-pane" id="representative" style="color:#666666;">
    <div class="row orders_exist">
        <div id="res-detalles" class="col-sm-10 col-sm-offset-1 "></div>
        <br>
    </div>
    <div class="client">
        <div class="row" style="margin-top: 20px;">
            <div class="col-sm-1">
                <img src="{{ asset('propuesta/img/icon/Datos-Empresa.png') }}" style="width: 75%;">
            </div>
            <div class="col-sm-10">
                <h4 class="info-text" style="color:#0084CA;">Datos de la Empresa</h4>
            </div>
            <div class="col-sm-5 col-sm-offset-1">
                <div id="enterprise_nam" class="form-group label-floating">
                    <label class="control-label Juridico"><B>Razón Social</B> <small class="text-danger">
                            *</small></label>
                    <label class="control-label Natural"><B>Nombres</B><small class="text-danger"> *</small></label>
                    <input id="nam_enterprise" name="nam_enterprise" type="text" class="form-control"
                        maxlength="150">
                </div>
            </div>
            <div class="col-sm-5">
                <div id="enterprise_lastnam" class="form-group label-floating">
                    <label class="control-label Juridico"><B>Nombre Comercial</B></label>
                    <label class="control-label Natural"><B>Apellidos</B> <small class="text-danger"> *</small></label>
                    <input id="lastnam_enterprise" name="lastnam_enterprise" type="text" class="form-control"
                        maxlength="150">
                </div>
            </div>
            <br>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-1">
                <img src="{{ asset('propuesta/img/icon/Ubicacion.png') }}" style="width: 75%;">
            </div>
            <div class="col-sm-10">
                <h4 class="info-text" style="color:#0084CA;"> Ubicación </h4>
            </div>
            <div class="col-sm-5 col-sm-offset-1">
                <div id="cod_department" class="form-group label-floating">
                    <label class="control-label"><B>Departamento</B><small class="text-danger"> *</small></label>
                    <select name="department" id="department" class="form-control" data-ajax="true"
                        data-url="{{ route('direction.municipality') }}" data-search="#municipality">
                        <option disabled="" selected=""></option>
                        @foreach ($cat_department as $code => $description)
                            <option value="{{ $code }}">{{ mb_strtoupper($description, 'UTF-8') }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-5">
                <div id="cod_municipality" class="form-group label-floating">
                    <label class="control-label"><B>Municipio</B><small class="text-danger"> *</small></label>
                    <select name="municipality" id="municipality" class="form-control">
                    </select>
                </div>
            </div>
            <div class="col-sm-10  col-sm-offset-1">
                <div id="line_address" class="form-group label-floating">
                    <label class="control-label"><B>Dirección</B><small class="text-danger"> *</small></label>
                    <input name="address_line" id="address_line" type="text" class="form-control" maxlength="200">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-1">
                <img src="{{ asset('propuesta/img/icon/Datos-Rep-Legal.png') }}" style="width: 75%;">
            </div>
            <div class="col-sm-10">
                <h4 class="info-text" style="color:#0084CA;">Datos del Representante Legal</h4>
            </div>
            <div class="col-sm-4 col-sm-offset-1">
                <div id="rep_type_identification" class="form-group label-floating">
                    <label class="control-label"><B>Tipo De documento</B> <small class="text-danger"> *</small></label>
                    <select id="type_identification_rep" name="type_identification_rep" class="form-control">
                        <option value="" disabled="" selected=""></option>
                        @foreach ($cat_type_identificationRep as $code => $description)
                            <option value="{{ $code }}">{{ strtoupper($description) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div id="rep_dni" class="form-group label-floating">
                    <label class="control-label"><B>Numero de Documento</B><small class="text-danger">
                            *</small></label>
                    <input id="dni_rep" name="dni_rep" type="text" class="form-control" maxlength="20">
                </div>
            </div>
            <div class="col-sm-5 col-sm-offset-1 Juridico">
                <div id="rep_nam" class="form-group label-floating">
                    <label class="control-label"><B>Nombres</B><small class="text-danger"> *</small></label>
                    <input id="nam_rep" name="nam_rep" type="text" class="form-control AlphabetsOnly"
                        maxlength="70">
                </div>
            </div>
            <div class="col-sm-5 Juridico">
                <div id="rep_lastnam" class="form-group label-floating">
                    <label class="control-label"><B>Apellidos</B><small class="text-danger"> *</small></label>
                    <input id="lastnam_rep" name="lastnam_rep" type="text" class="form-control AlphabetsOnly"
                        maxlength="70">
                </div>
            </div>
            <div class="col-sm-5 col-sm-offset-1">
                <div id="rep_email" class="form-group label-floating">
                    <label class="control-label"><b>Correo Electrónico del Representante Legal</b> <small
                            class="text-danger">
                            *</small></label>
                    <input id="email" name="email" type="email" class="form-control" maxlength="150">
                </div>
            </div>
            <div class="col-sm-5">
                <div id="rep_phone" class="form-group label-floating">
                    <label class="control-label"><b>Teléfono Celular del Representante Legal</b> <small
                            class="text-danger"> *</small></label>
                    <input id="phone" name="phone" type="text" class="form-control" maxlength="10">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 gradient-bg">
                <div class="col-sm-10 col-sm-offset-1">
                    <h6><b>¡Atención! Verifique los datos ingresados del Representante Legal <img height="30px"
                                width="30px" src="{{ asset('propuesta/img/icon/importante.png') }}"></b></h6>
                </div>
                <div class="col-sm-10 col-sm-offset-1">
                    Durante la gestion del Certificado Digital, el ente emisor se comunicará al número de teléfono
                    proporcionado para validar la identidad del representante legal. Se confirmarán los datos como:
                    teléfono
                    y correo electrónico, ya que estos estarán asociados al certificado digital. <b>Si se proporciona
                        información incorrecta, se deberá reiniciar el proceso, lo cual causará demoras importantes en
                        la
                        obtencion del certificado digital correspondiente</b>
                    <br>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-1">
                <img src="{{ asset('propuesta/img/icon/Datos-de-Contacto.png') }}" style="width: 75%;">
            </div>
            <div class="col-sm-10">
                <h4 class="info-text" style="color:#0084CA;">Datos de Contacto</h4>
                <h6 class="info-text">
                    Indique los correos y número telefónico en donde le llegarán las notificaciones correspondientes a
                    la
                    emisión de su certificado digital.
                </h6>
            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-5 col-sm-offset-1">
                <div class="col-sm-10">
                    <div id="rad_email" class="form-group label-floating">
                        <label class="control-label"><b>Correo Electronico Radicación de Facturas</b> <small
                                class="text-danger"> *</small></label>
                        <input id="email_rad" name="email_rad" type="email" class="form-control" maxlength="150">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group label-floating">
                        @php
                            $tooltips_email = '<p align:"center">A esta dirección de Correo Electrónico,</br>TFHKA enviará la Factura Electrónica.</br>Es importante que el receptor de clic</br>en el botón de Acuse de Recibido incluido</br>en el cuerpo del correo en el que se envía la</br>factura electrónica, para que The Factory HKA</br>conirme el correo de envío de la factura.</p>';
                        @endphp
                        <i class="material-icons" style="color:#337ab7;font-size: 16px;" data-toggle="tooltip"
                            rel="tooltip" data-placement="top" data-html="true"
                            title="{{ $tooltips_email }}">help_outline</i>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div id="fac_email" class="form-group label-floating">
                    <label class="control-label"><b>Correo Electronico Contacto de pagos</b> <small
                            class="text-danger">
                            *</small></label>
                    <input id="email_fac" name="email_fac" type="email" class="form-control" maxlength="150">
                </div>
            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-5  col-sm-offset-1">
                <div id="op_email" class="form-group label-floating">
                    <label class="control-label"><b>Correo</b><small>(Opcional)</small></label>
                    <input id="email_op" name="email_op" type="email" class="form-control" maxlength="150">
                </div>
            </div>
            <div class="col-sm-5">
                <div class="col-sm-10">
                    <div id="client_phone" class="form-group label-floating">
                        @php
                            $tooltips_phone = '<p align:"center">Ingrese un número de celular de 10 dígitos</br>o un número fijo con indicativo de 3 dígitos +</br>7 dígitos de número fijo</p>' . '<p align:"center"><b>Indicativos Colombia:</b></br>601 Cundinamarca y Bogotá D.C.</br>602 Cauca, Nariño y Valle.</br>604 Antioquia, Córdoba y Chocó.</br>' . '605 Atlántico, Bolívar, César, La Guajira, Magdalena</br> y Sucre</br>606 Caldas, Quindio y Risaralda.</br>607 Arauca, Norte de Santander y Santander.</br>' . '608 Amazonas, Boyacá, Casanare, Caquetá,</br>Guaviare, Guainía, Huila, Meta, Tolima, Putumayo,</br>San Andrés, Vaupés y Vichada.</br></p>';
                        @endphp
                        <label class="control-label"><b>Teléfono Fijo o Celular (10 dígitos)</b> <small
                                class="text-danger"> *</small></label>
                        <input id="phoneClient" name="phoneClient" type="text" class="form-control"
                            maxlength="10">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group label-floating">
                        <i class="material-icons" style="color:#337ab7;font-size: 16px;" data-toggle="tooltip"
                            rel="tooltip" data-placement="top" data-html="true"
                            title="{{ $tooltips_phone }}">help_outline</i>
                    </div>
                </div>
            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-5 col-sm-offset-1">
                <div id="is_attorney" class="form-group label-floating">
                    <label class="control-label"><b>Posee Apoderado</b><small class="text-danger"> *</small></label>
                    <select id="attorney" name="attorney" class="form-control">
                        <option value="" disabled="" selected=""></option>
                        <option value="1">SI</option>
                        <option value="2">NO</option>
                    </select>
                </div>
            </div>
        </div>
        @include('propuesta.attorney')
    </div>
</div>
