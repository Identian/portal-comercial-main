<?php

namespace App\Models;

use App\Models\CatRetenciones;
use App\Models\CatTypeServicio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatPlanProducto extends Model
{

    use SoftDeletes;


    protected $visible = [
        'id',
        'nombre',
        'descripcion',
        'max_transacion',
        'precio',
        'id_type_servicio',
        'id_type_retencion_producto',
        'retencion',
        'id_user',
        'id_cat_condicion_compra',
        'vigencia',
        'id_cat_plan_producto',
        'portal',
        'cat_especial'
    ];
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'max_transacion',
        'precio',
        'id_type_servicio',
        'id_type_retencion_producto',
        'id_user',
        'id_cat_condicion_compra',
        'vigencia',
        'id_cat_plan_producto'
    ];

    public function tipoServicio(){
        return $this->belongsTo(CatTypeServicio::class,'id_type_servicio');
    }

    public function tipoRetencion(){
        return $this->belongsTo(CatTypeServicio::class,'id_type_servicio');
    }

    public static function getData($id){
        return self::find($id);
    }

    public static function getLisTypeRG(){

        return self::whereNotNull('id')->where('id_type_servicio', '=', 2)->where(function ($query) {
            $query->whereNull('id_cat_plan_producto')->orWhere('id_cat_plan_producto', '');
        })->pluck('nombre', 'id');
    }
    public static function getLisTModificacionRG(){
        $idMod = self::where([['nombre','=','Modificaciones de Representaciones Gráficas'],['id_type_servicio', '=',2]])->first()->id;
        return self::whereNotNull('id')->where('id_cat_plan_producto',$idMod)->pluck('nombre','id');
    }

    public static function getRetenciones($idProducto, $cantidad, $catTypeTaxpayer){
        $producto = self::where('id', $idProducto)->first();
        $precio =$producto['precio'];
        $producto['precio']= floatval($producto['precio']/1.19);
        $iva = $precio - $producto['precio'];

        if ($producto['id_type_retencion_producto']>0) {
            $catRetencion = CatRetenciones::getCatRetencion($producto['id_type_retencion_producto'], $catTypeTaxpayer);
            $catRetencion['porcentaje_reteICA'] = [floatval($catRetencion['porcentaje_reteICA']*100),(floatval($producto['precio']*$catRetencion['porcentaje_reteICA'])*$cantidad)];
            $catRetencion['porcentaje_reteIVA'] = [floatval($catRetencion['porcentaje_reteIVA']*100),(floatval($iva*$catRetencion['porcentaje_reteIVA'])*$cantidad)];
            $catRetencion['porcentaje_retefuente'] = [floatval($catRetencion['porcentaje_retefuente']*100),(floatval($producto['precio']*$catRetencion['porcentaje_retefuente'])*$cantidad)];
        } else {
            $catRetencion['porcentaje_reteICA'] = [0,floatval(0)];
            $catRetencion['porcentaje_reteIVA'] = [0,floatval(0)];
            $catRetencion['porcentaje_retefuente'] = [0,floatval(0)];
        }
        $catRetencion['porcentaje_iva'] = [19,floatval($iva)*$cantidad];
        return $catRetencion;
    }

    public static function calcularRetencion($producto, $catTypeTaxpayer){
        $precio =$producto['precio'];
        $producto['precio']= floatval($producto['precio']/1.19);
        $iva = $precio - $producto['precio'];

        if ($producto['id_type_retencion_producto']>0) {
            $catRetencion = CatRetenciones::getCatRetencion($producto['id_type_retencion_producto'], $catTypeTaxpayer);
            $catRetencion['porcentaje_reteICA'] = floatval($producto['precio']*$catRetencion['porcentaje_reteICA']);
            $catRetencion['porcentaje_reteIVA'] = floatval($iva*$catRetencion['porcentaje_reteIVA']);
            $catRetencion['porcentaje_retefuente'] = floatval($producto['precio']*$catRetencion['porcentaje_retefuente']);
        } else {
            $catRetencion['porcentaje_reteICA'] = floatval(0);
            $catRetencion['porcentaje_reteIVA'] = floatval(0);
            $catRetencion['porcentaje_retefuente'] = floatval(0);
        }
        $catRetencion['porcentaje_iva'] = floatval($iva);
        return $catRetencion;
    }

    public static function getLisTypeReporte(){

        return self::whereNotNull('id')->where('tipo',3)->pluck('nombre','id');
    }

    public static function getPlanEmision($typeServicio, $cant = null, $catTypeTaxpayer){
        if($typeServicio != 12 ){
            $typeServicio = $typeServicio =='1'? 9 : 10;
        }
        $planEmision = self::where([['id_type_servicio','=',$typeServicio],['max_transacion', '>=',$cant]])->first();
        if (!$planEmision) {
            $planEmision['cat_especial']=true;
            if($typeServicio == 12){
                $planEmision = self::where([['id_type_servicio','=',$typeServicio],['max_transacion', '=',0]])->first();
                //$precio=$cant*51.011;
                $precio = $planEmision['precio']*$cant;
                $planEmision['precio']= $precio;

            }else if($typeServicio == 9){
                $planEmision = self::where([['id_type_servicio','=',$typeServicio],['max_transacion', '=',0]])->first();
                $precio = $planEmision['precio']*$cant;
                $certificado = self::where([['id_type_servicio','=',13],['max_transacion', '=',1]])->first();
                $planEmision['precio']= $precio+$certificado['precio'];
            }else{
                $planEmision = self::where([['id_type_servicio','=',$typeServicio],['max_transacion', '=',0]])->first();
                $precio = $planEmision['precio']*$cant;
                $certificado = self::where([['id_type_servicio','=',13],['max_transacion', '=',2]])->first();
                $planEmision['precio']= $precio+$certificado['precio'];
            }
        }
        $catRetencion = self::calcularRetencion($planEmision, $catTypeTaxpayer);
        $planEmision['retencion']=$catRetencion;
        return $planEmision;
    }

    public static function getPlanRecepcionSC($cant = null, $catTypeTaxpayer, $portalR){
        $planRecepcionSC = self::where([['id_type_servicio','=',11],['max_transacion', '>=',$cant]])->first();
        if($portalR=="no"){
            $planRecepcionSC['portal']=self::where('id_type_servicio', 14)->first();
            $catRetencionPortal = self::calcularRetencion($planRecepcionSC['portal'], $catTypeTaxpayer);
            $planRecepcionSC['portal']['retencion']=$catRetencionPortal;
        }else{
            $planRecepcionSC['portal']='';
        }
        $catRetencion = self::calcularRetencion($planRecepcionSC, $catTypeTaxpayer);
        $planRecepcionSC['retencion']=$catRetencion;
        return $planRecepcionSC;
    }

    public static function getPlanCertificado($cant = null, $catTypeTaxpayer){

        $planCertificado = self::where([['id_type_servicio','=',13],['max_transacion', '>=',$cant]])->first();
        $catRetencion = self::calcularRetencion($planCertificado, $catTypeTaxpayer);
        $planCertificado['retencion']=$catRetencion;
        return $planCertificado;
    }
    public static function getPlanHoras($cant = null, $catTypeTaxpayer){
        $planHoras = self::where('id', 1)->first();
        $planHoras['precio'] = $planHoras['precio']*$cant;
        $catRetencion = self::calcularRetencion($planHoras, $catTypeTaxpayer);
        $planHoras['retencion']=$catRetencion;
        return $planHoras;
    }

    public static function getPlanRG($id = null, $cant = null, $catTypeTaxpayer){

        $planRG = self::where('id', $id)->first();
        $planRG['precio'] = $planRG['precio']*$cant;
        $catRetencion = self::calcularRetencion($planRG, $catTypeTaxpayer);
        $planRG['retencion']=$catRetencion;
        return $planRG;
    }

    public static function getPlanReporte($id = null , $catTypeTaxpayer){
        $planReporte = self::where('id', $id)->first();
        $catRetencion = self::calcularRetencion($planReporte, $catTypeTaxpayer);
        $planReporte['retencion']=$catRetencion;
        return $planReporte;

    }

    public static function getPlanReporteArchCant($cant = null, $catTypeTaxpayer){
        $planReporteArchCant = self::where('id', 28)->first();
        $planReporteArchCant['precio'] = $planReporteArchCant['precio']*$cant;
        $catRetencion = self::calcularRetencion($planReporteArchCant, $catTypeTaxpayer);
        $planReporteArchCant['retencion']=$catRetencion;
        return $planReporteArchCant;
    }

    public static function getPlanReporteCant($cant = null, $tipo = null, $catTypeTaxpayer){
        $planReporteCant = self::where([['id_type_servicio','=',$tipo],['max_transacion', '>=',$cant]])->first();
        $catRetencion = self::calcularRetencion($planReporteCant, $catTypeTaxpayer);
        $planReporteCant['retencion']=$catRetencion;
        return $planReporteCant;
    }

    public static function getPrecio($id = null){
        $precio = self::where('id',$id)->first()->precio;
        $precio= floatval($precio /1.19);
        return $precio;
    }

    public static function getTipoServicio($id = null){
        return self::where('id', $id)->first()->id_type_servicio;

    }

}

