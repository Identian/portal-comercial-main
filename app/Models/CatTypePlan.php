<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CatTypePlan extends Model
{


    protected $visible = [
        'id',
        'name',
        'descripcion',
    ];
    protected $fillable = [
        'id',
        'name',
        'descripcion',
    ];

    public static function getLisTypePlan(){

        return self::whereNotNull('id')->get();
    }



}

