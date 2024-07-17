<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaPcomercial extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_identificacion',
        'identificacion',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'tipo_persona',
        'nit',
        'razon_social',
        'digito_verificacion',
        'nombre_comercial',
        'active'
    ];

    protected $visible = [
        'id',
        'tipo_identificacion',
        'identificacion',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'tipo_persona',
        'nit',
        'razon_social',
        'digito_verificacion',
        'nombre_comercial',
        'active'
    ];

    public static function getData($id){
        $data =  self::find($id);
        return $data;
    }


}

