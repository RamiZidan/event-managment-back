<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserPermission; 
use Illuminate\Support\Facades\Auth;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $required_permission ): Response
    {
        $user_id = Auth::user()->id ;
        $permissions = UserPermission::where('user_id',$user_id)->with('permission')->get();
        // return response()->json($permissions);
        foreach($permissions as $permission){
            if($permission->permission->name == $required_permission){
                return $next($request);
            }
        }
        return response()->json(['message' => 'You dont have the appropriate permission'], 403 );
    }
}
