<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Pernikahan',
            'Ulang Tahun',
            'Seminar',
            'Syukuran',
            'Wisuda',
            'Aqiqah',
            'Khitanan',
            'Corporate',
        ];

        foreach ($categories as $category) {
            EventCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'status' => 'active',
            ]);
        }
    }
}
