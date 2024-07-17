<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CatProduct extends Model
{


    protected $visible = [
        'id',
        'descripcion',
    ];
    protected $fillable = [
        'id',
        'descripcion',
    ];

    public static function getLisProduct(){

        return self::whereNotNull('id')->whereNotIn('id', ['1','2','5','6','7'])->pluck('descripcion','id');
    }



}

