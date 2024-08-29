<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surname;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Surname\DestroyRequest ;
use App\Http\Requests\Surname\StoreRequest ;
use App\Http\Requests\Surname\UpdateRequest ;
class SurnameController
{
    public function index()
    {
        $surnames = Surname::paginate();
        return response()->json( $surnames ) ;
    }
    public function destroy(DestroyRequest $request ){
        $surname = Surname::whereIn('id' , $request->ids  );
        $surname->delete() ;
        return response()->json(['message' => 'deleted successfully']);
    }
    public function store(StoreRequest $request ){
        $surname = Surname::create([
            'title'=>$request->title,
            'lang'=>$request->lang 
        ]);
        return response()->json(['data' => $surname ]) ;
    }
    public function update(UpdateRequest $request){
        $surname = Surname::where('id' , $request->route('id')) ;
        $surname->update($request->all());
        return response()->json(['message' => 'updated succesfully']);
    }
}
