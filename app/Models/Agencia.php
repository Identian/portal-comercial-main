<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CatOriginMedium;

class Agencia extends Model
{
    use HasFactory;

    protected $visible = [
        'id',
        'cedula',
        'nombre',
        'posibles_nombres',
        'codigo_oficina_virtual',
        'code_city',
        'city',
        'country',
        'code_country',
        'porc_venta',
        'porc_recaudo',
        'tipo_aliado',
        'descripcion_tipo_aliado',
        'nro_contrato',
        'nombre_erp_casa_software',
        'telefonos',
        'correo_contactos',
        'segmento_mercado',
        'tipo_integracion',
        'lenguaje_programacion',
        'observaciones',
        'status_integracion',
        'padre',
        'contacto_principal',
        'activo'
    ];

    public function tipoAliado(){
        return $this->belongsTo(CatOriginMedium::class,'tipo_aliado');
    }

    public static function getId($code = null){
         return self::where('codigo_oficina_virtual',$code)->first()->id;
    }
    public static function getData($id){
        $data =  self::find($id);
        $data['descripcion_tipo_aliado'] = CatOriginMedium::getOriginMedium($data['tipo_aliado']);
        return $data;
    }
    public static function getTipoAliado($code = null){

        return self::where('codigo_oficina_virtual',$code)->first()->tipo_aliado;
   }
    public static function getOriginVendor($code = null){

        return self::where('codigo_oficina_virtual',$code)->first()->nombre;
   }
}
