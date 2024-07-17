<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatOriginMedium extends Model
{
    use HasFactory;

    protected $visible = [
        'id',
        'descripcion',
        'active',
    ];

    public static function getOriginMedium($id = null){

         return self::where('id',$id)->first()->descripcion;
    }

    public static function getMethodList(){
        return self::where('active',1)->orderBy("descripcion","DESC")->pluck('descripcion','id');
    }
}
