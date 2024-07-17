<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CatRequisitoCondicionCompra extends Model
{


    protected $visible = [
        'id',
        'nombre',
        'descripcion',
        'id_cat_condicion_compra'
    ];

    public static function getListRequisitoCondicionCompra(){

        return self::whereNotNull('id')->pluck('descripcion','id');
    }

    public function catDetalleRequisitoCondicionCompra()
    {
        return $this->hasMany(CatDetalleRequisitoCondicionCompra::class, 'id_cat_requisito_condicion_compra');
    }
}

