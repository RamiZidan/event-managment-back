<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Invitation\StorePublicRequest ;
use App\Http\Requests\Invitation\StorePrivateRequest ;
use App\Http\Requests\Invitation\ShowRequest ;
use App\Http\Requests\Invitation\DestroyRequest ;


class InvitationController
{
    public function index(Request $request ){
        $invitation;
        if($request->query('type')){
            $invitations = Invitation::where('type' , $request->query('type'))->with(['seat', 'surname' , 'group'])->paginate() ;
        }
        else{
            $invitations = Invitation::with(['seat', 'surname' , 'group'])->paginate() ;
        }
        return response()->json( $invitations);
    }
    public function show(Request $request){
        $invitation = Invitation::where('id' , $request->route('id'))->first();
        return response()->json(['data' => $invitation]);
    }
    public function destroy(Request $request){
        $invitation = Invitation::whereIn('id' , $request->ids);
        $invitation->delete();
        return response()->json(['message'=>'invitations deleted succesfully']);
    }
    public function store_public_by_visitor(Request $request){
        $invitation = Invitation::create($request->all() + ['status' => 'processing' , 'type'=>'public'] ) ;
        return response()->json(['data' => $invitation]);
    }
    public function store_public(Request $request){
        $invitation = Invitation::create($request->all() );
        return response()->json(['data' => $invitation]);
    }
    public function store_private(Request $request){
        $invitation = Invitation::create($request->all() + ['type'=>'private' ]);
        return response()->json(['data' => $invitation]);
    }
    public function update_public(Request $request){
        $invitation = Invitation::where('id', $request->route('id'))->update($request->all());
        return response()->json(['message' => 'updated succesfully']);
    }
    public function update_private(Request $request){
        $invitation = Invitation::where('id', $request->route('id'))->update($request->all());
        return response()->json(['message' => 'updated succesfully']);
    }
}
