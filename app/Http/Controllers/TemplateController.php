<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $categories = EventCategory::where('status', 'active')
            ->orderBy('id')
            ->get();

        $templates = Template::query()
            ->select('templates.*')
            ->with('category')
            ->where('status', 'active')
            ->whereNotNull('view_name')
            ->when($request->category, function ($query) use ($request) {
                $query->whereHas('category', function ($categoryQuery) use ($request) {
                    $categoryQuery->where('slug', $request->category);
                });
            })
            ->orderBy('event_category_id', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(6)
            ->withQueryString();

        $heroPreviewSlugs = [
            'syukuran-doa-bersama',
            'syukuran-soft',
            'wisuda-elegant-graduate',
            'aqiqah-islamic',
            'seminar-tech-conference',
        ];

        $heroPreviewTemplates = Template::with('category')
            ->where('status', 'active')
            ->whereIn('slug', $heroPreviewSlugs)
            ->get()
            ->sortBy(function ($template) use ($heroPreviewSlugs) {
                return array_search($template->slug, $heroPreviewSlugs);
            })
            ->values();

        return view('templates.index', compact(
            'templates',
            'categories',
            'heroPreviewTemplates'
        ));
    }

    public function show($slug)
    {
        $template = Template::with('category')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $ownedInvitation = null;

        if (auth()->check()) {
            $ownedInvitation = \App\Models\Invitation::where('user_id', auth()->id())
                ->where('template_id', $template->id)
                ->first();
        }

        return view('templates.show', compact('template', 'ownedInvitation'));
    }
    public function livePreview(Template $template)
    {
        $category = EventCategory::first();

        $invitation = new \App\Models\Invitation();

        $invitation->id = 0;
        $invitation->template_id = $template->id;
        $invitation->event_category_id = $category?->id;
        $invitation->slug = 'preview-template';
        $invitation->title = 'Alex & Oktavia';
        $invitation->event_name = $category?->name ?? 'Pernikahan';
        $invitation->host_name = 'Keluarga Besar';
        $invitation->description = 'Dengan segala kerendahan hati, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara kami.';
        $invitation->event_date = Carbon::now()->addDays(30);
        $invitation->event_time = '09:00';
        $invitation->event_end_date = null;
        $invitation->event_end_time = null;
        $invitation->location_name = 'Gedung Serbaguna';
        $invitation->address = 'Jl. Contoh Alamat Acara';
        $invitation->maps_url = null;
        $invitation->cover_image = null;
        $invitation->music_url = null;
        $invitation->theme_color = 'maroon';
        $invitation->status = 'active';

        $invitation->setRelation('template', $template);
        $invitation->setRelation('category', $category);
        $invitation->setRelation('photos', collect());
        $invitation->setRelation('messages', collect());

        $people = collect([
            (object) [
                'photo' => null,
                'name' => 'Alex',
                'subtitle' => 'Putra',
                'family_name' => 'Bapak Ahmad',
            ],
            (object) [
                'photo' => null,
                'name' => 'Oktavia',
                'subtitle' => 'Putri',
                'family_name' => 'Bapak Hasan',
            ],
        ]);

        $gifts = collect([
            (object) [
                'label' => 'Bank / E-wallet',
                'account_number' => '1234567890',
                'account_name' => 'Alex Oktavia',
            ],
        ]);

        $invitation->setRelation('people', $people);
        $invitation->setRelation('gifts', $gifts);

        $mapData = [
            'open_url' => null,
            'embed_url' => null,
        ];

        if ($template->view_name === 'classic-letter') {
            return view('public-invitations.classic-letter', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'birthday-fun') {
            $invitation->title = 'Alya Turns 10';
            $invitation->event_name = 'Ulang Tahun';
            $invitation->description = 'Yuk datang dan rayakan hari spesial Alya bersama teman dan keluarga!';
            $invitation->theme_color = 'rose';

            return view('public-invitations.birthday-fun', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'birthday-candy') {
            $invitation->title = 'Alya Sweet Party';
            $invitation->event_name = 'Ulang Tahun';
            $invitation->description = 'Yuk datang dan rayakan hari manis penuh warna bersama kami!';
            $invitation->theme_color = 'rose';

            return view('public-invitations.birthday-candy', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'birthday-kids-party') {
            $invitation->title = 'Nadia Turns 8';
            $invitation->event_name = 'Ulang Tahun Anak';
            $invitation->description = 'Ayo hadir di pesta ulang tahun Nadia yang penuh permainan, tawa, dan kejutan seru!';
            $invitation->theme_color = 'sky';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Nadia',
                    'subtitle' => 'Birthday Star',
                    'family_name' => 'Putri dari Bapak Andi & Ibu Rina',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Family',
                    'subtitle' => 'Happy Family',
                    'family_name' => 'Siap menyambut tamu dengan ceria',
                ],
            ]);

            $invitation->setRelation('people', $people);

            return view('public-invitations.birthday-kids-party', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'birthday-elegant') {
            $invitation->title = 'Aurelia Sweet Seventeen';
            $invitation->event_name = 'Ulang Tahun Elegan';
            $invitation->host_name = 'Keluarga Besar Aurelia';
            $invitation->description = 'Dengan penuh kebahagiaan, kami mengundang Anda untuk menghadiri perayaan ulang tahun istimewa dalam suasana elegan, hangat, dan berkesan.';
            $invitation->location_name = 'Grand Ballroom Royal Hotel';
            $invitation->address = 'Jl. Luxury Avenue No. 8, Jakarta';
            $invitation->theme_color = 'gold';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Aurelia',
                    'subtitle' => 'Birthday Honoree',
                    'family_name' => 'Putri dari Bapak Alexander & Ibu Clarissa',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Bank / E-wallet',
                    'account_number' => '1234567890',
                    'account_name' => 'Aurelia Clarissa',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.birthday-elegant', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'seminar-pro') {
            $invitation->title = 'Future Business Strategy 2026';
            $invitation->event_name = 'Seminar Profesional';
            $invitation->host_name = 'Spektakuler Institute';
            $invitation->description = 'Seminar profesional untuk membahas strategi bisnis, teknologi, kepemimpinan, dan peluang pertumbuhan di era digital.';
            $invitation->location_name = 'Grand Conference Hall';
            $invitation->address = 'Jl. Executive Center No. 10, Jakarta';
            $invitation->theme_color = 'navy';
            $invitation->seminar_about_title = 'Seminar yang Dirancang untuk Insight, Networking, dan Aksi';
            $invitation->event_highlights = [
                [
                    'title' => 'Materi Terarah',
                    'description' => 'Bahasan acara dibuat ringkas, relevan, dan mudah dipahami peserta.',
                ],
                [
                    'title' => 'Pembicara Kompeten',
                    'description' => 'Tampilkan narasumber, moderator, mentor, atau tokoh utama acara.',
                ],
                [
                    'title' => 'RSVP Peserta',
                    'description' => 'Peserta dapat mengirim ucapan, konfirmasi hadir, dan jumlah tamu.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Dr. Andika Pratama',
                    'subtitle' => 'Keynote Speaker',
                    'family_name' => 'Business Strategy Consultant',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Moderator',
                    'family_name' => 'Public Communication Expert',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Rizky Mahendra',
                    'subtitle' => 'Panel Speaker',
                    'family_name' => 'Digital Growth Specialist',
                ],
            ]);

            $invitation->setRelation('people', $people);

            return view('public-invitations.seminar-pro', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'seminar-webinar-modern') {
            $invitation->title = 'Digital Growth Webinar 2026';
            $invitation->event_name = 'Webinar Modern';
            $invitation->host_name = 'Spektakuler Digital Academy';
            $invitation->description = 'Webinar modern untuk membahas strategi digital, personal branding, konten, teknologi, dan peluang pertumbuhan di era online.';
            $invitation->seminar_about_title = 'Webinar Modern untuk Insight, Skill, dan Networking Digital';
            $invitation->location_name = 'Online via Zoom Meeting';
            $invitation->address = 'Link webinar akan dibagikan kepada peserta terdaftar.';
            $invitation->theme_color = 'navy';
            $invitation->event_mode = 'online';
            $invitation->online_url = 'https://meet.google.com/preview-webinar';

            $invitation->event_highlights = [
                [
                    'title' => 'Sesi Interaktif',
                    'description' => 'Peserta dapat mengikuti pembahasan dengan format modern, ringkas, dan mudah dipahami.',
                ],
                [
                    'title' => 'Pembicara Praktisi',
                    'description' => 'Materi dibawakan oleh narasumber yang relevan dengan dunia digital dan industri kreatif.',
                ],
                [
                    'title' => 'Networking Online',
                    'description' => 'Cocok untuk membangun koneksi, bertukar insight, dan mendapatkan peluang baru.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Raka Pratama',
                    'subtitle' => 'Digital Strategist',
                    'family_name' => 'Keynote Speaker',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Putri',
                    'subtitle' => 'Content Growth Specialist',
                    'family_name' => 'Guest Speaker',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Arman Wijaya',
                    'subtitle' => 'Moderator',
                    'family_name' => 'Host Session',
                ],
            ]);

            $invitation->setRelation('people', $people);

            return view('public-invitations.seminar-webinar-modern', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'seminar-tech-conference') {
            $invitation->title = 'Future Tech Conference 2026';
            $invitation->event_name = 'Tech Conference';
            $invitation->host_name = 'Spektakuler Tech Community';
            $invitation->description = 'Konferensi teknologi modern untuk membahas AI, software engineering, startup, product development, dan transformasi digital.';
            $invitation->seminar_about_title = 'Conference untuk Developer, Founder, Creator, dan Tech Enthusiast';
            $invitation->location_name = 'Innovation Convention Center';
            $invitation->address = 'Jl. Digital Future No. 20, Jakarta';
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;
            $invitation->theme_color = 'navy';

            $invitation->event_highlights = [
                [
                    'title' => 'AI & Future Tech',
                    'description' => 'Bahasan tren teknologi, AI, automation, dan peluang digital masa depan.',
                ],
                [
                    'title' => 'Developer Session',
                    'description' => 'Sesi untuk programmer, software engineer, product builder, dan tech creator.',
                ],
                [
                    'title' => 'Startup Networking',
                    'description' => 'Bangun koneksi dengan komunitas, founder, mentor, dan peserta conference.',
                ],
                [
                    'title' => 'Product Showcase',
                    'description' => 'Cocok untuk demo produk, portofolio digital, dan sesi presentasi inovasi.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Arya Pradana',
                    'subtitle' => 'AI Engineer',
                    'family_name' => 'Keynote Speaker',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Product Lead',
                    'family_name' => 'Panel Speaker',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Rizky Mahendra',
                    'subtitle' => 'Startup Founder',
                    'family_name' => 'Guest Speaker',
                ],
            ]);

            $invitation->setRelation('people', $people);

            return view('public-invitations.seminar-tech-conference', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'seminar-education-talk') {
            $invitation->title = 'Education Talk 2026';
            $invitation->event_name = 'Education Talk';
            $invitation->host_name = 'Spektakuler Learning Community';
            $invitation->description = 'Acara edukatif yang menghadirkan pembelajaran ringan, inspiratif, dan menyenangkan untuk siswa, mahasiswa, guru, dan komunitas belajar.';
            $invitation->seminar_about_title = 'Belajar, Bertumbuh, dan Terinspirasi Bersama';
            $invitation->location_name = 'Aula Cendekia';
            $invitation->address = 'Jl. Pendidikan No. 25, Malang';
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;
            $invitation->theme_color = 'rose';

            $invitation->event_highlights = [
                [
                    'title' => 'Materi Ringan & Relevan',
                    'description' => 'Pembahasan disusun dengan bahasa yang mudah dipahami namun tetap bermanfaat.',
                ],
                [
                    'title' => 'Pembicara Inspiratif',
                    'description' => 'Hadirkan mentor, guru, praktisi, atau narasumber yang membagikan wawasan berharga.',
                ],
                [
                    'title' => 'Suasana Belajar Menyenangkan',
                    'description' => 'Desain acara dibuat ceria, nyaman, dan cocok untuk seminar pendidikan atau talkshow edukasi.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Dina Maharani',
                    'subtitle' => 'Education Mentor',
                    'family_name' => 'Keynote Speaker',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Raka Prasetya',
                    'subtitle' => 'Learning Facilitator',
                    'family_name' => 'Moderator',
                ],
            ]);

            $invitation->setRelation('people', $people);

            return view('public-invitations.seminar-education-talk', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'syukuran-ceria') {
            $invitation->title = 'Syukuran Rumah Baru';
            $invitation->event_name = 'Syukuran';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara syukuran kami dan berbagi kebahagiaan bersama.';
            $invitation->location_name = 'Kediaman Keluarga Hasan';
            $invitation->address = 'Jl. Melati Indah No. 20, Malang';
            $invitation->theme_color = 'emerald';
            $invitation->seminar_about_title = 'Momen Syukuran yang Hangat dan Menyenangkan';

            $invitation->event_highlights = [
                [
                    'title' => 'Suasana Ceria',
                    'description' => 'Desain dibuat segar, lembut, dan cocok untuk acara syukuran keluarga.',
                ],
                [
                    'title' => 'Undangan Lebih Hangat',
                    'description' => 'Tampilkan detail acara, galeri, amplop digital, dan ucapan tamu.',
                ],
            ];

            return view('public-invitations.syukuran-ceria', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'syukuran-warm') {
            $invitation->title = 'Syukuran Rumah Baru';
            $invitation->event_name = 'Syukuran';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara syukuran kami.';
            $invitation->location_name = 'Kediaman Keluarga Hasan';
            $invitation->address = 'Jl. Melati Indah No. 20, Malang';
            $invitation->theme_color = 'gold';
            $invitation->seminar_about_title = 'Momen Syukuran yang Hangat dan Bermakna';

            $invitation->event_highlights = [
                [
                    'title' => 'Suasana Hangat',
                    'description' => 'Desain dibuat lembut dan nyaman untuk acara keluarga, syukuran rumah, aqiqah, atau tasyakuran.',
                ],
                [
                    'title' => 'Informasi Lengkap',
                    'description' => 'Tampilkan detail acara, lokasi, countdown, galeri, amplop digital, dan ucapan tamu.',
                ],
            ];

            return view('public-invitations.syukuran-warm', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'syukuran-doa-bersama') {
            $invitation->title = 'Doa Bersama Keluarga';
            $invitation->event_name = 'Syukuran & Doa Bersama';
            $invitation->host_name = 'Keluarga Besar Bapak Rahmat';
            $invitation->description = 'Dengan penuh rasa syukur dan kebersamaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara doa bersama kami.';
            $invitation->location_name = 'Gedung Serbaguna Harmoni';
            $invitation->address = 'Jl. Melati Indah No. 18, Kota Malang';
            $invitation->theme_color = 'emerald';
            $invitation->seminar_about_title = 'Momen Syukur, Doa, dan Kebersamaan';

            $invitation->event_highlights = [
                [
                    'title' => 'Suasana Hangat',
                    'description' => 'Desain dibuat netral, hangat, dan cocok untuk acara doa bersama lintas suasana keluarga maupun komunitas.',
                ],
                [
                    'title' => 'Informasi Lengkap',
                    'description' => 'Tampilkan detail acara, countdown, galeri, amplop digital, dan ucapan tamu dalam satu halaman.',
                ],
                [
                    'title' => 'Tampilan Lebih Premium',
                    'description' => 'Susunan dibuat lebih modern, artistik, dan elegan agar undangan terlihat lebih wow dan berkesan.',
                ],
            ];

            return view('public-invitations.syukuran-doa-bersama', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'syukuran-soft') {
            $invitation->title = 'Syukuran Keluarga';
            $invitation->event_name = 'Syukuran';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Mari berkumpul dalam rasa syukur, mempererat silaturahmi, dan berbagi kebahagiaan bersama keluarga tersayang.';
            $invitation->location_name = 'Gedung Serbaguna Al-Ikhlas';
            $invitation->address = 'Jl. Melati No. 12, Kecamatan Sukajadi, Kota Bandung';
            $invitation->theme_color = 'emerald';
            $invitation->seminar_about_title = 'Momen Syukuran yang Lembut dan Bermakna';

            $invitation->event_highlights = [
                [
                    'title' => 'Momen Syukur',
                    'description' => 'Syukuran ini menjadi ungkapan rasa syukur atas nikmat dan kebahagiaan yang telah diberikan.',
                ],
                [
                    'title' => 'Silaturahmi Hangat',
                    'description' => 'Acara ini menjadi momen untuk berkumpul, berdoa, dan mempererat hubungan bersama keluarga serta kerabat.',
                ],
            ];

            return view('public-invitations.syukuran-soft', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wisuda-graduation-day') {
            $invitation->title = 'Graduation Day';
            $invitation->event_name = 'Wisuda & Syukuran Kelulusan';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa bangga dan syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen kelulusan yang penuh kebahagiaan.';
            $invitation->location_name = 'Gedung Graha Cendekia';
            $invitation->address = 'Jl. Pendidikan No. 25, Kota Malang';
            $invitation->theme_color = 'navy';
            $invitation->seminar_about_title = 'Merayakan Perjalanan, Prestasi, dan Masa Depan';

            $invitation->event_highlights = [
                [
                    'title' => 'Momen Kelulusan',
                    'description' => 'Rayakan perjalanan belajar, perjuangan, dan pencapaian yang telah diraih dengan penuh rasa bangga.',
                ],
                [
                    'title' => 'Syukuran Keluarga',
                    'description' => 'Acara ini menjadi momen berbagi rasa syukur bersama keluarga, sahabat, dan orang-orang terdekat.',
                ],
                [
                    'title' => 'Kenangan Berharga',
                    'description' => 'Abadikan momen wisuda dengan galeri, ucapan tamu, detail acara, dan undangan digital yang meriah.',
                ],
            ];

            return view('public-invitations.wisuda-graduation-day', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wisuda-golden-graduation') {
            $invitation->title = 'Golden Graduation';
            $invitation->event_name = 'Wisuda & Syukuran Kelulusan';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa bangga dan syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen kelulusan yang berkesan dan penuh kebahagiaan.';
            $invitation->location_name = 'Grand Ballroom Cendekia';
            $invitation->address = 'Jl. Pendidikan No. 25, Kota Malang';
            $invitation->theme_color = 'gold';
            $invitation->seminar_about_title = 'Merayakan Prestasi, Doa, dan Masa Depan';

            $invitation->event_highlights = [
                [
                    'title' => 'Momen Kelulusan',
                    'description' => 'Rayakan perjalanan belajar, perjuangan, dan pencapaian yang telah diraih dengan penuh rasa bangga.',
                ],
                [
                    'title' => 'Syukuran Keluarga',
                    'description' => 'Acara ini menjadi momen berbagi rasa syukur bersama keluarga, sahabat, dan orang-orang terdekat.',
                ],
                [
                    'title' => 'Kenangan Berharga',
                    'description' => 'Abadikan momen wisuda dengan galeri, ucapan tamu, detail acara, dan undangan digital yang mewah.',
                ],
            ];

            return view('public-invitations.wisuda-golden-graduation', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wisuda-campus-pride') {
            $invitation->title = 'Campus Pride Graduation';
            $invitation->event_name = 'Wisuda & Syukuran Kelulusan';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa bangga dan syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen kelulusan yang modern, hangat, dan penuh kebahagiaan.';
            $invitation->location_name = 'Auditorium Kampus Cendekia';
            $invitation->address = 'Jl. Pendidikan No. 25, Kota Malang';
            $invitation->theme_color = 'navy';
            $invitation->seminar_about_title = 'Merayakan Prestasi, Perjalanan, dan Masa Depan';

            $invitation->event_highlights = [
                [
                    'title' => 'Momen Kelulusan',
                    'description' => 'Rayakan perjalanan belajar, perjuangan, dan pencapaian yang telah diraih dengan penuh rasa bangga.',
                ],
                [
                    'title' => 'Kebanggaan Kampus',
                    'description' => 'Acara ini menjadi momen penuh makna untuk mengenang perjalanan akademik dan awal langkah baru.',
                ],
                [
                    'title' => 'Doa dan Dukungan',
                    'description' => 'Kehadiran keluarga dan sahabat menjadi penyempurna kebahagiaan di hari kelulusan.',
                ],
            ];

            return view('public-invitations.wisuda-campus-pride', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wisuda-elegant-graduate') {
            $invitation->title = 'Elegant Graduate';
            $invitation->event_name = 'Wisuda Elegan';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur dan bangga, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen kelulusan yang elegan, hangat, dan penuh makna.';
            $invitation->location_name = 'Ballroom Cendekia';
            $invitation->address = 'Jl. Pendidikan No. 25, Kota Malang';
            $invitation->theme_color = 'navy';
            $invitation->seminar_about_title = 'Perjalanan, Prestasi, dan Masa Depan';

            $invitation->event_highlights = [
                [
                    'title' => 'Momen Kelulusan',
                    'description' => 'Rayakan perjalanan belajar, perjuangan, dan pencapaian yang telah diraih dengan penuh rasa bangga.',
                ],
                [
                    'title' => 'Doa Keluarga',
                    'description' => 'Kehadiran keluarga dan sahabat menjadi penyempurna kebahagiaan pada hari kelulusan.',
                ],
                [
                    'title' => 'Langkah Baru',
                    'description' => 'Momen wisuda menjadi awal perjalanan baru menuju masa depan yang lebih indah.',
                ],
            ];

            return view('public-invitations.wisuda-elegant-graduate', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wisuda-simple-graduation') {
            $invitation->title = 'Simple Graduation';
            $invitation->event_name = 'Wisuda & Syukuran Kelulusan';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur dan kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen spesial kelulusan ini.';
            $invitation->location_name = 'Aula Graha Indah';
            $invitation->address = 'Jl. Melati No. 10, Bandung';
            $invitation->theme_color = 'emerald';
            $invitation->seminar_about_title = 'Momen Kelulusan yang Hangat dan Berkesan';

            $invitation->event_highlights = [
                [
                    'title' => 'Syukur & Terima Kasih',
                    'description' => 'Momen ini menjadi wujud rasa syukur dan terima kasih kepada keluarga, sahabat, dan orang-orang terdekat.',
                ],
                [
                    'title' => 'Momen Bahagia',
                    'description' => 'Rayakan pencapaian kelulusan bersama keluarga dan sahabat dalam suasana yang hangat.',
                ],
                [
                    'title' => 'Doa Bersama',
                    'description' => 'Kehadiran dan doa terbaik menjadi bagian penting dari langkah baru setelah kelulusan.',
                ],
            ];

            return view('public-invitations.wisuda-simple-graduation', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'aqiqah-soft') {
            $invitation->title = 'Tasyakuran Aqiqah';
            $invitation->event_name = 'Aqiqah';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara tasyakuran aqiqah buah hati kami.';
            $invitation->location_name = 'Kediaman Keluarga';
            $invitation->address = 'Jl. Melati No. 10, Malang';
            $invitation->theme_color = 'sage';
            $invitation->seminar_about_title = 'Doa, Syukur, dan Kebahagiaan Keluarga';

            $invitation->event_highlights = [
                [
                    'title' => 'Tasyakuran Aqiqah',
                    'description' => 'Momen penuh rasa syukur atas kelahiran buah hati tercinta.',
                ],
                [
                    'title' => 'Doa Bersama',
                    'description' => 'Kehadiran keluarga dan sahabat menjadi bagian dari doa baik untuk tumbuh kembang anak.',
                ],
                [
                    'title' => 'Kebersamaan Keluarga',
                    'description' => 'Acara ini menjadi ruang hangat untuk berkumpul dan berbagi kebahagiaan.',
                ],
            ];

            return view('public-invitations.aqiqah-soft', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'aqiqah-baby-blessing') {
            $invitation->title = 'Baby Blessing Aqiqah';
            $invitation->event_name = 'Tasyakuran Aqiqah';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur dan kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara aqiqah buah hati kami.';
            $invitation->location_name = 'Kediaman Keluarga';
            $invitation->address = 'Jl. Melati No. 10, Malang';
            $invitation->theme_color = 'sage';
            $invitation->seminar_about_title = 'Doa Baik untuk Buah Hati Tercinta';

            $invitation->event_highlights = [
                [
                    'title' => 'Aqiqah Penuh Syukur',
                    'description' => 'Momen penuh rasa syukur atas hadirnya buah hati sebagai anugerah terindah dalam keluarga.',
                ],
                [
                    'title' => 'Doa dan Harapan',
                    'description' => 'Kehadiran keluarga dan sahabat menjadi bagian dari doa baik untuk tumbuh kembang anak.',
                ],
                [
                    'title' => 'Kebersamaan Keluarga',
                    'description' => 'Acara ini menjadi ruang hangat untuk berkumpul, bersilaturahmi, dan berbagi kebahagiaan.',
                ],
            ];

            return view('public-invitations.aqiqah-baby-blessing', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'aqiqah-little-prince') {
            $invitation->title = 'Aqiqah Little Prince';
            $invitation->event_name = 'Tasyakuran Aqiqah';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur dan kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara aqiqah buah hati kami.';
            $invitation->location_name = 'Kediaman Keluarga';
            $invitation->address = 'Jl. Melati No. 10, Malang';
            $invitation->theme_color = 'navy';
            $invitation->seminar_about_title = 'Doa Baik untuk Pangeran Kecil Kami';

            $invitation->event_highlights = [
                [
                    'title' => 'Aqiqah Penuh Syukur',
                    'description' => 'Momen penuh rasa syukur atas hadirnya buah hati sebagai anugerah terindah dalam keluarga.',
                ],
                [
                    'title' => 'Doa dan Harapan',
                    'description' => 'Kehadiran keluarga dan sahabat menjadi bagian dari doa baik untuk tumbuh kembang anak.',
                ],
                [
                    'title' => 'Kebersamaan Keluarga',
                    'description' => 'Acara ini menjadi ruang hangat untuk berkumpul, bersilaturahmi, dan berbagi kebahagiaan.',
                ],
            ];

            return view('public-invitations.aqiqah-little-prince', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'aqiqah-little-princess') {
            $invitation->title = 'Aqiqah Little Princess';
            $invitation->event_name = 'Tasyakuran Aqiqah';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur dan kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara aqiqah buah hati kami.';
            $invitation->location_name = 'Kediaman Keluarga';
            $invitation->address = 'Jl. Melati No. 10, Malang';
            $invitation->theme_color = 'rose';
            $invitation->seminar_about_title = 'Doa Baik untuk Putri Kecil Kami';

            $invitation->event_highlights = [
                [
                    'title' => 'Aqiqah Penuh Syukur',
                    'description' => 'Momen penuh rasa syukur atas hadirnya buah hati sebagai anugerah terindah dalam keluarga.',
                ],
                [
                    'title' => 'Doa dan Harapan',
                    'description' => 'Kehadiran keluarga dan sahabat menjadi bagian dari doa baik untuk tumbuh kembang anak.',
                ],
                [
                    'title' => 'Kebersamaan Keluarga',
                    'description' => 'Acara ini menjadi ruang hangat untuk berkumpul, bersilaturahmi, dan berbagi kebahagiaan.',
                ],
            ];

            return view('public-invitations.aqiqah-little-princess', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'aqiqah-islamic') {
            $invitation->title = 'Aqiqah Islamic';
            $invitation->event_name = 'Tasyakuran Aqiqah';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara aqiqah buah hati kami.';
            $invitation->location_name = 'Kediaman Keluarga';
            $invitation->address = 'Jl. Melati No. 10, Malang';
            $invitation->theme_color = 'emerald';
            $invitation->seminar_about_title = 'Doa dan Syukur untuk Buah Hati Tercinta';

            $invitation->event_highlights = [
                [
                    'title' => 'Aqiqah Penuh Syukur',
                    'description' => 'Momen penuh rasa syukur atas hadirnya buah hati sebagai amanah dan anugerah dari Allah SWT.',
                ],
                [
                    'title' => 'Doa Keluarga',
                    'description' => 'Kehadiran keluarga dan sahabat menjadi bagian dari doa baik untuk tumbuh kembang buah hati.',
                ],
                [
                    'title' => 'Silaturahmi Hangat',
                    'description' => 'Acara ini menjadi ruang kebersamaan untuk berbagi kebahagiaan dan mempererat silaturahmi.',
                ],
            ];

            return view('public-invitations.aqiqah-islamic', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'khitanan-ceria') {
            $invitation->title = 'Khitanan Ceria';
            $invitation->event_name = 'Tasyakuran Khitanan';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur dan kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara tasyakuran khitanan putra kami.';
            $invitation->location_name = 'Kediaman Keluarga';
            $invitation->address = 'Jl. Melati No. 10, Malang';
            $invitation->theme_color = 'emerald';
            $invitation->seminar_about_title = 'Hari Bahagia untuk Jagoan Kecil Kami';

            $invitation->event_highlights = [
                [
                    'title' => 'Tasyakuran Penuh Syukur',
                    'description' => 'Momen penuh rasa syukur atas terlaksananya khitanan ananda tercinta.',
                ],
                [
                    'title' => 'Doa dan Harapan',
                    'description' => 'Kehadiran keluarga dan sahabat menjadi bagian dari doa baik untuk tumbuh kembang ananda.',
                ],
                [
                    'title' => 'Kebersamaan Keluarga',
                    'description' => 'Acara ini menjadi ruang hangat untuk bersilaturahmi dan berbagi kebahagiaan.',
                ],
            ];

            return view('public-invitations.khitanan-ceria', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'khitanan-little-hero') {
            $invitation->title = 'Khitanan Little Hero';
            $invitation->event_name = 'Tasyakuran Khitanan';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur dan kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara tasyakuran khitanan putra kami.';
            $invitation->location_name = 'Kediaman Keluarga';
            $invitation->address = 'Jl. Melati No. 10, Malang';
            $invitation->theme_color = 'navy';
            $invitation->seminar_about_title = 'Hari Bahagia untuk Jagoan Kecil Kami';

            $invitation->event_highlights = [
                [
                    'title' => 'Tasyakuran Khitanan',
                    'description' => 'Momen penuh rasa syukur atas terlaksananya khitanan ananda tercinta.',
                ],
                [
                    'title' => 'Doa untuk Ananda',
                    'description' => 'Kehadiran keluarga dan sahabat menjadi bagian dari doa baik untuk tumbuh kembang ananda.',
                ],
                [
                    'title' => 'Little Hero Moment',
                    'description' => 'Hari bahagia untuk jagoan kecil yang penuh doa, keberanian, dan kebahagiaan keluarga.',
                ],
            ];

            return view('public-invitations.khitanan-little-hero', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'khitanan-fun-party') {
            $invitation->title = 'Khitanan Fun Party';
            $invitation->event_name = 'Tasyakuran Khitanan';
            $invitation->host_name = 'Keluarga Besar Bapak Hasan';
            $invitation->description = 'Dengan penuh rasa syukur dan kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara tasyakuran khitanan putra kami.';
            $invitation->location_name = 'Kediaman Keluarga';
            $invitation->address = 'Jl. Melati No. 10, Malang';
            $invitation->theme_color = 'gold';
            $invitation->seminar_about_title = 'Pesta Syukur yang Ceria dan Penuh Kebahagiaan';

            $invitation->event_highlights = [
                [
                    'title' => 'Tasyakuran Ceria',
                    'description' => 'Momen penuh rasa syukur atas terlaksananya khitanan ananda tercinta dengan suasana cerah dan menyenangkan.',
                ],
                [
                    'title' => 'Doa untuk Ananda',
                    'description' => 'Kehadiran keluarga dan sahabat menjadi bagian dari doa baik untuk tumbuh kembang ananda.',
                ],
                [
                    'title' => 'Fun Party Moment',
                    'description' => 'Hari bahagia yang dikemas playful, penuh warna, dan asik untuk dikenang bersama keluarga.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Alex',
                    'subtitle' => 'Jagoan Kecil',
                    'family_name' => 'Putra dari Bapak Hasan',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Bank / E-wallet',
                    'account_number' => '1234567890',
                    'account_name' => 'Keluarga Besar Bapak Hasan',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.khitanan-fun-party', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-nusantara') {
            $invitation->title = 'Aisha & Rangga';
            $invitation->event_name = 'Pernikahan';
            $invitation->host_name = 'Keluarga Besar Aisha & Rangga';
            $invitation->description = 'Dua jiwa, dua hati, dan satu tujuan. Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam hari bahagia kami.';
            $invitation->location_name = 'Upperhills Convention Hall';
            $invitation->address = 'Jl. Metro Tj. Bunga No.995, Mattoangin, Kec. Mariso, Kota Makassar';
            $invitation->theme_color = 'maroon';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Aisha Putri',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Ahmad & Ibu Siti',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Rangga Pratama',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Budi & Ibu Dewi',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Aisha Putri',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-nusantara', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-minimal-black-gold') {
            $invitation->title = 'Ivan & Fanny';
            $invitation->event_name = 'The Wedding Of';
            $invitation->host_name = 'Family & Friends';
            $invitation->description = 'Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada hari pernikahan kami.';
            $invitation->location_name = 'Grand Ballroom';
            $invitation->address = 'Jl. Contoh Alamat No. 123';
            $invitation->theme_color = 'gold';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Ivan Surya',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Surya & Ibu Hediati',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Fanny Putri',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Handoko & Ibu Melati',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Ivan Surya',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-minimal-black-gold', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-royal-javanese') {
            $invitation->title = 'Alfanov & Mutiara';
            $invitation->event_name = 'Pernikahan';
            $invitation->host_name = 'Keluarga Besar Alfanov & Mutiara';
            $invitation->description = 'Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.';
            $invitation->location_name = 'Aula Sudirman Makodam Jaya';
            $invitation->address = 'Jl. Mayjen Sutoyo No.2, Cawang, Kec. Kramat Jati, Kota Jakarta Timur';
            $invitation->theme_color = 'gold';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Alfanov Khrisma Pratama',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Ahmad & Ibu Siti',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Mutiara Ayu Lestari',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Budi & Ibu Dewi',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Alfanov Khrisma Pratama',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-royal-javanese', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'khitanan-blue') {
            $invitation->title = 'Blue Blessing Khitanan';
            $invitation->event_name = 'Tasyakuran Khitanan';
            $invitation->host_name = 'Keluarga Besar Bapak Ahmad';
            $invitation->description = 'Dengan penuh rasa syukur dan bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara tasyakuran khitanan putra kami.';
            $invitation->location_name = 'Kediaman Keluarga Ahmad';
            $invitation->address = 'Jl. Biru Harmoni No. 12, Kota Malang';
            $invitation->theme_color = 'navy';

            // Khitanan hanya offline
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;

            $invitation->seminar_about_title = 'Momen Syukur untuk Jagoan Kecil';

            $invitation->event_highlights = [
                [
                    'title' => 'Doa Keluarga',
                    'description' => 'Momen penuh doa dan rasa syukur untuk ananda tercinta.',
                ],
                [
                    'title' => 'Suasana Hangat',
                    'description' => 'Acara disusun dengan nuansa keluarga yang hangat, elegan, dan berkesan.',
                ],
                [
                    'title' => 'Tasyakuran Khitanan',
                    'description' => 'Mengundang keluarga dan sahabat untuk hadir serta memberikan doa terbaik.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Alex Pratama',
                    'subtitle' => 'Ananda',
                    'family_name' => 'Putra dari Bapak Ahmad & Ibu Rina',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Bank / E-wallet',
                    'account_number' => '1234567890',
                    'account_name' => 'Keluarga Ahmad',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.khitanan-blue', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'khitanan-islamic') {
            $invitation->title = 'Tasyakuran Khitanan Ananda';
            $invitation->event_name = 'Tasyakuran Khitanan';
            $invitation->host_name = 'Keluarga Besar Bapak Ahmad';
            $invitation->description = 'Dengan penuh rasa syukur kepada Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa terbaik dalam acara tasyakuran khitanan putra kami.';
            $invitation->location_name = 'Kediaman Keluarga Ahmad';
            $invitation->address = 'Jl. Masjid Raya No. 12, Kota Malang';
            $invitation->theme_color = 'slate';

            // Khitanan hanya offline
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;

            $invitation->seminar_about_title = 'Doa, Syukur, dan Keberkahan untuk Ananda';

            $invitation->event_highlights = [
                [
                    'title' => 'Doa Keluarga',
                    'description' => 'Momen penuh doa dan rasa syukur untuk ananda tercinta.',
                ],
                [
                    'title' => 'Nuansa Islami',
                    'description' => 'Desain undangan dibuat lembut, elegan, dan bernuansa islami.',
                ],
                [
                    'title' => 'Tasyakuran Khitanan',
                    'description' => 'Mengundang keluarga dan sahabat untuk hadir serta memberikan doa terbaik.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Muhammad Al Fatih',
                    'subtitle' => 'Ananda',
                    'family_name' => 'Putra dari Bapak Ahmad & Ibu Rina',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Bank / E-wallet',
                    'account_number' => '1234567890',
                    'account_name' => 'Keluarga Ahmad',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.khitanan-islamic', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'corporate-launch') {
            $invitation->title = 'Grand Product Launch 2026';
            $invitation->event_name = 'Corporate Launch';
            $invitation->host_name = 'Spektakuler Creative Group';
            $invitation->description = 'Kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam momen peluncuran produk dan inovasi terbaru yang dirancang untuk membuka peluang kolaborasi, networking, dan pertumbuhan bisnis.';
            $invitation->seminar_about_title = 'Launch Moment untuk Inovasi, Kolaborasi, dan Pertumbuhan Bisnis';
            $invitation->location_name = 'Online via Zoom Meeting';
            $invitation->address = 'Link online akan dibagikan kepada peserta terdaftar.';
            $invitation->maps_url = null;
            $invitation->theme_color = 'navy';

            // Corporate boleh online/offline.
            // Untuk preview dibuat online agar tombol Join Online terlihat.
            $invitation->event_mode = 'online';
            $invitation->online_url = 'https://meet.google.com/preview-launch';

            $invitation->event_highlights = [
                [
                    'title' => 'Product Reveal',
                    'description' => 'Sesi peluncuran produk, layanan, atau brand terbaru dengan visual yang modern dan premium.',
                ],
                [
                    'title' => 'Business Insight',
                    'description' => 'Paparan strategi, visi, dan peluang kolaborasi bersama stakeholder dan partner.',
                ],
                [
                    'title' => 'Networking Session',
                    'description' => 'Momen untuk memperluas koneksi bisnis, komunitas, investor, dan calon pelanggan.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Raka Pratama',
                    'subtitle' => 'Chief Executive Officer',
                    'family_name' => 'Opening Keynote',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Head of Product',
                    'family_name' => 'Product Presenter',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Arman Wijaya',
                    'subtitle' => 'Partnership Lead',
                    'family_name' => 'Business Collaboration',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Official Partner / Support',
                    'account_number' => 'Partnership Desk',
                    'account_name' => 'Spektakuler Creative Group',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.corporate-launch', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'corporate-business-opening') {
            $invitation->title = 'Grand Opening Business Center';
            $invitation->event_name = 'Business Opening';
            $invitation->host_name = 'Nusantara Creative Group';

            $invitation->description = 'Kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara pembukaan bisnis sebagai momen awal kolaborasi, pelayanan, dan pertumbuhan baru bersama pelanggan, partner, dan relasi profesional.';

            $invitation->seminar_about_title = 'Opening Ceremony & Business Networking';

            $invitation->location_name = 'Nusantara Business Center';
            $invitation->address = 'Jl. Merdeka Bisnis No. 10, Kota Malang';
            $invitation->maps_url = null;

            $invitation->theme_color = 'navy';

            // Corporate boleh online/offline.
            // Preview dibuat offline agar suasana opening venue terlihat.
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;

            $invitation->event_highlights = [
                [
                    'title' => 'Opening Ceremony',
                    'description' => 'Momen pembukaan resmi bisnis, cabang, kantor, toko, showroom, atau layanan baru.',
                ],
                [
                    'title' => 'Business Introduction',
                    'description' => 'Perkenalan konsep, layanan, nilai bisnis, dan arah kolaborasi bersama pelanggan serta partner.',
                ],
                [
                    'title' => 'Networking Session',
                    'description' => 'Kesempatan membangun relasi profesional bersama tamu undangan, partner, dan calon pelanggan.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Raka Pratama',
                    'subtitle' => 'Founder / Director',
                    'family_name' => 'Opening Representative',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Business Manager',
                    'family_name' => 'Guest Relations',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Contact / Partnership',
                    'account_number' => '+62 812-0000-0000',
                    'account_name' => 'Nusantara Creative Group',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.corporate-business-opening', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'corporate-product-launch') {
            $invitation->title = 'NextGen Product Launch';
            $invitation->event_name = 'Product Launch';
            $invitation->host_name = 'Nusantara Innovation Group';

            $invitation->description = 'Kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara peluncuran produk terbaru sebagai momen perkenalan inovasi, demo produk, insight bisnis, dan peluang kolaborasi bersama pelanggan, partner, serta relasi profesional.';

            $invitation->seminar_about_title = 'Product Reveal & Launch Experience';

            $invitation->location_name = 'Online Product Showcase';
            $invitation->address = 'Link online akan dibagikan kepada peserta terdaftar.';
            $invitation->maps_url = null;

            $invitation->theme_color = 'gold';

            // Corporate Product Launch bisa online/offline.
            // Preview dibuat online agar tombol Join Online terlihat.
            $invitation->event_mode = 'online';
            $invitation->online_url = 'https://meet.google.com/product-launch-preview';

            $invitation->event_highlights = [
                [
                    'title' => 'Product Reveal',
                    'description' => 'Momen perkenalan produk, fitur utama, value proposition, atau inovasi terbaru kepada audiens.',
                ],
                [
                    'title' => 'Live Demo',
                    'description' => 'Sesi demonstrasi produk, cara penggunaan, benefit, dan pengalaman pengguna secara langsung.',
                ],
                [
                    'title' => 'Market Insight',
                    'description' => 'Paparan peluang pasar, strategi peluncuran, kolaborasi bisnis, dan sesi networking profesional.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Raka Pratama',
                    'subtitle' => 'Chief Product Officer',
                    'family_name' => 'Product Keynote',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Product Manager',
                    'family_name' => 'Live Demo Session',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Arman Wijaya',
                    'subtitle' => 'Business Development Lead',
                    'family_name' => 'Partnership & Market Insight',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Product Info / Partnership',
                    'account_number' => 'product@company.com',
                    'account_name' => 'Nusantara Innovation Group',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.corporate-product-launch', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'corporate-company-gathering') {
            $invitation->title = 'Annual Company Gathering 2026';
            $invitation->event_name = 'Company Gathering';
            $invitation->host_name = 'Nusantara Creative Group';

            $invitation->description = 'Kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara company gathering sebagai momen kebersamaan, apresiasi, kolaborasi, dan penguatan hubungan antar tim, partner, serta keluarga besar perusahaan.';

            $invitation->seminar_about_title = 'Gathering Moment & Team Appreciation';

            $invitation->location_name = 'Nusantara Grand Ballroom';
            $invitation->address = 'Jl. Harmoni Bisnis No. 12, Kota Malang';
            $invitation->maps_url = null;

            $invitation->theme_color = 'slate';

            // Corporate boleh online/offline.
            // Preview dibuat offline agar suasana gathering venue terlihat.
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;

            $invitation->event_highlights = [
                [
                    'title' => 'Team Appreciation',
                    'description' => 'Momen apresiasi untuk tim, karyawan, partner, atau pihak yang berkontribusi dalam perjalanan perusahaan.',
                ],
                [
                    'title' => 'Togetherness Session',
                    'description' => 'Sesi kebersamaan, ramah tamah, makan bersama, hiburan, atau aktivitas internal perusahaan.',
                ],
                [
                    'title' => 'Networking & Collaboration',
                    'description' => 'Kesempatan mempererat relasi profesional antar divisi, partner, tamu undangan, dan keluarga besar perusahaan.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Raka Pratama',
                    'subtitle' => 'Chief Executive Officer',
                    'family_name' => 'Opening Speech',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Human Capital Lead',
                    'family_name' => 'Gathering Coordinator',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Arman Wijaya',
                    'subtitle' => 'Event Relations',
                    'family_name' => 'Guest & Partner Relations',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Gathering Info / Contact Desk',
                    'account_number' => '+62 812-0000-0000',
                    'account_name' => 'Nusantara Creative Group',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.corporate-company-gathering', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'corporate-formal-invitation') {
            $invitation->title = 'Executive Formal Invitation';
            $invitation->event_name = 'Corporate Formal Event';
            $invitation->host_name = 'Nusantara Executive Group';

            $invitation->description = 'Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara corporate formal yang dirancang elegan, profesional, dan informatif sebagai bagian dari momen penting perusahaan, institusi, maupun organisasi.';

            $invitation->seminar_about_title = 'Formal Agenda & Executive Session';

            $invitation->location_name = 'Nusantara Executive Hall';
            $invitation->address = 'Jl. Sudirman Business District No. 21, Jakarta';
            $invitation->maps_url = null;

            $invitation->theme_color = 'slate';

            // Corporate boleh online/offline.
            // Preview dibuat offline agar nuansa undangan formal terlihat.
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;

            $invitation->event_highlights = [
                [
                    'title' => 'Formal Opening',
                    'description' => 'Pembukaan acara secara resmi dengan suasana profesional, rapi, dan berkesan.',
                ],
                [
                    'title' => 'Executive Session',
                    'description' => 'Sesi utama untuk penyampaian informasi, arahan, presentasi, atau agenda strategis perusahaan.',
                ],
                [
                    'title' => 'Professional Networking',
                    'description' => 'Kesempatan membangun relasi formal bersama tamu undangan, partner, stakeholder, dan jajaran perusahaan.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Raka Pratama',
                    'subtitle' => 'Chief Executive Officer',
                    'family_name' => 'Keynote Representative',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Corporate Secretary',
                    'family_name' => 'Formal Event Coordinator',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Arman Wijaya',
                    'subtitle' => 'Public Relations Lead',
                    'family_name' => 'Guest Relations',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Corporate Contact Desk',
                    'account_number' => 'contact@company.com',
                    'account_name' => 'Nusantara Executive Group',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.corporate-formal-invitation', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'corporate-startup-event') {
            $invitation->title = 'Startup Growth Day';
            $invitation->event_name = 'Corporate Startup Event';
            $invitation->host_name = 'Nusantara Startup Lab';

            $invitation->description = 'Kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara startup yang penuh energi, kolaborasi, pitch session, networking, dan momen pertumbuhan bersama tim, partner, investor, serta komunitas kreatif.';

            $invitation->seminar_about_title = 'Startup Agenda & Pitch Session';

            $invitation->location_name = 'Nusantara Innovation Hub';
            $invitation->address = 'Jl. Startup Kreatif No. 8, Kota Malang';
            $invitation->maps_url = null;

            $invitation->theme_color = 'navy';

            // Corporate boleh online/offline.
            // Preview dibuat online agar kesan startup digital lebih terasa.
            $invitation->event_mode = 'online';
            $invitation->online_url = 'https://meet.google.com/startup-event-preview';

            $invitation->event_highlights = [
                [
                    'title' => 'Pitch Session',
                    'description' => 'Sesi presentasi ide, produk, layanan, atau inovasi startup kepada audiens, partner, investor, dan komunitas.',
                ],
                [
                    'title' => 'Growth Talk',
                    'description' => 'Sesi insight tentang pertumbuhan bisnis, strategi branding, market fit, kolaborasi, dan pengembangan startup.',
                ],
                [
                    'title' => 'Networking Session',
                    'description' => 'Kesempatan membangun relasi bersama founder, mentor, investor, partner, komunitas, dan tim kreatif.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Raka Pratama',
                    'subtitle' => 'Founder & CEO',
                    'family_name' => 'Opening Talk / Startup Vision',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Growth Strategist',
                    'family_name' => 'Growth Talk / Community Session',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Arman Wijaya',
                    'subtitle' => 'Product Lead',
                    'family_name' => 'Product Demo / Pitch Session',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Startup Contact / Partnership',
                    'account_number' => 'startup@company.com',
                    'account_name' => 'Nusantara Startup Lab',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.corporate-startup-event', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'corporate-grand-opening-pro') {
            $invitation->title = 'Prestige Grand Opening';
            $invitation->event_name = 'Grand Opening Ceremony';
            $invitation->host_name = 'Nusantara Premier Group';

            $invitation->description = 'Kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara grand opening sebagai momen pembukaan resmi, perkenalan layanan, networking, dan awal kolaborasi profesional.';

            $invitation->seminar_about_title = 'Grand Opening Agenda';

            $invitation->location_name = 'Nusantara Premier Hall';
            $invitation->address = 'Jl. Merdeka No. 88, Jakarta';
            $invitation->maps_url = null;

            $invitation->theme_color = 'gold';

            // Corporate Grand Opening Pro bisa online/offline.
            // Untuk preview dibuat offline agar nuansa grand opening venue terlihat.
            $invitation->event_mode = 'offline';
            $invitation->online_url = 'https://meet.google.com/grand-opening-pro';

            $invitation->event_highlights = [
                [
                    'title' => 'Opening Ceremony',
                    'description' => 'Momen pembukaan resmi bisnis, kantor, showroom, cabang, layanan, atau brand baru dengan suasana profesional dan elegan.',
                ],
                [
                    'title' => 'Business Introduction',
                    'description' => 'Sesi perkenalan profil perusahaan, layanan utama, visi bisnis, dan arah kolaborasi bersama tamu undangan.',
                ],
                [
                    'title' => 'Professional Networking',
                    'description' => 'Kesempatan membangun relasi bersama partner, pelanggan, stakeholder, investor, dan relasi bisnis profesional.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Raka Pratama',
                    'subtitle' => 'Chief Executive Officer',
                    'family_name' => 'Opening Representative',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Business Director',
                    'family_name' => 'Grand Opening Host',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Arman Wijaya',
                    'subtitle' => 'Partnership Lead',
                    'family_name' => 'Guest & Partner Relations',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Grand Opening Contact / Partnership',
                    'account_number' => '+62 812-0000-0000',
                    'account_name' => 'Nusantara Premier Group',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.corporate-grand-opening-pro', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'corporate-award-night') {
            $invitation->title = 'The Prestige Award Night';
            $invitation->event_name = 'Gala Award Ceremony';
            $invitation->host_name = 'Nusantara Excellence Group';

            $invitation->description = 'Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri malam penghargaan eksklusif sebagai bentuk apresiasi atas pencapaian, dedikasi, kolaborasi, dan kontribusi terbaik dalam suasana gala yang mewah dan berkelas.';

            $invitation->seminar_about_title = 'Award Night Agenda';

            $invitation->event_date = now()->addMonths(2)->format('Y-m-d');
            $invitation->event_time = '19:00';
            $invitation->event_end_time = '22:30';

            $invitation->location_name = 'Nusantara Grand Ballroom';
            $invitation->address = 'Jl. Sudirman No. 88, Jakarta';
            $invitation->maps_url = 'https://maps.google.com/?q=Nusantara+Grand+Ballroom';

            $invitation->theme_color = 'gold';

            // Template ini bisa online/offline.
            // Untuk preview dibuat offline agar nuansa gala ballroom terlihat.
            $invitation->event_mode = 'offline';
            $invitation->online_url = 'https://meet.google.com/award-night-preview';

            $invitation->event_highlights = [
                [
                    'title' => 'Red Carpet Session',
                    'description' => 'Momen penyambutan tamu, dokumentasi, dan sesi pembuka dengan nuansa gala yang elegan dan eksklusif.',
                ],
                [
                    'title' => 'Award Presentation',
                    'description' => 'Sesi pemberian penghargaan untuk individu, tim, partner, atau pihak yang memberikan kontribusi terbaik.',
                ],
                [
                    'title' => 'Gala Networking',
                    'description' => 'Kesempatan membangun relasi profesional dalam suasana malam penghargaan yang mewah dan berkelas.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Adrian Pratama',
                    'subtitle' => 'Chief Executive Officer',
                    'family_name' => 'Award Night Host',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Creative Director',
                    'family_name' => 'Gala Ceremony Lead',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Rafael Wijaya',
                    'subtitle' => 'Partnership Director',
                    'family_name' => 'Guest Relations',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Award Night Contact / Partnership',
                    'account_number' => '+62 812-0000-0000',
                    'account_name' => 'Nusantara Excellence Group',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.corporate-award-night', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'corporate-networking-night') {
            $invitation->title = 'Executive Networking Night';
            $invitation->event_name = 'Corporate Networking Night';
            $invitation->host_name = 'Nusantara Business Network';

            $invitation->description = 'Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara networking night sebagai ruang pertemuan profesional, pertukaran insight bisnis, koneksi strategis, dan peluang kolaborasi dalam suasana modern dan elegan.';

            $invitation->seminar_about_title = 'Networking Agenda';

            $invitation->event_date = now()->addMonths(2)->format('Y-m-d');
            $invitation->event_time = '19:00';
            $invitation->event_end_time = '22:00';

            $invitation->location_name = 'Nusantara Executive Lounge';
            $invitation->address = 'Jl. Sudirman No. 88, Jakarta';
            $invitation->maps_url = 'https://maps.google.com/?q=Nusantara+Executive+Lounge';

            $invitation->theme_color = 'navy';

            // Template ini bisa online/offline.
            // Untuk preview dibuat offline agar suasana networking venue terlihat.
            $invitation->event_mode = 'offline';
            $invitation->online_url = 'https://meet.google.com/networking-night-preview';

            $invitation->event_highlights = [
                [
                    'title' => 'Business Networking',
                    'description' => 'Sesi membangun koneksi profesional bersama pelaku bisnis, partner, stakeholder, dan komunitas corporate.',
                ],
                [
                    'title' => 'Market Insight Session',
                    'description' => 'Diskusi ringan tentang peluang pasar, tren industri, strategi kolaborasi, dan insight bisnis terkini.',
                ],
                [
                    'title' => 'Strategic Collaboration',
                    'description' => 'Momen untuk membuka peluang kerja sama, memperluas jaringan, dan membangun relasi bisnis yang berkelanjutan.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Raka Pratama',
                    'subtitle' => 'Business Network Lead',
                    'family_name' => 'Networking Host',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Partnership Director',
                    'family_name' => 'Strategic Relations',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Arman Wijaya',
                    'subtitle' => 'Market Analyst',
                    'family_name' => 'Insight Speaker',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Networking Contact / Partnership',
                    'account_number' => '+62 812-0000-0000',
                    'account_name' => 'Nusantara Business Network',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.corporate-networking-night', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'corporate-business-seminar') {
            $invitation->title = 'Executive Business Seminar';
            $invitation->event_name = 'Corporate Business Seminar';
            $invitation->host_name = 'Nusantara Business Institute';

            $invitation->description = 'Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam seminar bisnis profesional sebagai ruang berbagi wawasan, strategi, relasi, dan peluang kolaborasi dalam suasana corporate yang elegan.';

            $invitation->seminar_about_title = 'Business Seminar Agenda';

            $invitation->event_date = now()->addMonths(2)->format('Y-m-d');
            $invitation->event_time = '09:00';
            $invitation->event_end_time = '12:30';

            $invitation->location_name = 'Nusantara Business Hall';
            $invitation->address = 'Jl. Sudirman No. 88, Jakarta';
            $invitation->maps_url = 'https://maps.google.com/?q=Nusantara+Business+Hall';

            $invitation->theme_color = 'navy';

            // Template ini mendukung online/offline.
            // Preview dibuat offline agar tampilan venue seminar terlihat.
            $invitation->event_mode = 'offline';
            $invitation->online_url = 'https://meet.google.com/business-seminar-preview';

            $invitation->event_highlights = [
                [
                    'title' => 'Business Insight',
                    'description' => 'Sesi pembahasan strategi bisnis, tren industri, pengembangan pasar, dan peluang pertumbuhan perusahaan.',
                ],
                [
                    'title' => 'Professional Discussion',
                    'description' => 'Diskusi bersama pembicara, peserta, partner, atau stakeholder mengenai topik bisnis yang relevan dan aplikatif.',
                ],
                [
                    'title' => 'Networking Session',
                    'description' => 'Kesempatan membangun relasi profesional, memperluas koneksi, dan membuka peluang kolaborasi bisnis.',
                ],
            ];

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Raka Pratama',
                    'subtitle' => 'Business Strategy Speaker',
                    'family_name' => 'Seminar Keynote Speaker',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Nadia Kirana',
                    'subtitle' => 'Corporate Development Lead',
                    'family_name' => 'Panel Discussion Moderator',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Arman Wijaya',
                    'subtitle' => 'Market Analyst',
                    'family_name' => 'Business Insight Contributor',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Seminar Contact / Partnership',
                    'account_number' => '+62 812-0000-0000',
                    'account_name' => 'Nusantara Business Institute',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.corporate-business-seminar', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-golden-romance') {
            $invitation->title = 'Putri & Alex';
            $invitation->event_name = 'The Wedding Of';
            $invitation->host_name = 'Keluarga Besar Putri & Alex';

            $invitation->description = 'Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan acara pernikahan putra-putri kami. Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.';

            $invitation->event_date = now()->addMonths(5)->format('Y-m-d');
            $invitation->event_time = '10:00';
            $invitation->event_end_time = '13:00';

            $invitation->location_name = 'Golden Palace Wedding Hall';
            $invitation->address = 'Jl. Mawar Indah No. 18, Jakarta';
            $invitation->maps_url = 'https://maps.google.com/?q=Golden+Palace+Wedding+Hall';

            // Pernikahan hanya offline, template tidak menampilkan mode.
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;

            // Tema warna
            $invitation->theme_color = 'gold';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Putri',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Akbar & Ibu Siti',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Alex',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Budi & Ibu Dewi',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'BCA',
                    'account_number' => '1234567890',
                    'account_name' => 'Putri',
                ],
                (object) [
                    'label' => 'Mandiri',
                    'account_number' => '0987654321',
                    'account_name' => 'Alex',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-golden-romance', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-elegant-white') {
            $invitation->title = 'Aurelia & Naufal';
            $invitation->event_name = 'The Wedding Of';
            $invitation->host_name = 'Keluarga Besar Aurelia & Naufal';

            $invitation->description = 'Dengan penuh rasa syukur dan kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada hari pernikahan kami.';

            $invitation->event_date = now()->addMonths(5)->format('Y-m-d');
            $invitation->event_time = '10:00';
            $invitation->event_end_time = '13:00';

            $invitation->location_name = 'White Orchid Ballroom';
            $invitation->address = 'Jl. Melati Putih No. 18, Jakarta';
            $invitation->maps_url = 'https://maps.google.com/?q=White+Orchid+Ballroom';

            // Pernikahan hanya offline, template tidak menampilkan mode.
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;

            // Bisa diganti: maroon, emerald, navy, rose, gold, slate
            $invitation->theme_color = 'slate';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Aurelia Putri',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Akbar & Ibu Siti',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Naufal Pratama',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Budi & Ibu Dewi',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'BCA',
                    'account_number' => '1234567890',
                    'account_name' => 'Aurelia Putri',
                ],
                (object) [
                    'label' => 'Mandiri',
                    'account_number' => '0987654321',
                    'account_name' => 'Naufal Pratama',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-elegant-white', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-floral-love') {
            $invitation->title = 'Nayla & Arkan';
            $invitation->event_name = 'The Wedding Of';
            $invitation->host_name = 'Keluarga Besar Nayla & Arkan';

            $invitation->description = 'Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan acara pernikahan putra-putri kami. Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.';

            $invitation->event_date = now()->addMonths(5)->format('Y-m-d');
            $invitation->event_time = '10:00';
            $invitation->event_end_time = '13:00';

            $invitation->location_name = 'Floral Garden Wedding Hall';
            $invitation->address = 'Jl. Melati Indah No. 21, Jakarta';
            $invitation->maps_url = 'https://maps.google.com/?q=Floral+Garden+Wedding+Hall';

            // Pernikahan hanya offline, template tidak menampilkan mode.
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;

            // Tetap mendukung 6 tema warna editor:
            // maroon, emerald, navy, rose, gold, slate
            $invitation->theme_color = 'gold';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Nayla Putri',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Akbar & Ibu Siti',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Arkan Pratama',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Budi & Ibu Dewi',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'BCA',
                    'account_number' => '1234567890',
                    'account_name' => 'Nayla Putri',
                ],
                (object) [
                    'label' => 'Mandiri',
                    'account_number' => '0987654321',
                    'account_name' => 'Arkan Pratama',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-floral-love', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-rustic-garden') {
            $invitation->title = 'Putri & Alex';
            $invitation->event_name = 'Pernikahan';
            $invitation->host_name = 'Keluarga Besar';
            $invitation->description = 'Dengan penuh sukacita, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada hari bahagia kami.';
            $invitation->event_date = Carbon::now()->addDays(45);
            $invitation->event_time = '10:00';
            $invitation->event_end_date = null;
            $invitation->event_end_time = '13:00';
            $invitation->location_name = 'Greenhouse Garden Hall';
            $invitation->address = 'Jl. Taman Bunga No. 20, Jakarta';
            $invitation->maps_url = null;
            $invitation->theme_color = 'emerald';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Putri',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Putra & Ibu Sari',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Alex',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Alex & Ibu Maya',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Bank / E-wallet',
                    'account_number' => '1234567890',
                    'account_name' => 'Putri',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-rustic-garden', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-green-garden') {
            $invitation->title = 'Budian & Putri';
            $invitation->event_name = 'The Wedding Of';
            $invitation->host_name = 'Keluarga Besar';
            $invitation->description = 'Dengan penuh sukacita, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada hari bahagia kami.';
            $invitation->event_date = Carbon::now()->addDays(60);
            $invitation->event_time = '10:00';
            $invitation->event_end_date = null;
            $invitation->event_end_time = '13:00';
            $invitation->location_name = 'Green Garden Hall';
            $invitation->address = 'Jl. Garden Lake No. 22, Jakarta';
            $invitation->maps_url = null;
            $invitation->cover_image = null;
            $invitation->music_url = null;
            $invitation->theme_color = 'emerald';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Budian',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Alex & Ibu Ayu',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Putri',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Putra & Ibu Sari',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Budian & Putri',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-green-garden', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-classic-letter') {
            $invitation->title = 'Theodorus & Evelyn';
            $invitation->event_name = 'Pernikahan';
            $invitation->host_name = 'Keluarga Besar';
            $invitation->description = 'Atas puji Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan acara pernikahan kami dan mengundang Bapak/Ibu/Saudara/i untuk hadir memberikan doa restu.';
            $invitation->event_date = Carbon::now()->addDays(50);
            $invitation->event_time = '13:00';
            $invitation->event_end_date = null;
            $invitation->event_end_time = '16:00';
            $invitation->location_name = 'Kanisius Chapel';
            $invitation->address = 'Jl. Raya Kupang Indah No. 15, Dukuh Kupang, Surabaya';
            $invitation->maps_url = null;
            $invitation->cover_image = null;
            $invitation->music_url = null;
            $invitation->theme_color = 'gold';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Theo',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak & Ibu Ida',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Evelyn',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari keluarga tercinta',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Theodorus & Evelyn',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-classic-letter', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-luxury-maroon') {
            $invitation->title = 'Alex & Putri';
            $invitation->event_name = 'The Wedding Of';
            $invitation->host_name = 'Keluarga Besar';
            $invitation->description = 'Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.';
            $invitation->event_date = Carbon::now()->addDays(70);
            $invitation->event_time = '08:00';
            $invitation->event_end_date = null;
            $invitation->event_end_time = '12:00';
            $invitation->location_name = 'Kediaman Mempelai Wanita';
            $invitation->address = 'Jl. Gatot Subroto GG Putri Ayu VI No. 14, Bawah';
            $invitation->maps_url = null;
            $invitation->cover_image = null;
            $invitation->music_url = null;
            $invitation->theme_color = 'maroon';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Putri',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri pertama dari Bapak Akbar & Ibu Siti',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Alex',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari keluarga tercinta',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Putri & Alex',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-luxury-maroon', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-vintage-romance') {
            $invitation->title = 'Franciskus & Kristina';
            $invitation->event_name = 'The Wedding Of';
            $invitation->host_name = 'Keluarga Besar';
            $invitation->description = 'By the grace and blessing of God, we request the honour of your presence at our wedding.';
            $invitation->event_date = Carbon::now()->addDays(80);
            $invitation->event_time = '12:30';
            $invitation->event_end_date = null;
            $invitation->event_end_time = '14:00';
            $invitation->location_name = 'Krakatau Room';
            $invitation->address = 'Grand Hyatt Hotel Jakarta, Jl. M. H. Thamrin Kav. 28-30, Gondangdia, Menteng, Jakarta Pusat';
            $invitation->maps_url = null;
            $invitation->cover_image = null;
            $invitation->music_url = null;
            $invitation->theme_color = 'maroon';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Franciskus',
                    'subtitle' => 'Groom',
                    'family_name' => 'The second son of beloved family',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Kristina',
                    'subtitle' => 'Bride',
                    'family_name' => 'The daughter of beloved family',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Franciskus & Kristina',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-vintage-romance', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-peach-blossom') {
            $invitation->title = ' Putri & Alex';
            $invitation->event_name = 'The Wedding Of';
            $invitation->description = 'By the grace and blessing of God, we request the honour of your presence at our wedding.';
            $invitation->event_date = \Illuminate\Support\Carbon::parse('2025-10-19');
            $invitation->event_time = '09:00';
            $invitation->event_end_date = null;
            $invitation->event_end_time = '11:00';
            $invitation->location_name = 'St. Yohanes Penginjil Church';
            $invitation->address = 'Jl. Melawai Raya No. 197, RT. 01 / RW. 06, Kramat Pela, Kebayoran Baru';
            $invitation->theme_color = 'rose';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Putri',
                    'subtitle' => 'Bride',
                    'family_name' => 'The Daughter of beloved family',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Alex',
                    'subtitle' => 'Groom',
                    'family_name' => 'The Son of beloved family',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Putri & Alex',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-peach-blossom', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-batik-elegance') {
            $invitation->title = 'Rama & Sinta';
            $invitation->event_name = 'The Wedding Of';
            $invitation->description = 'Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir memberikan doa restu pada hari bahagia kami.';
            $invitation->event_date = \Illuminate\Support\Carbon::parse('2025-11-22');
            $invitation->event_time = '10:00';
            $invitation->event_end_date = null;
            $invitation->event_end_time = '13:00';
            $invitation->location_name = 'Pendopo Batik Heritage';
            $invitation->address = 'Jl. Batik Elegance No. 12, Yogyakarta';
            $invitation->theme_color = 'maroon';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Rama',
                    'subtitle' => 'Groom',
                    'family_name' => 'Putra dari keluarga tercinta',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Sinta',
                    'subtitle' => 'Bride',
                    'family_name' => 'Putri dari keluarga tercinta',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Rama & Sinta',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-batik-elegance', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-modern-couple') {
            $invitation->title = 'Imran & Zara';
            $invitation->event_name = 'The Wedding Of';
            $invitation->description = 'With love and happiness, we invite you to celebrate our wedding day.';
            $invitation->event_date = \Illuminate\Support\Carbon::parse('2026-08-15');
            $invitation->event_time = '10:00';
            $invitation->event_end_date = null;
            $invitation->event_end_time = '13:00';
            $invitation->location_name = 'Royal Palace Wedding Hall';
            $invitation->address = 'Jl. Palace Garden No. 21, Jakarta';
            $invitation->theme_color = 'navy';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Imran',
                    'subtitle' => 'Groom',
                    'family_name' => 'The son of beloved family',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Zara',
                    'subtitle' => 'Bride',
                    'family_name' => 'The daughter of beloved family',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Imran & Zara',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-modern-couple', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-emerald-wedding') {
            $invitation->title = 'Putri & Alex';
            $invitation->event_name = 'The Wedding of';
            $invitation->description = 'Maha Suci Allah yang telah menciptakan makhluk-Nya berpasang-pasangan. Ya Allah semoga ridho-Mu tercurah mengiringi pernikahan kami.';
            $invitation->event_date = \Illuminate\Support\Carbon::parse('2026-12-31');
            $invitation->event_time = '08:00';
            $invitation->event_end_date = null;
            $invitation->event_end_time = null;
            $invitation->location_name = 'Auditorium Masjid';
            $invitation->address = 'Jalan Raya Bojong Sari No. 5, Gunung Putri, Citeureup, Bogor, Jawa Barat';
            $invitation->theme_color = 'emerald';

            $people = collect([
                (object) [
                    'photo' => null,
                    'image' => null,
                    'name' => 'Putri',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Ahmad & Ibu Siti',
                    'instagram' => null,
                ],
                (object) [
                    'photo' => null,
                    'image' => null,
                    'name' => 'Alex',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Budi & Ibu Dewi',
                    'instagram' => null,
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Putri & Alex',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-emerald-wedding', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-soft-sakura') {
            $invitation->title = 'Alex & Putri';
            $invitation->event_name = 'The Wedding Of';
            $invitation->description = 'Dengan penuh rasa bahagia, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada hari pernikahan kami.';
            $invitation->event_date = \Illuminate\Support\Carbon::parse('2026-02-22');
            $invitation->event_time = '10:00';
            $invitation->event_end_date = null;
            $invitation->event_end_time = '13:00';
            $invitation->location_name = 'Sakura Garden Hall';
            $invitation->address = 'Jl. Garden Sakura No. 22, Jakarta';
            $invitation->maps_url = null;

            // Tetap pakai 6 tema bawaan, pilih rose untuk default soft sakura
            $invitation->theme_color = 'rose';

            $people = collect([
                (object) [
                    'photo' => null,
                    'image' => null,
                    'name' => 'Alex',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Budi & Ibu Dewi',
                    'instagram' => null,
                ],
                (object) [
                    'photo' => null,
                    'image' => null,
                    'name' => 'Putri',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Ahmad & Ibu Siti',
                    'instagram' => null,
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Alex & Putri',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-soft-sakura', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-ocean-love') {
            $invitation->title = 'Imran & Zoya';
            $invitation->event_name = 'The Wedding Of';
            $invitation->host_name = 'Keluarga Besar Imran & Zoya';

            $invitation->description = 'With the blessing of God, we invite you to celebrate our wedding day in a beautiful ocean palace atmosphere.';

            $invitation->event_date = \Illuminate\Support\Carbon::parse('2026-09-20');
            $invitation->event_time = '10:00';
            $invitation->event_end_date = null;
            $invitation->event_end_time = '13:00';

            $invitation->location_name = 'Ocean Palace Wedding Hall';
            $invitation->address = 'Jl. Ocean Palace Garden No. 21, Jakarta';
            $invitation->maps_url = null;

            // Tetap pakai 6 tema bawaan editor
            $invitation->theme_color = 'navy';

            // Pernikahan hanya offline
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;

            $people = collect([
                (object) [
                    'photo' => null,
                    'image' => null,
                    'name' => 'Imran',
                    'subtitle' => 'Groom',
                    'family_name' => 'The son of beloved family',
                    'instagram' => null,
                ],
                (object) [
                    'photo' => null,
                    'image' => null,
                    'name' => 'Zoya',
                    'subtitle' => 'Bride',
                    'family_name' => 'The daughter of beloved family',
                    'instagram' => null,
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'Wedding Gift',
                    'account_number' => '1234567890',
                    'account_name' => 'Imran & Zoya',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-ocean-love', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-pastel-wedding') {
            $invitation->title = 'Aurelia & Naufal';
            $invitation->event_name = 'The Wedding Of';
            $invitation->host_name = 'Keluarga Besar Aurelia & Naufal';

            $invitation->description = 'Dengan penuh rasa syukur dan kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada hari pernikahan kami.';

            $invitation->event_date = Carbon::now()->addDays(58);
            $invitation->event_time = '10:00';
            $invitation->event_end_date = null;
            $invitation->event_end_time = '13:00';

            $invitation->location_name = 'Pastel Garden Wedding Hall';
            $invitation->address = 'Jl. Sakura Pastel No. 18, Jakarta';
            $invitation->maps_url = null;

            $invitation->cover_image = null;
            $invitation->music_url = null;

            // Pernikahan hanya offline.
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;

            // Tetap memakai 6 warna bawaan editor: maroon, emerald, navy, rose, gold, slate.
            $invitation->theme_color = 'rose';

            $people = collect([
                (object) [
                    'photo' => null,
                    'name' => 'Aurelia Putri',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Ahmad & Ibu Sinta',
                ],
                (object) [
                    'photo' => null,
                    'name' => 'Naufal Pratama',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Budi & Ibu Dewi',
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'BCA',
                    'account_number' => '1234567890',
                    'account_name' => 'Aurelia Putri',
                ],
                (object) [
                    'label' => 'Mandiri',
                    'account_number' => '0987654321',
                    'account_name' => 'Naufal Pratama',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-pastel-wedding', compact('invitation', 'mapData'));
        }

        if ($template->view_name === 'wedding-simple-nikah') {
            $invitation->title = 'Justin & Sisca';
            $invitation->event_name = 'The Wedding Of';
            $invitation->host_name = 'Keluarga Besar Justin & Sisca';

            $invitation->description = 'Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan pernikahan kami. Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.';

            $invitation->event_date = \Illuminate\Support\Carbon::now()->addDays(60);
            $invitation->event_time = '10:00';

            // Jika ingin contoh tanggal sampai muncul di live preview, isi ini.
            // Jika tidak ingin muncul, ubah menjadi null.
            $invitation->event_end_date = null;
            $invitation->event_end_time = '13:00';

            $invitation->location_name = 'Gedung Pernikahan Harmoni';
            $invitation->address = 'Jl. Melati Putih No. 18, Jakarta';
            $invitation->maps_url = 'https://maps.google.com/?q=Gedung+Pernikahan+Harmoni';

            // Pernikahan tetap offline.
            $invitation->event_mode = 'offline';
            $invitation->online_url = null;

            // Tetap memakai 6 tema bawaan editor:
            // maroon, emerald, navy, rose, gold, slate
            $invitation->theme_color = 'gold';

            $people = collect([
                (object) [
                    'photo' => null,
                    'image' => null,
                    'name' => 'Justin',
                    'subtitle' => 'Mempelai Pria',
                    'family_name' => 'Putra dari Bapak Ahmad & Ibu Siti',
                    'instagram' => null,
                ],
                (object) [
                    'photo' => null,
                    'image' => null,
                    'name' => 'Sisca',
                    'subtitle' => 'Mempelai Wanita',
                    'family_name' => 'Putri dari Bapak Budi & Ibu Dewi',
                    'instagram' => null,
                ],
            ]);

            $gifts = collect([
                (object) [
                    'label' => 'BCA',
                    'account_number' => '1234567890',
                    'account_name' => 'Justin',
                ],
                (object) [
                    'label' => 'Mandiri',
                    'account_number' => '0987654321',
                    'account_name' => 'Sisca',
                ],
            ]);

            $invitation->setRelation('people', $people);
            $invitation->setRelation('gifts', $gifts);

            return view('public-invitations.wedding-simple-nikah', compact('invitation', 'mapData'));
        }

        return view('public-invitations.general', compact('invitation', 'mapData'));
    }
}
