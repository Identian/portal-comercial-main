<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relacion extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'enterprise_id',
        'person_id',
        'relation_type',
        'active'
    ];
    protected $visible = [
        'id',
        'enterprise_id',
        'person_id',
        'relation_type',
        'active'
        ];

    public static function getIdPersona($id,$type){
        return self::where([['relation_type','=',$type],['enterprise_id','=', $id],['active','=', 1]])->first();
    }

    public static function getId($id_enterprise,$id_representative){
        return self::where([['enterprise_id','=',$id_enterprise],['person_id','=', $id_representative]])->first()->id;
    }

}
