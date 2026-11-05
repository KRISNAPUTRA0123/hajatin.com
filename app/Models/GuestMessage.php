<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestMessage extends Model
{
    protected $fillable = [
        'invitation_id',
        'guest_name',
        'message',
        'attendance_status',
        'guest_count',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
