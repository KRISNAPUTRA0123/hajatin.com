<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\GoogleMapsUrlService;

class InvitationEditorController extends Controller
{
    public function edit(Invitation $invitation)
    {
        abort_if($invitation->user_id !== Auth::id(), 403);

        $invitation->load([
            'template',
            'category',
            'photos',
            'messages',
            'people',
            'gifts',
        ]);

        return view('editor.edit', compact('invitation'));
    }

    public function update(Request $request, Invitation $invitation)
    {
        abort_if($invitation->user_id !== Auth::id(), 403);

        $maxGalleryPhotos = 6;

        $request->validate([
            'title' => 'required|string|max:255',
            'event_name' => 'nullable|string|max:255',
            'host_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'event_end_date' => 'nullable|date|after_or_equal:event_date',
            'event_time' => ['nullable', 'date_format:H:i'],
            'event_end_time' => ['nullable', 'date_format:H:i'],
            'seminar_about_title' => 'nullable|string|max:255',
            'location_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'maps_url' => 'nullable|string',
            'theme_color' => 'nullable|in:maroon,emerald,navy,rose,gold,slate',

            'delete_cover' => 'nullable|boolean',
            'reset_delete_gallery' => 'nullable|boolean',

            'event_mode' => 'nullable|in:online,offline',
            'online_url' => 'nullable|string|max:1000',

            'people.*.name' => 'nullable|string|max:255',
            'people.*.subtitle' => 'nullable|string|max:255',
            'people.*.family_name' => 'nullable|string|max:255',
            'people.*.existing_photo' => 'nullable|string|max:1000',
            'people_photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',

            'gifts.*.label' => 'nullable|string|max:255',
            'gifts.*.account_number' => 'nullable|string|max:255',
            'gifts.*.account_name' => 'nullable|string|max:255',

            'event_highlights' => 'nullable|array|max:12',
            'event_highlights.*.title' => 'nullable|string|max:255',
            'event_highlights.*.description' => 'nullable|string|max:500',

            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',

            'gallery_images' => 'nullable|array|max:6',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $existingGalleryCount = $request->boolean('reset_delete_gallery')
            ? 0
            : $invitation->photos()->count();

        $newGalleryCount = $request->hasFile('gallery_images')
            ? count($request->file('gallery_images'))
            : 0;

        if (($existingGalleryCount + $newGalleryCount) > $maxGalleryPhotos) {
            return back()
                ->withErrors([
                    'gallery_images' => "Maksimal {$maxGalleryPhotos} foto galeri. Hapus beberapa foto lama terlebih dahulu sebelum upload baru.",
                ])
                ->withInput();
        }

        $templateView = $invitation->template->view_name ?? 'general';

        $isSeminarTemplate = in_array($templateView, [
            'seminar-pro',
            'seminar-webinar-modern',
            'seminar-tech-conference',
            'seminar-education-talk',
        ]);

        $isWisudaTemplate = in_array($templateView, [
            'wisuda-graduation-day',
            'wisuda-golden-graduation',
            'wisuda-campus-pride',
            'wisuda-elegant-graduate',
            'wisuda-simple-graduation',
        ]);

        $isCorporateTemplate =
            Str::startsWith($templateView, 'corporate-')
            || str_contains(strtolower($invitation->template->category->slug ?? ''), 'corporate')
            || str_contains(strtolower($invitation->template->category->name ?? ''), 'corporate');

        $canChooseEventMode = $isSeminarTemplate || $isWisudaTemplate || $isCorporateTemplate;

        $eventMode = $canChooseEventMode
            ? $request->input('event_mode', 'offline')
            : 'offline';

        $eventHighlights = collect($request->input('event_highlights', []))
        ->take(12)
        ->map(function ($item) {
            return [
                'title' => trim($item['title'] ?? ''),
                'description' => trim($item['description'] ?? ''),
            ];
        })
        ->filter(function ($item) {
            return $item['title'] !== '' || $item['description'] !== '';
        })
        ->values()
        ->toArray();

        $data = [
            'title' => $request->title,
            'event_name' => $request->event_name,
            'host_name' => $request->host_name,
            'description' => $request->description,
            'event_highlights' => $eventHighlights,
            'event_date' => $request->event_date,
            'event_time' => $request->filled('event_time')
                ? $request->event_time
                : null,
            'event_end_date' => $request->event_end_date,
            'event_end_time' => $request->filled('event_end_time')
                ? $request->event_end_time
                : null,
            'seminar_about_title' => $request->seminar_about_title,
            'event_mode' => $eventMode,
            'online_url' => $eventMode === 'online' ? $request->online_url : null,
            'location_name' => $request->location_name,
            'address' => $request->address,
            'maps_url' => $request->maps_url,
            'theme_color' => $request->theme_color ?: 'maroon',
            'slug' => $this->shouldRegenerateSlug($invitation)
                ? $this->generatePrivateSlug()
                : $invitation->slug,
            'status' => 'draft',
        ];

        if ($request->boolean('delete_cover')) {
            if ($invitation->cover_image && Storage::disk('public')->exists($invitation->cover_image)) {
                Storage::disk('public')->delete($invitation->cover_image);
            }

            $data['cover_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($invitation->cover_image && Storage::disk('public')->exists($invitation->cover_image)) {
                Storage::disk('public')->delete($invitation->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $invitation->update($data);

        if ($request->boolean('reset_delete_gallery')) {
            $invitation->loadMissing('photos');

            foreach ($invitation->photos as $photo) {
                if (!empty($photo->image_path) && Storage::disk('public')->exists($photo->image_path)) {
                    Storage::disk('public')->delete($photo->image_path);
                }

                $photo->delete();
            }
        }

        if ($request->has('people')) {
            $oldPeoplePhotoPaths = $invitation->people()
                ->pluck('photo')
                ->filter()
                ->values()
                ->toArray();

            $invitation->people()->delete();

            $usedPeoplePhotos = [];

            foreach ($request->people as $index => $personData) {
                $name = trim($personData['name'] ?? '');
                $subtitle = trim($personData['subtitle'] ?? '');
                $familyName = trim($personData['family_name'] ?? '');
                $existingPhoto = $personData['existing_photo'] ?? null;

                if (
                    $name === '' &&
                    $subtitle === '' &&
                    $familyName === '' &&
                    empty($existingPhoto) &&
                    !$request->hasFile("people_photos.$index")
                ) {
                    continue;
                }

                $photoPath = $existingPhoto;

                if ($request->hasFile("people_photos.$index")) {
                    if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                        Storage::disk('public')->delete($photoPath);
                    }

                    $photoPath = $request->file("people_photos.$index")
                        ->store('invitations/people', 'public');
                }

                if ($photoPath) {
                    $usedPeoplePhotos[] = $photoPath;
                }

                $invitation->people()->create([
                    'photo' => $photoPath,
                    'name' => $name !== '' ? $name : null,
                    'subtitle' => $subtitle !== '' ? $subtitle : null,
                    'family_name' => $familyName !== '' ? $familyName : null,
                    'sort_order' => $index,
                ]);
            }

            foreach ($oldPeoplePhotoPaths as $oldPhotoPath) {
                if (!in_array($oldPhotoPath, $usedPeoplePhotos, true)) {
                    Storage::disk('public')->delete($oldPhotoPath);
                }
            }
        }

        if ($request->has('gifts')) {
            $invitation->gifts()->delete();

            foreach ($request->gifts as $index => $giftData) {
                if (
                    empty($giftData['label']) &&
                    empty($giftData['account_number']) &&
                    empty($giftData['account_name'])
                ) {
                    continue;
                }

                $invitation->gifts()->create([
                    'label' => $giftData['label'] ?? null,
                    'account_number' => $giftData['account_number'] ?? null,
                    'account_name' => $giftData['account_name'] ?? null,
                    'sort_order' => $index,
                ]);
            }
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                $path = $image->store('invitations/gallery', 'public');

                InvitationPhoto::create([
                    'invitation_id' => $invitation->id,
                    'image_path' => $path,
                    'sort_order' => $invitation->photos()->count() + $index + 1,
                ]);
            }
        }

        return redirect()
            ->route('editor.edit', $invitation)
            ->with('success', 'Data undangan berhasil disimpan.');
    }

    private function generateUniqueSlug(string $eventName, string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug(trim($eventName . ' ' . $title));

        if ($baseSlug === '') {
            $baseSlug = 'undangan';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
            \App\Models\Invitation::where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function shouldRegenerateSlug(Invitation $invitation): bool
    {
        if (empty($invitation->slug)) {
            return true;
        }

        if (!Str::startsWith($invitation->slug, 'u-')) {
            return true;
        }

        if (strlen($invitation->slug) < 10) {
            return true;
        }

        return Invitation::where('slug', $invitation->slug)
            ->where('id', '!=', $invitation->id)
            ->exists();
    }

    private function generatePrivateSlug(): string
    {
        do {
            $slug = 'u-' . Str::random(14);
        } while (Invitation::where('slug', $slug)->exists());

        return $slug;
    }

    public function publish(Invitation $invitation)
    {
        abort_if($invitation->user_id !== Auth::id(), 403);

        $templateView = $invitation->template->view_name ?? 'general';

        $isSeminarTemplate = in_array($templateView, [
            'seminar-pro',
            'seminar-webinar-modern',
            'seminar-tech-conference',
            'seminar-education-talk',
        ]);

        $isWisudaTemplate = in_array($templateView, [
            'wisuda-graduation-day',
            'wisuda-golden-graduation',
            'wisuda-campus-pride',
            'wisuda-elegant-graduate',
            'wisuda-simple-graduation',
        ]);

        $isCorporateTemplate =
            Str::startsWith($templateView, 'corporate-')
            || str_contains(strtolower($invitation->template->category->slug ?? ''), 'corporate')
            || str_contains(strtolower($invitation->template->category->name ?? ''), 'corporate');

        $canChooseEventMode = $isSeminarTemplate || $isWisudaTemplate || $isCorporateTemplate;

        $eventMode = $canChooseEventMode
            ? ($invitation->event_mode ?: 'offline')
            : 'offline';

        if (!$invitation->title || !$invitation->event_date) {
            return redirect()
                ->route('editor.edit', $invitation)
                ->with('error', 'Lengkapi minimal judul dan tanggal sebelum publish.');
        }

        if ($eventMode === 'online') {
            if (!$invitation->online_url) {
                return redirect()
                    ->route('editor.edit', $invitation)
                    ->with('error', 'Lengkapi link online sebelum publish.');
            }
        } else {
            if (!$invitation->location_name) {
                return redirect()
                    ->route('editor.edit', $invitation)
                    ->with('error', 'Lengkapi lokasi sebelum publish.');
            }
        }

        $invitation->update([
            'slug' => $this->shouldRegenerateSlug($invitation)
                ? $this->generatePrivateSlug()
                : $invitation->slug,
            'status' => 'active',
            'expired_at' => $invitation->expired_at ?: now()->addMonths(3),
        ]);

        return redirect()
            ->route('editor.edit', $invitation)
            ->with('success', 'Undangan berhasil dipublish. Link sudah bisa dibagikan.');
    }

    public function publicShow($slug)
    {
        $invitation = Invitation::with([
            'template',
            'category',
            'photos',
            'messages',
            'people',
            'gifts',
        ])
            ->where('slug', $slug)
            ->firstOrFail();

        if ($invitation->status !== 'active') {
            return view('public-invitations.not-active', compact('invitation'));
        }

        $mapData = GoogleMapsUrlService::makeEmbedUrl(
            $invitation->maps_url,
            $invitation->location_name,
            $invitation->address
        );

        $viewName = $invitation->template->view_name ?? 'general';

        if ($viewName === 'classic-letter') {
            return view('public-invitations.classic-letter', compact('invitation', 'mapData'));
        }

        if ($viewName === 'birthday-fun') {
            return view('public-invitations.birthday-fun', compact('invitation', 'mapData'));
        }

        if ($viewName === 'birthday-candy') {
            return view('public-invitations.birthday-candy', compact('invitation', 'mapData'));
        }

        if ($viewName === 'birthday-kids-party') {
            return view('public-invitations.birthday-kids-party', compact('invitation', 'mapData'));
        }

        if ($viewName === 'birthday-elegant') {
            return view('public-invitations.birthday-elegant', compact('invitation', 'mapData'));
        }

        if ($viewName === 'seminar-pro') {
            return view('public-invitations.seminar-pro', compact('invitation', 'mapData'));
        }

        if ($viewName === 'seminar-webinar-modern') {
            return view('public-invitations.seminar-webinar-modern', compact('invitation', 'mapData'));
        }

        if ($viewName === 'seminar-tech-conference') {
            return view('public-invitations.seminar-tech-conference', compact('invitation', 'mapData'));
        }

        if ($viewName === 'seminar-education-talk') {
            return view('public-invitations.seminar-education-talk', compact('invitation', 'mapData'));
        }

        if ($viewName === 'syukuran-ceria') {
            return view('public-invitations.syukuran-ceria', compact('invitation', 'mapData'));
        }

        if ($viewName === 'syukuran-warm') {
            return view('public-invitations.syukuran-warm', compact('invitation', 'mapData'));
        }

        if ($viewName === 'syukuran-doa-bersama') {
            return view('public-invitations.syukuran-doa-bersama', compact('invitation', 'mapData'));
        }

        if ($viewName === 'syukuran-soft') {
            return view('public-invitations.syukuran-soft', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wisuda-graduation-day') {
            return view('public-invitations.wisuda-graduation-day', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wisuda-golden-graduation') {
            return view('public-invitations.wisuda-golden-graduation', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wisuda-campus-pride') {
            return view('public-invitations.wisuda-campus-pride', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wisuda-elegant-graduate') {
            return view('public-invitations.wisuda-elegant-graduate', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wisuda-simple-graduation') {
            return view('public-invitations.wisuda-simple-graduation', compact('invitation', 'mapData'));
        }

        if ($viewName === 'aqiqah-soft') {
            return view('public-invitations.aqiqah-soft', compact('invitation', 'mapData'));
        }

        if ($viewName === 'aqiqah-baby-blessing') {
            return view('public-invitations.aqiqah-baby-blessing', compact('invitation', 'mapData'));
        }

        if ($viewName === 'aqiqah-little-prince') {
            return view('public-invitations.aqiqah-little-prince', compact('invitation', 'mapData'));
        }

        if ($viewName === 'aqiqah-little-princess') {
            return view('public-invitations.aqiqah-little-princess', compact('invitation', 'mapData'));
        }

        if ($viewName === 'aqiqah-islamic') {
            return view('public-invitations.aqiqah-islamic', compact('invitation', 'mapData'));
        }

        if ($viewName === 'khitanan-ceria') {
            return view('public-invitations.khitanan-ceria', compact('invitation', 'mapData'));
        }

        if ($viewName === 'khitanan-little-hero') {
            return view('public-invitations.khitanan-little-hero', compact('invitation', 'mapData'));
        }

        if ($viewName === 'khitanan-fun-party') {
            return view('public-invitations.khitanan-fun-party', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-nusantara') {
            return view('public-invitations.wedding-nusantara', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-minimal-black-gold') {
            return view('public-invitations.wedding-minimal-black-gold', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-royal-javanese') {
            return view('public-invitations.wedding-royal-javanese', compact('invitation', 'mapData'));
        }

        if ($viewName === 'khitanan-blue') {
            return view('public-invitations.khitanan-blue', compact('invitation', 'mapData'));
        }

        if ($viewName === 'khitanan-islamic') {
            return view('public-invitations.khitanan-islamic', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-launch') {
            return view('public-invitations.corporate-launch', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-business-opening') {
            return view('public-invitations.corporate-business-opening', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-product-launch') {
            return view('public-invitations.corporate-product-launch', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-company-gathering') {
            return view('public-invitations.corporate-company-gathering', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-formal-invitation') {
            return view('public-invitations.corporate-formal-invitation', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-startup-event') {
            return view('public-invitations.corporate-startup-event', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-grand-opening-pro') {
            return view('public-invitations.corporate-grand-opening-pro', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-award-night') {
            return view('public-invitations.corporate-award-night', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-networking-night') {
            return view('public-invitations.corporate-networking-night', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-business-seminar') {
            return view('public-invitations.corporate-business-seminar', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-golden-romance') {
            return view('public-invitations.wedding-golden-romance', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-elegant-white') {
            return view('public-invitations.wedding-elegant-white', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-floral-love') {
            return view('public-invitations.wedding-floral-love', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-rustic-garden') {
            return view('public-invitations.wedding-rustic-garden', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-green-garden') {
            return view('public-invitations.wedding-green-garden', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-classic-letter') {
            return view('public-invitations.wedding-classic-letter', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-luxury-maroon') {
            return view('public-invitations.wedding-luxury-maroon', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-vintage-romance') {
            return view('public-invitations.wedding-vintage-romance', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-peach-blossom') {
            return view('public-invitations.wedding-peach-blossom', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-batik-elegance') {
            return view('public-invitations.wedding-batik-elegance', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-modern-couple') {
            return view('public-invitations.wedding-modern-couple', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-emerald-wedding') {
            return view('public-invitations.wedding-emerald-wedding', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-soft-sakura') {
            return view('public-invitations.wedding-soft-sakura', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-ocean-love') {
            return view('public-invitations.wedding-ocean-love', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-pastel-wedding') {
            return view('public-invitations.wedding-pastel-wedding', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-simple-nikah') {
            return view('public-invitations.wedding-simple-nikah', compact('invitation', 'mapData'));
        }

        return view('public-invitations.general', compact('invitation', 'mapData'));
    }

    public function deletePhoto(InvitationPhoto $photo)
    {
        abort_if($photo->invitation->user_id !== Auth::id(), 403);

        Storage::disk('public')->delete($photo->image_path);

        $photo->delete();

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }

    public function preview(Invitation $invitation)
    {
        abort_if($invitation->user_id !== Auth::id(), 403);

        $invitation->load([
            'template',
            'category',
            'photos',
            'messages',
            'people',
            'gifts',
        ]);

        $mapData = GoogleMapsUrlService::makeEmbedUrl(
            $invitation->maps_url,
            $invitation->location_name,
            $invitation->address
        );

        $viewName = $invitation->template->view_name ?? 'general';

        if ($viewName === 'classic-letter') {
            return view('public-invitations.classic-letter', compact('invitation', 'mapData'));
        }

        if ($viewName === 'birthday-fun') {
            return view('public-invitations.birthday-fun', compact('invitation', 'mapData'));
        }

        if ($viewName === 'birthday-candy') {
            return view('public-invitations.birthday-candy', compact('invitation', 'mapData'));
        }

        if ($viewName === 'birthday-kids-party') {
            return view('public-invitations.birthday-kids-party', compact('invitation', 'mapData'));
        }

        if ($viewName === 'birthday-elegant') {
            return view('public-invitations.birthday-elegant', compact('invitation', 'mapData'));
        }

        if ($viewName === 'seminar-pro') {
            return view('public-invitations.seminar-pro', compact('invitation', 'mapData'));
        }

        if ($viewName === 'seminar-webinar-modern') {
            return view('public-invitations.seminar-webinar-modern', compact('invitation', 'mapData'));
        }

        if ($viewName === 'seminar-tech-conference') {
            return view('public-invitations.seminar-tech-conference', compact('invitation', 'mapData'));
        }

        if ($viewName === 'seminar-education-talk') {
            return view('public-invitations.seminar-education-talk', compact('invitation', 'mapData'));
        }

        if ($viewName === 'syukuran-ceria') {
            return view('public-invitations.syukuran-ceria', compact('invitation', 'mapData'));
        }

        if ($viewName === 'syukuran-warm') {
            return view('public-invitations.syukuran-warm', compact('invitation', 'mapData'));
        }

        if ($viewName === 'syukuran-doa-bersama') {
            return view('public-invitations.syukuran-doa-bersama', compact('invitation', 'mapData'));
        }

        if ($viewName === 'syukuran-soft') {
            return view('public-invitations.syukuran-soft', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wisuda-graduation-day') {
            return view('public-invitations.wisuda-graduation-day', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wisuda-golden-graduation') {
            return view('public-invitations.wisuda-golden-graduation', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wisuda-campus-pride') {
            return view('public-invitations.wisuda-campus-pride', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wisuda-elegant-graduate') {
            return view('public-invitations.wisuda-elegant-graduate', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wisuda-simple-graduation') {
            return view('public-invitations.wisuda-simple-graduation', compact('invitation', 'mapData'));
        }

        if ($viewName === 'aqiqah-soft') {
            return view('public-invitations.aqiqah-soft', compact('invitation', 'mapData'));
        }

        if ($viewName === 'aqiqah-baby-blessing') {
            return view('public-invitations.aqiqah-baby-blessing', compact('invitation', 'mapData'));
        }

        if ($viewName === 'aqiqah-little-prince') {
            return view('public-invitations.aqiqah-little-prince', compact('invitation', 'mapData'));
        }

        if ($viewName === 'aqiqah-little-princess') {
            return view('public-invitations.aqiqah-little-princess', compact('invitation', 'mapData'));
        }

        if ($viewName === 'aqiqah-islamic') {
            return view('public-invitations.aqiqah-islamic', compact('invitation', 'mapData'));
        }

        if ($viewName === 'khitanan-ceria') {
            return view('public-invitations.khitanan-ceria', compact('invitation', 'mapData'));
        }

        if ($viewName === 'khitanan-little-hero') {
            return view('public-invitations.khitanan-little-hero', compact('invitation', 'mapData'));
        }

        if ($viewName === 'khitanan-fun-party') {
            return view('public-invitations.khitanan-fun-party', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-nusantara') {
            return view('public-invitations.wedding-nusantara', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-minimal-black-gold') {
            return view('public-invitations.wedding-minimal-black-gold', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-royal-javanese') {
            return view('public-invitations.wedding-royal-javanese', compact('invitation', 'mapData'));
        }

        if ($viewName === 'khitanan-blue') {
            return view('public-invitations.khitanan-blue', compact('invitation', 'mapData'));
        }

        if ($viewName === 'khitanan-islamic') {
            return view('public-invitations.khitanan-islamic', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-launch') {
            return view('public-invitations.corporate-launch', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-business-opening') {
            return view('public-invitations.corporate-business-opening', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-product-launch') {
            return view('public-invitations.corporate-product-launch', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-company-gathering') {
            return view('public-invitations.corporate-company-gathering', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-formal-invitation') {
            return view('public-invitations.corporate-formal-invitation', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-startup-event') {
            return view('public-invitations.corporate-startup-event', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-grand-opening-pro') {
            return view('public-invitations.corporate-grand-opening-pro', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-award-night') {
            return view('public-invitations.corporate-award-night', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-networking-night') {
            return view('public-invitations.corporate-networking-night', compact('invitation', 'mapData'));
        }

        if ($viewName === 'corporate-business-seminar') {
            return view('public-invitations.corporate-business-seminar', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-golden-romance') {
            return view('public-invitations.wedding-golden-romance', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-elegant-white') {
            return view('public-invitations.wedding-elegant-white', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-floral-love') {
            return view('public-invitations.wedding-floral-love', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-rustic-garden') {
            return view('public-invitations.wedding-rustic-garden', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-green-garden') {
            return view('public-invitations.wedding-green-garden', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-classic-letter') {
            return view('public-invitations.wedding-classic-letter', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-luxury-maroon') {
            return view('public-invitations.wedding-luxury-maroon', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-vintage-romance') {
            return view('public-invitations.wedding-vintage-romance', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-peach-blossom') {
            return view('public-invitations.wedding-peach-blossom', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-batik-elegance') {
            return view('public-invitations.wedding-batik-elegance', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-modern-couple') {
            return view('public-invitations.wedding-modern-couple', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-emerald-wedding') {
            return view('public-invitations.wedding-emerald-wedding', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-soft-sakura') {
            return view('public-invitations.wedding-soft-sakura', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-ocean-love') {
            return view('public-invitations.wedding-ocean-love', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-pastel-wedding') {
            return view('public-invitations.wedding-pastel-wedding', compact('invitation', 'mapData'));
        }

        if ($viewName === 'wedding-simple-nikah') {
            return view('public-invitations.wedding-simple-nikah', compact('invitation', 'mapData'));
        }

        return view('public-invitations.general', compact('invitation', 'mapData'));
    }
}
