<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipment;
use App\User;
use App\Item;

class ItemsController extends Controller
{
    public function getCreateItem(){
        $data = Shipment::getShipments();
        return view('createItem', ['data'=>$data]);    
    }
    
    public function getItem($id){
        $data = Item::getItem($id);
        User::checkExpiration($data);
        return view('viewItem', ['data'=>$data]);
    }
    
    public function postCreateItem(Request $request){
        $data = Item::createItem($request);
        User::checkExpiration($data);
        return $data;
    }
    
    public function editItem($id){
        $data = Shipment::getShipments();
        $item = Item::getItem($id);
        User::checkExpiration($data);
        return view('createItem', ['data'=>$data, 'item'=>$item]);  
    }
    
    public function updateItem(Request $request){
        $data = Item::updateItem($request);
        User::checkExpiration($data);
        return $data;
    }

    public function deleteItem($id){
        $data = Item::deleteItem($id);
        User::checkExpiration($data);
        return $data;
    }

}
