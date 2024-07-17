<?php

namespace App\Http\Controllers;


use PDF;
use Mail;
use App\Models\Agencia;
use App\Models\Cliente;
use App\Models\Persona;
use App\Models\Relacion;
use App\Models\CatPlanSC;
use App\Models\Concesion;
use App\Models\Documento;
use App\Models\Propuesta;
use App\Models\CatProduct;
use App\Models\Expediente;
use App\Models\CatProducto;
use App\Models\CatTerminos;
use App\Models\CatTypePlan;
use Illuminate\Http\Request;
use App\Models\CatDepartment;
use App\Models\CatPersonType;
use App\Models\CatMunicipality;
use App\Models\CatOriginMedium;
use App\Models\CatPlanProducto;
use App\Models\CatTypeServicio;
use App\Models\CatTypeTaxpayer;
use App\Models\CatFormatLinkage;
use App\Models\DetallePropuesta;
use App\Models\ClientePcomercial;
use App\Models\FoliosContratados;
use App\Models\PersonaPcomercial;
use App\Models\RelacionPcomercial;
use App\Models\VwDetallePropuesta;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CatTimeFormatLinkage;
use App\Models\CatIdentificationType;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Models\TransaccionDetallePropuesta;
use Dompdf\FontMetrics;
use App\Models\CatCondicionCompra;
use App\Models\CatPlanCondicionCompra;
use App\Models\CatRequisitoCondicionCompra;



