<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class InvitationSeat extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected $table = 'invitation_seat';
    
    public function invitation(){
        return $this->belongsTo(Invitation::class);
    }
    public function seat(){
        return $this->belongsTo(Seat::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
