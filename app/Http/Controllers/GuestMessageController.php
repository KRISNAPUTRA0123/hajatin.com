<?php

namespace App\Http\Controllers;

use App\Models\GuestMessage;
use App\Models\Invitation;
use Illuminate\Http\Request;

class GuestMessageController extends Controller
{
    public function store(Request $request, Invitation $invitation)
    {
        if ($invitation->status !== 'active') {
            abort(403, 'Undangan belum aktif.');
        }

        $request->validate([
            'guest_name' => 'required|string|max:100',
            'message' => 'required|string|max:1000',
            'attendance_status' => 'nullable|in:hadir,tidak_hadir,ragu',
            'guest_count' => 'nullable|integer|min:1|max:10',
        ]);

        GuestMessage::create([
            'invitation_id' => $invitation->id,
            'guest_name' => $request->guest_name,
            'message' => $request->message,
            'attendance_status' => $request->attendance_status,
            'guest_count' => $request->guest_count ?? 1,
        ]);

        return back()->with('message_success', 'Ucapan berhasil dikirim. Terima kasih.');
    }
}
