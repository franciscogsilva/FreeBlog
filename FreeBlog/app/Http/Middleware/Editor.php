<?php

namespace App\Http\Middleware;

use Closure;
//use JWTAuth;
use Illuminate\Support\Facades\Auth;
//use Tymon\JWTAuth\Exceptions\JWTException;

class Editor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(Auth::user()->isEditor()){
            return $next($request);
        }else{
            Auth::logout();
            return redirect()->route('login');            
        }

        /*
        if(Auth::user()){
            if(Auth::user()->isAdmin()){
                return $next($request);
            }else{
                Auth::logout();
                return redirect()->route('login');            
            }
        }elseif(JWTAuth::parseToken()->authenticate()){
            if(JWTAuth::parseToken()->authenticate()->isAdmin()){
                return $next($request);
            }else{
                JWTAuth::invalidate(JWTAuth::getToken());
                return response()->json([
                    'error'     =>  'User not authorized',
                    'success'   =>  false
                ],401)->setEncodingOptions(JSON_NUMERIC_CHECK);           
            }
        }
        */
    }
}
