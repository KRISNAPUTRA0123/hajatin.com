<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'invitation_id',
        'invoice_number',
        'amount',
        'payment_gateway',
        'payment_method',
        'status',
        'payment_reference',
        'paid_at',
        'snap_token',
        'snap_redirect_url',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
