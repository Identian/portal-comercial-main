<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatFormatLinkage extends Model
{

    protected $visible = [
        'id',
        'code',
        'descripcion',
        'application_type'
    ];
    protected $fillable = [
        'id',
        'code',
        'descripcion',
        'application_type'
    ];

    public static function getFormatLinkage($id = null){

         return self::where('id',$id)->first()->code;
    }

    public static function getApplicationType($id = null){

         return self::where('id',$id)->first()->application_type;
    }

    public static function getFormatList($val = null){
        if ($val == 'true') {
            return self::whereNotNull('id')->whereIn('id', ['10'])->orderBy("code","ASC")->pluck('code','id');
        }else{
            return self::whereNotNull('id')->whereIn('id', ['8', '5', '6'])->orderBy("code","ASC")->pluck('code','id');
        }

    }

}
