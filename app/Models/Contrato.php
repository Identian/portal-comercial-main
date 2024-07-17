<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;


    protected $visible = [
        'idcliente',
        'codigo_contrato',
        'active',
        'solicitud_recibida',
        'contrato_formalizado',
        'contrato_facturado',
        'renovacion_automatica',
        'ruta_contrato'
    ];
}
