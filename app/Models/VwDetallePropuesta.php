<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VwDetallePropuesta extends Model
{


    protected $visible = [
        'id',
        'id_propuesta',
        'id_plan_producto',
        'id_cat_servicio',
        'nombre_producto',
        'descripcion_producto',
        'nombre_servicio',
        'precio',
        'cantidad',
        'detalles',
        'active'
    ];

    public static function getDPropuesta($idPropuesta){
        return self::where('id_propuesta',$idPropuesta)->get();
   }

}

