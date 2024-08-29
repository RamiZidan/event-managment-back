<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function invitationSeats(){
        return $this->hasMany(InvitationSeat::class);
    }
    public function seats(){
        return $this->belongsToMany(Seat::class );
    }
    public function seat(){
        return $this->belongsToMany(Seat::class)->withPivot('status')->wherePivot('status' ,'active');
    }
    public function surname(){
        return $this->belongsTo(Surname::class);
    }
  
    
}
