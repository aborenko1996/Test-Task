<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Shipment;

class ShipmentsController extends Controller
{
    public function getShipments(Request $request){
        $data = Shipment::getShipments();
        User::checkExpiration($data);
        return view('shipments', ['data'=>$data]);
    }
    
    public function getCreateShipment(){
        return view('createShipment');
    }
    
    public function postCreateShipment(Request $request){
        $data = Shipment::createShipment($request);
        User::checkExpiration($data);
        return $data;
    }
    
    public function getShipment($id){
        $data = Shipment::getShipment($id);
        User::checkExpiration($data);
        return view('viewShipment', ['data'=>$data]);
    }
    
    public function updateShipment(Request $request){
        $data = Shipment::updateShipment($request);
        User::checkExpiration($data);
        return $data;
    }

   public function editShipment($id){
       $data = Shipment::getShipment($id);
       User::checkExpiration($data);
       return view('createShipment', ['data'=>$data]);
   }

    public function deleteShipment($id){
        $data = Shipment::deleteShipment($id);
        User::checkExpiration($data);
        return $data;
    }
    
    public function sendShipment($id){
        $data = Shipment::sendShipment($id);
        User::checkExpiration($data);
        return $data;
    }
    
}
