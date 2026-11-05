<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Template;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');

        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $signatureKey = $request->signature_key;

        $validSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $validSignature) {
            Log::warning('Invalid Midtrans signature', $request->all());
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaction::with(['template.category', 'user'])
            ->where('invoice_number', $orderId)
            ->first();

        if (!$transaction) {
            Log::warning('Midtrans transaction not found', $request->all());
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;

        if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
            $transaction->update([
                'status' => 'paid',
                'paid_at' => now(),
                'payment_reference' => $request->transaction_id,
                'payment_method' => $request->payment_type,
            ]);

            if (!$transaction->invitation_id) {
                $invitation = $this->createInvitation($transaction);

                $transaction->update([
                    'invitation_id' => $invitation->id,
                ]);
            }
        } elseif ($transactionStatus === 'pending') {
            $transaction->update([
                'status' => 'pending',
                'payment_reference' => $request->transaction_id,
                'payment_method' => $request->payment_type,
            ]);
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
            $transaction->update([
                'status' => $transactionStatus === 'expire' ? 'expired' : 'failed',
                'payment_reference' => $request->transaction_id,
                'payment_method' => $request->payment_type,
            ]);
        }

        return response()->json(['message' => 'Notification processed']);
    }

    private function generatePrivateSlug(): string
    {
        do {
            $slug = 'u-' . Str::random(14);
        } while (Invitation::where('slug', $slug)->exists());

        return $slug;
    }

    private function createInvitation(Transaction $transaction): Invitation
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
}
