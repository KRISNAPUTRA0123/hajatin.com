<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GuestMessage;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'event_category_id',
        'slug',
        'title',
        'event_name',
        'seminar_about_title',
        'event_highlights',
        'host_name',
        'description',
        'event_date',
        'event_time',
        'event_mode',
        'online_url',
        'location_name',
        'address',
        'maps_url',
        'cover_image',
        'music_url',
        'status',
        'expired_at',
        'theme_color',
        'event_end_date',
        'event_end_time',
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_end_date' => 'date',
        'expired_at' => 'datetime',
        'event_highlights' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function photos()
    {
        return $this->hasMany(InvitationPhoto::class)->orderBy('sort_order');
    }

    public function messages()
    {
        return $this->hasMany(GuestMessage::class)->latest();
    }

    public function people()
    {
        return $this->hasMany(InvitationPerson::class)->orderBy('sort_order');
    }

    public function gifts()
    {
        return $this->hasMany(InvitationGift::class)->orderBy('sort_order');
    }
}
