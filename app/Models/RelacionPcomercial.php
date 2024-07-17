<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PersonaPcomercial;

class RelacionPcomercial extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_propuesta',
        'id_persona_pcomercial',
        'relation_type',
        'active'
    ];
    protected $visible = [
        'id',
        'id_propuesta',
        'id_persona_pcomercial',
        'relation_type',
        'active'
        ];

    public function representante(){
        return $this->belongsTo(PersonaPcomercial::class,'id_persona_pcomercial');
    }

    public static function getDataPersona($id,$type){
        $idPersona = self::where([['relation_type','=',$type],['id_propuesta','=', $id],['active','=', 1]])->first();
        return isset($idPersona) ? PersonaPcomercial::getData($idPersona->id_persona_pcomercial):null;
    }

    public static function getId($idPropuesta,$idRepresentative){
        return self::where([['id_propuesta','=',$idPropuesta],['id_persona_pcomercial','=', $idRepresentative]])->first()->id;
    }

    public static function getIdRep($idPropuesta,$type){
        return self::where([['relation_type','=',$type],['id_propuesta','=',$idPropuesta]])->first()->id_persona_pcomercial;
    }

}
