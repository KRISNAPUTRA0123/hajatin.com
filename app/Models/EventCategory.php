<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'status',
    ];

    public function templates()
    {
        return $this->hasMany(Template::class);
    }
}
