<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatDepartment extends Model
{
    protected $visible = [
        'id',
        'code',
        'description',
        'active',
    ];
    protected $fillable = [
        'id',
        'code',
        'description',
        'active',
    ];

    public static function getCodeDepartment($id = null){

         return self::where('id',$id)->first()->code;
    }

    public static function getDepartment($id = null){

         return self::where('id',$id)->first()->description;
    }

    public static function getDeparmentsList($code = null){
        $query = self::where('active',1);
        if(isset($code)){
            $query->where('id',$code);
        }
        //$query->orderBy('description','desc');
        $data = $query->pluck('description','id');
        return $data;
    }

    public static function getIdDepartament($code = null){

        return self::where('code',$code)->first()->id;
   }

}
