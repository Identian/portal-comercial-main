<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TransaccionDetallePropuesta extends Model
{

    public $timestamps = false;

    protected $visible = [
        'id',
        'id_detalle_propuesta',
        'id_cat_transaccion',
        'cantidad',
        'active',
        'id_cat_application_type'
    ];
    protected $fillable = [
        'id',
        'id_detalle_propuesta',
        'id_cat_transaccion',
        'cantidad',
        'active',
        'id_cat_application_type'
    ];

    public static function getCantidad($idDetallePropuesta = null){
        return self::where('id_detalle_propuesta',$idDetallePropuesta)->first();
    }

    public static function getDPropuesta($idDetallePropuesta = null){
        return self::where('id_detalle_propuesta',$idDetallePropuesta)->get();
    }

}

