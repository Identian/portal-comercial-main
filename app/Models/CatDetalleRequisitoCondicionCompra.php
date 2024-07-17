<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CatDetalleRequisitoCondicionCompra extends Model
{


    protected $visible = [
        'id',
        'descripcion',
        'id_cat_requisito_condicion_compra'
    ];

    public static function getListDetalleRequisitoCondicionCompra(){

        return self::whereNotNull('id')->pluck('descripcion','id');
    }
}

