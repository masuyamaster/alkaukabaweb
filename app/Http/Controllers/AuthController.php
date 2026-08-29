<?php

namespace App\Http\Controllers;

use App\Models\User;
use Google\Client as GoogleClient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Single entry point mirroring the legacy api.php?action=... contract
     * so the Android app only needs to change its base URL.
     */
    public function handle(Request $request): JsonResponse
    {
        return match ($request->query('action')) {
            'register' => $this->register($request),
            'login' => $this->login($request),
            'google_login' => $this->googleLogin($request),
            default => response()->json([
                'status' => 'error',
                'message' => 'Endpoint tidak ditemukan. Gunakan ?action=register, ?action=login, atau ?action=google_login',
            ], 404),
        };
    }

    private function register(Request $request): JsonResponse
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');

        if (empty($username) || empty($email) || empty($password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak lengkap. Butuh username, email, dan password.',
            ], 400);
        }

        $exists = User::where('email', $email)->orWhere('username', $username)->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username atau Email sudah terdaftar.',
            ], 400);
        }

        User::create([
            'name' => $username,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil.',
        ], 201);
    }

    private function login(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (empty($email) || empty($password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak lengkap. Butuh email dan password.',
            ], 400);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak terdaftar.',
            ], 404);
        }

        if (! Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password salah.',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil.',
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ],
        ], 200);
    }

    private function googleLogin(Request $request): JsonResponse
    {
        $idToken = $request->input('id_token');

        if (empty($idToken)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak lengkap. Butuh id_token.',
            ], 400);
        }

        $client = new GoogleClient(['client_id' => config('services.google.client_id')]);

        try {
            $payload = $client->verifyIdToken($idToken);

            if (! $payload) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token Google tidak valid atau sudah kadaluarsa.',
                ], 401);
            }

            $googleId = $payload['sub'];
            $email = $payload['email'];
            $username = $payload['name'] ?? explode('@', $email)[0];

            $user = User::where('email', $email)->first();

            if ($user) {
                if (empty($user->google_id)) {
                    $user->update(['google_id' => $googleId]);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Login Google berhasil.',
                    'data' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                    ],
                ], 200);
            }

            $newUser = User::create([
                'name' => $username,
                'username' => $username,
                'email' => $email,
                'password' => Hash::make(Str::random(20)),
                'google_id' => $googleId,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Registrasi dan Login Google berhasil.',
                'data' => [
                    'id' => $newUser->id,
                    'username' => $newUser->username,
                    'email' => $newUser->email,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server saat verifikasi token: '.$e->getMessage(),
            ], 500);
        }
    }
}
