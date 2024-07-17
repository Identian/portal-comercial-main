<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CatTerminos extends Model
{


    protected $visible = [
        'id',
        'nombre',
        'descripcion',
        'active'
    ];

    public static function getTerminosList(){
        return self::where('active',1)->pluck('nombre','id');
    }

}

