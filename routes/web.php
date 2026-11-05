<?php

use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationEditorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestMessageController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\FirebaseAuthController;

Route::get('/', [TemplateController::class, 'index'])->name('home');

Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');

Route::get('/templates/{template}/live-preview', [TemplateController::class, 'livePreview'])
    ->name('templates.live-preview');

Route::get('/templates/{slug}', [TemplateController::class, 'show'])
    ->name('templates.show');

Route::post('/auth/firebase-google', [FirebaseAuthController::class, 'login'])
    ->middleware('throttle:10,1')
    ->name('firebase.google.login');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/editor/{invitation}', [InvitationEditorController::class, 'edit'])
        ->name('editor.edit');

    Route::put('/editor/{invitation}', [InvitationEditorController::class, 'update'])
        ->name('editor.update');

    Route::post('/editor/{invitation}/publish', [InvitationEditorController::class, 'publish'])
        ->name('editor.publish');

    Route::delete('/editor/photos/{photo}', [InvitationEditorController::class, 'deletePhoto'])
        ->name('editor.photos.delete');

    Route::get('/dashboard/invitations/{invitation}/messages', [DashboardController::class, 'messages'])
        ->name('dashboard.messages');

    Route::get('/templates/{template}/checkout/start', [CheckoutController::class, 'start'])
        ->name('checkout.start');

    Route::get('/checkout/{transaction}', [CheckoutController::class, 'show'])
        ->name('checkout.show');

    Route::get('/checkout/{transaction}/finish', [CheckoutController::class, 'finish'])
        ->name('checkout.finish');

    Route::get('/checkout/{transaction}/success', [CheckoutController::class, 'success'])
        ->name('checkout.success');

    Route::get('/editor/{invitation}/preview', [InvitationEditorController::class, 'preview'])
        ->name('editor.preview');

});

require __DIR__.'/auth.php';

Route::post('/invitations/{invitation}/messages', [GuestMessageController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('guest-messages.store');

Route::get('/u/{slug}', [InvitationEditorController::class, 'publicShow'])
    ->name('invitation.public');

Route::post('/midtrans/webhook', [MidtransCallbackController::class, 'handle'])
    ->name('midtrans.webhook');
