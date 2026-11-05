<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;

class FirebaseAuthController extends Controller
{
    public function login(Request $request, FirebaseAuth $firebaseAuth)
    {
        $request->validate([
            'idToken' => ['required', 'string'],
        ]);

        try {
            $verifiedIdToken = $firebaseAuth->verifyIdToken($request->idToken);

            $firebaseUid = $verifiedIdToken->claims()->get('sub');

            $firebaseUser = $firebaseAuth->getUser($firebaseUid);

            if (empty($firebaseUser->email)) {
                return response()->json([
                    'message' => 'Akun Google tidak memiliki email yang valid.',
                ], 422);
            }

            $user = User::updateOrCreate(
                [
                    'email' => $firebaseUser->email,
                ],
                [
                    'firebase_uid' => $firebaseUid,
                    'name' => $firebaseUser->displayName ?: Str::before($firebaseUser->email, '@'),
                    'avatar' => $firebaseUser->photoUrl,
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user, true);

            $request->session()->regenerate();

            return response()->json([
                'redirect' => route('dashboard'),
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Login Google gagal. Silakan coba lagi.',
            ], 401);
        }
    }
}
