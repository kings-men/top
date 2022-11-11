<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Auth;
use DB;

class RolesValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role){

        $user = Auth::user();
        $roleDetail = UserRole::where('user_id',$user->id)->with('roleDetail')->first();

        if($roleDetail->roleDetail->name == $role){
            return $next($request);

        }else{
            return common_response( "Unauthorized Role", False, 401, [] );
        }

    }
}
