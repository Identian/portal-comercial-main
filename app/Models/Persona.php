<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'identificacion',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'posicion_org',
        'active',
        'tipo_identificacion',
        'tipo_persona',
        'nit',
        'razon_social',
        'digito_verificacion',
        'nombre_comercial'
    ];

    protected $visible = [
        'id',
        'identificacion',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'posicion_org',
        'active',
        'tipo_identificacion',
        'tipo_persona',
        'nit',
        'razon_social',
        'digito_verificacion',
        'nombre_comercial'
    ];

    public static function getData($id){
        $data =  self::find($id);
        return $data;
    }


}

