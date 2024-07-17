<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CatRetenciones;

class CatPlanSC extends Model
{


    protected $visible = [
        'id',
        'nombre',
        'descripcion',
        'tipo',
        'precio',
        'cantidad',
        'id_type_producto',
        'retencion'
    ];
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'tipo',
        'precio',
        'cantidad',
        'id_type_producto'
    ];


    public static function getLisSC(){

        return self::whereNotNull('id')->pluck('descripcion','id');
    }

    public static function getLisTypeReporte(){

        return self::whereNotNull('id')->where('tipo',3)->pluck('nombre','id');
    }

    public static function getPlanSC($Cant = null){

        return self::where('cantidad', '>=',$Cant)->first();
   }

   public static function getPlanHoras($Cant = null, $cat_type_taxpayer){

        //return self::where('max_transacion', '>=',$Cant)->first();
        return self::where('id', 1)->first();
    }

    public static function getPlanRG($Cant = null, $cat_type_taxpayer){

        $PlanRG = self::where('id', 2)->first();
        $cat_retencion = CatRetenciones::getCatRetencion($PlanRG['id_type_producto'], $cat_type_taxpayer);
        $cat_retencion['porcentaje_reteICA'] = intval($PlanRG['precio'])*$cat_retencion['porcentaje_reteICA'];
        $cat_retencion['porcentaje_reteIVA'] = intval($PlanRG['precio'])*$cat_retencion['porcentaje_reteIVA'];
        $cat_retencion['porcentaje_retefuente'] = intval($PlanRG['precio'])*$cat_retencion['porcentaje_retefuente'];
        $PlanRG['retencion']=$cat_retencion;
        return $PlanRG;
        //return self::where('id', 2)->first();
    }

    public static function getPlanReporte($id = null , $cat_type_taxpayer){
        $PlanReporte = self::where('id', $id)->first();
        $cat_retencion = CatRetenciones::getCatRetencion($PlanReporte['id_type_producto'], $cat_type_taxpayer);
        $cat_retencion['porcentaje_reteICA'] = intval($PlanReporte['precio'])*$cat_retencion['porcentaje_reteICA'];
        $cat_retencion['porcentaje_reteIVA'] = intval($PlanReporte['precio'])*$cat_retencion['porcentaje_reteIVA'];
        $cat_retencion['porcentaje_retefuente'] = intval($PlanReporte['precio'])*$cat_retencion['porcentaje_retefuente'];
        $PlanReporte['retencion']=$cat_retencion;
        return $PlanReporte;

        //return self::where('id', $id)->first();
    }

    public static function getPlanReporteCant($Cant = null, $tipo = null, $cat_type_taxpayer){
        $PlanReporteCant = self::where([['tipo','=',$tipo],['cantidad', '>=',$Cant]])->first();
        $cat_retencion = CatRetenciones::getCatRetencion($PlanReporteCant['id_type_producto'], $cat_type_taxpayer);
        $cat_retencion['porcentaje_reteICA'] = intval($PlanReporteCant['precio'])*$cat_retencion['porcentaje_reteICA'];
        $cat_retencion['porcentaje_reteIVA'] = intval($PlanReporteCant['precio'])*$cat_retencion['porcentaje_reteIVA'];
        $cat_retencion['porcentaje_retefuente'] = intval($PlanReporteCant['precio'])*$cat_retencion['porcentaje_retefuente'];
        $PlanReporteCant['retencion']=$cat_retencion;
        return $PlanReporteCant;
        //return self::where([['tipo','=',$tipo],['cantidad', '>=',$Cant]])->first();
    }

}

