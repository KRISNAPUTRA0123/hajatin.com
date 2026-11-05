<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationPerson extends Model
{
    protected $fillable = [
        'invitation_id',
        'photo',
        'name',
        'subtitle',
        'family_name',
        'sort_order',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
