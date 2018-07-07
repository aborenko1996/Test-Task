<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function login(Request $request){
        return view('login');
    }
    
    public function auth(Request $request){
        $data = User::getToken($request->email, $request->password);
        if(isset($data['error']) && $data['error']){
            return $data;
        }else{
            $request->session()->put('authToken', $data[0]['token']);
            $request->session()->put('tokenExpired', false);
            return $data[0];
        }
    }
    
}
