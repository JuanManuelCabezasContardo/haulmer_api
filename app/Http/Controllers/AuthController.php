<?php

namespace App\Http\Controllers;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    //
    public function __construct(){
        $this->key = "example_key";
    }
    public function login(Request $request,$correo,$contrasena){
        //echo $nombre,"<br><br>",$correo;
        $response = Http::get('https://60380d194e3a9b0017e92ba9.mockapi.io/haulmer_mock/usuarios?correo_electronico='.$correo);
        if(!empty($response->json())){
            $contrasena_response= $response->json()[0]["contrasena"];
            
            if($contrasena_response == $contrasena){
                $time=time();//tiempo actual
                $token = array(
                    "iat" => $time,
                    "exp" => $time+(10),//segundos
                    'idUsuario'=>$response->json()[0]["id"]
                );
                $jwt = JWT::encode($token,$this->key);
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
        
        try{
            $jwt= $request->session()->get("token_jwt");
            if(empty($jwt)){
                return response()->json(['message' => 'Su token a expirado por favor ingresar nuevamente a login',],404);
            }
            $decoded = JWT::decode($jwt,$this->key, array('HS256'));
            $time=time();
            $token = array(
                "iat" => $time,
                "exp" => $time+(10),
                'idUsuario'=>$decoded->idUsuario
            );
            $jwt = JWT::encode($token,$this->key);
            $request->session()->put(["token_jwt"=>$jwt]);
            return response()->json(['message' => 'Su token fue refrescado',"id"=>$decoded->idUsuario],200);;
        }catch(\Firebase\JWT\ExpiredException $e){
            return response()->json(['message' => 'Su token a expirado por favor ingresar nuevamente a login',],404);
        }
    }
    public function logout(Request $request){
        $request->session()->flush();
        return response()->json(['message' => 'Cerro sesion exitosamente',],200);
    }

    public function me_update(Request $request){
        try{
             //comprobar si hay token
            $jwt= $request->session()->get("token_jwt");
            if(empty($jwt)){
                return response()->json(['message' => 'Su token a expirado por favor ingresar nuevamente a login',],404);
            }
            $decoded = JWT::decode($jwt,$this->key, array('HS256'));
            $time=time();
            $token = array(
                "iat" => $time,
                "exp" => $time+(10),
                'idUsuario'=>$decoded->idUsuario
            );
            $jwt = JWT::encode($token,$this->key);
            $request->session()->put(["token_jwt"=>$jwt]);
            //aqui comprobar si el id es el correcto
            $response = Http::get('https://60380d194e3a9b0017e92ba9.mockapi.io/haulmer_mock/usuarios/'.$decoded->idUsuario);
            $datos_user= $response->json();
            $datos_user["correo_electronico"]=$request->input('correo_electronico');
            $datos_user["nombre"]=$request->input('nombre');
            $datos_user["contrasena"]=$request->input('contrasena');
            $response = Http::put('https://60380d194e3a9b0017e92ba9.mockapi.io/haulmer_mock/usuarios/'.$decoded->idUsuario,$datos_user);
            //$datos_user["token"]=;//extra
            return response()->json(['message' => 'Su token fue refrescado'],$response->status());//"id"=>$decoded->idUsuario
        }catch(\Firebase\JWT\ExpiredException $e){
            return response()->json(['message' => 'Su token a expirado por favor ingresar nuevamente a login',],404);
        }
        

        
    }
    public function me_del(Request $request){
        
        try{
             //comprobar si hay token
            $jwt= $request->session()->get("token_jwt");
            if(empty($jwt)){
                return response()->json(['message' => 'Su token a expirado por favor ingresar nuevamente a login',],404);
            }
            $decoded = JWT::decode($jwt,$this->key, array('HS256'));
            $time=time();
            $token = array(
                "iat" => $time,
                "exp" => $time+(10),
                'idUsuario'=>$decoded->idUsuario
            );
            $jwt = JWT::encode($token,$this->key);
            $request->session()->put(["token_jwt"=>$jwt]);
            //aqui comprobar si el id es el correcto
            $response = Http::get('https://60380d194e3a9b0017e92ba9.mockapi.io/haulmer_mock/usuarios/'.$decoded->idUsuario);
            $datos_user= $response->json();
            $datos_user["correo_electronico"]=$request->input('correo_electronico');
            $datos_user["nombre"]=$request->input('nombre');
            $datos_user["contrasena"]=$request->input('contrasena');
            $response = Http::delete('https://60380d194e3a9b0017e92ba9.mockapi.io/haulmer_mock/usuarios/'.$decoded->idUsuario);
            //$datos_user["token"]=;//extra
            return response()->json(['message' => 'Su token fue refrescado'],$response->status());//"id"=>$decoded->idUsuario
        }catch(\Firebase\JWT\ExpiredException $e){
            return response()->json(['message' => 'Su token a expirado por favor ingresar nuevamente a login',],404);
        }
    }
    public function new(Request $request){//me_add
        $response = Http::post('https://60380d194e3a9b0017e92ba9.mockapi.io/haulmer_mock/usuarios',[
            'nombre' => $request->input('nombre'),
            'correo_electronico' => $request->input('correo_electronico'),
            'contrasena' => $request->input('contrasena'),
        ]);
        if($response->status() == 200 ){//no habia otro en mockapi.io
            return response()->json(['message' => 'La respuesta fue exitosa',],$response->status());
        }
        else if($response->status() == 201){
            return response()->json(['message' => 'el usuario ha sido creado exitosamente',],$response->status());
        }
        else{
            return response()->json(['message' => 'Su tiene algun error en la validacion',],$response->status());
        }

    }
}
