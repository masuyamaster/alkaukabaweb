<?php

namespace App\Http\Controllers;

use App\Models\User;
use Google\Client as GoogleClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

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
            'update_profile' => $this->updateProfile($request),
            'change_password' => $this->changePassword($request),
            'delete_account' => $this->deleteAccount($request),
            'upload_avatar' => $this->uploadAvatar($request),
            'delete_avatar' => $this->deleteAvatar($request),
            default => response()->json([
                'status' => 'error',
                'message' => 'Endpoint tidak ditemukan. Gunakan ?action=register, ?action=login, ?action=google_login, ?action=update_profile, ?action=change_password, ?action=delete_account, ?action=upload_avatar, atau ?action=delete_avatar',
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

        $user = User::create([
            'name' => $data['username'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil.',
            'data' => $this->userResponse($user),
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
     * Ganti nama tampilan (username). Email sengaja tidak bisa diubah lewat endpoint ini -
     * ganti email butuh alur verifikasi ulang yang belum ada, di luar scope saat ini.
     */
    private function updateProfile(Request $request): JsonResponse
    {
        $user = $this->authenticatedUser($request);

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi tidak valid, silakan login ulang.',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username tidak boleh kosong.',
            ], 400);
        }

        $username = $validator->validated()['username'];

        $taken = User::where('username', $username)->where('id', '!=', $user->id)->exists();

        if ($taken) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username sudah dipakai.',
            ], 400);
        }

        $user->update(['username' => $username, 'name' => $username]);

        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui.',
            'data' => $this->userResponse($user, issueToken: false),
        ], 200);
    }

    private function changePassword(Request $request): JsonResponse
    {
        $user = $this->authenticatedUser($request);

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi tidak valid, silakan login ulang.',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak lengkap. Butuh current_password dan new_password (minimal 6 karakter).',
            ], 400);
        }

        $data = $validator->validated();

        if (! Hash::check($data['current_password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password saat ini salah.',
            ], 401);
        }

        $user->update(['password' => Hash::make($data['new_password'])]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diubah.',
            // Password berubah -> semua token lama dicabut (di dalam userResponse) dan
            // token baru diterbitkan, klien harus pakai token ini untuk request berikutnya.
            'data' => $this->userResponse($user),
        ], 200);
    }

    private function deleteAccount(Request $request): JsonResponse
    {
        $user = $this->authenticatedUser($request);

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi tidak valid, silakan login ulang.',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Konfirmasi password diperlukan untuk menghapus akun.',
            ], 400);
        }

        if (! Hash::check($validator->validated()['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password salah.',
            ], 401);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Akun berhasil dihapus.',
        ], 200);
    }

    private function uploadAvatar(Request $request): JsonResponse
    {
        $user = $this->authenticatedUser($request);

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi tidak valid, silakan login ulang.',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'photo' => ['required', 'image', 'mimes:jpeg,png,webp', 'max:4096'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Foto tidak valid. Gunakan JPG/PNG/WebP maksimal 4MB.',
            ], 400);
        }

        $photo = $validator->validated()['photo'];

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $path = $photo->storeAs('avatars', $user->id.'-'.time().'.'.$photo->extension(), 'public');

        $user->update(['avatar_path' => $path]);

        return response()->json([
            'status' => 'success',
            'message' => 'Foto profil berhasil diperbarui.',
            'data' => $this->userResponse($user, issueToken: false),
        ], 200);
    }

    private function deleteAvatar(Request $request): JsonResponse
    {
        $user = $this->authenticatedUser($request);

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi tidak valid, silakan login ulang.',
            ], 401);
        }

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->update(['avatar_path' => null]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Foto profil berhasil dihapus.',
            'data' => $this->userResponse($user, issueToken: false),
        ], 200);
    }

    /**
     * Resolve user dari Sanctum bearer token tanpa middleware auth:sanctum di route -
     * satu route /api.php ini juga melayani action publik (register/login/google_login)
     * yang tidak boleh kena guard itu.
     */
    private function authenticatedUser(Request $request): ?User
    {
        $token = PersonalAccessToken::findToken((string) $request->bearerToken());

        if (! $token || ! $token->tokenable instanceof User) {
            return null;
        }

        return $token->tokenable;
    }

    /**
     * @return array{id: int, username: string, email: string, avatar_url: ?string, token?: string}
     */
    private function userResponse(User $user, bool $issueToken = true): array
    {
        $response = [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'avatar_url' => $user->avatar_path ? Storage::disk('public')->url($user->avatar_path) : null,
        ];

        if ($issueToken) {
            // Satu token aktif per user (bukan per device) - cukup untuk scope app ini saat
            // ini (single-session), lebih simpel daripada kelola banyak token per device.
            $user->tokens()->delete();
            $response['token'] = $user->createToken('android')->plainTextToken;
        }

        return $response;
    }
}
