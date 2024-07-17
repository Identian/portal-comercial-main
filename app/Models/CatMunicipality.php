<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CatDepartment;

class CatMunicipality extends Model
{
    protected $visible = [
        'id',
        'code',
        'department_code',
        'id_department',
        'department',
        'description',
        'active'
    ];

    public function departamento(){
        return $this->belongsTo(CatDepartment::class,'department_code','code');
    }

    public static function getData($id){
        $data =  self::find($id);
        $data['id_department']= CatDepartment::getIdDepartament($data['department_code']);
        $data['department']= CatDepartment::getDepartment($data['id_department']);
        return $data;
    }

    public static function getMunicipalityList($department_code = null){
        $query = self::where('active',1);
        if(isset($department_code)){
            $query->where('department_code',$department_code);
        }
        $data = $query->select('description','id');
        return $data->get()->toArray();
    }

    public static function getMunicipality($id = null){

         return self::where('id',$id)->first()->description;
    }

    public static function getDescriptionMunicipality($department_code = null,$municipality_code = null, ){

        return self::where('code', $department_code.$municipality_code)->first()->description;
   }

    public static function getCodeMunicipality($id = null){

         return self::where('id',$id)->first()->code;
    }

    public static function getIdMunicipality($code = null){

        return self::where('code',$code)->first()->id;
   }

}
