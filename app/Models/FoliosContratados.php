<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoliosContratados extends Model
{
    use HasFactory;
    const UPDATED_AT = null;

    protected $fillable = [
        'id_cliente',
        'cantidad',
        'vigencia_años',
        'tipo_folios',
        'activo',
        'cargados_fel'
    ];

    protected $visible = [
        'id',
        'idcliente',
        'cantidad',
        'vigencia_años',
        'tipo_folios',
        'activo',
        'cargados_fel'
    ];
}


