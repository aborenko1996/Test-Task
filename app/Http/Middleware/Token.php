<?php

namespace App\Http\Middleware;

use Closure;
use Request;

class Token
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(!$request->session()->has('authToken') && Request::path() != 'login'){
            return redirect('login');
        }else if ($request->session()->has('authToken') && Request::path() == 'login'){
            return redirect('shipment/list');
        }
        
        $response = $next($request);
        
        if($request->session()->get('tokenExpired') && Request::path() != 'login'){
            $request->session()->forget('authToken');
            if($request->ajax()){
                 return response()->json(['expired'=>true], 200); 
            }
            return redirect('login');
        }
       
        return $response;
    }
}
