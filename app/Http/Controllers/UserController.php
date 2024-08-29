<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\StoreUserRequest;
// use App\Models\Permission;
use App\Models\UserPermission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\DestroyRequest ;
use App\Http\Requests\User\UpdatePermissionsRequest ;
use App\Http\Requests\User\UpdateProfileRequest ;


class UserController
{

    public function profile(){
        $user = User::where('id' , Auth::user()->id )->first();
        return response()->json(['data'=> $user]) ;
    }
    public function update_profile(UpdateProfileRequest $request){
        $request['password'] = bcrypt($request->password);
        $user_id = Auth::user()->id; 
        $user = User::where('id', $user_id )->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            // 'type' => $request->type,
            'username' => $request->username,
        ]);
        return response()->json(['data' => $user]);
    }

    public function index(){
        $users = User::paginate();
        return response()->json($users);
    }
    public function update_permissoins(UpdatePermissionsRequest $request){
        $user = User::where('id' , $request->id )->first() ;
        UserPermission::where('user_id' , $request->id)->delete();
        foreach($request->permissions as $permission_id ){
            $user_permission = UserPermission::create(['permission_id' => $permission_id , 'user_id' => $request->id]);
        }
        return response()->json(['message' => 'updated succesfully']);
    }
    public function store(StoreUserRequest $request)
    {
        $request['password'] = bcrypt($request->password);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'username' => $request->username,
        ]);
        
        // foreach($request->permissions as $permission_id ){
        //     UserPermission::create([
        //         'permission_id'=>$permission_id ,
        //         'user_id' => $user->id 
        //     ]);
        // }

        return response()->json(['user' => $user], 200);
    }
    public function show($id)
    {
        $user = User::where('id', $id)->first();

        return response()->json(['user' => $user], 200);
    }

    public function destroy(DestroyRequest $request ){
        $user = User::whereIn('id', $request->ids );
        $user->delete();
        return response()->json(['message'=>'deleted successfully']);
    }
    public function update(Request $request ){
        $user = User::where('id',$request->route('id'));
        $user->update($request->all());
        return response()->json(['message'=>'updated successfully']);
    }

}
