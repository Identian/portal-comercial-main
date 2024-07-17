<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CatProducto extends Model
{


    protected $visible = [
        'id',
        'descripcion',
    ];
    protected $fillable = [
        'id',
        'descripcion',
    ];

    public static function getLisProducto(){

        return self::whereNotNull('id')->pluck('descripcion','id');
    }



}

