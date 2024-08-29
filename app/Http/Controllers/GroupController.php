<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group; 
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Group\DestroyRequest ;
use App\Http\Requests\Group\StoreRequest ;
use App\Http\Requests\Group\UpdateRequest ;
class GroupController
{
    public function index()
    {
        $groups = Group::paginate();

        return response()->json( $groups ) ;
    }
    public function destroy(DestroyRequest $request ){
        $group = Group::whereIn('id' , $request->ids  );
        $group->delete() ;
        return response()->json(['message' => 'deleted successfully']);
    }
    public function store(StoreRequest $request ){
        $group = Group::create([
            'title' => $request->title ,
            'color' => $request->color 
        ]);
        return response()->json(['data' => $group ]) ;
    }
    public function update(UpdateRequest $request){
        $group = Group::where('id' , $request->id) ;
        $group->update($request->all());
        return response()->json(['message'=>'updated succesfully']);
    }
}