class PropuestaController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function decrypt($string, $key)
    {
        $result = '';
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }
        return $result;
    }

    public function encrypt($string, $key)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    public function condicionesCompra($id,$pdf=false){
        $plan = CatPlanProducto::find($id);
        if (!empty($plan['id_cat_condicion_compra'])) {
            $condiciones = CatCondicionCompra::find($plan['id_cat_condicion_compra']);
            $transacciones = $plan['max_transacion'];
            $vigencia = $plan['vigencia'];
            $planCondicionCompra = CatPlanCondicionCompra::find($id);
            $requisitoCondicionCompra = CatRequisitoCondicionCompra::find($id);

            return view('propuesta.condiciones', compact(
                'condiciones',
                'planCondicionCompra',
                'requisitoCondicionCompra',
                'transacciones',
                'vigencia',
                'pdf'
                ));
          }

    }

    public function detallePropuestas($propuestas){

        $tbody = '';
        foreach ($propuestas as $key=>$propuesta) {
            $cadenaEncriptada = self::encrypt($propuesta['id'],Config::get('params.general.string_key'));
            $clientePcomercial = ClientePcomercial::getClienteP($propuesta['id_cliente_pcomercial']);
            $tPropuesta= '5';
            $tCliente= $clientePcomercial->person_type;

            $tbody .='<table style="width: 100%;">'
            .'<thead>'
            .'<tr>'
                .'<th colspan="2" style="background-color: #E9E8E8;padding: 3px 5px;"> <span class="info-text"> Propuesta Creada el  '.date_format($propuesta['created_at'], 'd-m-Y').'</span> </th>'
            .'</tr>'
            .'</thead>'
            .'<tbody>'
            .'<tr style="color: #FFFFFF;background-color: #408BC6;">'
                .'<td style="padding: 3px 5px;">Nombre del Producto</td>'
                .'<td>Descripción</td>'
            .'</tr>';
            $detallePropuesta = VwDetallePropuesta::getDPropuesta($propuesta['id']);
            foreach ($detallePropuesta as $key=>$value) {
                if($value['id_cat_servicio'] == 9 || $value['id_cat_servicio'] == 10 || $value['id_cat_servicio'] == 13){
                    $tPropuesta= $tCliente == 1? '3':'4';
                }
                $tbody .='<tr style="border-bottom: 1pt solid #E9E8E8;">'
                .'<td width="33%" style="padding: 3px 5px;">'
                   .$value['nombre_producto']
                .'</td>'
                .'<td width="67%" >'.$value['descripcion_producto'].'</td>'
            .'</tr>';
            };
            $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&'.$tPropuesta;
            $tbody .='<tr>'
                .'<td colspan="2" style="padding: 3px 5px; text-align: right;"> <a id="ver" href="'.$url.'" target="_blank" class="btn btn-fill btn-success  btn-wd" style="padding: 5px;">Ver / Editar</a> </td>'
            .'</tr>';
            $tbody .='</tbody>'
            .'</table>';
        };


        $tableDetalles= '<h4 class="info-text" style="color:#0084CA;">Usted Posee '.count($propuestas).' propuestas activas</h4>'
            .'<table width="100%">'
                .'<tbody>'
                        .$tbody
                .'</tbody>'
            .'</table>';

            return $tableDetalles;

    }

    public function index($encrypt = null){
        $tipo = '';
        $nit = '';
        $dv = '';
        if (!is_null($encrypt)) {
            try {
                $cadenaDesencriptada = self::decrypt($encrypt, Config::get('params.general.string_key'));
                $array = explode("/", $cadenaDesencriptada);
                if (count($array) == 3) {
                    foreach ($array as $value) {
                        if ($value == '') {
                            return view('errors.500'); // vista de error
                        }
                    }
                    $tipo = $array[0];
                    $nit = $array[1];
                    $dv = $array[2];
                } else {
                    return view('errors.500'); // vista de error
                }
            } catch (DecryptException $e) {
                return view('errors.500'); // vista de error
            }
        }
        $terminos = CatTerminos::getTerminosList();
        $cat_producto = CatProducto::getLisProducto();
        $cat_sc = CatTypeServicio::getLisTypeSC();
        $cat_type_rg = CatPlanProducto::getLisTypeRG();
        $cat_type_mod_rg = CatPlanProducto::getLisTModificacionRG();
        $cat_type_reporte = CatPlanSC::getLisTypeReporte();
        $cat_buy = CatProduct::getLisProduct();
        $cat_type_person = CatPersonType::getPersonTipeList();
        $cat_type_taxpayer = CatTypeTaxpayer::getTipeTaxpayerList();
        $cat_type_identification = CatIdentificationType::getListIdentificationTypes();
        $cat_type_identificationRep = CatIdentificationType::getListIdentificationRep();
        $cat_department = CatDepartment::getDeparmentsList();
        $cat_method = CatOriginMedium::getMethodList();
        $cat_time_format_linkage = CatTimeFormatLinkage::getTimeFormatList();
        return view('propuesta.index', compact(
            'tipo',
            'nit',
            'dv',
            'terminos',
            'cat_buy','cat_producto',
            'cat_sc',
            'cat_type_person',
            'cat_method',
            'cat_type_identification',
            'cat_type_identificationRep',
            'cat_department',
            'cat_time_format_linkage',
            'cat_type_taxpayer',
            'cat_type_rg',
            'cat_type_mod_rg',
            'cat_type_reporte'
            ));

    }


    public function editPropuesta($encrypt){

        $data = explode('&',$encrypt);

        $listaDocs = intval($data[1]);

        try {
            $id = self::decrypt($data[0], Config::get('params.general.string_key'));
            $propuesta = Propuesta::getPropuesta($id);
            if($propuesta->active == 1){
                $datos[] = $propuesta;
                $aliado = Agencia::getData($propuesta->id_agency);
                $clientePcomercial = ClientePcomercial::getClienteP($propuesta->id_cliente_pcomercial);
                array_push($datos,$clientePcomercial);
                $ubicacion = CatMunicipality::getData($clientePcomercial->id_municipality);
                array_push($datos,$ubicacion);
                $representante = RelacionPcomercial::getDataPersona($id,1);
                $acronym = CatIdentificationType::getAcronym($representante->tipo_identificacion);
                array_push($datos,$representante);
                $apoderado= RelacionPcomercial::getDataPersona($id,8);
                array_push($datos,$apoderado);
                $detallePropuesta = DetallePropuesta::getDPropuesta($id);
                //$transaccionDetallePropuesta = TransaccionDetallePropuesta::getDPropuesta(408);
                //dd($detallePropuesta);
                $clienteTipoExpediente=$propuesta->tipo;
            }else{
                $firmado=false;
                if($propuesta->cant_firmas > 0){
                    $firmado=true;
                }
                return view('propuesta.caducado',compact(
                    'firmado'
                ));
            }
        } catch (DecryptException $e) {
            return view('errors.500'); // vista de error
        }
        $terminos = CatTerminos::getTerminosList();
        $cat_producto = CatProducto::getLisProducto();
        $cat_sc = CatTypeServicio::getLisTypeSC();
        $cat_type_rg = CatPlanProducto::getLisTypeRG();
        $cat_type_mod_rg = CatPlanProducto::getLisTModificacionRG();
        $cat_type_reporte = CatPlanSC::getLisTypeReporte();
        $cat_buy = CatProduct::getLisProduct();
        $cat_type_person = CatPersonType::getPersonTipeList();
        $cat_type_taxpayer = CatTypeTaxpayer::getTipeTaxpayerList();
        $cat_type_identification = CatIdentificationType::getListIdentificationTypes();
        $cat_type_identificationRep = CatIdentificationType::getListIdentificationRep();
        $cat_department = CatDepartment::getDeparmentsList();
        $cat_method = CatOriginMedium::getMethodList();
        $cat_time_format_linkage = CatTimeFormatLinkage::getTimeFormatList();
        return view('propuesta.detalle.index', compact(
            'encrypt',
            'datos',
            'detallePropuesta',
            'terminos',
            'cat_buy','cat_producto',
            'cat_sc',
            'cat_type_person',
            'cat_method',
            'cat_type_identification',
            'cat_type_identificationRep',
            'cat_department',
            'cat_time_format_linkage',
            'cat_type_taxpayer',
            'cat_type_rg',
            'cat_type_reporte',
            'listaDocs',
            'cat_type_mod_rg',
            'acronym',
            'aliado',
            'clienteTipoExpediente'
        ));

    }
    public function details(Request $request)
    {
        $attributes = $request->all();
        $result['plan_emision']= '';
        $result['plan_recepcion'] = '';
        $result['plan_portal_recepcion'] = '';
        $result['plan_certificado']= '';
        $result['plan_horas']= '';
        $result['plan_rg'] = '';
        $result['plan_plantilla'] = '';
        $result['plan_modRg'] = '';
        $result['plan_Reporte_facturas']= '';
        $result['plan_Reporte_clientes'] = '';
        $result['plan_Reporte_productos']= '';
        $result['plan_Reporte_clientes__productos'] = '';
        $result['plan_Reporte_secuenciales']= '';
        $result['plan_Rtraza'] = '';
        $result['plan_Dpdf']= '';
        $result['plan_Rarch'] = '';
        $result['plan_Csv']= '';
        $result['plan_Gmanual'] = '';
        $detallePropuesta = DetallePropuesta::getDPropuesta($attributes['id_propuesta']);
        foreach ($detallePropuesta as $value) {
            $detalle = CatPlanProducto::getData($value['id_plan_producto']);

            switch ($detalle['id_type_servicio']) {
                case 1:
                    $result['plan_horas'] = $detalle;
                    $result['plan_horas_cant'] = $value['cantidad'];
                    $result['plan_horas_cantPrice'] = $value['precio'];
                    $result['plan_horas_price'] = $value['precio']/$value['cantidad'];
                    break;
                case 2:
                    switch ($detalle['id']) {
                        case 2:
                            $result['plan_plantilla'] = $detalle;
                            $result['plan_plRg_cant'] = $value['cantidad'];
                            $result['plan_plRg_cantPrice'] = $value['precio'];
                            $result['plan_plRg_price'] = $value['precio']/$value['cantidad'];
                            break;
                        case 241:
                            $result['plan_rg'] = $detalle;
                            $result['plan_rg_cant'] = $value['cantidad'];
                            $result['plan_rg_cantPrice'] = $value['precio'];
                            $result['plan_rg_price'] = $value['precio']/$value['cantidad'];
                            break;
                        default:
                            $result['plan_modRg'] = $detalle;
                            $result['plan_modRg_price'] = $value['precio'];
                        }
                    break;
                case 3:
                    $nameRp =str_replace('+', '', $detalle['nombre']);
                    $nameRp =str_replace(' ', '_', $nameRp);
                    $nameRp = ucfirst(strtolower($nameRp));
                    $result['plan_'.$nameRp] = $detalle;
                    $result['plan_'.$nameRp.'_price'] = $value['precio'];
                    break;
                case 4:
                    $result['plan_Dpdf'] = $detalle;
                    $result['plan_Dpdf_price'] = $value['precio'];

                case 5:
                    $result['plan_Rtraza'] = $detalle;
                    $result['plan_Rtraza_price'] = $value['precio'];
                    break;
                case 6:
                    $result['plan_Rarch'] = $detalle;
                    $result['plan_Rarch_cant'] = $value['cantidad'];
                    $result['plan_Rarch_price'] = $value['precio'];
                    break;
                case 7:
                    $result['plan_Csv'] = $detalle;
                    $result['plan_Csv_price'] = $value['precio'];
                    break;
                case 8:
                    $result['plan_Gmanual'] = $detalle;
                    $result['plan_Gmanual_price'] = $value['precio'];
                    break;
                case 9:
                    $result['plan_emision'] = $detalle;
                    $result['plan_emision_price'] = $value['precio'];
                    $result['transacciones'] = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                    break;
                case 10:
                    $result['plan_emision'] = $detalle;
                    $result['plan_emision_price'] = $value['precio'];
                    $result['transacciones'] = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                    break;
                case 11:
                    $result['plan_recepcion'] = $detalle;
                    $result['plan_recepcion_price'] = $value['precio'];
                    $result['transaccionesR'] = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                    break;
                case 12:
                    $result['plan_emision'] = $detalle;
                    $result['plan_emision_price'] = $value['precio'];
                    $result['transacciones'] = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                    break;
                case 13:
                    $result['plan_certificado'] = $detalle;
                    $result['plan_certificado_price'] = $value['precio'];
                    break;
                case 14:
                    $result['plan_portal_recepcion'] = $detalle;
                    $result['plan_portal_recepcion_price'] = $value['precio'];
                    break;

                }

        }
        return json_encode($result);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */


    public function optfirma(Request $request)
    {
        $attributes = $request->all();
        $email=$attributes['email'];
        if($attributes['attorney']=='1'){
            $email=$attributes['email_attorney'];
        }
            $jsonToken = array();
            if(Config::get('params.general.ambiente')== 'production'){
                $token = ServicesController::SingatureOptAutentic($jsonToken);
                if($token){
                    $data_mail = array();
                    $data_mail['email'] = $email;
                    $data_mail['otp'] = $token->code;
                    Mail::send('mails.otp_envio', ['data_mail' => $data_mail], function ($message) use ($data_mail) {
                        $message->to($data_mail['email'])->subject("Código de autenticación");
                    });

                    $result['result']=1;
                    $result['email'] = $email;
                }else{
                    $result['result'] = 0;
                    $result['errors'] = 'No se creo opt.';
                }
            }else{
                $user =  ServicesController::CreateOTPUser($jsonToken);
                    $jsonToken ['key']=$user->key;
                    $jsonToken ['email']=$email;
                    $jsonToken ['period']='3600';

                $token = ServicesController::SingatureOptFirma($jsonToken);
                if($token){
                    $dataMail = array();
                    $dataMail['email'] = $email;
                    $dataMail['otp'] = $token->otp;
                    Mail::send('mails.otp_cliente', ['data_mail' => $dataMail], function ($message) use ($dataMail) {
                        $message->to($dataMail['email'])->subject("Código de autenticación para firmado de odc");
                        if(Config::get('params.general.ambiente') == 'production'){
                            $message->bcc('mcardenas@thefactoryhka.com');
                        }
                    });
                    $result['result']=1;
                    $result['email'] = $email;
                    $result['otp_user_key'] = $user->key;
                }else{
                    return response()->json(["code" => 200, "message" => "No se creo opt", "result" => 0], 200);
                }
            }
            return json_encode($result);

    }
    public function store(Request $request)
    {
        $mailTemplate = 'odc_correo';
        $attributes = $request->all();
        $result['result']=1;
        DB::beginTransaction();
        $clientePc = new ClientePcomercial();
        $clientePc->company_id = $attributes['dni'];
        $clientePc->verification_digit = $attributes['dv'];
        $clientePc->person_type = intval($attributes['type_person']);
        if($clientePc->person_type == 1){
            $clientePc->name_socialreason = is_null($attributes['nam_enterprise_edit']) ? $attributes['nam_enterprise'] : $attributes['nam_enterprise_edit'];
            $clientePc->comercial_name = is_null($attributes['lastnam_enterprise_edit']) ? $attributes['lastnam_enterprise'] : $attributes['lastnam_enterprise_edit'];
        }else{
            $clientePc->name_socialreason = (is_null($attributes['nam_enterprise_edit']) ? $attributes['nam_enterprise'] : $attributes['nam_enterprise_edit']).' '.(is_null($attributes['lastnam_enterprise_edit']) ? $attributes['lastnam_enterprise'] : $attributes['lastnam_enterprise_edit']);
            $clientePc->comercial_name = '';
        }
        $clientePc->id_municipality = intval($attributes['municipality']);
        $clientePc->address = $attributes['address_line'];
        $clientePc->phone = $attributes['phoneClient'];
        $clientePc->email_billing_contact = $attributes['email_fac'];
        $clientePc->email_invoices = $attributes['email_rad'];
        $clientePc->email_optional = $attributes['email_op'];
        $clientePc->id_tipo_contribuyente = intval($attributes['cat_type_taxpayer']);
        $clientePc->doc_valid = $attributes['doc_valid']=='false'? 0:1;
        if($clientePc->save()){
            $propuesta = new Propuesta();
            $propuesta->id_cliente_pcomercial = $clientePc->id;
            $propuesta->id_agency = Agencia::getId($attributes['code_agency']);
            $propuesta->iva = $attributes['iva'];
            $propuesta->retencion_ica = $attributes['reteICA'];
            $propuesta->retencion_iva = $attributes['reteIVA'];
            $propuesta->retencion_fuente = $attributes['reteFuente'];
            $propuesta->subtotal = $attributes['monto'];
            $propuesta->descuento = 0;
            $propuesta->total = $attributes['aPagar'];
            $propuesta->terminos_aceptados = json_encode($attributes['listTermino']);
            $propuesta->tipo = Cliente::getDataEnterprise($attributes['type_person'], $attributes['dni'], $attributes['dv'])? 3:1;
            if($propuesta->save()){
                $representative = new PersonaPcomercial();
                $representative->active = 1;
                $representative->tipo_identificacion = intval($attributes['type_identification_rep']);
                if($clientePc->person_type == 1){
                    $representative->identificacion =  $attributes['dni_rep'];
                    $representative->nombre = $attributes['nam_rep'];
                    $representative->apellido = $attributes['lastnam_rep'];
                }else{
                    $representative->identificacion = $attributes['dni_rep'];
                    $representative->nombre =  $attributes['nam_enterprise'];
                    $representative->apellido = $attributes['lastnam_enterprise'];
                }
                $representative->email = $attributes['email'];
                $representative->telefono = $attributes['phone'];
                if($representative->save()){
                    $propuestaRepresentative = new RelacionPcomercial();
                    $propuestaRepresentative->id_propuesta = $propuesta->id;
                    $propuestaRepresentative->id_persona_pcomercial = $representative->id;
                    $propuestaRepresentative->relation_type = 1;
                    if(!$propuestaRepresentative->save()){
                        $result['result'] = 0;
                        $result['errors'] = 'No se registro la relacion propuesta/representate.';
                    }
                }
                foreach ($attributes['planesAdd'] as $value) {
                    $cantidad = 1;
                    switch ($value) {
                        case 1:
                            $cantidad = $attributes['cant_folios_serComplentario_1'];
                            break;
                        case 2:
                            $cantidad = $attributes['cant_type_rg_2'];
                            break;
                        case 28:
                            $cantidad = $attributes['cant_reporte_traza'];
                            break;
                        case 241:
                            $cantidad = $attributes['cant_type_rg_241'];
                            break;
                    }
                    $detallePropuesta = new DetallePropuesta();
                    $detallePropuesta->id_propuesta = $propuesta->id;
                    $detallePropuesta->id_plan_producto = $value;
                    $detallePropuesta->precio = CatPlanProducto::getPrecio($value)*$cantidad;
                    $detallePropuesta->cantidad = $cantidad;
                    $getRetencion = CatPlanProducto::getRetenciones($value, $cantidad,$attributes['cat_type_taxpayer']);
                    $retencion = [
                        'retefuente' => $getRetencion['porcentaje_retefuente'],
                        'reteIVA' => $getRetencion['porcentaje_reteIVA'],
                        'reteICA' => $getRetencion['porcentaje_reteICA'],
                        'iva' => $getRetencion['porcentaje_iva']
                    ];
                    $retenciones=$retencion;
                            foreach ($retenciones as $key => $retencion) {
                                $retenciones[$key][0] = number_format($retencion[0], 2, ',', '');
                                $retenciones[$key][1] =floatval(number_format( $retencion[1], 2, '.', ''));
                            }
                    $detallePropuesta->retencion = json_encode($retenciones);
                    if ($detallePropuesta->save()) {
                        $tipoServicio = CatPlanProducto::getTipoServicio($detallePropuesta->id_plan_producto);
                        foreach ($attributes['listProducto'] as $code) {
                            if($code <= 2 && ($tipoServicio == 9 || $tipoServicio == 10 || $tipoServicio == 12)){
                                $transDetallePropuesta = new TransaccionDetallePropuesta();
                                $transDetallePropuesta->id_detalle_propuesta = $detallePropuesta->id;
                                $transDetallePropuesta->id_cat_transaccion = $code;
                                $transDetallePropuesta->cantidad =$attributes['cant_folios_'.$code];
                                $transDetallePropuesta->id_cat_application_type =$attributes['type_portal_'.$code];
                                if(!$transDetallePropuesta->save()){
                                    $result['result'] = 0;
                                    $result['errors'] = 'Error al registrar cantidad de folios de Emisión y/o Nómina.';
                                    break;
                                }
                            }
                            if($code == 3 && $tipoServicio == 11){
                                $transDetallePropuesta = new TransaccionDetallePropuesta();
                                $transDetallePropuesta->id_detalle_propuesta = $detallePropuesta->id;
                                $transDetallePropuesta->id_cat_transaccion = $code;
                                $transDetallePropuesta->cantidad =$attributes['cant_folios_3'];
                                $transDetallePropuesta->id_cat_application_type =$attributes['type_portal_3'];
                                if(!$transDetallePropuesta->save()){
                                    $result['result'] = 0;
                                    $result['errors'] = 'Error al registrar cantidad de folios de Recepción.';
                                    break;
                                }
                            }
                        }
                    }else{
                        $result['result'] = 0;
                        $result['errors'] = 'Error al registrar planes.';
                        break;
                    }
                }
            }else{
                $result['result'] = 0;
                $result['errors'] = 'No se registro propuesta.';
            }
        }else{
            $result['result'] = 0;
            $result['errors'] = 'No se registro cliente.';
        }

        if($result['result']== 0){
            DB::rollBack();
            return back();
            $result['message'] = 'Por favor revise los siguentes errores: ';
        }else{
            DB::commit();
            $dataClient= $propuesta->id;
            $cadenaEncriptada = self::encrypt($dataClient,Config::get('params.general.string_key'));


            if($attributes['exist_client']=='true'){
                if($attributes['type_person']==1){
                    if(isset($attributes['time_format_linkage'])){
                        $propuesta->slug = $cadenaEncriptada.'&3';
                        $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&3';
                        $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&3';

                    }else{
                        $propuesta->slug = $cadenaEncriptada.'&5';
                        $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&5';
                        $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&5';
                    }
                }else{
                    if(isset($attributes['time_format_linkage'])){
                        $propuesta->slug = $cadenaEncriptada.'&4';
                        $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&4';
                        $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&4';
                    }else{
                        $propuesta->slug = $cadenaEncriptada.'&5';
                        $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&5';
                        $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&5';
                    }

                }
            }else{
                if($attributes['type_person']==1){
                    $propuesta->slug = $cadenaEncriptada.'&1';
                    $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&1';
                    $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&1';

                }else{
                    $propuesta->slug = $cadenaEncriptada.'&2';
                    $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&2';
                    $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&2';
                }
            }
            $propuesta->save();
            $dataMail = array();
            $dataMail['email'] = $attributes['email'];
            $dataMail['url']= $url;
            $dataMail['urlPdf']= $urlPdf;
            Mail::send('mails.'.$mailTemplate, ['data_mail' => $dataMail], function ($message) use ($dataMail) {
                $message->to($dataMail['email'])->subject("Propuesta Comercial");
                if(Config::get('params.general.ambiente') == 'production'){
                    $message->bcc('mcardenas@thefactoryhka.com');
                }
            });

            $result['message'] = 'Se ha guardado con éxito';
            $result['result']=1;
            $result['email'] = $attributes['email'];
            $result['nit'] = $attributes['dni'];

        }

        return json_encode($result);

    }

    public function update(Request $request)
    {
        $mailTemplate = 'odc_correo';
        $attributes = $request->all();
        $result['result']=1;
        DB::beginTransaction();
        $propuesta = Propuesta::find($attributes['id_propuesta']);
        $propuesta->active = 0;
        if ($propuesta->save()) {
            $clientePc = ClientePcomercial::getClienteUpdate($propuesta->id_cliente_pcomercial);
            if($clientePc->person_type == 1){
                $clientePc->name_socialreason = $attributes['nam_enterprise'];
                $clientePc->comercial_name =$attributes['lastnam_enterprise'];
            }else{
                $clientePc->name_socialreason =  $attributes['nam_enterprise'].' '.$attributes['lastnam_enterprise'];
                $clientePc->comercial_name = '';
            }
            $clientePc->id_municipality = intval($attributes['municipality']);
            $clientePc->address = $attributes['address_line'];
            $clientePc->phone = $attributes['phoneClient'];
            $clientePc->email_billing_contact = $attributes['email_fac'];
            $clientePc->email_invoices = $attributes['email_rad'];
            $clientePc->email_optional = $attributes['email_op'];
            $clientePc->id_tipo_contribuyente = intval($attributes['cat_type_taxpayer']);
            if($clientePc->save()){
                $propuesta = new Propuesta();
                $propuesta->id_cliente_pcomercial = $clientePc->id;
                $propuesta->id_agency = Agencia::getId($attributes['code_agency']);
                $propuesta->iva = $attributes['iva'];
                $propuesta->retencion_ica = $attributes['reteICA'];
                $propuesta->retencion_iva = $attributes['reteIVA'];
                $propuesta->retencion_fuente = $attributes['reteFuente'];
                $propuesta->subtotal = $attributes['monto'];
                $propuesta->descuento = 0;
                $propuesta->total = $attributes['aPagar'];
                $propuesta->terminos_aceptados = json_encode($attributes['listTermino']);
                $propuesta->tipo = Cliente::getDataEnterprise($attributes['type_person'], $attributes['dni'], $attributes['dv'])? 3:1;
                if($propuesta->save()){
                    $representative = new PersonaPcomercial();
                    $representative->active = 1;
                    $representative->tipo_identificacion = intval($attributes['type_identification_rep']);
                    if($clientePc->person_type == 1){
                        $representative->identificacion =  $attributes['dni_rep'];
                        $representative->nombre = $attributes['nam_rep'];
                        $representative->apellido = $attributes['lastnam_rep'];
                    }else{
                        $representative->identificacion = $attributes['dni_rep'];
                        $representative->nombre =  $attributes['nam_enterprise'];
                        $representative->apellido = $attributes['lastnam_enterprise'];
                    }
                    $representative->email = $attributes['email'];
                    $representative->telefono = $attributes['phone'];
                    if($representative->save()){
                        $propuestaRepresentative = new RelacionPcomercial();
                        $propuestaRepresentative->id_propuesta = $propuesta->id;
                        $propuestaRepresentative->id_persona_pcomercial = $representative->id;
                        $propuestaRepresentative->relation_type = 1;
                        if(!$propuestaRepresentative->save()){
                            $result['result'] = 0;
                            $result['errors'] = 'No se registro la relacion propuesta/representate.';
                        }
                    }
                    foreach ($attributes['planesAdd'] as $value) {
                        $cantidad = 1;
                        switch ($value) {
                            case 1:
                                $cantidad = $attributes['cant_folios_serComplentario_1'];
                                break;
                            case 2:
                                $cantidad = $attributes['cant_type_rg_2'];
                                break;
                            case 28:
                                $cantidad = $attributes['cant_reporte_traza'];
                                break;
                            case 241:
                                $cantidad = $attributes['cant_type_rg_241'];
                                break;
                        }
                        $detallePropuesta = new DetallePropuesta();
                        $detallePropuesta->id_propuesta = $propuesta->id;
                        $detallePropuesta->id_plan_producto = $value;
                        $detallePropuesta->precio = CatPlanProducto::getPrecio($value)*$cantidad;
                        $detallePropuesta->cantidad = $cantidad;
                        $getRetencion = CatPlanProducto::getRetenciones($value, $cantidad,$attributes['cat_type_taxpayer']);
                        $retencion = [
                            'retefuente' => $getRetencion['porcentaje_retefuente'],
                            'reteIVA' => $getRetencion['porcentaje_reteIVA'],
                            'reteICA' => $getRetencion['porcentaje_reteICA'],
                            'iva' => $getRetencion['porcentaje_iva']
                        ];
                        $retenciones=$retencion;
                            foreach ($retenciones as $key => $retencion) {
                                $retenciones[$key][0] = number_format($retencion[0], 2, ',', '');
                                $retenciones[$key][1] =floatval(number_format( $retencion[1], 2, '.', ''));
                            }
                        $detallePropuesta->retencion = json_encode($retenciones);
                        if ($detallePropuesta->save()) {
                            $tipoServicio = CatPlanProducto::getTipoServicio($detallePropuesta->id_plan_producto);
                            foreach ($attributes['listProducto'] as $code) {
                                if($code <= 2 && ($tipoServicio == 9 || $tipoServicio == 10 || $tipoServicio == 12)){
                                    $transDetallePropuesta = new TransaccionDetallePropuesta();
                                    $transDetallePropuesta->id_detalle_propuesta = $detallePropuesta->id;
                                    $transDetallePropuesta->id_cat_transaccion = $code;
                                    $transDetallePropuesta->cantidad =$attributes['cant_folios_'.$code];
                                    $transDetallePropuesta->id_cat_application_type =$attributes['type_portal_'.$code];
                                    if(!$transDetallePropuesta->save()){
                                        $result['result'] = 0;
                                        $result['errors'] = 'Error al registrar cantidad de folios de Emisión y/o Nómina.';
                                        break;
                                    }
                                }
                                if($code == 3 && $tipoServicio == 11){
                                    $transDetallePropuesta = new TransaccionDetallePropuesta();
                                    $transDetallePropuesta->id_detalle_propuesta = $detallePropuesta->id;
                                    $transDetallePropuesta->id_cat_transaccion = $code;
                                    $transDetallePropuesta->cantidad =$attributes['cant_folios_3'];
                                    $transDetallePropuesta->id_cat_application_type =$attributes['type_portal_3'];
                                    if(!$transDetallePropuesta->save()){
                                        $result['result'] = 0;
                                        $result['errors'] = 'Error al registrar cantidad de folios de Recepción.';
                                        break;
                                    }
                                }
                            }
                        }else{
                            $result['result'] = 0;
                            $result['errors'] = 'Error al registrar planes.';
                            break;
                        }
                    }
                }else{
                    $result['result'] = 0;
                    $result['errors'] = 'No se registro propuesta.';
                }
            }else{
                $result['result'] = 0;
                $result['errors'] = 'No se registro cliente.';
            }
        }else{
            $result['result'] = 0;
            $result['errors'] = 'No se actualizo la propuesta.';
        }


        if($result['result']== 0){
            DB::rollBack();
            return back();
            $result['message'] = 'Por favor revise los siguentes errores: ';
        }else{
            DB::commit();
            $dataClient= $propuesta->id;
            $cadenaEncriptada = self::encrypt($dataClient,Config::get('params.general.string_key'));
            $consultaCliente=Cliente::getDataEnterprise($attributes['type_person'], $attributes['dni'], $attributes['dv']);
            if($consultaCliente){
                if($attributes['type_person']==1){
                    if(isset($attributes['time_format_linkage'])){
                        $propuesta->slug = $cadenaEncriptada.'&3';
                        $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&3';
                        $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&3';

                    }else{
                        $propuesta->slug = $cadenaEncriptada.'&5';
                        $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&5';
                        $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&5';
                    }
                }else{
                    if(isset($attributes['time_format_linkage'])){
                        $propuesta->slug = $cadenaEncriptada.'&4';
                        $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&4';
                        $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&4';
                    }else{
                        $propuesta->slug = $cadenaEncriptada.'&5';
                        $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&5';
                        $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&5';
                    }

                }
            }else{
                if($attributes['type_person']==1){
                    $propuesta->slug = $cadenaEncriptada.'&1';
                    $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&1';
                    $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&1';

                }else{
                    $propuesta->slug = $cadenaEncriptada.'&2';
                    $url = Config::get('params.services.url').'propuesta/'.$cadenaEncriptada.'&2';
                    $urlPdf= Config::get('params.services.url').'propuesta/pdf/'.$cadenaEncriptada.'&2';
                }
            }
            $propuesta->save();
            $dataMail = array();
            $dataMail['email'] = $attributes['email'];
            $dataMail['url']= $url;
            $dataMail['urlPdf']= $urlPdf;
            Mail::send('mails.'.$mailTemplate, ['data_mail' => $dataMail], function ($message) use ($dataMail) {
                $message->to($dataMail['email'])->subject("Actualizacion de Propuesta Comercial");
                if(Config::get('params.general.ambiente') == 'production'){
                    $message->bcc('mcardenas@thefactoryhka.com');
                }
            });

            $result['message'] = 'Se ha actualizo con éxito';
            $result['result']=1;
            $result['email'] = $attributes['email'];
            $result['nit'] = $attributes['dni'];

        }

        return json_encode($result);

    }

    function type(Request $request,$code_type_person){
        if(!$request->ajax()){
            return response()->json(["code"=>500,"message"=>"Acceso No Autorizado"],403);
        }
        $cat_type_identification = CatIdentificationType::getListIdentification($code_type_person);
        return response()->json(["code"=>200,"message"=>"Exitoso","data"=>$cat_type_identification],200);
    }

    function typeFormat(Request $request){
        try {

            $val = $request->input('val');
            $cat_type_format_linkage = CatFormatLinkage::getFormatList($val);
            $response = ['data' => $cat_type_format_linkage];

        } catch (\Exception $exception) {
            return response()->json([ 'message' => 'Hubo un error al recuperar los registros' ], 500);
        }
        return response()->json($response);
    }


    public function encrypt_email($email)
    {
        $result = '';
        preg_match('~([^@]+)@([^\.]+)((\.[^$]+)+)~', $email, $email_parts);

        $percent = 50;

        $prefix_percent = (strlen($email_parts[1]) * $percent) / 100;

        $prefix_email = substr($email, 0, $prefix_percent) . str_repeat('*', strlen($email_parts[1])-($prefix_percent-1));

        $suffix_email = str_repeat('*', strlen($email_parts[2])) . $email_parts[3];

        $new_email = $prefix_email . '@' . $suffix_email;

        return $new_email;
    }

    public function search(Request $request)
    {
        $attributes = $request->all();
        $propuesta = Propuesta::getPropuestaActiva($attributes['type_person'], $attributes['dni'], $attributes['dv']);
        if($propuesta['activas'] <= 2){
            $detalles ='';
            $Enterprise = Cliente::getDataEnterprise($attributes['type_person'], $attributes['dni'], $attributes['dv']);
            $correo='';
            if (isset($Enterprise) && !empty($Enterprise)) {
                if(count($Enterprise->contrato)>0){
                    return response()->json(["code" => 403, "errors" => '<div class="alert alert-danger" role="alert">
                        <p>Para continuar con su proceso por favor comuníquese con su asesor comercial</p>
                </div>
                ', "result" => 0, "propuesta" => $propuesta], 200);
                }
                $idRepresentante = Relacion::getIdPersona($Enterprise->id, 1);
                $Representative = Persona::getData($idRepresentante->person_id);
                $idAttorney = Relacion::getIdPersona($Enterprise->id, 8);
                if (isset($idAttorney) && !empty($idAttorney)) {
                    $attorney = Persona::getData($idAttorney->person_id);
                    $Attorney = $attorney;
                } else {
                    $Attorney = null;
                }
                $municipality = '';
                if ($Enterprise->code_city) {
                    $municipality = CatMunicipality::getIdMunicipality($Enterprise->code_department . $Enterprise->code_city);
                }
                $derpament = '';
                if ($Enterprise->code_department) {
                    $derpament = CatDepartment::getIdDepartament($Enterprise->code_department);
                }

                $vendor = Agencia::getId($Enterprise->code_agency);
                $idOriginMedium = Agencia::getTipoAliado($Enterprise->code_agency);
                $Enterprise->origin_medium= CatOriginMedium::getOriginMedium($idOriginMedium);
                $Enterprise->origin_vendor= Agencia::getOriginVendor($Enterprise->code_agency);
                if($propuesta['activas']>0){
                    $detalles = self::detallePropuestas($propuesta['propuestas']);
                }
                if($attributes['id_type_person'] == ''){
                    $email= $Representative->email;
                    $jsonToken = array();
                    $user =  ServicesController::CreateOTPUser($jsonToken);
                    $jsonToken ['key']=$user->key;
                    $jsonToken ['email']=$email;
                    $jsonToken ['period']='3600';
                    $token =  ServicesController::SingatureOpt($jsonToken);
                    if($token){
                        $dataMail = array();
                        $dataMail['email'] = $email;
                        $dataMail['otp'] = $token->otp;
                        Mail::send('mails.otp_cliente', ['data_mail' => $dataMail], function ($message) use ($dataMail) {
                            $message->to($dataMail['email'])->subject("Código de autenticación");
                            if(Config::get('params.general.ambiente') == 'production'){
                                $message->bcc('mcardenas@thefactoryhka.com');
                            }
                        });
                        $correo = self::encrypt_email($email);

                    }else{
                        return response()->json(["code" => 200, "message" => "No se creo opt", "result" => 0], 200);
                    }

                }

                return response()->json(["code" => 200, "message" => "Empresa encontrada", "enterprise" => $Enterprise, "detalles"=> $detalles,"Representative" => $Representative, "Attorney" => $Attorney, "municipality" => $municipality, "derpament" => $derpament, "vendor" => $vendor,'correo'=>$correo, "result" => 1, 'otp_user_key'=>$user->key], 200);

            } else {
                return response()->json(["code" => 200, "errors" => '<div class="alert alert-warning" role="alert">
                        <p>Los datos ingresados no corresponden a un cliente registrado previamente por favor revise e intente nuevamente, en caso de no haberse inscrito previamente, vamos a iniciar su proceso de vinculación.</p>
                </div>
                ', "result" => 0, "enterprise" => $Enterprise], 200);
            }
        }else{
            return response()->json(["code" => 403, "errors" => '<div class="alert alert-danger" role="alert">
                        <p>Este cliente posee mas de tres propuestas comercial activas</p>
                </div>
                ', "result" => 0, "propuesta" => $propuesta], 200);
        }

    }
    public function valid(Request $request)
    {
        $attributes = $request->all();
        $result['result']=1;
        $result['mesagge']='';
        $rut = base64_encode(file_get_contents($attributes['rut_attachment']->getPathName()));
            $jsonRut = array();
            $jsonRut['RUT'] = $rut;

            $Rut = ServicesController::SingatureRut($jsonRut);
            $result['SingatureRut']=$Rut;
            if(isset($Rut->codigo) && $Rut->codigo==0){
                $tipo='24';
                $tip_per=$Rut->data->$tipo->data;
                if($tip_per == intval($attributes['type_person'])){
                    $nit='5';
                    $dni=$Rut->data->$nit->data;
                    if($dni == $attributes['dni']){
                        $depart='39';
                        $munic='40';
                        $address='41';
                        $mail='42';
                        $phone='44';
                        $reg_nit = Cliente::getNit($dni);
                        $result['existe']= !$reg_nit? false : true;
                        $result['type_person']= $tip_per==1 ? '1': '2';
                        if($tip_per == 1){
                            $enterprise='35';
                            $rep='18';
                            $rep_sub='19';
                            $ide='101';
                            $ape='104';
                            $ape2='105';
                            $nam='106';
                            $nam2='107';
                            $datos_repre=$Rut->data->$rep;
                            $datos_sub_repre=$Rut->data->$rep_sub;
                            $dni_rep=$datos_repre->$ide->data;
                            $dni_sub_rep=$datos_sub_repre->$ide->data;
                            $dni=$Rut->data->$nit->data;
                            $result['nam_enterprise']=trim($Rut->data->$enterprise->data);
                            if($reg_nit){
                                $result['comercial_name']= $reg_nit['comercial_name'];
                            }else{
                                $result['comercial_name']= '';
                            }
                            $result['dni_rep'] =$tip_per==1 ? $dni_rep : $dni;
                            $result['nam_rep'] =$datos_repre->$nam->data.' '.$datos_repre->$nam2->data;
                            $result['lastnam_rep'] =$datos_repre->$ape->data.' '.$datos_repre->$ape2->data;

                        }else{
                            $cod_num='26';
                            $nam='33';
                            $nam1='34';
                            $lastnam='31';
                            $lastnam1='32';
                            $dni=$Rut->data->$cod_num->data;
                            if (isset($Rut->data->$nam1)) {
                                $nombre=trim($Rut->data->$nam->data).' '.trim($Rut->data->$nam1->data);
                            }else{
                                $nombre=trim($Rut->data->$nam->data);
                            }
                            if (isset($Rut->data->$lastnam1)) {
                                $apellido=trim($Rut->data->$lastnam->data).' '.trim($Rut->data->$lastnam1->data);
                            }else{
                                $apellido=trim($Rut->data->$lastnam->data);
                            }
                            $result['nam_enterprise']=$nombre;
                            $result['comercial_name']= $apellido;
                            $result['dni_rep'] = $dni;
                            $result['nam_rep'] =$nombre;
                            $result['lastnam_rep'] =$apellido;
                        }
                        $result['dni']=$dni;
                        $result['email']= $Rut->data->$mail->data;
                        if($reg_nit){
                            $result['email_invoices']=$reg_nit['email_invoices'];
                            $result['email_billing_contact']=$reg_nit['email_billing_contact'];
                            $result['email_optional']=$reg_nit['email_optional'];
                        }
                        $result['phone'] =$Rut->data->$phone->data;
                        $result['department'] =strval(CatDepartment::getIdDepartament($Rut->data->$depart->data));
                        $municipality = CatMunicipality::getDescriptionMunicipality($Rut->data->$depart->data . $Rut->data->$munic->data);
                        $result['cod_municipality'] =CatMunicipality::getIdMunicipality($Rut->data->$depart->data . $Rut->data->$munic->data);
                        $result['municipality'] =$municipality;
                        $result['address_line'] =$Rut->data->$address->data;
                        if($reg_nit){
                            $result['cat_method']= $reg_nit['id_cat_origin_medium'];
                            $result['vendor']= $reg_nit['origin_vendor'];
                            $result['code_agency']= $reg_nit['code_agency'];
                        }else{
                            $result['cat_method']= '';
                            $result['vendor']='';
                            $result['code_agency']= '';
                        }
                    }else{
                        $result['result']=0;
                        $result['errors']='Numero de Documento No Coincide con el NIT del RUT';
                    }
                }else{
                    $result['result']=0;
                    $result['errors']='Tipo de Persona No Coincide con el del RUT';
                }

            }elseif($Rut->codigo==25 || $Rut->codigo==24 ){
                $result['result']= 2;
            }else{
                $result['result']=0;
                $result['errors']='
                <ul class="list-unstyled">
                    <li>Ha ocurrido un error al leer el RUT. Es necesario que el documento que se adjunte sea el PDF descargado de la DIAN y sin clave.</li> <br>
                    <li>Para realizar la descarga del documento desde la DIAN realice los siguientes pasos:<br>
                        <ul>
                            <li>Paso 1. Ingrese al Portal MUISCA:<a href="https://muisca.dian.gov.co"  target="_blank"> www.muisca.dian.gov.co</a> www.muisca.dian.gov.co</li>
                            <li>Paso 2.  Inicie sesión con sus datos</li>
                            <li>Paso 3. Haga clic en “Obtener copia RUT”  ubicado en la ventana principal</li>
                            <li>Paso 4. Cargue nuevamente el documento en nuestro Portal de Registro</li>
                        </ul>
                    </li>
                </ul>';
            }

            return json_encode($result);

    }

    public function valid_opt(Request $request)
    {
        $attributes = $request->all();
        $jsonValidOtp = array();
        $jsonValidOtp["key"]= $attributes['user'];
        $jsonValidOtp["email"]=$attributes['email'];
        $jsonValidOtp["period"]="3600";
        $jsonValidOtp["otp"]=$attributes['opt_cliente'];

        $ValidOpt = ServicesController::SingatureValidOpt($jsonValidOtp);

        $CodeValid=$ValidOpt->valid;
        if($CodeValid=='true'){
            $result['result']=1;
            $result['message'] = 'Código de autenticación ha sido validado, presione "Siguiente" para continuar con el proceso.';
        }else if ($CodeValid =='false') {
            $result['result'] = 0;
            $result['used'] = 1;
            $result['ValidOpt'] = $ValidOpt;
            $result['errors'] = 'Código de autenticación no valido.';
        }else{
            $result['ValidOpt'] = $ValidOpt;
            $result['used'] = 2;
            $result['result'] = 0;
            $result['errors'] = 'Código de autenticación no valido.';
        }


            return json_encode($result);

    }

    public function valid_vendor(Request $request)
    {
        $attributes = $request->all();
        $code=$attributes['code_agency'];
            $valid = ServicesController::SingatureCode($code);

            if($valid){
                if($valid->exist){
                    $idOriginMedium = Agencia::getTipoAliado($attributes['code_agency']);
                    $result['cat_method']=CatOriginMedium::getOriginMedium($idOriginMedium);
                    $result['vendor']=Agencia::getOriginVendor($attributes['code_agency']);
                    $result['result']=1;
                    $result['message'] = '<div class="alert alert-success" role="alert">
                    <ul class="list-unstyled">
                        <li>El Código de Agencia ha sido validado exitosamente. Por favor, haga clic en el botón
                        <b>SIGUIENTE</b> para continuar con el proceso de compra</li><br>
                    </ul>
                </div>
                ';
                    if($valid->insoft){
                        $result['insoft']=1;
                    }else{
                        $result['insoft']=0;
                    }
                    $idVendor = Agencia::getId($code);
                    $result['concesion'] = 'false';
                    $jsonConcesionAgencia = array();
                    $jsonConcesionAgencia["codigo"]= $attributes['code_agency'];
                    $jsonConcesionAgencia["tipo"]='agencia';
                    $validConcesionA = ServicesController::SingatureConcesion($jsonConcesionAgencia);

                    if($validConcesionA){
                        if(isset($validConcesionA->concesion) && isset($validConcesionA->tipo)){
                            $result['concesion']= 'true';
                        }
                    }
                }else{
                    $result['result']=0;
                    $result['errors'] = 'El Código de Agencia <b>no ha sido validado</b>, por favor verifique e intentelo nuevamente.<br><br>En caso de que no conozca el código asociado a su vendedor, por favor comuníquese con su asesor o con nuestra Área Comercial a través de los siguientes medios:
                    <ul>
                        <li>Máster 1: +57 317 668 7663, Opción 1 </li>
                        <li>Correo Electrónico: ventas_co@thefactoryhka.com</li>
                    </ul>';
                }
            }else{
                $result['result'] = 0;
                $result['errors'] = 'No se logro validar Código de agencia, por favor intentelo de nuevo.';
            }


            return json_encode($result);

    }

    public function search_plan(Request $request)
    {
        $attributes = $request->all();
        $result['plan_emision']= '';
        $result['plan_recepcion'] = '';
        $result['plan_certificado']= '';
        $result['plan_horas']= '';
        $result['plan_rg'] = '';
        $result['plan_plantilla'] = '';
        $result['plan_rg_mod'] = '';
        $result['plan_Rfactura']= '';
        $result['plan_Rclientes'] = '';
        $result['plan_Rproductos']= '';
        $result['plan_Rcli_proc'] = '';
        $result['plan_Rsecuenciales']= '';
        $result['plan_Rtraza'] = '';
        $result['plan_Dpdf']= '';
        $result['plan_Rarch'] = '';
        $result['plan_Csv']= '';
        $result['plan_Gmanual'] = '';
        $tipoServicio= isset($attributes['time_format_linkage']) ? $attributes['time_format_linkage']:12;
        foreach ($attributes['listProducto'] as $value) {
            switch ($value) {
                case 1:
                    $folios_emision = $attributes['cant_folios_1'] + $attributes['cant_folios_2'];
                    $result['plan_emision'] = $folios_emision == 0 ? '' : CatPlanProducto::getPlanEmision($tipoServicio, $folios_emision , $attributes['cat_type_taxpayer']);
                    break;
                case 2:
                    $folios_emision = $attributes['cant_folios_1'] + $attributes['cant_folios_2'];
                    $result['plan_emision'] = $folios_emision == 0 ? '' : CatPlanProducto::getPlanEmision($tipoServicio, $folios_emision, $attributes['cat_type_taxpayer']);
                    break;
                case 3:
                    $folios_recepcion = $attributes['cant_folios_3'];
                    $result['plan_recepcion'] = $folios_recepcion == 0 ? '' : CatPlanProducto::getPlanRecepcionSC($folios_recepcion, $attributes['cat_type_taxpayer'],$attributes['RecepContratRta']);
                    break;
                case 4:
                    if ($result['plan_emision']==''){
                        $result['plan_certificado'] = $tipoServicio == 12 ? '' : CatPlanProducto::getPlanCertificado($tipoServicio, $attributes['cat_type_taxpayer']);
                    }
                    break;
                case 5:
                    foreach ($attributes['listSC'] as $valueSC) {
                        switch ($valueSC) {
                            case 1:
                                $result['plan_horas'] =  CatPlanProducto::getPlanHoras($attributes['cant_folios_serComplentario_1'], $attributes['cat_type_taxpayer']);
                                break;
                            case 2:
                                foreach ($attributes['listTypeRG'] as $valueRG) {
                                    switch ($valueRG) {
                                        case 2:
                                            $result['plan_plantilla'] = CatPlanProducto::getPlanRG($valueRG, $attributes['cant_type_rg_'.$valueRG], $attributes['cat_type_taxpayer']);
                                            break;
                                        case 241:
                                            $result['plan_rg'] = CatPlanProducto::getPlanRG($valueRG, $attributes['cant_type_rg_'.$valueRG], $attributes['cat_type_taxpayer']);
                                            break;
                                        case 242:
                                            $result['plan_rg_mod'] = CatPlanProducto::getPlanRG($attributes['cant_type_rg_242'], 1 , $attributes['cat_type_taxpayer']);
                                            break;
                                    }
                                }
                                break;
                            case 3:
                                foreach ($attributes['listTypeReporte'] as $valueTR) {
                                    switch ($valueTR) {
                                        case 3:
                                            $result['plan_Rfactura'] = CatPlanProducto::getPlanReporte(3, $attributes['cat_type_taxpayer']);
                                            break;
                                        case 4:
                                            $result['plan_Rclientes'] = CatPlanProducto::getPlanReporte(4, $attributes['cat_type_taxpayer']);
                                            break;
                                        case 5:
                                            $result['plan_Rproductos'] = CatPlanProducto::getPlanReporte(5, $attributes['cat_type_taxpayer']);
                                            break;
                                        case 6:
                                            $result['plan_Rcli_proc'] = CatPlanProducto::getPlanReporte(6, $attributes['cat_type_taxpayer']);
                                            break;
                                        case 7:
                                            $result['plan_Rsecuenciales'] = CatPlanProducto::getPlanReporte(7, $attributes['cat_type_taxpayer']);
                                            break;
                                        case 8:
                                            $canTraza = $attributes['cant_reporte_traza'] > 40 ? 40 : $attributes['cant_reporte_traza'];
                                            $result['plan_Rtraza'] = CatPlanProducto::getPlanReporteCant($canTraza, 5, $attributes['cat_type_taxpayer']);
                                            break;
                                    }
                                }
                                break;
                            case 4:
                                $canPdf = $attributes['cant_folios_serComplentario_4'] > 100000 ? 100000 : $attributes['cant_folios_serComplentario_4'];
                                $result['plan_Dpdf'] =  CatPlanProducto::getPlanReporteCant($canPdf,4, $attributes['cat_type_taxpayer']);
                                break;
                            case 6:
                                $result['plan_Rarch'] =  CatPlanProducto::getPlanReporteArchCant($attributes['cant_folios_serComplentario_6'], $attributes['cat_type_taxpayer']);
                                break;
                            case 7:
                                $canCsv = $attributes['cant_folios_serComplentario_7'] > 4000 ? 4000 : $attributes['cant_folios_serComplentario_7'];
                                $result['plan_Csv'] =  CatPlanProducto::getPlanReporteCant($canCsv,7, $attributes['cat_type_taxpayer']);
                                break;
                            case 8:
                                $canGmanual = $attributes['cant_folios_serComplentario_8'] > 3 ? 3 : $attributes['cant_folios_serComplentario_8'];
                                $result['plan_Gmanual'] =  CatPlanProducto::getPlanReporteCant($canGmanual,8, $attributes['cat_type_taxpayer']);
                                break;
                        }
                    }
                    break;
            }


        }

        return json_encode($result);

    }

    public function exportPdf($encrypt)
    {
        $data = explode('&',$encrypt);

        $id = self::decrypt($data[0], Config::get('params.general.string_key'));
        $propuesta = Propuesta::find($id);
        $terminos = CatTerminos::getTerminosList();
        if($propuesta){
            if($propuesta->active == 1){
                $datos[] = $propuesta;
                $clientePcomercial = ClientePcomercial::getClienteP($propuesta->id_cliente_pcomercial);
                array_push($datos,$clientePcomercial);
                $ubicacion = CatMunicipality::getData($clientePcomercial->id_municipality);
                array_push($datos,$ubicacion);
                $representante = RelacionPcomercial::getDataPersona($id,1);
                $acronym = CatIdentificationType::getAcronym($representante->tipo_identificacion);
                array_push($datos,$representante);
                $apoderado= RelacionPcomercial::getDataPersona($id,8);
                array_push($datos,$apoderado);
                $detallePropuesta = VwDetallePropuesta::getDPropuesta($id);
                $transacciones = 0;
                $transaccionesR = 0;
                $servicioEm = false;
                $servicioRe = false;
                $condicionesVista = [];
                foreach ($detallePropuesta as $value) {
                    $detalle = CatPlanProducto::getData($value['id_plan_producto']);
                    $condicionVista = self::condicionesCompra($value['id_plan_producto'],true);
                    if (!is_null($condicionVista)) {
                        if (!is_null($condicionVista['condiciones'])) {
                            array_push($condicionesVista, $condicionVista);
                        }
                    }
                    switch ($detalle['id_type_servicio']) {
                        case 9:
                            $transacciones = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                            $servicioEm = true;
                            break;
                        case 10:
                            $transacciones = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                            $servicioEm = true;
                            break;
                        case 11:
                            $transaccionesR = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                            $servicioRe = true;
                            break;
                        case 12:
                            $transacciones = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                            $servicioEm = true;
                            break;

                    }
                }
            }else{
                if($propuesta->cant_firmas > 0){
                    $firmado = true;
                }else{

                    $firmado = false;
                }
                return view('propuesta.caducado',compact('firmado'));
            }
                $propuesta->cant_descargas += 1;
                $propuesta->save();
                return PDF::loadView('pdf.vista',['ambiente'=>Config::get('params.general.ambiente'),'datos' => $datos,'detallePropuesta' => $detallePropuesta, 'tipo'=>$data[1],'acronimoTipoDoc'=>$acronym, 'transacciones'=>$transacciones, 'transaccionesR'=>$transaccionesR, 'servicioEm'=>$servicioEm, 'servicioRe'=>$servicioRe, 'terminos'=>$terminos, 'condicionesVista'=>$condicionesVista ])

                ->stream(' Propuesta Comercial TFHKA '. $datos[1]->company_id.' '.date_format($datos[1]->created_at, 'd-m-Y H-i-s').'.pdf');
            }
            abort(403, 'Unauthorized action.');
     }

    public function store_attorney(Request $request)
    {
        $attributes = $request->all();
        $result['result']=1;
        DB::beginTransaction();
        $enterprise = new Cliente();
        $enterprise->code_department = CatDepartment::getCodeDepartment($attributes['department']);
        $enterprise->code_city =  substr(CatMunicipality::getCodeMunicipality($attributes['municipality']),-3);
        $enterprise->person_type = intval($attributes['type_person']);
        $enterprise->company_id = $attributes['dni'];
        $enterprise->verification_digit = $attributes['dv'];
        if($enterprise->person_type == 1){
            $enterprise->name_socialreason = is_null($attributes['nam_enterprise_edit']) ? $attributes['nam_enterprise'] : $attributes['nam_enterprise_edit'];
            $enterprise->comercial_name = is_null($attributes['lastnam_enterprise_edit']) ? $attributes['lastnam_enterprise'] : $attributes['lastnam_enterprise_edit'];
        }else{
            $enterprise->name_socialreason = (is_null($attributes['nam_enterprise_edit']) ? $attributes['nam_enterprise'] : $attributes['nam_enterprise_edit']).' '.(is_null($attributes['lastnam_enterprise_edit']) ? $attributes['lastnam_enterprise'] : $attributes['lastnam_enterprise_edit']);
            $enterprise->comercial_name = '';
        }
        $enterprise->address = $attributes['address_line'];
        $enterprise->code_agency = $attributes['code_agency'];
        $enterprise->email_billing_contact = $attributes['email_fac'];
        $enterprise->email_invoices = $attributes['email_rad'];
        $enterprise->email_optional = $attributes['email_op'];
        $enterprise->client_type = 1;
        $enterprise->id_cat_origin_medium = Agencia::getTipoAliado($attributes['code_agency']);
        $enterprise->origin_medium = CatOriginMedium::getOriginMedium($enterprise->id_cat_origin_medium);
        $enterprise->origin_vendor = $attributes['vendor'];
        $enterprise->general_status = 0;
        $enterprise->active = 1;
        $enterprise->application_type = CatFormatLinkage::getApplicationType($attributes['type_format_linkage']);
        $enterprise->phone = $attributes['phone'];
        $enterprise->id_format_linkage = $attributes['type_format_linkage'];
        $enterprise->format_linkage = CatFormatLinkage::getFormatLinkage($attributes['type_format_linkage']);
        $enterprise->comments_registration_portal = $attributes['comments'];
        $enterprise->id_agency = Agencia::getId($attributes['code_agency']);
        $enterprise->department = CatDepartment::getDepartment($attributes['department']);
        $enterprise->city = CatMunicipality::getMunicipality($attributes['municipality']);
        //////// Representante Legal////
        $representative = new Persona();
        $representative->active = 1;
        $representative->tipo_identificacion = intval($attributes['type_identification_rep']);
        $representative->identificacion = $attributes['dni_rep'];
        if($attributes['type_person']=='1'){
            $representative->nombre = is_null($attributes['nam_rep_edit']) ? $attributes['nam_rep'] : $attributes['nam_rep_edit'];
            $representative->apellido = is_null($attributes['lastnam_rep_edit']) ? $attributes['lastnam_rep'] : $attributes['lastnam_rep_edit'];
        }else{
            $representative->nombre = $enterprise->name_socialreason;
            $representative->apellido = $enterprise->comercial_name;
        }
        $representative->email = $attributes['email'];

        if($enterprise->save() && $representative->save()){
            $enterpriseRepresentative = new Relacion();
            $enterpriseRepresentative->enterprise_id = $enterprise->id;
            $enterpriseRepresentative->person_id = $representative->id;
            $enterpriseRepresentative->relation_type = 1;
            $enterpriseRepresentative->active = 1;
            if(!$enterpriseRepresentative->save()){
                $result['result'] = 0;
                $result['errors'] = 'No se registro la relacion empresa/representate.';
            }
           if(isset($attributes['comments']) && !empty($attributes['comments'])){
                $jsonComment = array();
                $jsonComment['id_tipo'] = 10;
                $jsonComment['comentario'] = $attributes['comments'];
                $jsonComment['tipo_registro'] ='cliente';
                $jsonComment['id_user'] = Config::get('params.credentials.user_vito');
                $jsonComment['id_registro'] = $enterprise->id;
                $comentario = ServicesController::CreateComentario($jsonComment);
                if(!$comentario){
                    $result['result'] = 0;
                    $result['errors'] = 'No se registro el comentario.';
                }
            }
        }else{
            $result['result'] = 0;
            $result['errors'] = 'No se registro la empresa y/o representante.';
        }

        //////// Apoderado////
        $attorney = new Persona();
        $attorney->active = 1;
        $attorney->tipo_persona = $attributes['type_attorney'];
        $attorney->nit = $attributes['nit_attorney'];
        $attorney->digito_verificacion = $attributes['dv_attorney'];
        $attorney->tipo_identificacion = intval($attributes['type_identification_attorney']);
        $attorney->identificacion = $attributes['dni_attorney'];
        $attorney->nombre = $attributes['nam_attorney'];
        $attorney->apellido = $attributes['lastnam_attorney'];
        if($attributes['type_attorney']=='1'){
            $attorney->razon_social = $attributes['nam_attorney_juridico'];
            $attorney->nombre_comercial = $attributes['lastnam_attorney_juridico'];
        }
        $attorney->email = $attributes['email_attorney'];
        $attorney->telefono = $attributes['phone_attorney'];
        if($attorney->save()){
            $enterpriseAttorney = new Relacion();
            $enterpriseAttorney->enterprise_id = $enterprise->id;
            $enterpriseAttorney->person_id = $attorney->id;
            $enterpriseAttorney->relation_type = 8;
            $enterpriseAttorney->active = 1;
            if(!$enterpriseAttorney->save()){
                $result['result'] = 0;
                $result['errors'] = 'No se registro la relacion empresa/apoderado.';
            }

        }else{
            $result['result'] = 0;
            $result['errors'] = 'No se registro el apoderado.';
        }

        //////// fin Apoderado ////////

            $RazonSocial= self::eliminar_tildes($enterprise->name_socialreason);
            $NamEnterprise = preg_replace('([^A-Za-z0-9 ])', '', $RazonSocial);
            $folder = trim($NamEnterprise).'_'.trim($enterprise->company_id);
            $folder =str_replace(' ', '_', $folder);
            $target_path = '../public/expedientes/'.$folder.'/';
            if (!file_exists($target_path)) { mkdir($target_path, 0777, true);  }
            $doc_cedula = move_uploaded_file($attributes['representative_doc_attach']->getPathName(), $target_path. basename( 'Cedula Representante.pdf'));
            if ($doc_cedula) {
                $doc_rut = move_uploaded_file($attributes['rut_attachment']->getPathName(), $target_path. basename( 'Rut.pdf'));
                if ($doc_rut) {
                    $doc_comprobante = move_uploaded_file($attributes['payment_support']->getPathName(), $target_path. basename( 'Comprobante de Pago.pdf'));
                    if ($doc_comprobante) {
                        if($attributes['type_person']=='1'){
                            $nombre_doc = 'Camara de Comercio.pdf';
                        }else{
                            $nombre_doc = 'Carta Notariada.pdf';
                        }
                        $doc_camara_comercio = move_uploaded_file($attributes['chamber_commerce']->getPathName(), $target_path. basename( $nombre_doc));
                        if ($doc_camara_comercio) {
                            $doc_formato_viculacion = move_uploaded_file($attributes['link_format']->getPathName(), $target_path. basename( 'Formato Vinculacion.pdf'));
                            if ($doc_formato_viculacion) {
                                //////// Apoderado////
                                    $attorney_doc_attach = move_uploaded_file($attributes['attorney_doc_attach']->getPathName(), $target_path. basename( 'Cedula Apoderado.pdf'));
                                    if (!$attorney_doc_attach){
                                        $result['result'] = 0;
                                        $result['errors'] = 'No se registro Cedula Apoderado.';
                                    }

                                    $doc_rut_attorney = move_uploaded_file($attributes['rut_attorney']->getPathName(), $target_path. basename( 'Rut Apoderado.pdf'));
                                    if (!$doc_rut_attorney){
                                        $result['result'] = 0;
                                        $result['errors'] = 'No se registro Rut Apoderado.';
                                    }

                                    if($attributes['type_person']=='1' && $attributes['type_attorney']=='1'){
                                            $doc_camara_comercio_attorney = move_uploaded_file($attributes['chamber_commerce_attorney']->getPathName(), $target_path. basename( 'Camara de Comercio Apoderado.pdf'));
                                    if (!$doc_camara_comercio_attorney){
                                        $result['result'] = 0;
                                        $result['errors'] = 'No se registro Camara de Comercio Apoderado.';
                                    }
                                    }

                                    $doc_power_attorney = move_uploaded_file($attributes['power_attorney']->getPathName(), $target_path. basename( 'Poder Conferido.pdf'));
                                    if (!$doc_power_attorney){
                                        $result['result'] = 0;
                                        $result['errors'] = 'No se registro Poder Conferido.';
                                    }
                                $municipality = $enterprise->city;
                                $acronym = CatIdentificationType::getAcronym($representative->tipo_identificacion);
                                $pdf = PDF::loadView('pdf.pdf', ['enterprise' => $enterprise,'representative' => $representative,'acronym' => $acronym,'municipality' => $municipality]);
                                $certificado=$pdf->output();
                                $ruta = $target_path . basename( 'Documento de Confianza').'.pdf';
                                file_put_contents($ruta,$certificado);

                            }else{
                                $result['result'] = 0;
                                $result['errors'] = 'No se guardo Formato Vinculacion.';
                            }

                        }else{
                            $result['result'] = 0;
                            $result['errors'] = 'No se guardo '.$nombre_doc.'.';
                        }

                    }else{
                        $result['result'] = 0;
                        $result['errors'] = 'No se guardo Comprobante de Pago.';
                    }
                }else{
                    $result['result'] = 0;
                    $result['errors'] = 'No se guardo RUT.';
                }
            }else{
                $result['result'] = 0;
                $result['errors'] = 'No se guardo Cedula Representante.';
            }
        $UrlAzure=Config::get('params.services.url_azure');
            $UrlDoc=Config::get('params.services.url_doc');
        $expediente = new Expediente();
        $expediente->idcliente = $enterprise->id;
        $expediente->active = 1;
        $expediente->urlExpediente = $UrlDoc.$folder;
        $expediente->urlAzure = $UrlAzure.$folder;
        $expediente->issigned = 0;
        $expediente->tipoExpediente = 1;
        if($expediente->save()){
            $expe_document = new Documento();
            $expe_document->idexpediente =$expediente->id;
            $expe_document->tipodocumento = 1;
            $expe_document->name = 'Cedula Representante.pdf';
            $expe_document->urlazure = $expediente->urlAzure.'/'.$expe_document->name;
            $expe_document->Urldoc = $expediente->urlExpediente.'/'.$expe_document->name;
            $expe_document->estatus = 1;
            $expe_document->fechadoc = Now();
            if(!$expe_document->save()){
                $result['result'] = 0;
                $result['errors'] = 'No se registro Cedula Representante.';
            }
            $expe_document = new Documento();
            $expe_document->idexpediente =$expediente->id;
            $expe_document->tipodocumento = 2;
            $expe_document->name = 'Rut.pdf';
            $expe_document->urlazure = $expediente->urlAzure.'/'.$expe_document->name;
            $expe_document->Urldoc = $expediente->urlExpediente.'/'.$expe_document->name;
            $expe_document->estatus = 1;
            $expe_document->fechadoc = Now();
            if(!$expe_document->save()){
                $result['result'] = 0;
                $result['errors'] = 'No se registro Rut.';
            }
            $expe_document = new Documento();
            $expe_document->idexpediente =$expediente->id;
            $expe_document->tipodocumento = 3;
            $expe_document->name = $nombre_doc;
            $expe_document->urlazure = $expediente->urlAzure.'/'.$expe_document->name;
            $expe_document->Urldoc = $expediente->urlExpediente.'/'.$expe_document->name;
            $expe_document->estatus = 1;
            $expe_document->fechadoc = Now();
            if(!$expe_document->save()){
                $result['result'] = 0;
                $result['errors'] = 'No se registro '.$nombre_doc.'.';
            }
            $expe_document = new Documento();
            $expe_document->idexpediente =$expediente->id;
            $expe_document->tipodocumento = 4;
            $expe_document->name = 'Documento de Confianza.pdf';
            $expe_document->urlazure = $expediente->urlAzure.'/'.$expe_document->name;
            $expe_document->Urldoc = $expediente->urlExpediente.'/'.$expe_document->name;
            $expe_document->estatus = 1;
            $expe_document->fechadoc = Now();
            if(!$expe_document->save()){
                $result['result'] = 0;
                $result['errors'] = 'No se registro Documento de Confianza.';
            }
            $expe_document = new Documento();
            $expe_document->idexpediente =$expediente->id;
            $expe_document->tipodocumento = 5;
            $expe_document->name = 'Comprobante de Pago.pdf';
            $expe_document->urlazure = $expediente->urlAzure.'/'.$expe_document->name;
            $expe_document->Urldoc = $expediente->urlExpediente.'/'.$expe_document->name;
            $expe_document->estatus = 1;
            $expe_document->fechadoc = Now();
            if(!$expe_document->save()){
                $result['result'] = 0;
                $result['errors'] = 'No se registro Comprobante de Pago.';
            }
            $expe_document = new Documento();
            $expe_document->idexpediente =$expediente->id;
            $expe_document->tipodocumento = 6;
            $expe_document->name = 'Formato Vinculacion.pdf';
            $expe_document->urlazure = $expediente->urlAzure.'/'.$expe_document->name;
            $expe_document->Urldoc = $expediente->urlExpediente.'/'.$expe_document->name;
            $expe_document->estatus = 1;
            $expe_document->fechadoc = Now();
            if(!$expe_document->save()){
                $result['result'] = 0;
                $result['errors'] = 'No se registro Formato Vinculacion.';
            }
            $expe_document = new Documento();
            $expe_document->idexpediente =$expediente->id;
            $expe_document->tipodocumento = 7;
            $expe_document->name = 'Cedula Apoderado.pdf';
            $expe_document->urlazure = $expediente->urlAzure.'/'.$expe_document->name;
            $expe_document->Urldoc = $expediente->urlExpediente.'/'.$expe_document->name;
            $expe_document->estatus = 1;
            $expe_document->fechadoc = Now();
            if(!$expe_document->save()){
                $result['result'] = 0;
                $result['errors'] = 'No se registro Cedula Apoderado.';
            }
            $expe_document = new Documento();
            $expe_document->idexpediente =$expediente->id;
            $expe_document->tipodocumento = 8;
            $expe_document->name = 'Rut Apoderado.pdf';
            $expe_document->urlazure = $expediente->urlAzure.'/'.$expe_document->name;
            $expe_document->Urldoc = $expediente->urlExpediente.'/'.$expe_document->name;
            $expe_document->estatus = 1;
            $expe_document->fechadoc = Now();
            if(!$expe_document->save()){
                $result['result'] = 0;
                $result['errors'] = 'No se registro Rut Apoderado.';
            }
            if($attributes['type_person']=='1' && $attributes['type_attorney']=='1'){
                $expe_document = new Documento();
                $expe_document->idexpediente =$expediente->id;
                $expe_document->tipodocumento = 9;
                $expe_document->name = 'Camara de Comercio Apoderado.pdf';
                $expe_document->urlazure = $expediente->urlAzure.'/'.$expe_document->name;
                $expe_document->Urldoc = $expediente->urlExpediente.'/'.$expe_document->name;
                $expe_document->estatus = 1;
                $expe_document->fechadoc = Now();
                if(!$expe_document->save()){
                    $result['result'] = 0;
                    $result['errors'] = 'No se registro Camara de Comercio Apoderado.';
                }
            }
            $expe_document = new Documento();
            $expe_document->idexpediente =$expediente->id;
            $expe_document->tipodocumento = 14;
            $expe_document->name = 'Poder Conferido.pdf';
            $expe_document->urlazure = $expediente->urlAzure.'/'.$expe_document->name;
            $expe_document->Urldoc = $expediente->urlExpediente.'/'.$expe_document->name;
            $expe_document->estatus = 1;
            $expe_document->fechadoc = Now();
            if(!$expe_document->save()){
                $result['result'] = 0;
                $result['errors'] = 'No se registro Poder Conferido.';
            }
        }else{
            $result['result'] = 0;
            $result['errors'] = 'No se registro el Expediente.';
        }
            if($attributes['insoft']=='true'){

                $cant_folios = new FoliosContratados();
                $cant_folios->id_cliente = $enterprise->id;
                $cant_folios->cantidad = $attributes['cant_folios_e'];
                $cant_folios->vigencia_años = $attributes['time_format_linkage'];
                $cant_folios->tipo_folios = 1;
                $cant_folios->activo = 1;
                $cant_folios->cargados_fel =0;
                if(!$cant_folios->save()){
                    $result['result'] = 0;
                    $result['errors'] = 'No se registro cantidad de folios Emisiòn.';
                }
                $cant_folios = new FoliosContratados();
                $cant_folios->id_cliente = $enterprise->id;
                $cant_folios->cantidad = $attributes['cant_folios_r'];
                $cant_folios->vigencia_años = $attributes['time_format_linkage'];
                $cant_folios->tipo_folios = 2;
                $cant_folios->activo = 1;
                $cant_folios->cargados_fel =0;
                if(!$cant_folios->save()){
                    $result['result'] = 0;
                    $result['errors'] = 'No se registro cantidad de folios Recepciòn.';
                };
                $cant_folios = new FoliosContratados();
                $cant_folios->id_cliente = $enterprise->id;
                $cant_folios->cantidad = $attributes['cant_folios_n'];
                $cant_folios->vigencia_años = $attributes['time_format_linkage'];
                $cant_folios->tipo_folios = 3;
                $cant_folios->activo = 1;
                $cant_folios->cargados_fel =0;
                if(!$cant_folios->save()){
                    $result['result'] = 0;
                    $result['errors'] = 'No se registro cantidad de folios Nomina.';
                };
            }

        if($result['result']== 0){
                DB::rollBack();
                return back();
                $result['message'] = 'Por favor revise los siguentes errores: ';
        }else{

            $result['message'] = 'Se ha guardado con éxito';

                DB::commit();
                $result['result'] = 1;
                $result['id_enterprise'] = intval($enterprise->id);
                $result['nit'] = intval($enterprise->company_id);
        }

             return json_encode($result);


    }

    public static function  is_valid_email($str)
    {
      $matches = null;
      return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $str, $matches));
    }

    public static function eliminar_tildes($cadena){

        $cadena = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $cadena
        );

        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $cadena );

        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $cadena );

        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $cadena );

        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $cadena );

        $cadena = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $cadena
        );

        return $cadena;
    }

    public function firmarpdf(Request $request)
    {
        DB::beginTransaction();
        $attributes = $request->all();
        $CodeValid='';
        if(Config::get('params.general.ambiente')== 'production'){
            $ValidOpt = ServicesController::SingatureValidOptAutentic($attributes['optfirma']);
            $CodeValid=$ValidOpt->msj;
        }else{
            $jsonValidOtp = array();
            $jsonValidOtp["key"]= $attributes['userfirma'];
            $jsonValidOtp["email"]=$attributes['email'];
            $jsonValidOtp["period"]="3600";
            $jsonValidOtp["otp"]=$attributes['optfirma'];
            $ValidOpt = ServicesController::SingatureValidOpt($jsonValidOtp);
            if($ValidOpt->valid=='true'){
                $CodeValid='validated';
                }
            }
        if($CodeValid=='validated'){
        $data = explode('&',$attributes['encriptado']);
        $id = self::decrypt($data[0], Config::get('params.general.string_key'));
        $propuesta = Propuesta::find($id);
        if($propuesta->terminos_aceptados == ''){
            $propuesta->terminos_aceptados = json_encode($attributes['listTerminoFirma']);
            $propuesta->save();
        }
        $terminos = CatTerminos::getTerminosList();
        if($propuesta){
            if($propuesta->active == 1){
                $datos[] = $propuesta;
                $clientePcomercial = ClientePcomercial::getClienteP($propuesta->id_cliente_pcomercial);
                array_push($datos,$clientePcomercial);
                $ubicacion = CatMunicipality::getData($clientePcomercial->id_municipality);
                array_push($datos,$ubicacion);
                $representante = RelacionPcomercial::getDataPersona($id,1);
                $acronym = CatIdentificationType::getAcronym($representante->tipo_identificacion);
                array_push($datos,$representante);
                $apoderado= RelacionPcomercial::getDataPersona($id,8);
                array_push($datos,$apoderado);
                $detallePropuesta = VwDetallePropuesta::getDPropuesta($id);
                $transacciones = 0;
                $transaccionesR = 0;
                $servicioEm = false;
                $servicioRe = false;
                $condicionesVista = [];
                foreach ($detallePropuesta as $value) {
                    $detalle = CatPlanProducto::getData($value['id_plan_producto']);
                    $condicionVista = self::condicionesCompra($value['id_plan_producto'],true);
                    if (!is_null($condicionVista)) {
                        if (!is_null($condicionVista['condiciones'])) {
                            array_push($condicionesVista, $condicionVista);
                        }
                    }
                    switch ($detalle['id_type_servicio']) {
                        case 9:
                            $transacciones = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                            $servicioEm = true;
                            break;
                        case 10:
                            $transacciones = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                            $servicioEm = true;
                            break;
                        case 11:
                            $transaccionesR = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                            $servicioRe = true;
                            break;
                        case 12:
                            $transacciones = TransaccionDetallePropuesta::getDPropuesta($value['id']);
                            $servicioEm = true;
                            break;

                    }
                }
            }else{
                return view('propuesta.caducado');
            }
                if ($datos[1]->person_type == '1'){
                    $RazonSocial= $datos[1]->name_socialreason;
                }else{
                    $RazonSocial=$datos[1]->name_socialreason . ' ' . $datos[1]->comercial_name;
                }
                $RazonSocial= self::eliminar_tildes($RazonSocial);
                $NamEnterprise = preg_replace('([^A-Za-z0-9 ])', '', $RazonSocial);
                $folder = trim($NamEnterprise).'_'.trim($datos[1]->company_id);
                $folder =str_replace(' ', '_', $folder);
                $target_path = '../public/odc/'.$folder.'/';
                if (!file_exists($target_path)) { mkdir($target_path, 0777, true);  }

                $pdf = PDF::loadView('pdf.firmado', ['ambiente'=>Config::get('params.general.ambiente'),'datos' => $datos,'detallePropuesta' => $detallePropuesta, 'tipo'=>$data[1],'acronimoTipoDoc'=>$acronym, 'transacciones'=>$transacciones, 'transaccionesR'=>$transaccionesR, 'servicioEm'=>$servicioEm, 'servicioRe'=>$servicioRe, 'terminos'=>$terminos, 'condicionesVista'=>$condicionesVista ]);
                $certificado=$pdf->output();
                $ruta = $target_path . basename( 'Propuesta Comercial TFHKA '. $datos[1]->company_id.' '.date_format($datos[1]->created_at, 'd-m-Y')).'.pdf';
                file_put_contents($ruta,$certificado);
                $acronym = CatIdentificationType::getAcronym($datos[3]->tipo_identificacion);
                ////////////////////firmado///////////////////////////////////////
                    $result['signed'] = '';
                    $token = ServicesController::SingatureToken();
                    if(isset($token->access_token) && $token->access_token !=''){
                       $archivo = file_get_contents($ruta);
                        $tamano = strlen($archivo);
                        $arreglo = array();
                        for ($i = 0;$i < $tamano;$i++) {
                            $byte = ord($archivo[$i]);
                            $byte = $byte < 128 ? $byte : $byte - 256;
                            $arreglo[] = $byte;
                        }

                        $json = array();
                        $json['metadata'] = array();
                            if($datos[1]->person_type=='1'){
                                $json['metadata']['names'] = $datos[3]->nombre;
                                $json['metadata']['lastNames'] = $datos[3]->apellido;
                                $json['metadata']['docId'] = $datos[3]->identificacion;
                                $json['metadata']['documentType'] = $acronym;
                                $json['metadata']['secureKey'] = str_replace(" ","_", $RazonSocial." ".$acronym." ".$datos[3]->identificacion);
                            }else{
                                $json['metadata']['names'] = $datos[3]->nombre;
                                $json['metadata']['lastNames'] = $datos[3]->apellido;
                                $json['metadata']['docId'] = $datos[3]->identificacion;
                                $json['metadata']['documentType'] = $acronym;
                                $json['metadata']['secureKey'] = str_replace(" ","_", $RazonSocial." ".$acronym." ".$datos[3]->identificacion);
                            }

                        $json['files'] = array();
                        $arrArchivo = array();
                        $arrArchivo['fileContent'] = $arreglo;
                        $arrArchivo['fileName'] = 'Propuesta Comercial TFHKA ' . $datos[1]->company_id . ' ' . date_format($datos[1]->created_at, 'd-m-Y H-i-s') . '.pdf';
                        $json['files'][] = $arrArchivo;

                        $firmado = ServicesController::SingatureDigitalService($json,$token->access_token);
                        if(isset($firmado->operationCode) && $firmado->operationCode==1000){

                            $source = file_get_contents($firmado->urlDocuments);
                            $target_path6 = $target_path . basename( 'firma').'.zip';
                            file_put_contents($target_path6,$source);
                            $zip = new \ZipArchive;

                            $res = $zip->open($target_path6);
                            if ($res === TRUE) {
                                $zip->extractTo($target_path);
                                $zip->close();
                                $pdf = file_get_contents($target_path.basename( $arrArchivo['fileName']));
                                $fileName = 'Propuesta Comercial TFHKA ' . $datos[1]->company_id . ' ' . date_format($datos[1]->created_at, 'd-m-Y H-i-s') . '.pdf';
                                $data_mail = array();
                                $data_mail['urlPortal'] = $attributes['exist_client']=='true' ? Config::get('params.services.url_recompra'):Config::get('params.services.url_vinculacion');
                                $data_mail['email'] = $attributes['email'];
                                $data_mail['cliente'] = $RazonSocial;
                                $data_mail['nit'] = $datos[1]->company_id;
                                $data_mail['aliadoEmail'] = $datos[0]->aliado->correo_contactos;
                                $productos = DetallePropuesta::getDPropuesta($id);
                                $cantRetenciones = 0;
                                foreach($productos as $producto){
                                    if(!is_null($producto['retencion'])){
                                        $retencion = json_decode($producto['retencion'], true);

                                    foreach ($retencion as $key => $item) {
                                        if($item[1] > 0){
                                            $cantRetenciones++;
                                        }
                                    }
                                    }

                                };
                                if($cantRetenciones > 0){
                                    $pdfR = PDF::loadView('pdf.certificado_retencion',['ambiente'=>Config::get('params.general.ambiente'),'propuesta'=>$propuesta,'productos'=>$productos]);
                                    $pdfRetencion=$pdfR->output();
                                    $ruta = $target_path . basename( 'Certificado de Retencion '. $datos[1]->company_id.' '.date_format($datos[1]->created_at, 'd-m-Y H-i-s')).'.pdf';
                                    file_put_contents($ruta,$pdfRetencion);
                                    $archivo = file_get_contents($ruta);
                                    $tamano = strlen($archivo);
                                    $arreglo = array();
                                    for ($i = 0;$i < $tamano;$i++) {
                                        $byte = ord($archivo[$i]);
                                        $byte = $byte < 128 ? $byte : $byte - 256;
                                        $arreglo[] = $byte;
                                    }
                                    $arrArchivo['fileContent'] = $arreglo;
                                    $arrArchivo['fileName'] = 'Certificado de Retencion ' . $datos[1]->company_id . ' ' . date_format($datos[1]->created_at, 'd-m-Y H-i-s') . '.pdf';
                                    $json['files'][] = $arrArchivo;
                                    $firmadoRetencion = ServicesController::SingatureDigitalService($json,$token->access_token);
                                    if(isset($firmadoRetencion->operationCode) && $firmadoRetencion->operationCode==1000){
                                        $source = file_get_contents($firmadoRetencion->urlDocuments);
                                        $target_path6 = $target_path . basename( 'firmaRetencion').'.zip';
                                        file_put_contents($target_path6,$source);
                                        $zip = new \ZipArchive;

                                        $res = $zip->open($target_path6);
                                        if ($res === TRUE) {
                                            $zip->extractTo($target_path);
                                            $zip->close();
                                        }
                                    }
                                    $fileNameCR = 'Certificado de Retencion '. $datos[1]->company_id.' '.date_format($datos[1]->created_at, 'd-m-Y H-i-s'). '.pdf';
                                    $certificadoRetencion = file_get_contents($target_path.basename( $fileNameCR));
                                }else{
                                    $certificadoRetencion ='';
                                    $fileNameCR ='';
                                }
                                if($attributes['exist_client']=='true'){
                                    if($attributes['type_person']==1){
                                        if(isset($attributes['time_format_linkage'])){
                                            $correofirma = 'recompra_con_cd_juridica';
                                        }else{
                                            $correofirma = 'recompra_sin_cd';
                                        }
                                    }else{
                                        if(isset($attributes['time_format_linkage'])){
                                            $correofirma = 'recompra_con_cd_natural';
                                        }else{
                                            $correofirma = 'recompra_sin_cd';
                                        }
                                    }
                                }else{
                                    if($attributes['type_person']==1){
                                        $correofirma = 'nuevo_usuario_juridica';
                                    }else{
                                        $correofirma = 'nuevo_usuario_natural';
                                    }
                                }
                                Mail::send('mails.'.$correofirma, ['data_mail' => $data_mail], function ($message) use ($data_mail,$pdf,$fileName,$cantRetenciones,$certificadoRetencion,$fileNameCR) {
                                    $message->to($data_mail['email'])->subject("NIT ".$data_mail['nit']." - ".$data_mail['cliente']." Orden de compra firmada");
                                    $message->attachData($pdf,$fileName);
                                    if($cantRetenciones > 0){
                                        $message->attachData($certificadoRetencion,$fileNameCR);
                                    }
                                    $message->bcc(Config::get('params.emails.ventas_co'));
                                    if(Config::get('params.general.ambiente') == 'production'){
                                        $aliadoEmail= self::is_valid_email($data_mail['aliadoEmail']);
                                        if($aliadoEmail){
                                            $message->cc($data_mail['aliadoEmail']);
                                        }
                                        $message->bcc('mcardenas@thefactoryhka.com');
                                    }else{
                                        $message->cc(Config::get('params.emails.aliado_test'));
                                    }

                                });
                                $result['result'] = 1;
                                $result['email'] = $attributes['email'];
                                $result['mensaje'] = '';
                                $propuesta->cant_firmas += 1;
                                $propuesta->active = 0;
                                $propuesta->save();
                                DB::commit();
                                return $result;

                                }else{
                                    $ruta = $target_path . basename( 'firmado').'.pdf';
                                    $result['signed'] = 'false';
                                    DB::rollBack();
                                }
                            }else{
                                $result['result'] = 0;
                                $result['errors'] = 'El Documento firmado no se guardo.';
                                DB::rollBack();
                            }

                        }else{
                            $result['ws_firmado'] = $firmado;
                            $result['signed'] = 'false';
                            DB::rollBack();
                        }

                    }else{
                        $result['ws_token'] = $token;
                        $result['signed'] = 'false';
                        DB::rollBack();
                    }
        }else{
            $result['ValidOpt'] = $ValidOpt->valid;
                    $result['result'] = 0;
                    $result['errors'] = 'Código de autenticación no valido.';
                    DB::rollBack();
                    return $result;
        }
                //////////////////////////end firmado///////////////////////////////////////////////
   }

}
