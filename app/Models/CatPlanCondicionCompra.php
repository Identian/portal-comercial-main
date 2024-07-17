<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CatPlanCondicionCompra extends Model
{


    protected $visible = [
        'id',
        'nombre',
        'descripcion',
        'id_cat_condicion_compra'
    ];

    public static function getListPlanCondicionCompra(){

        return self::whereNotNull('id')->pluck('descripcion','id');
    }

    public function catDetallePlanCondicionCompra()
    {
        return $this->hasMany(CatDetallePlanCondicionCompra::class, 'id_cat_plan_condicion_compra');
    }
}

