<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    /**
     * 🔥 Helper untuk hashing + benchmark
     */
    private function generateHashBenchmark($plain)
    {
        // 🔥 ambil pepper dari .env
        $pepper = env('PASSWORD_PEPPER');

        // 🔥 bcrypt memakai pepper
        $plainWithPepper = $plain . $pepper;

        // bcrypt
        $startBcrypt = microtime(true);
        $bcryptHash = Hash::make($plainWithPepper);
        $timeBcrypt = microtime(true) - $startBcrypt;

        // md5 TANPA pepper
        $startMd5 = microtime(true);
        $md5Hash = md5($plain);
        $timeMd5 = microtime(true) - $startMd5;

        // sha1 TANPA pepper
        $startSha1 = microtime(true);
        $sha1Hash = sha1($plain);
        $timeSha1 = microtime(true) - $startSha1;

        return [
            'bcrypt_hash' => $bcryptHash,
            'md5_hash' => $md5Hash,
            'sha1_hash' => $sha1Hash,
            'time_bcrypt' => $timeBcrypt,
            'time_md5' => $timeMd5,
            'time_sha1' => $timeSha1,
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',

            'password' => [
                'required',
                'confirmed',
                'min:6',
                'regex:/[A-Z]/', // harus ada huruf kapital
                'regex:/[a-z]/', // harus ada huruf kecil
                'regex:/[0-9]/', // harus ada angka
                'regex:/[@$!%*#?&.,]/', // harus ada karakter unik
            ],

            'nik' => 'required',
            'phone' => 'required|regex:/^[0-9]+$/|min:10|max:15'

        ], [
            'password.min' => 'Password minimal 8 karakter',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter unik',
        ]);

        // 🔥 generate hash
        $hashData = $this->generateHashBenchmark($request->password);

        // simpan user (bcrypt)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->email,
            'password' => $hashData['bcrypt_hash'],
            'role' => 'warga',
            'nik' => $request->nik,
            'alamat' => null,
            'phone' => $request->phone,
            'email_verified_at' => now() // 🔥 langsung dianggap verified
        ]);

        // 🔥 simpan ke password_logs
        PasswordLog::create([
            'user_id' => $user->id,
            'bcrypt_hash' => $hashData['bcrypt_hash'],
            'md5_hash' => $hashData['md5_hash'],
            'sha1_hash' => $hashData['sha1_hash'],
            'time_bcrypt' => $hashData['time_bcrypt'],
            'time_md5' => $hashData['time_md5'],
            'time_sha1' => $hashData['time_sha1'],
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->with('error', 'User tidak ditemukan')
                ->withInput();
        }

        $plain = $request->password;

        // 🔥 ambil pepper
        $pepper = env('PASSWORD_PEPPER');

        // 🔥 benchmark bcrypt
        $startBcrypt = microtime(true);

        $bcryptCheck = Hash::check(
            $plain . $pepper,
            $user->password
        );

        $timeBcrypt = microtime(true) - $startBcrypt;

        // 🔥 benchmark md5
        $startMd5 = microtime(true);

        md5($plain);

        $timeMd5 = microtime(true) - $startMd5;

        // 🔥 benchmark sha1
        $startSha1 = microtime(true);

        sha1($plain);

        $timeSha1 = microtime(true) - $startSha1;

        // 🔥 password salah
        if (!$bcryptCheck) {

            return back()
                ->with('error', 'Password salah')
                ->withInput();
        }

        // 🔥 benchmark result
        $benchmark = [
            'bcrypt' => round($timeBcrypt * 1000, 5),
            'md5' => round($timeMd5 * 1000, 5),
            'sha1' => round($timeSha1 * 1000, 5),
        ];

        // =====================================================
        // 🔥 ADMIN TANPA OTP
        // =====================================================

        if ($user->role === 'admin') {

            Auth::login($user);

            $request->session()->regenerate();

            return redirect('/dashboard')
                ->with('benchmark', $benchmark);
        }

        // =====================================================
        // 🔥 WARGA DENGAN OTP EMAIL
        // =====================================================

        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->otp_expired_at = now()->addMinutes(5);
        $user->save();

        try {

            // 🔥 kirim OTP menggunakan BREVO API
            $response = Http::withHeaders([
                'api-key' => env('BREVO_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post(
                'https://api.brevo.com/v3/smtp/email',
                [
                    'sender' => [
                        'name' => 'Desa Bloro',
                        'email' => env('MAIL_FROM_ADDRESS'),
                    ],

                    'to' => [
                        [
                            'email' => $user->email
                        ]
                    ],

                    'subject' => 'Kode OTP Login',

                    'textContent' =>
                    "Kode OTP login Anda adalah: $otp\n\nKode ini berlaku selama 5 menit."
                ]
            );

            // 🔥 jika gagal kirim
            if (!$response->successful()) {

                return back()->with(
                    'error',
                    'Gagal mengirim OTP ke email user'
                );
            }
        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Server email sedang bermasalah'
            );
        }

        // 🔥 simpan session sementara
        session([
            'otp_user_id' => $user->id,
            'benchmark' => $benchmark
        ]);

        return redirect('/verify-otp')
            ->with(
                'success',
                'Kode OTP telah dikirim ke email Anda'
            );
    }

    /**
     * 🔹 LOGOUT
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * 🔹 PROFIL
     */
    public function profil()
    {
        return view('warga.profil');
    }

    /**
     * 🔹 UPDATE PROFIL + PASSWORD
     */
    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
            'phone' => 'nullable|regex:/^[0-9]+$/|min:10|max:15',
            'alamat' => 'nullable'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->email;
        $user->nik = $request->nik;
        $user->alamat = $request->alamat;
        $user->phone = $request->phone;

        // 🔥 kalau password diubah
        if (!empty($request->password)) {

            $hashData = $this->generateHashBenchmark($request->password);

            // update password utama
            $user->password = $hashData['bcrypt_hash'];

            // simpan ke log
            PasswordLog::create([
                'user_id' => $user->id,
                'bcrypt_hash' => $hashData['bcrypt_hash'],
                'md5_hash' => $hashData['md5_hash'],
                'sha1_hash' => $hashData['sha1_hash'],
                'time_bcrypt' => $hashData['time_bcrypt'],
                'time_md5' => $hashData['time_md5'],
                'time_sha1' => $hashData['time_sha1'],
            ]);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $user = User::find(session('otp_user_id'));

        if (!$user) {
            return redirect('/login');
        }

        // cek OTP salah
        if ($user->otp != $request->otp) {
            return back()->with('error', 'Kode OTP salah');
        }

        // cek expired
        if (now()->gt($user->otp_expired_at)) {
            return back()->with('error', 'Kode OTP sudah expired');
        }

        // hapus OTP
        $user->otp = null;
        $user->otp_expired_at = null;
        $user->email_verified_at = now();
        $user->save();

        // login user
        Auth::login($user);

        session()->forget('otp_user_id');

        $benchmark = session('benchmark');

        // redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect('/dashboard')
                ->with('benchmark', $benchmark);
        }

        return redirect('/')
            ->with('benchmark', $benchmark);
    }
}
