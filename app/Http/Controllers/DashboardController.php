<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\GuestMessage;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $allInvitations = Invitation::where('user_id', Auth::id())->get();

        $invitationIds = $allInvitations->pluck('id');

        $totalInvitations = $allInvitations->count();

        $totalMessages = GuestMessage::whereIn('invitation_id', $invitationIds)
            ->count();

        $totalAttend = GuestMessage::whereIn('invitation_id', $invitationIds)
            ->where('attendance_status', 'hadir')
            ->sum('guest_count');

        $totalNotAttend = GuestMessage::whereIn('invitation_id', $invitationIds)
            ->where('attendance_status', 'tidak_hadir')
            ->count();

        $totalMaybe = GuestMessage::whereIn('invitation_id', $invitationIds)
            ->where('attendance_status', 'ragu')
            ->count();

        $invitations = Invitation::with(['template', 'category'])
            ->withCount('messages')
            ->withSum([
                'messages as attend_guest_total' => function ($query) {
                    $query->where('attendance_status', 'hadir');
                }
            ], 'guest_count')
            ->withCount([
                'messages as maybe_messages_count' => function ($query) {
                    $query->where('attendance_status', 'ragu');
                }
            ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $transactions = Transaction::with(['template', 'invitation'])
            ->where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'invitations',
            'totalInvitations',
            'totalMessages',
            'totalAttend',
            'totalNotAttend',
            'totalMaybe',
            'transactions'
        ));
    }

    public function messages(Invitation $invitation)
    {
        abort_if($invitation->user_id !== Auth::id(), 403);

        $invitation->load(['template', 'category', 'messages']);

        $totalMessages = $invitation->messages->count();

        $totalAttend = $invitation->messages
            ->where('attendance_status', 'hadir')
            ->sum('guest_count');

        $totalNotAttend = $invitation->messages
            ->where('attendance_status', 'tidak_hadir')
            ->count();

        $totalMaybe = $invitation->messages
            ->where('attendance_status', 'ragu')
            ->count();

        return view('dashboard.messages', compact(
            'invitation',
            'totalMessages',
            'totalAttend',
            'totalNotAttend',
            'totalMaybe'
        ));
    }
}
