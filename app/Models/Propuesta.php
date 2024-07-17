<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Agencia;
use App\Models\ClientePcomercial;

class Propuesta extends Model
{


    protected $visible = [
        'id',
        'id_cliente_pcomercial',
        'id_agency',
        'iva',
        'retencion_ica',
        'retencion_iva',
        'retencion_fuente',
        'subtotal',
        'descuento',
        'total',
        'active',
        'agency',
        'terminos_aceptados',
        'cant_descargas',
        'cant_firmas',
        'tipo',
        'slug'
    ];
    protected $fillable = [
        'id',
        'id_cliente_pcomercial',
        'id_agency',
        'iva',
        'retencion_ica',
        'retencion_iva',
        'retencion_fuente',
        'subtotal',
        'descuento',
        'total',
        'active',
        'terminos_aceptados',
        'cant_descargas',
        'cant_firmas',
        'tipo',
        'slug'
    ];

    public function clienteComercial(){
        return $this->belongsTo(ClientePcomercial::class,'id_cliente_pcomercial');
    }

    public function relacion(){
        return $this->belongsTo(RelacionPcomercial::class,'id','id_propuesta');
    }

    public function aliado(){
        return $this->belongsTo(Agencia::class,'id_agency');
    }

    public static function getPropuesta($id = null){
        $data = self::where('id',$id)->first();
        $data['agency'] = Agencia::getData($data['id_agency']);
        return $data;
   }
   public static function getPropuestaActiva($type,$dni,$dv){
    $clienteP = ClientePcomercial::getData($type,$dni,$dv);
    $resul['propuestas']= [];
    $resul['activas']= 0;
    if($clienteP){
        foreach ($clienteP as $value) {
            $propuestas = self::where([['id_cliente_pcomercial','=',$value['id']],['active','=',1]])->orderBy('id', 'DESC')->get();
            foreach ($propuestas as $propuesta) {
                array_push($resul['propuestas'], $propuesta);
                $resul['activas']++;
            }

        }
    }
    return $resul;
}

}

