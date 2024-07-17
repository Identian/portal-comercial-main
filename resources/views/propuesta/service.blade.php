<div class="tab-pane" id="services" style="color:#666666;">
    <div class="row">
        <div class="col-sm-1">
            <img src="{{ asset('propuesta/img/icon/Planes-y-Servicios.png') }}" style="width: 75%;">
        </div>
        <div class="col-sm-10">
            <h4 class="info-text" style="color:#0084CA;"> Planes y Servicios </h4>
            <h6 class="info-text"> Seleccione los productos a comprar </h6>
        </div>
        <div id="list_error" class="col-sm-12 col-sm-offset-1 ">
        </div>
    </div>
    <div class="row" style="margin-top: 25px;">
        @foreach ($cat_producto as $code => $description)
            <div class="col-sm-10 col-sm-offset-1 producto_{{ $code }}">
                <div class="col-sm-12 togglebutton has-error">
                    <label>
                        <input class="cat_producto  {{ $code <= 3 ? 'transacciones' : '' }}" type="checkbox"
                            value="{{ $code }}" id="cat_producto_{{ $code }}" name="listProducto[]">
                        <span>{{ mb_strtoupper($description, 'utf-8') }}</span>
                    </label>
                </div>
                @if ($code <= 2)
                    <div class="col-sm-7 cat_producto_{{ $code }}" style="display: none;">
                        <div id="div_cant_folios_{{ $code }}"
                            class="form-group label-floating is-empty_cat_producto_{{ $code }}">
                            <label class="control-label">Cantidad de Transacciones de
                                {{ mb_strtoupper($description, 'utf-8') }}<small class="text-danger"> *</small></label>
                            <input id="cant_folios_{{ $code }}" name="cant_folios_{{ $code }}"
                                type="text" class="form-control form-product cat_producto_{{ $code }}"
                                maxlength="7">
                        </div>
                    </div>
                    <div class="col-sm-5 cat_producto_{{ $code }}" style="display: none;">
                        <div id="div_type_portal_{{ $code }}"
                            class="form-group label-floating is-empty_cat_producto_{{ $code }}">
                            <label class="control-label">Seleccione<small class="text-danger"> *</small></label>
                            <select id="type_portal_{{ $code }}" name="type_portal_{{ $code }}"
                                class="form-control form-product  cat_producto_{{ $code }}">
                                <option value="" disabled="" selected=""></option>
                                <option value="1">{{ mb_strtoupper('Portal WEB', 'UTF-8') }}</option>
                                <option value="2">{{ mb_strtoupper('Integración', 'UTF-8') }}
                                </option>
                            </select>
                        </div>
                    </div>
                @endif
                @if ($code == 3)
                    <div class="col-sm-12 cat_producto_{{ $code }}" style="display: none;">
                        <div class="recepContract">
                            <span id="span_recepContract" class="">¿Tiene el servicio de Recepción
                                Contratado?</span><br>
                            <input type="radio" id="si" name="RecepContratRta" value="si">
                            <label for="si">Sí</label>
                            <input type="radio" id="no" name="RecepContratRta" value="no">
                            <label for="no">No</label>
                        </div>
                    </div>
                    <div class="col-sm-7 cat_producto_{{ $code }}" style="display: none;">
                        <div id="div_cant_folios_{{ $code }}"
                            class="form-group label-floating is-empty_cat_producto_{{ $code }}">
                            <label class="control-label">Cantidad de Transacciones de
                                {{ mb_strtoupper($description, 'utf-8') }}<small class="text-danger"> *</small></label>
                            <input id="cant_folios_{{ $code }}" name="cant_folios_{{ $code }}"
                                type="text" class="form-control form-product cat_producto_{{ $code }}"
                                maxlength="7">
                        </div>
                    </div>
                    <div class="col-sm-5 cat_producto_{{ $code }}" style="display: none;">
                        <div id="div_type_portal_{{ $code }}"
                            class="form-group label-floating is-empty_cat_producto_{{ $code }}">
                            <label class="control-label">Seleccione<small class="text-danger"> *</small></label>
                            <select id="type_portal_{{ $code }}" name="type_portal_{{ $code }}"
                                class="form-control form-product  cat_producto_{{ $code }}">
                                <option value="" disabled="" selected=""></option>
                                <option value="1">{{ mb_strtoupper('Portal WEB', 'UTF-8') }}</option>
                                <option value="2">{{ mb_strtoupper('Integración', 'UTF-8') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <br>
                @endif
                @if ($code == 4)
                    <div class="col-sm-6 cat_producto_{{ $code }}" style="display: none;">
                        <div id="div_time_format_linkage_{{ $code }}"
                            class="form-group label-floating is-empty_cat_producto_{{ $code }}">
                            <label class="control-label">Tiempo del Certificado<small class="text-danger">
                                    *</small></label>
                            <select id="time_format_linkage" name="time_format_linkage"
                                class="form-control form-product cat_producto_{{ $code }}">
                                <option value="" disabled="" selected=""></option>
                                @foreach ($cat_time_format_linkage as $code => $description)
                                    <option value="{{ $code }}">{{ strtoupper($description) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
        <div class="row cat_producto_5 col-sm-10 col-sm-offset-1" style="display: none;margin-top: 25px;">
            <div class="col-sm-1">
                <img src="{{ asset('propuesta/img/icon/Servicios-Complementarios.png') }}" style="width: 75%;">
            </div>
            <div class="col-sm-10">
                <h4 class="info-text" style="color:#0084CA;"> Servicios Complementarios </h4>
            </div>
            <div class="col-sm-10 col-sm-offset-1" id="mensaje-planSC"></div>
            @foreach ($cat_sc as $cod => $description)
                @if ($cod == 2)
                    <div class="col-sm-10">
                        <div class="col-sm-12 togglebutton has-error">
                            <label>
                                <input class="cat_serComplentario" type="checkbox" value="{{ $cod }}"
                                    id="cat_serComplentario_{{ $cod }}" name="listSC[]">
                                <span>{{ mb_strtoupper($description, 'utf-8') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 cat_serComplentario_{{ $cod }} ocultarSC"
                        style="margin-top: 15px; margin-bottom: 15px;border-radius: 10px; background-color: #f0f0f0;padding: 10px ;display: none;">
                        <div class="col-sm-12" id="mensaje-planRG"></div>
                        @foreach ($cat_type_rg as $cod_rg => $nombre)
                            <div class="col-sm-12">
                                <div class="col-sm-12 togglebutton has-error">
                                    <label>
                                        <input class="cat_type_rg" type="checkbox" value="{{ $cod_rg }}"
                                            id="cat_type_rg_{{ $cod_rg }}" name="listTypeRG[]">
                                        <span>{{ mb_strtoupper($nombre, 'utf-8') }}</span>
                                    </label>
                                </div>
                                <div class="col-sm-6 cant_rg cat_type_rg_{{ $cod_rg }} ocultarSC"
                                    style="display: none;">
                                    <div id="div_cant_type_rg_{{ $cod_rg }}"
                                        class="form-group label-floating is-empty_cat_type_rg{{ $cod_rg }}">
                                        @if ($cod_rg == 242)
                                            <label class="control-label">Seleccione<small class="text-danger">
                                                    *</small></label>
                                            <select id="cant_type_rg_{{ $cod_rg }}"
                                                name="cant_type_rg_{{ $cod_rg }}"
                                                class="form-control form-product limpiarCantRG limpiarCantSC">
                                                <option value="" disabled="" selected=""></option>
                                                @foreach ($cat_type_mod_rg as $code => $nombre)
                                                    <option value="{{ $code }}">
                                                        {{ mb_strtoupper($nombre, 'UTF-8') }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label class="control-label">Indique Cantidad<small class="text-danger">
                                                    *</small></label>
                                            <input id="cant_type_rg_{{ $cod_rg }}"
                                                name="cant_type_rg_{{ $cod_rg }}" type="text"
                                                class="form-control form-product cat_type_rg{{ $cod_rg }} limpiarCantSC limpiarCantRG"
                                                maxlength="2">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif($cod == 3)
                    <div class="col-sm-10">
                        <div class="col-sm-12 togglebutton has-error">
                            <label>
                                <input class="cat_serComplentario" type="checkbox" value="{{ $cod }}"
                                    id="cat_serComplentario_{{ $cod }}" name="listSC[]">
                                <span>{{ mb_strtoupper($description, 'utf-8') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-10 col-sm-offset-1 cat_serComplentario_{{ $cod }} ocultarSC"
                        style="margin-top: 15px; margin-bottom: 15px;border-radius: 10px; background-color: #f0f0f0;padding: 10px ;display: none;">
                        <div class="col-sm-10" id="mensaje-planR"></div>
                        @foreach ($cat_type_reporte as $cod_reporte => $nombre)
                            <div class="col-sm-6">
                                <div class="col-sm-12 togglebutton has-error">
                                    <label>
                                        <input class="cat_type_reporte" type="checkbox" value="{{ $cod_reporte }}"
                                            id="cat_type_reporte_{{ $cod_reporte }}" name="listTypeReporte[]">
                                        <span>{{ mb_strtoupper($nombre, 'utf-8') }}</span>
                                    </label>
                                </div>
                                @if ($cod_reporte == 8)
                                    <div class="col-sm-10 cant_reporte_traza" style="display: none;">
                                        <div id="div_cant_reporte_traza"
                                            class="form-group label-floating is-empty_cat_reporte_traza">
                                            <label class="control-label">Cantidad de
                                                {{ mb_strtoupper($nombre, 'utf-8') }}<small class="text-danger">
                                                    *</small></label>
                                            <input id="cant_reporte_traza" name="cant_reporte_traza" type="text"
                                                class="form-control form-product cant_reporte_traza" maxlength="2">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="col-sm-6">
                        <div class="col-sm-12 togglebutton has-error">
                            <label>
                                <input class="cat_serComplentario" type="checkbox" value="{{ $cod }}"
                                    id="cat_serComplentario_{{ $cod }}" name="listSC[]">
                                <span>{{ mb_strtoupper($description, 'utf-8') }}</span>
                            </label>
                        </div>
                        <div class="col-sm-10 cat_serComplentario_{{ $cod }} ocultarSC"
                            style="display: none;">
                            <div id="div_cant_folios_serComplentario_{{ $cod }}"
                                class="form-group label-floating is-empty_cat_serComplentario_{{ $cod }}">
                                <label class="control-label">Cantidad de
                                    {{ mb_strtoupper($description, 'utf-8') }}<small class="text-danger">
                                        *</small></label>
                                <input id="cant_folios_serComplentario_{{ $cod }}"
                                    name="cant_folios_serComplentario_{{ $cod }}" type="text"
                                    class="form-control form-product cat_serComplentario_{{ $cod }} limpiarCantSC"
                                    maxlength="6">
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    </div>
    <div class="row bg-planSelect col-sm-10 col-sm-offset-1 plan" id="planes-seleccionados">
        <div class="col-sm-10 col-sm-offset-1">
            <h4 class="info-text" style="color:#0084CA;"> Confirmación de servicios seleccionados </h4>
            <hr style="color:#0084CA;">
            <input type="hidden" id="conf_plan" name="conf_plan" value="">
            <input type="hidden" id="totalPlanes" name="totalPlanes" value="">
            <input type="hidden" id="monto" name="monto" value="">
            <input type="hidden" id="aPagar" name="aPagar" value="">
            <input type="hidden" id="iva" name="iva" value="">
            <input type="hidden" id="reteICA" name="reteICA" value="">
            <input type="hidden" id="reteIVA" name="reteIVA" value="">
            <input type="hidden" id="reteFuente" name="reteFuente" value="">
        </div>
        <div class="col-sm-12" id="mensaje-plan"></div>
        <div class="col-sm-12" id="select-plan"></div>

        <div class="row col-sm-12 plan plan_Emision" style="margin-top: 10px;">
            <h6 class="text"> Plan de Emisión (Valor antes de IVA)</h6>
            <div class="col-sm-12" id="mensaje-plan-emision"></div>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect" type="checkbox" value="" name="planesAdd[]"
                        id="p_emision"><span id="name_plan_emision" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_emision" style="color: #343a40;margin-left: 12%;"></span>
                <input type="hidden" id="desc_plan_emision" name="desc_plan_emision" value="">
                <input type="hidden" id="max_trans_emision" name="max_trans_emision" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan plan_Recepcion" style="margin-top: 25px;">
            <h6 class="text"> Plan de Recepción (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect" type="checkbox" value="" name="planesAdd[]"
                        id="p_recepcion"><span id="name_plan_recepcion" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_recepcion" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_recepcion" name="desc_plan_recepcion" value="">
                <input type="hidden" id="max_trans_recepcion" name="max_trans_recepcion" value="">
            </div>
        </div>

        <div class="row col-sm-10 plan plan_Portal_Recepcion" style="margin-top: 25px;">
            <h6 class="text"> Portal de Recepción (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect" type="checkbox" value="" name="planesAdd[]"
                        id="portal_recepcion"><span id="name_portal_recepcion"
                        style="color: #343a40;"></span></label>
                <br>
                <span id="price_portal_recepcion" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_portal_recepcion" name="desc_portal_recepcion" value="">
                <input type="hidden" id="max_trans_portal_recepcion" name="max_trans_portal_recepcion"
                    value="">
            </div>
        </div>
        <div class="row col-sm-10 plan plan_Certificado" style="margin-top: 25px;">
            <h6 class="text"> Certificado Digital (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect" type="checkbox" value="" name="planesAdd[]"
                        id="p_certificado"><span id="name_plan_certificado" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_certificado" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_certificado" name="desc_plan_certificado" value="">
                <input type="hidden" id="max_trans_certificado" name="max_trans_certificado" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_Horas" style="margin-top: 25px;">
            <h6 class="text"> Plan de HORAS (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_horas"><span id="name_plan_horas" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_horas" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="max_trans_horas" name="max_trans_horas" value="">
                <input type="hidden" id="plan_horas_sin_formato" name="plan_horas_sin_formato" value="">
                <input type="hidden" id="desc_plan_horas" name="desc_plan_horas" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_RG_plantilla" style="margin-top: 25px;">
            <h6 class="text"> Plan de PLANTILLA PERSONALIZADA (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_pl"><span id="name_plan_plantilla" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_plantilla" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="plan_plantilla_sin_formato" name="plan_plantilla_sin_formato"
                    value="">
                <input type="hidden" id="desc_plan_plantilla" name="desc_plan_plantilla" value="">
                <input type="hidden" id="max_trans_plantilla" name="max_trans_plantilla" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_RG" style="margin-top: 25px;">
            <h6 class="text"> Plan de REPRESENTACIONES GRAFICAS (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_rg"><span id="name_plan_rg" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_rg" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="plan_rg_sin_formato" name="plan_rg_sin_formato" value="">
                <input type="hidden" id="desc_plan_rg" name="desc_plan_rg" value="">
                <input type="hidden" id="max_trans_rg" name="max_trans_rg" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_RG_Mod" style="margin-top: 25px;">
            <h6 class="text"> Plan de Modificación REPRESENTACIONES GRAFICAS (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_rg_mod"><span id="name_plan_rg_mod" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_rg_mod" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_rg_mod" name="desc_plan_rg_mod" value="">
                <input type="hidden" id="max_trans_rg_mod" name="max_trans_rg_mod" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_RFactura" style="margin-top: 25px;">
            <h6 class="text"> Plan de REPORTE FACTURAS (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_rfact"><span id="name_plan_rfact" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_rfact" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_rfact" name="desc_plan_rfact" value="">
                <input type="hidden" id="max_trans_rfact" name="max_trans_rfact" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_RClientes" style="margin-top: 25px;">
            <h6 class="text"> Plan de REPORTE CLIENTES (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_rclient"><span id="name_plan_rclient" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_rclient" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_rclient" name="desc_plan_rclient" value="">
                <input type="hidden" id="max_trans_rclient" name="max_trans_rclient" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_RProduct" style="margin-top: 25px;">
            <h6 class="text"> Plan de REPORTE PRODUCTOS (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_rproduct"><span id="name_plan_rproduct" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_rproduct" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_rproduct" name="desc_plan_rproduct" value="">
                <input type="hidden" id="max_trans_rproduct" name="max_trans_rproduct" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_RCliProc" style="margin-top: 25px;">
            <h6 class="text"> Plan de REPORTE CLIENTES + PRODUCTOS (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_rcliprod"><span id="name_plan_rcliprod" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_rcliprod" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_rcliprod" name="desc_plan_rcliprod" value="">
                <input type="hidden" id="max_trans_rcliprod" name="max_trans_rcliprod" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_RSecuen" style="margin-top: 25px;">
            <h6 class="text"> Plan de REPORTE SECUNCIALES (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_rsecuen"><span id="name_plan_rsecuen" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_rsecuen" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_rsecuen" name="desc_plan_rsecuen" value="">
                <input type="hidden" id="max_trans_rsecuen" name="max_trans_rsecuen" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_RTraza" style="margin-top: 25px;">
            <h6 class="text"> Plan de REPORTE TRAZA (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_rtraza"><span id="name_plan_rtraza" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_rtraza" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_rtraza" name="desc_plan_rtraza" value="">
                <input type="hidden" id="max_trans_rtraza" name="max_trans_rtraza" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_DPdf" style="margin-top: 25px;">
            <h6 class="text"> Plan de DESCARGA DE PDF Y XML (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_dpdf"><span id="name_plan_dpdf" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_dpdf" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_dpdf" name="desc_plan_dpdf" value="">
                <input type="hidden" id="max_trans_dpdf" name="max_trans_dpdf" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_RArch" style="margin-top: 25px;">
            <h6 class="text"> Plan de REVISIÓN ARCHIVO (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_rarch"><span id="name_plan_rarch" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_rarch" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_rarch" name="desc_plan_rarch" value="">
                <input type="hidden" id="max_trans_rarch" name="max_trans_rarch" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_CSV" style="margin-top: 25px;">
            <h6 class="text"> Plan de CREACIÓN CSV (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_csv"><span id="name_plan_csv" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_csv" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="desc_plan_csv" name="desc_plan_csv" value="">
                <input type="hidden" id="max_trans_csv" name="max_trans_csv" value="">
            </div>
        </div>
        <div class="row col-sm-10 plan planSc plan_GManual" style="margin-top: 25px;">
            <h6 class="text"> Plan de GENERACIÓN MANUAL (Valor antes de IVA)</h6>
            <div class="col-sm-10 togglebutton has-error">
                <label><input class="planSlect ckSc" type="checkbox" value="" name="planesAdd[]"
                        id="p_gmanual"><span id="name_plan_gmanual" style="color: #343a40;"></span></label>
                <br>
                <span id="price_plan_gmanual" style="color: #343a40;margin-left: 15%;"></span>
                <input type="hidden" id="max_trans_gmanual" name="max_trans_gmanual" value="">
                <input type="hidden" id="desc_plan_gmanual" name="desc_plan_gmanual" value="">
            </div>
        </div>
    </div>
</div>
