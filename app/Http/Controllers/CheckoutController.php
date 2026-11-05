<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Template;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    private function setupMidtrans(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized');
        Config::$is3ds = (bool) config('services.midtrans.is_3ds');
    }

    public function start(Template $template)
    {
        $existingInvitation = Invitation::where('user_id', Auth::id())
            ->where('template_id', $template->id)
            ->first();

        if ($existingInvitation) {
            return redirect()->route('editor.edit', $existingInvitation);
        }

        $pendingTransaction = Transaction::where('user_id', Auth::id())
            ->where('template_id', $template->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($pendingTransaction) {
            return redirect()->route('checkout.show', $pendingTransaction);
        }

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'template_id' => $template->id,
            'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(10)),
            'amount' => $this->getCheckoutAmount($template),
            'payment_gateway' => 'midtrans',
            'payment_method' => 'snap',
            'status' => 'pending',
        ]);

        return redirect()->route('checkout.show', $transaction);
    }

    public function show(Transaction $transaction)
    {
        abort_if($transaction->user_id !== Auth::id(), 403);

        $transaction->load('template.category', 'user');

        if (!$transaction->snap_token && $transaction->status === 'pending') {
            $this->setupMidtrans();

            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->invoice_number,
                    'gross_amount' => (int) $transaction->amount,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'item_details' => [
                    [
                        'id' => 'template-' . $transaction->template->id,
                        'price' => (int) $transaction->amount,
                        'quantity' => 1,
                        'name' => 'Template ' . $transaction->template->name,
                    ],
                ],

                'callbacks' => [
                    'finish' => route('checkout.finish', $transaction),
                    'unfinish' => route('checkout.show', $transaction),
                    'error' => route('checkout.show', $transaction),
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            $transaction->update([
                'snap_token' => $snapToken,
            ]);
        }

        return view('checkout.show', compact('transaction'));
    }

    public function finish(Transaction $transaction)
    {
        abort_if($transaction->user_id !== Auth::id(), 403);

        if ($transaction->status !== 'paid') {
            return redirect()
                ->route('checkout.show', $transaction)
                ->with('error', 'Pembayaran belum terkonfirmasi. Silakan tunggu beberapa saat.');
        }

        if (!$transaction->invitation_id) {
            $invitation = $this->createInvitationFromTransaction($transaction);

            $transaction->update([
                'invitation_id' => $invitation->id,
            ]);
        }

        return redirect()
            ->route('editor.edit', $transaction->invitation_id)
            ->with('success', 'Pembayaran berhasil. Silakan edit undangan kamu.');
    }

    private function generatePrivateSlug(): string
    {
        do {
            $slug = 'u-' . Str::random(14);
        } while (Invitation::where('slug', $slug)->exists());

        return $slug;
    }

    public function createInvitationFromTransaction(Transaction $transaction): Invitation
    {
        $template = $transaction->template;
        $defaultData = $this->getDefaultInvitationData($template, $transaction);

        return Invitation::create([
            'user_id' => $transaction->user_id,
            'template_id' => $template->id,
            'event_category_id' => $template->event_category_id,
            'slug' => $this->generatePrivateSlug(),

            'title' => $defaultData['title'],
            'event_name' => $defaultData['event_name'],
            'host_name' => $defaultData['host_name'],
            'description' => $defaultData['description'],

            'status' => 'draft',
            'expired_at' => now()->addMonths(3),
        ]);
    }

    private function getDefaultInvitationData(Template $template, Transaction $transaction): array
    {
        $viewName = strtolower($template->view_name ?? '');
        $categoryName = strtolower($template->category->name ?? '');
        $categorySlug = strtolower($template->category->slug ?? '');

        if (
            str_starts_with($viewName, 'wedding-') ||
            str_contains($categoryName, 'pernikahan') ||
            str_contains($categoryName, 'wedding') ||
            str_contains($categorySlug, 'pernikahan') ||
            str_contains($categorySlug, 'wedding')
        ) {
            return [
                'title' => 'Alex & Putri',
                'event_name' => 'Pernikahan',
                'host_name' => 'Keluarga Besar Alex & Putri',
                'description' => 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu dalam acara pernikahan kami.',
            ];
        }

        if (str_starts_with($viewName, 'birthday-') || str_contains($categoryName, 'ulang tahun')) {
            return [
                'title' => 'Ulang Tahun Aruna',
                'event_name' => 'Ulang Tahun',
                'host_name' => 'Keluarga Aruna',
                'description' => 'Dengan penuh kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara ulang tahun kami.',
            ];
        }

        if (str_starts_with($viewName, 'seminar-') || str_contains($categoryName, 'seminar')) {
            return [
                'title' => 'Seminar Digital Marketing',
                'event_name' => 'Seminar',
                'host_name' => 'Panitia Seminar',
                'description' => 'Kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara seminar yang dirancang untuk menambah wawasan dan relasi.',
            ];
        }

        if (str_starts_with($viewName, 'wisuda-') || str_contains($categoryName, 'wisuda')) {
            return [
                'title' => 'Wisuda Aruna Putri',
                'event_name' => 'Wisuda',
                'host_name' => 'Keluarga Besar Aruna Putri',
                'description' => 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara syukuran wisuda.',
            ];
        }

        if (str_starts_with($viewName, 'aqiqah-')) {
            return [
                'title' => 'Aqiqah Aisyah',
                'event_name' => 'Aqiqah',
                'host_name' => 'Keluarga Besar Aisyah',
                'description' => 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara tasyakuran aqiqah buah hati kami.',
            ];
        }

        if (str_starts_with($viewName, 'khitanan-')) {
            return [
                'title' => 'Khitanan Azka',
                'event_name' => 'Khitanan',
                'host_name' => 'Keluarga Besar Azka',
                'description' => 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara tasyakuran khitanan ananda kami.',
            ];
        }

        if (str_starts_with($viewName, 'syukuran-')) {
            return [
                'title' => 'Syukuran Keluarga',
                'event_name' => 'Syukuran',
                'host_name' => 'Keluarga Besar',
                'description' => 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara syukuran keluarga kami.',
            ];
        }

        if (str_starts_with($viewName, 'corporate-') || str_contains($categoryName, 'corporate')) {
            return [
                'title' => 'Grand Product Launch 2026',
                'event_name' => 'Corporate Event',
                'host_name' => $transaction->user->name ?? 'Hajatin',
                'description' => 'Kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara resmi perusahaan yang diselenggarakan secara profesional.',
            ];
        }

        return [
            'title' => 'Undangan Acara',
            'event_name' => $template->category->name ?? 'Acara',
            'host_name' => $transaction->user->name ?? 'Tuan Rumah',
            'description' => 'Kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara kami.',
        ];
    }

    public function success(Transaction $transaction)
    {
        abort_if($transaction->user_id !== Auth::id(), 403);

        $transaction->load(['template', 'invitation']);

        if ($transaction->status !== 'paid') {
            return redirect()
                ->route('checkout.show', $transaction)
                ->with('error', 'Pembayaran belum terkonfirmasi.');
        }

        return view('checkout.success', compact('transaction'));
    }

    private function getCheckoutAmount(Template $template): int
    {
        $user = Auth::user();

        $testEmail = config('services.test_payment.email');
        $testTemplateSlug = config('services.test_payment.template_slug');
        $testAmount = (int) config('services.test_payment.amount', 1);

        if (
            $user &&
            $testEmail &&
            strtolower($user->email) === strtolower($testEmail) &&
            $testTemplateSlug &&
            $template->slug === $testTemplateSlug
        ) {
            return max(1, $testAmount);
        }

        return (int) $template->price;
    }
}
