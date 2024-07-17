<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concesion extends Model
{
    use HasFactory;

    protected $visible = [
        'id',
        'id_cat_concesion',
        'tipo_registro',
        'id_registro'
        ];

    public static function getConcesion($type,$registro,$idregistro,$idEnterprise = null){
        return self::where([['id_cat_concesion','=',$type],['tipo_registro','=', $registro],['id_registro','=', $idregistro]])->orwhere([['id_cat_concesion','=',$type],['tipo_registro','=', 'cliente'],['id_registro','=', $idEnterprise]])->first();
    }

}
