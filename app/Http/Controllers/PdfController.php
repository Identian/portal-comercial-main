<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Redirect;
use PDF;
use App\Models\ModelBase;
use App\Models\CatCity;
use App\Models\CatDepartment;
use App\Models\CatMethod;
use App\Models\CatTypePerson;
use App\Models\CatTypeDocument;
use App\Models\CatTypes;
use App\Models\EnterprisesHistoric;
use App\Models\Enterprise;
use App\Models\Representative;
use App\Models\Clientes;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{

    public function index()
    {
        $representatives = Representatives::all();

        return view('pdf.notes',['representatives' => $representatives]);

    }

    public function pdf($id_enterprise){
        $enterprise = Enterprise::getDataCertificado($id_enterprise);
            if($enterprise["id_cat_type_person"]=='1'){
                $target_path = '../app/Documentos/Juridico/'.$enterprise["id_cat_identification"].'_'.$enterprise["document_id"].'/certificado.pdf';
            }else{
                $target_path = '../app/Documentos/Natural/'.$enterprise["id_cat_identification"].'_'.$enterprise["document_id"].'/certificado.pdf';
            }
        $archivo = file_get_contents($target_path);
        $tamano = strlen($archivo);
        $arreglo = array();
        for ($i = 0;$i < $tamano;$i++) {
            $byte = ord($archivo[$i]);
            $byte = $byte < 128 ? $byte : $byte - 256;
            $arreglo[] = $byte;
        }
        $json = array();
        $json['metadata'] = array();
        $json['metadata']['names'] = 'Fernando';
        $json['metadata']['lastNames'] = 'Fernando';
        $json['metadata']['docId'] = '1346578963';
        $json['metadata']['secureKey'] = 'TransUnion_DecisionEdge_Latam_654987_C.C._1234567890';
        $json['files'] = array();
        $arrArchivo = array();
        $arrArchivo['fileContent'] = $arreglo;
        $arrArchivo['fileName'] = 'firmado.pdf';
        $json['files'][] = $arrArchivo;


        $firmado = ServicesController::SingatureDigitalService($enterprise,$json);
        if($firmado->operationCode==1000){
            $source = file_get_contents($firmado->urlDocuments);
            file_put_contents("../app/Documentos/firma.zip",$source);
            $zip = new \ZipArchive;
            $res = $zip->open("../app/Documentos/firma.zip");
            if ($res === TRUE) {
              if($enterprise["id_cat_type_person"]=='1'){
                $ruta = '../app/Documentos/Juridico/'.$enterprise["id_cat_identification"].'_'.$enterprise["document_id"].'/';
            }else{
                $ruta = '../app/Documentos/Natural/'.$enterprise["id_cat_identification"].'_'.$enterprise["document_id"].'/';
            }
              $zip->extractTo($ruta);
              $zip->close();
             return view('registro.descarga',['url' => $firmado->urlDocuments]);
            } else {
            }

        }

    }

}
