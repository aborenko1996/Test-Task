<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Stream\Stream;

class ShipmentsController extends Controller
{
    private $apiUrl = "https://api.shipments.test-y-sbm.com/";

    private function checkExpiration($request, $exception){
        $content = json_decode($exception->getResponse()->getBody()->getContents());
        $message = isset($content->message) ? $content->message : $content->error;
        if($message == 'token_expired'){
            $request->session()->forget('authToken');
            if($request->ajax())
            return ['error'=>true, 'message'=>$message, 'expired'=>true];
            else return redirect('/login');
        }else{
            return ['error'=>true, 'message'=>$message];
        }
    }

    private function getContent($req){
        $body = $req->getBody();
        $content = $body->getContents();
        return $content = json_decode($content, true)['data'];
    }

    private function getShipments(Request $request){
        try{
            $client = new GuzzleClient();
            $req = $client->request('GET', $this->apiUrl . 'shipment', ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . $request->session()->get('authToken')]]);
            return $this->getContent($req)['shipments'];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    private function getItem(Request $request){
        try{
            $client = new GuzzleClient();
            $req = $client->request('GET', $this->apiUrl . 'item/' . $request->id, ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . $request->session()->get('authToken')]]);
            return $this->getContent($req);
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function __construct(){
        $this->middleware('token')->except('login', 'auth');
    }

    public function login(Request $request){
        if($request->session()->has('authToken')){
            return redirect('/shipment');
        }
        return view('login');
    }

    public function createItemGet(Request $request){
        $shipments = $this->getShipments($request);
        return view('createItem', ['shipments'=>$shipments]);
    }

    public function editItem(Request $request, $id){
        $shipments = $this->getShipments($request);
        return view('createItem', ['shipments'=>$shipments, 'item'=>$this->getItem($request)]);
    }

    public function updateItem(Request $request, $id){
        try{
            $client = new GuzzleClient();
            $req = $client->request('PUT', $this->apiUrl . 'item/' . $request->id, ['json'=>['id'=>$request->id, 'code'=>$request->code, 'shipment_id'=>$request->shipment_id,'name'=>$request->name], 'headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . $request->session()->get('authToken')]]);
           return ['error'=>false];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function createItemPost(Request $request){
        try{
            $client = new GuzzleClient();
            $req = $client->request('POST', $this->apiUrl . 'item', ['json'=>['id'=>$request->id, 'name'=>$request->name, 'shipment_id'=>$request->shipment_id, 'code'=>$request->code], 'headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . $request->session()->get('authToken')]]);
           return ['error'=>false];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function deleteItem(Request $request){
        try{
            $client = new GuzzleClient();
            $req = $client->request('DELETE', $this->apiUrl . 'item/' . $request->id, ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . $request->session()->get('authToken')]]);
           return ['error'=>false];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function auth(Request $request){
        try{
            $client = new GuzzleClient();
            $req = $client->request('POST', $this->apiUrl . 'login', ['headers'=>['Content-Type'=>'application/json'],'json'=>['email'=>$request->email, 'password'=>$request->password]]);
            $body = $req->getBody();
            $content = $body->getContents();
            $token = json_decode($content, true)["data"][0]["token"];
            $request->session()->put('authToken',$token);
            return ['error'=>false, 'message'=>'Login successful'];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return ['error'=>true, 'message'=>'Login failed'];
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function deleteShipment(Request $request, $id){
        try{
            $client = new GuzzleClient();
            $req = $client->request('DELETE', $this->apiUrl . 'shipment/' . $request->id, ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . $request->session()->get('authToken')]]);
           return ['error'=>false];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function item(Request $request, $id){
        try{
            $content = $this->getItem($request);
            return view('viewItem', ['item'=>$content]);
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function editShipment(Request $request, $id){
        try{
            $client = new GuzzleClient();
            $req = $client->request('GET', $this->apiUrl . 'shipment/' . $id, ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . $request->session()->get('authToken')]]);
            $content = $this->getContent($req);
            return view('createShipment', ['shipment'=>$content]);
        }catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function shipments(Request $request){
        try{
            $content = $this->getShipments($request);
           return view('shipments', ['shipments'=>$content]);
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function createShipmentPost(Request $request){
        try{
            $client = new GuzzleClient();
            $req = $client->request('POST', $this->apiUrl . 'shipment', ['json'=>['id'=>$request->id, 'name'=>$request->name], 'headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . $request->session()->get('authToken')]]);
           return ['error'=>false];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function createShipmentGet(){
        return view('createShipment');
    }

    public function sendShipment(Request $request){
        try{
            $client = new GuzzleClient();
            $req = $client->request('POST', $this->apiUrl . 'shipment/' . $request->id . '/send', ['json'=>['id'=>$request->id, 'name'=>$request->name], 'headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . $request->session()->get('authToken')]]);
           return ['error'=>false];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function updateShipment(Request $request){
        try{
            $client = new GuzzleClient();
            $req = $client->request('PUT', $this->apiUrl . 'shipment/' . $request->id, ['json'=>['id'=>$request->id, 'name'=>$request->name], 'headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . $request->session()->get('authToken')]]);
           return ['error'=>false];
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }

    public function shipment(Request $request, $id){
        try{
            $client = new GuzzleClient();
            $req = $client->request('GET', $this->apiUrl . 'shipment/' . $request->id, ['headers'=>['Content-Type'=>'application/json', 'Authorization'=>'Bearer ' . $request->session()->get('authToken')]]);
            $content = $this->getContent($req);
            return view('viewShipment', ['shipment'=>$content]);
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->checkExpiration($request, $e);
        }
        catch(\GuzzleHttp\Exception\ServerException $e){
            return ['error'=>true, 'message'=>json_decode($e->getResponse()->getBody())->message];
        }
    }
}
