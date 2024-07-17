<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CatPlanProducto;

class DetallePropuesta extends Model
{

    public $timestamps = false;

    protected $visible = [
        'id',
        'id_propuesta',
        'id_plan_producto',
        'precio',
        'cantidad',
        'detalles',
        'active'
    ];
    protected $fillable = [
        'id',
        'id_propuesta',
        'id_plan_producto',
        'precio',
        'cantidad',
        'active'
    ];

    public static function getDPropuesta($idPropuesta){
        /*$array =self::where('id_propuesta',$idPropuesta)->get();
        foreach ($array as $value) {
            $value['detalles'] = CatPlanProducto::getData($value['id_plan_producto']);
        }*/
        return self::where('id_propuesta',$idPropuesta)->get();
   }

}

