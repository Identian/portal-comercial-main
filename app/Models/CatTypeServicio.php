<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CatTypeServicio extends Model
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

    public static function getLisTypeSC(){

        return self::whereNotNull('id')->whereNotIn('id', ['5','9','10','11','12','13','14'])->pluck('name','id');
    }

}

