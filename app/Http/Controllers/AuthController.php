<?php

namespace App\Http\Controllers;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class AuthController extends Controller
{
    //
    public function __construct(){
        
    }
    public function login(Request $request,$correo,$contrasena){
        //echo $nombre,"<br><br>",$correo;
        $response = Http::get('https://60380d194e3a9b0017e92ba9.mockapi.io/haulmer_mock/usuarios?correo_electronico='.$correo);
        if(!empty($response->json())){
            $contrasena_response= $response->json()[0]["contrasena"];
            
            if($contrasena_response == $contrasena){
                $key = "example_key";
                $time=time();
                $token = array(
                    "iat" => $time,
                    "exp" => $time+(10),
                    'idUsuario'=>1
                );
                $jwt = JWT::encode($token, $key);
                $request->session()->put(["_token"=>""]);
                $request->session()->put(["token_jwt"=>$jwt]);
                return response()->json(['message' => 'Token JWT exitoso',],200);
            }
            else{
                return response()->json(['message' => 'Ingrese nuevamnete Contrasena ',],401);
            }
        }
        else{
            return response()->json(['message' => 'No existe usuario'],418);
        }
    }//lo que hice en la manana
    public function refresh_token(Request $request){
        $key = "example_key";
        $jwt= $request->session()->get("token_jwt");
        try{
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            $time=time();
            $token = array(
                "iat" => $time,
                "exp" => $time+(10),
                'idUsuario'=>1
            );
            $jwt = JWT::encode($token, $key);
            $request->session()->put(["token_jwt"=>$jwt]);
            return response()->json(['message' => 'Su token fue refrescado',],200);;
        }catch(\Firebase\JWT\ExpiredException $e){
            return response()->json(['message' => 'Su token a expirado por favor ingresar nuevamente a login',],404);
        }
    }
    public function logout(Request $request){
        $request->session()->flush();
        return response()->json(['message' => 'Cerro sesion exitosamente',],200);
    }
    public function me_update(){
        
    }
    public function me_del(){

    }
    public function new(){//me_add

    }
}
