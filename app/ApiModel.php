<?php

namespace App;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Stream\Stream;

class ApiModel
{
    protected static function request($method, $url, $data, $returnContent = false){
        try{
            $client = new GuzzleClient();
            $req = $client->request($method, config('app.apiUrl') . $url, $data);
            if($returnContent){
                $body = $req->getBody();
                $content = $body->getContents();
                return json_decode($content, true)["data"];
            }
            
            return ['error'=>false];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            $body = json_decode($e->getResponse()->getBody());
            $message = isset($body->message) ? $body->message : $body->error;
            return ['error'=>true, 'message'=>$message];
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            $body = json_decode($e->getResponse()->getBody());
            $message = isset($body->message) ? $body->message : $body->error;
            return ['error'=>true, 'message'=>$message];
        }
    }
}
