<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CatDetallePlanCondicionCompra extends Model
{


    protected $visible = [
        'id',
        'descripcion',
        'id_cat_plan_condicion_compra'
    ];

    public static function getListDetallePlanCondicionCompra(){

        return self::whereNotNull('id')->pluck('descripcion','id');
    }
}

