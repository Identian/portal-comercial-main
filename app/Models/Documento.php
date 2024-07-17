<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'idexpediente',
        'comentario',
        'estatus',
        'fechadoc',
        'urldoc',
        'name',
        'vistaprevia',
        'tipodocumento',
        'porc_confiabilidad',
        'urlazure'
    ];

    protected $visible = [
        'id',
        'idexpediente',
        'comentario',
        'estatus',
        'fechadoc',
        'urldoc',
        'name',
        'vistaprevia',
        'tipodocumento',
        'porc_confiabilidad',
        'urlazure'
    ];
}


