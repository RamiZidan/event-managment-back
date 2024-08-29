<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

     use GeneralTrait;
    public function handle(Request $request, Closure $next)
    {
    
      
            $user = $request->user();
            if($user){
            if(!$user->is_admin){

                return $this->returnError(403,'Access Denied as you are not Admin!');

            }
            else{
                return $next($request);
                
            }}
            else{
                return $this->returnError(401,'Not authenticated');

            }
        
       
    }
}
