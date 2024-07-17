<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatTypeTaxpayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'descripcion',
    ];

    public static function getTipeTaxpayerList(){

    return self::whereNotNull('id')->pluck('descripcion','id');
    }

    public static function getDescripcion($id = null){

        return self::where('id',$id)->first()->descripcion;
   }

}
