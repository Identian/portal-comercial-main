<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CatRetenciones extends Model
{


    protected $visible = [
        'id',
        'porcentaje_retefuente',
        'porcentaje_reteIVA',
        'porcentaje_reteICA',
        'id_tipo_prod',
        'id_tipo_contribuyente',
        'porcentaje_iva'
    ];
    protected $fillable = [
        'id',
        'porcentaje_retefuente',
        'porcentaje_reteIVA',
        'porcentaje_reteICA',
        'id_tipo_prod',
        'id_tipo_contribuyente'
    ];

    public static function getCatRetencion($tipo_prod = null, $tipo_contribuyente){


        $cat_retencion = self::where('id_tipo_prod', $tipo_prod)->where('id_tipo_contribuyente', $tipo_contribuyente)->first();

        return $cat_retencion;
   }

}

