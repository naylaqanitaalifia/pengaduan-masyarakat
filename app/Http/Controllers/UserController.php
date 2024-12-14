<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'STAFF')->get();
        return view('headstaff.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'STAFF',
        ]);

        return redirect()->back()->with('success', 'Staff berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user -> role == 'STAFF' && $user->responses()->exists()) {
            return redirect()->back()->with('failed', 'Tidak dapat menghapus akun, staff sudah pernah membuat tanggapan!');
        } else {
            $user->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus akun!');
        }
    }

    public function resetPassword($id) {
        $user = User::findOrFail($id);

        $newPassword = substr($user->email, 0, 4);

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        return redirect()->back()->with('success', 'Password berhasil direset!');
    }
}
