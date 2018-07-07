<?php

namespace App;
use Request;

class Shipment extends ApiModel
{
    public static function getShipments(){
        $data = self::request('get', 'shipment', ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . \Request::session()->get('authToken')]], true);
        return $data;
    }
    
    public static function createShipment($data){
        $data = self::request('post', 'shipment', ['json'=>['id'=>$data->id, 'name'=>$data->name], 'headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . \Request::session()->get('authToken')]]);
        return $data;
    }
    
    public static function getShipment($id){
        $data = self::request('get', 'shipment/' . $id, ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . \Request::session()->get('authToken')]], true);
        return $data;
    }
    
    public static function updateShipment($data){
        $data = self::request('put', 'shipment/' . $data->id, ['json'=>['id'=>$data->id, 'name'=>$data->name], 'headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . \Request::session()->get('authToken')]]);
        return $data;
    }
    
    public static function deleteShipment($id){
        $data = self::request('delete', 'shipment/' . $id, ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . \Request::session()->get('authToken')]]);
        return $data;
    }
    
    public static function sendShipment($id){
        $data = self::request('post', 'shipment/' . $id . '/send', ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . \Request::session()->get('authToken')]]);
        return $data;
    }
}
