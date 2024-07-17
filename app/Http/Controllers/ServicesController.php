<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class ServicesController extends Controller
{
    public static function ExecService($method,$url,$params,$token)
    {
        $client = new \GuzzleHttp\Client();
        try{
            $request = $client->request($method, $url, [
                'headers' => ['Authorization' => 'Bearer '.$token],
                'Content-Type'     => 'application/json',
                'json' => $params
            ]);

            return $request;

        }catch (\GuzzleHttp\Exception\ClientException $ex){
            \Log::Warning('ClientException', [
                'url' => $url,
                'code' => $ex->getResponse()->getStatusCode(),
                'message' => $ex->getMessage(),
                'params'=>$params,
            ]);
            return $ex->getResponse();
        }catch(\GuzzleHttp\Exception\ConnectException $ex){
            \Log::Warning('ConnectException', [
                'url' => $url,
                'message' => $ex->getMessage()
                ]);
                return "Falla de comunicacion entre aplicaciones: ".$ex->getMessage();

            }catch(\GuzzleHttp\Exception\RequestException $ex){
                \Log::Warning('RequestException', [
                    'url' => $url,
                    'code' => $ex->getResponse()->getStatusCode(),
                    'message' => $ex->getMessage(),
                    'params'=>$params,
                    ]);
                    return $ex->getResponse()->getBody()->getContents();
                }catch(\GuzzleHttp\Exception\BadResponseException $ex){
                    \Log::Warning('BadResponseException', [
                        'url' => $url,
                        'code' => $ex->getResponse()->getStatusCode(),
                        'message' => $ex->getMessage()
                        ]);

            return $ex->getResponse()->getBody(true)->getContents();
        }
    }

    public static function SingatureDigitalService($archivo,$token)
    {
        $url = Config::get('params.services.ws_autentic');
        $method = "POST";
        $params = $archivo;

        $response = self::ExecService($method,$url,$params,$token);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function SingatureToken()
    {

        $jsonToken = array();
        $jsonToken['audience'] = Config::get('params.credentials.audience');
        $jsonToken['grant_type'] = 'client_credentials';
        $jsonToken['client_id'] = Config::get('params.credentials.client_id');
        $jsonToken['client_secret'] = Config::get('params.credentials.client_secret');

        $url = Config::get('params.services.ws_oauth');
        $method = "POST";
        $params = $jsonToken;

        $response = self::ExecServiceToken($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function ExecServiceToken($method,$url,$params)
    {
        $client = new \GuzzleHttp\Client();
        try{
            $request = $client->request($method, $url, [
                'Content-Type'     => 'application/json',
                'json' => $params
            ]);

            return $request;

        }catch (\GuzzleHttp\Exception\ClientException $ex){
            \Log::Warning('ClientException', [
                'url' => $url,
                'code' => $ex->getResponse()->getStatusCode(),
                'message' => $ex->getMessage(),
                'params'=>$params,
            ]);

            return $ex->getResponse();
        }catch(\GuzzleHttp\Exception\ConnectException $ex){
            \Log::Warning('ConnectException', [
                'url' => $url,
                'message' => $ex->getMessage()
                ]);
                return $ex->getResponse();

            }catch(\GuzzleHttp\Exception\RequestException $ex){
                \Log::Warning('RequestException', [
                    'url' => $url,
                    'code' => $ex->getResponse()->getStatusCode(),
                    'message' => $ex->getMessage(),
                    'params'=>$params,
                    ]);
                    return $ex->getResponse()->getBody()->getContents();
                }catch(\GuzzleHttp\Exception\BadResponseException $ex){
                    \Log::Warning('BadResponseException', [
                        'url' => $url,
                        'code' => $ex->getResponse()->getStatusCode(),
                        'message' => $ex->getMessage()
                        ]);

            return $e->getResponse()->getBody(true)->getContents();
        }
    }

    public static function SingatureCode($code)
    {
        $url = Config::get('params.services.ws_agencia').$code;
        $method = "GET";
        $params = $code;

        $response = self::ExecServiceCode($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function ExecServiceCode($method,$url,$params)
    {
        $client = new \GuzzleHttp\Client();
        try{
            $request = $client->request($method, $url);

            return $request;

        }catch (\GuzzleHttp\Exception\ClientException $ex){
            \Log::Warning('ClientException', [
                'url' => $url,
                'code' => $ex->getResponse()->getStatusCode(),
                'message' => $ex->getMessage(),
                'params'=>$params,
            ]);
            return $ex->getResponse();
        }catch(\GuzzleHttp\Exception\ConnectException $ex){
            \Log::Warning('ConnectException', [
                'url' => $url,
                'message' => $ex->getMessage()
                ]);

               return $ex->getResponse();
        }
    }


    public static function CreateOTPUser($archivo)
    {
        $url = Config::get('params.services.ws_usuario_otp');
        $method = "GET";
        $params = $archivo;

        $response = self::ExecCreateOptUser($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }
    public static function SingatureOpt($archivo)
    {
        $url = Config::get('params.services.ws_otp');
        $method = "GET";
        $params = $archivo;

        $response = self::ExecCreateOptUser($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }
    public static function SingatureOptAutentic($archivo)
    {
        $url = Config::get('params.services.ws_otpfirma');
        $method = "GET";
        $params = $archivo;

        $response = self::ExecServiceOpt($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }
    public static function SingatureOptFirma($archivo)
    {
        $url = Config::get('params.services.ws_otpfirma');
        $method = "GET";
        $params = $archivo;

        $response = self::ExecCreateOptUser($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }
    public static function SingatureValidOpt($archivo)
    {
        $url = Config::get('params.services.ws_validateotp');
        $method = "GET";
        $params = $archivo;

        $response = self::ExecCreateOptUser($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }
    public static function SingatureValidOptAutentic($archivo)
    {
        $url = Config::get('params.services.ws_validateotpfirma').'/'.$archivo;
        $method = "GET";
        $params = $archivo;

        $response = self::ExecServiceOpt($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }
    public static function SingatureConcesion($archivo)
    {
        $url = Config::get('params.services.ws_concesion');
        $method = "POST";
        $params = $archivo;

        $response = self::ExecCreateOptUser($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }
    public static function ExecServiceOpt($method,$url,$params)
    {
        $client = new \GuzzleHttp\Client();
        try{
            $request = $client->request($method, $url, [
                'headers' => ['Authorization' => Config::get('params.credentials.otp_token')],
                'Content-Type'     => 'application/json',
                'json' => $params
            ]);

            return $request;

        }catch (\GuzzleHttp\Exception\ClientException $ex){
            \Log::Warning('ClientException', [
                'url' => $url,
                'code' => $ex->getResponse()->getStatusCode(),
                'message' => $ex->getMessage(),
                'params'=>$params,
            ]);
            dd("Excepcion de cliente". $ex->getMessage());
        }catch(\GuzzleHttp\Exception\ConnectException $ex){
            \Log::Warning('ConnectException', [
                'url' => $url,
                'message' => $ex->getMessage()
                ]);
                dd("Excepcion de Conexion");

            }catch(\GuzzleHttp\Exception\RequestException $ex){
                \Log::Warning('RequestException', [
                    'url' => $url,
                    'code' => $ex->getResponse()->getStatusCode(),
                    'message' => $ex->getMessage(),
                    'params'=>$params,
                    ]);
                    return $ex->getResponse()->getBody()->getContents();
                }catch(\GuzzleHttp\Exception\BadResponseException $ex){
                    \Log::Warning('BadResponseException', [
                        'url' => $url,
                        'code' => $ex->getResponse()->getStatusCode(),
                        'message' => $ex->getMessage()
                        ]);

                        dd("Excepcion de mala respuesta");
        }
    }
    public static function ExecCreateOptUser($method,$url,$params)
    {
        $client = new \GuzzleHttp\Client();
        try{
            $request = $client->request($method, $url, [
                'headers' => ['x-api-key' => Config::get('params.credentials.ws_x_api_key')],
                'Content-Type'     => 'application/json',
                'json' => $params
            ]);

            return $request;

        }catch (\GuzzleHttp\Exception\ClientException $ex){
            \Log::Warning('ClientException', [
                'url' => $url,
                'code' => $ex->getResponse()->getStatusCode(),
                'message' => $ex->getMessage(),
                'params'=>$params,
            ]);
            dd("Excepcion de cliente". $ex->getMessage());
        }catch(\GuzzleHttp\Exception\ConnectException $ex){
            \Log::Warning('ConnectException', [
                'url' => $url,
                'message' => $ex->getMessage()
                ]);
                dd("Excepcion de Conexion");

            }catch(\GuzzleHttp\Exception\RequestException $ex){
                \Log::Warning('RequestException', [
                    'url' => $url,
                    'code' => $ex->getResponse()->getStatusCode(),
                    'message' => $ex->getMessage(),
                    'params'=>$params,
                    ]);
                    return $ex->getResponse()->getBody()->getContents();
                }catch(\GuzzleHttp\Exception\BadResponseException $ex){
                    \Log::Warning('BadResponseException', [
                        'url' => $url,
                        'code' => $ex->getResponse()->getStatusCode(),
                        'message' => $ex->getMessage()
                        ]);

                        dd("Excepcion de mala respuesta");
        }
    }


    public static function CreateComentario($archivo)
    {
        $url = Config::get('params.services.ws_comments');
        $method = "POST";
        $params = $archivo;
        $response = self::ExecService_Comments($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function ExecService_Comments($method,$url,$params)
    {
        $client = new \GuzzleHttp\Client();
        try{
            $request = $client->request($method, $url, [
                'json' => $params
            ]);

            return $request;

        }catch (\GuzzleHttp\Exception\ClientException $ex){
            \Log::Warning('ClientException', [
                'url' => $url,
                'code' => $ex->getResponse()->getStatusCode(),
                'message' => $ex->getMessage(),
                'params'=>$params,
            ]);
            return $ex->getResponse();
        }catch(\GuzzleHttp\Exception\ConnectException $ex){
            \Log::Warning('ConnectException', [
                'url' => $url,
                'message' => $ex->getMessage()
                ]);
                return "Falla de comunicacion entre aplicaciones: ".$ex->getMessage();
        }
    }

    public static function SingatureRut($archivo)
    {
        $url = Config::get('params.services.ws_readRut');
        $method = "POST";
        $params = $archivo;
        $response = self::ExecServiceRut_Cc($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }
        public static function SingatureCc($archivo)
    {

        $url = Config::get('params.services.ws_matchFiles');
        $method = "POST";
        $params = $archivo;
        $response = self::ExecServiceRut_Cc($method,$url,$params);
        $response = (gettype($response) == "string") ? json_decode($response) : json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function ExecServiceRut_Cc($method,$url,$params)
    {
        $client = new \GuzzleHttp\Client();
        try{
            $request = $client->request($method, $url, [
                'headers' => ['X-API-KEY' => 'de0ff81f-5296-451c-bb7a-e170b97e3788'],
                'Content-Type'     => 'application/json',
                'json' => $params
            ]);

            return $request;

        }catch (\GuzzleHttp\Exception\ClientException $ex){
            \Log::Warning('ClientException', [
                'url' => $url,
                'code' => $ex->getResponse()->getStatusCode(),
                'message' => $ex->getMessage(),
                'params'=>$params,
            ]);
            return $ex->getResponse();
        }catch(\GuzzleHttp\Exception\ConnectException $ex){
            \Log::Warning('ConnectException', [
                'url' => $url,
                'message' => $ex->getMessage()
                ]);
                return "Falla de comunicacion entre aplicaciones: ".$ex->getMessage();

        }
    }

    public static function deleteDirectory($dir) {
        if(!$dh = @opendir($dir)) return;
        while (false !== ($current = readdir($dh))) {
            if($current != '.' && $current != '..') {
                if (!@unlink($dir.'/'.$current))
                    deleteDirectory($dir.'/'.$current);
            }
        }
        closedir($dh);
        @rmdir($dir);
    }

}
