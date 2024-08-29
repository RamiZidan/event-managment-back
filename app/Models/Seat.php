<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function invitation_seat(){
        return $this->hasMany(InvitationSeat::class);
    }
    public function invitations(){

        return $this->belongsToMany(Invitation::class )->withPivot('status');
    }
    
}
