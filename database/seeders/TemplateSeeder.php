<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $categories = EventCategory::pluck('id', 'slug');

        $templates = [
            /*
            |--------------------------------------------------------------------------
            | 20 Template Pernikahan
            |--------------------------------------------------------------------------
            */
            ['pernikahan', 'Modern Couple', 'wedding-modern-couple', 'Template modern untuk pasangan muda dengan desain bersih dan stylish.', 64000, true],
            ['pernikahan', 'Classic Letter', 'wedding-classic-letter', 'Template surat klasik untuk undangan pernikahan digital.', 69000, true],
            ['pernikahan', 'Batik Elegance', 'wedding-batik-elegance', 'Template pernikahan dengan aksen batik elegan.', 69000, true],
            ['pernikahan', 'Minimal Black Gold', 'wedding-minimal-black-gold', 'Template minimalis hitam emas untuk kesan elegan dan premium.', 64000, true],
            ['pernikahan', 'Floral Love', 'wedding-floral-love', 'Template pernikahan dengan hiasan bunga lembut dan manis.', 69000, true],
            ['pernikahan', 'Rustic Garden', 'wedding-rustic-garden', 'Template pernikahan outdoor dengan tema rustic dan garden party.', 69000, true],
            ['pernikahan', 'Sekar Arum', 'classic-letter', 'Template elegan untuk undangan pernikahan dengan nuansa lembut dan romantis.', 49000, false],
            ['pernikahan', 'Luxury Maroon', 'wedding-luxury-maroon', 'Template mewah bernuansa maroon untuk undangan pernikahan premium.', 64000, true],
            ['pernikahan', 'Soft Sakura', 'wedding-soft-sakura', 'Template pernikahan lembut dengan nuansa pink sakura.', 69000, true],
            ['pernikahan', 'Royal Javanese', 'wedding-royal-javanese', 'Template pernikahan adat Jawa yang mewah, klasik, dan elegan.', 49000, false],
            ['pernikahan', 'Green Garden', 'wedding-green-garden', 'Template pernikahan natural dengan warna hijau dan floral.', 69000, true],
            ['pernikahan', 'Elegant White', 'wedding-elegant-white', 'Template minimalis putih elegan untuk undangan pernikahan modern.', 64000, true],
            ['pernikahan', 'Pastel Wedding', 'wedding-pastel-wedding', 'Template pernikahan pastel yang lembut dan modern.', 69000, true],
            ['pernikahan', 'Vintage Romance', 'wedding-vintage-romance', 'Template pernikahan vintage dengan nuansa hangat dan romantis.', 64000, true],
            ['pernikahan', 'Golden Romance', 'wedding-golden-romance', 'Template pernikahan premium dengan nuansa gold dan romantis.', 64000, true],
            ['pernikahan', 'Simple Nikah', 'wedding-simple-nikah', 'Template sederhana untuk akad nikah atau acara keluarga.', 55000, false],
            ['pernikahan', 'Ocean Love', 'wedding-ocean-love', 'Template pernikahan bernuansa biru laut yang tenang dan elegan.', 64000, true],
            ['pernikahan', 'Peach Blossom', 'wedding-peach-blossom', 'Template peach floral untuk undangan pernikahan yang manis.', 69000, true],
            ['pernikahan', 'Emerald Wedding', 'wedding-emerald-wedding', 'Template pernikahan emerald dengan kesan mewah dan tenang.', 69000, true],
            ['pernikahan', 'Nusantara Wedding', 'wedding-nusantara', 'Template pernikahan bernuansa tradisional Indonesia.', 69000, true],

            /*
            |--------------------------------------------------------------------------
            | 4 Template Ulang Tahun
            |--------------------------------------------------------------------------
            */
            ['ulang-tahun', 'Birthday Fun', 'birthday-fun', 'Template ceria untuk acara ulang tahun anak, remaja, dan keluarga.', 35000, false],
            ['ulang-tahun', 'Candy Birthday', 'birthday-candy', 'Template ulang tahun colorful dengan nuansa candy dan balon.', 35000, false],
            ['ulang-tahun', 'Kids Party', 'birthday-kids-party', 'Template ulang tahun anak dengan desain lucu dan playful.', 35000, false],
            ['ulang-tahun', 'Elegant Birthday', 'birthday-elegant', 'Template ulang tahun dewasa dengan desain simpel dan elegan.', 45000, true],

            /*
            |--------------------------------------------------------------------------
            | 4 Template Seminar
            |--------------------------------------------------------------------------
            */
            ['seminar', 'Seminar Pro', 'seminar-pro', 'Template profesional untuk seminar, workshop, webinar, dan pelatihan.', 45000, true],
            ['seminar', 'Webinar Modern', 'seminar-webinar-modern', 'Template modern untuk webinar dan event online.', 45000, true],
            ['seminar', 'Tech Conference', 'seminar-tech-conference', 'Template seminar teknologi dengan desain profesional.', 45000, true],
            ['seminar', 'Education Talk', 'seminar-education-talk', 'Template seminar pendidikan, talkshow, dan diskusi kampus.', 45000, true],

            /*
            |--------------------------------------------------------------------------
            | 4 Template Syukuran
            |--------------------------------------------------------------------------
            */
            ['syukuran', 'Syukur Ceria', 'syukuran-ceria', 'Template sederhana dan hangat untuk acara syukuran keluarga.', 45000, true],
            ['syukuran', 'Warm Syukuran', 'syukuran-warm', 'Template syukuran bernuansa hangat dan kekeluargaan.', 45000, true],
            ['syukuran', 'Doa Bersama', 'syukuran-doa-bersama', 'Template untuk doa bersama, tasyakuran, dan acara keluarga.', 45000, true],
            ['syukuran', 'Soft Syukuran', 'syukuran-soft', 'Template syukuran lembut dengan tampilan bersih dan sederhana.', 45000, true],

            /*
            |--------------------------------------------------------------------------
            | 5 Template Wisuda
            |--------------------------------------------------------------------------
            */
            ['wisuda', 'Graduation Day', 'wisuda-graduation-day', 'Template modern untuk undangan wisuda dan perayaan kelulusan.', 45000, true],
            ['wisuda', 'Golden Graduation', 'wisuda-golden-graduation', 'Template wisuda bernuansa emas dan elegan.', 45000, true],
            ['wisuda', 'Campus Pride', 'wisuda-campus-pride', 'Template wisuda untuk mahasiswa, sekolah, dan acara kampus.', 45000, true],
            ['wisuda', 'Simple Graduation', 'wisuda-simple-graduation', 'Template wisuda sederhana namun tetap berkesan.', 45000, true],
            ['wisuda', 'Elegant Graduate', 'wisuda-elegant-graduate', 'Template wisuda elegan untuk acara kelulusan formal.', 45000, true],

            /*
            |--------------------------------------------------------------------------
            | 5 Template Aqiqah
            |--------------------------------------------------------------------------
            */
            ['aqiqah', 'Aqiqah Soft', 'aqiqah-soft', 'Template lembut untuk acara aqiqah keluarga.', 45000, true],
            ['aqiqah', 'Baby Blessing', 'aqiqah-baby-blessing', 'Template aqiqah dengan nuansa bayi yang manis dan hangat.', 45000, true],
            ['aqiqah', 'Little Prince', 'aqiqah-little-prince', 'Template aqiqah bayi laki-laki dengan warna soft blue.', 45000, true],
            ['aqiqah', 'Little Princess', 'aqiqah-little-princess', 'Template aqiqah bayi perempuan dengan warna soft pink.', 45000, true],
            ['aqiqah', 'Islamic Aqiqah', 'aqiqah-islamic', 'Template aqiqah bernuansa islami dan keluarga.', 45000, true],

            /*
            |--------------------------------------------------------------------------
            | 5 Template Khitanan
            |--------------------------------------------------------------------------
            */
            ['khitanan', 'Khitan Ceria', 'khitanan-ceria', 'Template ceria untuk undangan khitanan anak.', 45000, true],
            ['khitanan', 'Little Hero', 'khitanan-little-hero', 'Template khitanan anak laki-laki dengan desain fun dan heroik.', 45000, true],
            ['khitanan', 'Blue Khitan', 'khitanan-blue', 'Template khitanan bernuansa biru dan modern.', 45000, true],
            ['khitanan', 'Islamic Khitan', 'khitanan-islamic', 'Template khitanan dengan sentuhan islami.', 45000, true],
            ['khitanan', 'Fun Khitan Party', 'khitanan-fun-party', 'Template khitanan yang ceria dan cocok untuk pesta keluarga.', 45000, true],

            /*
            |--------------------------------------------------------------------------
            | 10 Template Corporate
            |--------------------------------------------------------------------------
            */
            ['corporate', 'Corporate Launch', 'corporate-launch', 'Template formal untuk grand opening, launching produk, dan event perusahaan.', 45000, true],
            ['corporate', 'Business Opening', 'corporate-business-opening', 'Template corporate untuk pembukaan bisnis dan acara resmi.', 45000, true],
            ['corporate', 'Product Launch', 'corporate-product-launch', 'Template modern untuk launching produk dan brand activation.', 45000, true],
            ['corporate', 'Company Gathering', 'corporate-company-gathering', 'Template untuk gathering perusahaan dan acara internal kantor.', 45000, true],
            ['corporate', 'Formal Invitation', 'corporate-formal-invitation', 'Template undangan formal untuk event perusahaan.', 45000, true],
            ['corporate', 'Startup Event', 'corporate-startup-event', 'Template corporate modern untuk startup, pitch, dan networking.', 45000, true],
            ['corporate', 'Grand Opening Pro', 'corporate-grand-opening-pro', 'Template profesional untuk grand opening toko, kantor, atau bisnis.', 45000, true],
            ['corporate', 'Award Night', 'corporate-award-night', 'Template untuk acara penghargaan, malam apresiasi, dan gala dinner.', 45000, true],
            ['corporate', 'Business Seminar', 'corporate-business-seminar', 'Template corporate untuk seminar bisnis dan profesional.', 45000, true],
            ['corporate', 'Networking Night', 'corporate-networking-night', 'Template modern untuk networking event dan komunitas bisnis.', 45000, true],
        ];

        foreach ($templates as [$categorySlug, $name, $viewName, $description, $price, $isPremium]) {
            if (!isset($categories[$categorySlug])) {
                continue;
            }

            $slug = $viewName;

            Template::updateOrCreate(
                ['view_name' => $viewName],
                [
                    'event_category_id' => $categories[$categorySlug],
                    'name' => $name,
                    'slug' => $slug,
                    'thumbnail' => null,
                    'preview_image' => null,
                    'description' => $description,
                    'price' => $price,
                    'is_premium' => $isPremium,
                    'status' => 'active',
                ]
            );
        }
    }
}
