<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        // bcrypt
        $startBcrypt = microtime(true);
        $bcryptHash = Hash::make($plain);
        $timeBcrypt = microtime(true) - $startBcrypt;

        // md5
        $startMd5 = microtime(true);
        $md5Hash = md5($plain);
        $timeMd5 = microtime(true) - $startMd5;

        // sha1
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
            'password' => 'required|confirmed|min:6',
            'nik' => 'required',
            'phone' => 'required|regex:/^[0-9]+$/|min:10|max:15'
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
            return back()->with('error', 'User tidak ditemukan')->withInput();
        }

        $plain = $request->password;

        // benchmarking (tidak disimpan ke DB)
        $startBcrypt = microtime(true);
        $bcryptCheck = Hash::check($plain, $user->password);
        $timeBcrypt = microtime(true) - $startBcrypt;

        $startMd5 = microtime(true);
        md5($plain);
        $timeMd5 = microtime(true) - $startMd5;

        $startSha1 = microtime(true);
        sha1($plain);
        $timeSha1 = microtime(true) - $startSha1;

        if (!$bcryptCheck) {
            return back()->with('error', 'Password salah')->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        $benchmark = [
            'bcrypt' => round($timeBcrypt * 1000, 5),
            'md5' => round($timeMd5 * 1000, 5),
            'sha1' => round($timeSha1 * 1000, 5),
        ];

        if ($user->role === 'admin') {
            return redirect('/dashboard')->with('benchmark', $benchmark);
        }

        return redirect('/')->with('benchmark', $benchmark);
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
}
