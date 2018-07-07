<?php

namespace App;
use Request;

class User extends ApiModel
{
    public static function getToken($email, $password){
        $data = self::request('post', 'login', ['headers'=>['Content-Type'=>'application/json'],'json'=>['email'=>$email, 'password'=>$password]], true);
        return $data;
        /* try{
            $client = new GuzzleClient();
            $req = $client->request('POST', config('app.apiUrl') . 'login', ['headers'=>['Content-Type'=>'application/json'],'json'=>['email'=>$email, 'password'=>$password]]);
            $body = $req->getBody();
            $content = $body->getContents();
            $token = json_decode($content, true)["data"][0]["token"];
            \Request::session()->put('authToken',$token);
            return ['error'=>false, 'message'=>'Login successful'];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return ['error'=>true, 'message'=>'Login failed'];
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        } */
    }
    
    public static function checkExpiration($data){
       
        if(isset($data['message']) && $data['message']=='token_expired'){
            \Request::session()->put('tokenExpired', true);
            return true;
        }
        return false;
    }
}
