<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contrato;

class Cliente extends Model
{
    use HasFactory;

    protected $visible = [
        'id',
        'name_socialreason',
        'company_id',
        'verification_digit',
        'code_department',
        'code_city',
        'address',
        'comercial_name',
        'code_agency',
        'email_billing_contact',
        'email_invoices',
        'email_optional',
        'client_type',
        'origin_medium',
        'origin_vendor',
        'person_type',
        'general_status',
        'active',
        'application_type',
        'phone',
        'id_format_linkage',
        'format_linkage',
        'cantidad_folios',
        'comments_registration_portal',
        'id_cat_origin_medium',
        'id_time_format_linkage',
        'id_agency',
        'city',
        'department'

    ];

    protected $fillable = [
        'name_socialreason',
        'company_id',
        'verification_digit',
        'code_department',
        'code_city',
        'address',
        'comercial_name',
        'code_agency',
        'email_billing_contact',
        'email_invoices',
        'email_optional',
        'client_type',
        'origin_medium',
        'origin_vendor',
        'person_type',
        'general_status',
        'active',
        'application_type',
        'phone',
        'id_format_linkage',
        'format_linkage',
        'cantidad_folios',
        'comments_registration_portal',
        'id_cat_origin_medium',
        'id_time_format_linkage',
        'id_agency',
        'city',
        'department'
    ];


    public static function getNit($nit = null,$tipe = null){

         return self::where('company_id',$nit)->first();
    }

    public static function getId($nit = null){

        return self::where('company_id',$nit)->first()->id;
   }
    public static function getDataCertificado($id_enterprise){
        $data_enterprise =  self::find($id_enterprise);
        return $data_enterprise;
    }

    public static function getDataEnterprise($type,$document_id,$dv){
        return self::where(
            [['person_type','=',$type],['company_id','=', $document_id],['verification_digit','=', $dv]]
            )->first();
    }

    public static function getDataPrevia($id_enterprise,$nit){
        $data_enterprise =  self::where('company_id',$nit)->where('id',$id_enterprise)->first();
        return $data_enterprise;
    }

    public function contrato(){
        return $this->hasMany(Contrato::class,'idcliente')->where('active', '1');
    }
}


