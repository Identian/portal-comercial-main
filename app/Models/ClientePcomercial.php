<?php

namespace App\Models;

use App\Models\CatTypeTaxpayer;
use Illuminate\Database\Eloquent\Model;


class ClientePcomercial extends Model
{


    protected $visible = [
        'id',
        'company_id',
        'verification_digit',
        'name_socialreason',
        'comercial_name',
        'person_type',
        'id_municipality',
        'address',
        'email_billing_contact',
        'email_invoices',
        'email_optional',
        'id_tipo_contribuyente',
        'tipo_contribuyente',
        'phone'
    ];
    protected $fillable = [
        'id',
        'company_id',
        'verification_digit',
        'name_socialreason',
        'comercial_name',
        'person_type',
        'id_municipality',
        'address',
        'email_billing_contact',
        'email_invoices',
        'email_optional',
        'id_tipo_contribuyente',
        'phone'
    ];

    public function tipoContribuyente(){
        return $this->belongsTo(CatTypeTaxpayer::class,'id_tipo_contribuyente');
    }

    public function municipio(){
        return $this->belongsTo(CatMunicipality::class,'id_municipality');
    }


    public static function getClienteP($id = null){
        $data=  self::where('id',$id)->first();
        $data['tipo_contribuyente'] = CatTypeTaxpayer::getDescripcion($data['id_tipo_contribuyente']);
        return $data;
   }

    public static function getClienteUpdate($id = null){
        $data=  self::where('id',$id)->first();
        return $data;
   }

    public static function getData($type,$dni,$dv){
        return self::where([['person_type','=',$type],['company_id','=',$dni],['verification_digit','=',$dv]])->get();
   }



}

