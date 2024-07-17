<?php

namespace App\Models;

use App\Models\Agencia;
use Illuminate\Database\Eloquent\Model;

class TopAgenciaPropuestasPorMes extends Model
{


    protected $visible = [
        'mes',
        'anio',
        'id_agency',
        'total_propuestas',
        'total_con_firmas'
    ];

    public function aliado(){
        return $this->belongsTo(Agencia::class,'id_agency');
    }
}

