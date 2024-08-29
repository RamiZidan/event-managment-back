<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\InvitationSeat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Seat\ShowRequest ;
use App\Http\Requests\Seat\AssignSeatRequest;
class SeatController
{
    public function index(Request $request){
        $seats ;
        if($request->query('status') == 'empty'){
            $seats = Seat::with(['invitation_seat'])->doesntHave('invitation_seat')->orWhereHas('invitation_seat', function ($q){
                $q->where('status','inactive');
            })->paginate();
        }
        else if($request->query('reserved')){
            $seats = Seat::with(['invitation_seat'])->whereHas('invitation_seat', function($q) {
                $q->where('status', 'active'); 
            })->paginate();
        }
        else{ // all
            $seats = Seat::with(['invitation_seat','invitations'])->paginate();
        }        
        return response()->json($seats);
    }

    public function history(ShowRequest $request){
        $seat_history = InvitationSeat::where('seat_id' , $request->route('id'))->with('user','invitation')->where('status','inactive')->get();
        return response()->json(['data'=>$seat_history]);
    }

    public function assign_seat(AssignSeatRequest $request ){
        $invitation_seat = InvitationSeat::where('seat_id' , $request->route('id'))->where('status' , 'active');
        $invitation_seat->update([
            'status'=>'inactive'
        ]);
        if($request->invitation_id){ // inviation id not required
            $invitation_seat = InvitationSeat::create([
                'seat_id' => $request->route('id') ,
                'invitation_id' => $request->invitation_id ,
                'status'=>'active',
                'user_id'=> Auth::user()->id 
            ]);
        }
        
        return response()->json(['data'=>$invitation_seat]);
    }

    public function reports(){
        
        // $vipPrivateCount = Seat::where('status', 'vip')->with('invitations')
        //     ->whereHas('invitations', function ($query) {
        //         $query->where('type', 'private')
        //             ->where('invitation_seat.status', 'active'); 
        //     })
        //     ->count();

        // $normalPrivateCount = Seat::where('status', 'normal')->with('invitations')
        //     ->whereHas('invitations', function ($query) {
        //         $query->where('type', 'private')
        //             ->wherePivot('status', 'active');
        //     })
        //     ->count();

        // $vipPublicCount = Seat::where('status', 'vip')->with('invitations')
        //     ->whereHas('invitations', function ($query) {
        //         $query->where('type', 'public')
        //             ->wherePivot('status', 'active');
        //     })
        //     ->count();

        // $normalPublicCount = Seat::where('status', 'normal')->with('invitations')
        //     ->whereHas('invitations', function ($query) {
        //         $query->where('type', 'public')
        //             ->wherePivot('status', 'active');
        //     })
        //     ->count();
        // static data for testing 
        return response()->json([
            'private_vip'=>3  ,
            'private_normal'=>4 ,
            'public_vip'=>5 ,
            'public_normal'=> 10
        ]);

    }
    public function show(Request $request){
        $seat = Seat::where('id', $request->id)->first() ;
        return response()->json(['data'=> $seat]);
    }
    
}
