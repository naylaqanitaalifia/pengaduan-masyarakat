<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function loginOrRegister(Request $request) {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|min:6',
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if ($user) {
    //         if (Hash::check($request->password, $user->password)) {
    //             Auth::login($user);

    //             switch ($user->role) {
    //                 case 'GUEST':
    //                     return redirect()->route('report.articles')->with('success', 'Berhasil login!');
    //                     break;
    //                 case 'STAFF':
    //                     return redirect()->route('report.index')->with('success', 'Berhasil login!');
    //                     break;
    //                 case 'HEAD_STAFF':
    //                     return redirect()->route('report.dashboard')->with('success', 'Berhasil login!');
    //                     break;
    //                 default:
    //                     return redirect()->back()->with('failed', 'Role tidak dikenali!');
    //                     break;
    //             }
    //         } else {
    //             return redirect()->back()->with('failed', 'Password salah!');
    //         }
    //     } else {
    //             $user = User::create([
    //                 'email' => $request->email,
    //                 'password' => Hash::make($request->password),
    //             ]);
    
    //             Auth::login($user);

    //             if ($user->role == 'GUEST') {
    //                 return redirect()->route('report.articles')->with('Berhasil login');
    //             } elseif ($user->role == 'STAFF') {
    //                 return redirect()->route('report.index')->with('Berhasil login!');
    //             } elseif ($user->role == 'HEAD_STAFF') {
    //                 return redirect()->route('report.dashboard')->with('Berhasil login!');
    //             } else {
    //                 return redirect()->back()->with('failed', 'Role tidak dikenali!');
    //             }
    //         }
    // }

    public function loginOrRegister(Request $request) {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        // Cari pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            // Tangani kasus login dengan password biasa
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return $this->redirectByRole($user);
            }
    
            // Tangani login dengan password default (reset password)
            $defaultPassword = substr($user->email, 0, 4);
            if ($user->password_reset_at && $request->password === $defaultPassword) {
                Auth::login($user);
                return $this->redirectByRole($user);
            }
    
            // Jika password salah
            return redirect()->back()->with('failed', 'Password salah!');
        }
    
        // Jika pengguna tidak ditemukan, buat pengguna baru
        $newUser = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        Auth::login($newUser);
        return $this->redirectByRole($newUser);
    }

    private function redirectByRole($user) {
        switch ($user->role) {
            case 'GUEST':
                return redirect()->route('report.articles')->with('success', 'Berhasil login!');
            case 'STAFF':
                return redirect()->route('report.index')->with('success', 'Berhasil login!');
            case 'HEAD_STAFF':
                return redirect()->route('report.dashboard')->with('success', 'Berhasil login!');
            default:
                return redirect()->back()->with('failed', 'Role tidak dikenali!');
        }
    }
    
    

    public function logout() {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}
