<?php

namespace App\Http\Controllers;

use App\Models\User;
use Google\Client as GoogleClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak lengkap. Butuh username, email, dan password.',
            ], 400);
        }

        $data = $validator->validated();

        $exists = User::where('email', $data['email'])->orWhere('username', $data['username'])->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username atau Email sudah terdaftar.',
            ], 400);
        }

        User::create([
            'name' => $data['username'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil.',
        ], 201);
    }

    private function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak lengkap. Butuh email dan password.',
            ], 400);
        }

        $data = $validator->validated();

        $user = User::where('email', $data['email'])->first();

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak terdaftar.',
            ], 404);
        }

        if (! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password salah.',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil.',
            'data' => $this->userResponse($user),
        ], 200);
    }

    private function googleLogin(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id_token' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak lengkap. Butuh id_token.',
            ], 400);
        }

        $idToken = $validator->validated()['id_token'];

        $client = new GoogleClient(['client_id' => config('services.google.client_id')]);

        try {
            $payload = $client->verifyIdToken($idToken);

            if (! $payload) {
                Log::warning('google_login: verifyIdToken returned false', [
                    'client_id' => config('services.google.client_id'),
                ]);

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
                    'data' => $this->userResponse($user),
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
                'data' => $this->userResponse($newUser),
            ], 201);
        } catch (\Exception $e) {
            Log::error('google_login verification failed', [
                'message' => $e->getMessage(),
                'client_id' => config('services.google.client_id'),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server saat verifikasi token.',
            ], 500);
        }
    }

    /**
     * @return array{id: int, username: string, email: string}
     */
    private function userResponse(User $user): array
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
        ];
    }
}
