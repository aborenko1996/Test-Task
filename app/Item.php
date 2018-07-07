<?php

namespace App;

class Item extends ApiModel
{
    public static function getItem($id){
        $data = self::request('get', 'item/' . $id, ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . \Request::session()->get('authToken')]], true);
        return $data;
    }
    
    public static function createItem($data){
        $data = self::request('post', 'item', ['json'=>['id'=>$data->id, 'name'=>$data->name, 'code'=>$data->code, 'shipment_id'=>$data->shipment_id], 'headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . \Request::session()->get('authToken')]]);
        return $data;
    }
    
    public static function updateItem($data){
        $data = self::request('put', 'item/' . $data->id, ['json'=>['id'=>$data->id, 'name'=>$data->name, 'code'=>$data->code, 'shipment_id'=>$data->shipment_id], 'headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . \Request::session()->get('authToken')]]);
        return $data;
    }
    
    public static function deleteItem($id){
        $data = self::request('delete', 'item/' . $id, ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . \Request::session()->get('authToken')]], true);
        return $data;
    }
    
}
