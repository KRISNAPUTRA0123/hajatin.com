<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TemplatePurchaseController extends Controller
{
    public function buy(Template $template)
    {
        $existingInvitation = Invitation::where('user_id', Auth::id())
            ->where('template_id', $template->id)
            ->first();

        if ($existingInvitation) {
            return redirect()->route('editor.edit', $existingInvitation);
        }

        $invitation = Invitation::create([
            'user_id' => Auth::id(),
            'template_id' => $template->id,
            'event_category_id' => $template->event_category_id,

            // URL dibuat acak agar tidak memakai nama pelanggan / judul acara
            'slug' => $this->generatePrivateSlug(),

            'title' => $template->name,
            'event_name' => $template->category->name,
            'host_name' => Auth::user()->name,
            'description' => '',
            'status' => 'draft',
            'expired_at' => now()->addMonths(3),
        ]);

        return redirect()->route('editor.edit', $invitation)
            ->with('success', 'Template berhasil dibeli. Silakan edit undangan kamu.');
    }

    private function generatePrivateSlug(): string
    {
        do {
            $slug = 'u-' . Str::random(14);
        } while (Invitation::where('slug', $slug)->exists());

        return $slug;
    }
}
