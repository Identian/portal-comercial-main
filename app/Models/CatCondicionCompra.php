<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CatCondicionCompra extends Model
{


    protected $visible = [
        'id',
        'nombre',
        'descripcion'
    ];

    public function catPlanCondicionCompra()
    {
        return $this->hasMany(CatPlanCondicionCompra::class, 'id_cat_condicion_compra');
    }

    public function catRequisitoCondicionCompra()
    {
        return $this->hasMany(CatRequisitoCondicionCompra::class, 'id_cat_condicion_compra');
    }

}

