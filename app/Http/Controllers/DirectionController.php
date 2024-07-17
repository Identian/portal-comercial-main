<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatCity;
use App\Models\CatDepartment;
use App\Models\CatMunicipality;
use Illuminate\Support\Facades\DB;

class DirectionController extends Controller
{
    function municipality(Request $request,$code_department){
        if(!$request->ajax()){
            return response()->json(["code"=>500,"message"=>"Acceso No Autorizado"],403);
        }
        $code = CatDepartment::getCodeDepartment($code_department);
        $cat_municipalities = CatMunicipality::getMunicipalityList($code);
        return response()->json(["code"=>200,"message"=>"Exitoso","data"=>$cat_municipalities],200);
    }

    function city(Request $request,$code_municipality,$code_department){
        if(!$request->ajax()){
            return response()->json(["code"=>500,"message"=>"Acceso No Autorizado"],403);
        }
        $cat_cities = CatCity::getCities($code_municipality,$code_department);
        return response()->json(["code"=>200,"message"=>"Exitoso","data"=>$cat_cities],200);
    }
}
