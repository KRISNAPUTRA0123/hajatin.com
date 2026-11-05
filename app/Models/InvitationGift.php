<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationGift extends Model
{
    protected $fillable = [
        'invitation_id',
        'label',
        'account_number',
        'account_name',
        'sort_order',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
