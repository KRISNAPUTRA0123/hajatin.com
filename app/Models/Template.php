<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'event_category_id',
        'name',
        'slug',
        'thumbnail',
        'preview_image',
        'view_name',
        'description',
        'price',
        'is_premium',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }
}
