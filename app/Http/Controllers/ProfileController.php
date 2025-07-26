<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the profile page.
     */
    public function index()
    {
        return view('admin.profile.index');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = User::find(session('logged_id'));

        if (!$user) {
            return back()->withErrors(['error' => 'User tidak ditemukan.']);
        }

        $request->validate([
            'nama_admin' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'nama_admin' => $request->nama_admin,
            'email' => $request->email,
        ]);

        return back()->with('success_profile', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = User::find(session('logged_id'));

        if (!$user) {
            return back()->withErrors(['error' => 'User tidak ditemukan.']);
        }

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success_password', 'Password berhasil diperbarui.');
    }
}
