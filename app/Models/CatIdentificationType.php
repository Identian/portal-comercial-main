<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CatIdentificationType extends Model
{
    use HasFactory;


    protected $visible = [
        'id',
        'descripcion',
        'active',
    ];

    public static function getListIdentificationTypes(){
        return self::where('active',1)->orderBy("descripcion","ASC")->pluck('descripcion','id');
    }

    public static function getListIdentificationRep(){
        return self::where('active',1)->whereIn('id', [2,5,6,7,11])->orderBy("descripcion","ASC")->pluck('descripcion','id');
    }

    public static function getAcronym($id = null){

         return self::where('id',$id)->first()->acronym;
    }

    public static function getListIdentification($id_cat_type_person = null){
        $query = self::where('active',1);
        if(isset($id_cat_type_person)){
                $query->whereIn('id', [1]);
        }
        $query->orderBy('descripcion','asc');
        $data = $query->select('descripcion','id');
        return $data->get()->toArray();
    }

}
