<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PelangganAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.pelanggan-login');
    }

    public function showRegister()
    {
        $tarifs = Tarif::all();
        return view('auth.pelanggan-register', compact('tarifs'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggans',
            'password' => 'required|string|min:8|confirmed',
            'nomor_kwh' => 'required|string|unique:pelanggans',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'id_tarif' => 'required|exists:tarifs,id_tarif',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'nomor_kwh.required' => 'Nomor KWH wajib diisi.',
            'nomor_kwh.unique' => 'Nomor KWH sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'id_tarif.required' => 'Tarif listrik wajib dipilih.',
            'id_tarif.exists' => 'Tarif yang dipilih tidak valid.',
        ]);

        try {
            $pelanggan = Pelanggan::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nomor_kwh' => $request->nomor_kwh,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'id_tarif' => $request->id_tarif,
                'status' => 'waiting', // Default status waiting untuk approval admin
            ]);

            return redirect()->route('pelanggan.login')
                ->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu persetujuan admin. Silakan login setelah disetujui.');

        } catch (\Exception $e) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah pelanggan ada dan statusnya aktif
        $pelanggan = Pelanggan::where('email', $request->email)->first();

        if (!$pelanggan) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email tidak terdaftar.');
        }

        if ($pelanggan->status !== 'aktif') {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Akun Anda belum diaktifkan oleh admin. Silakan hubungi admin.');
        }

        // Login sebagai pelanggan menggunakan guard 'pelanggan'
        if (Auth::guard('pelanggan')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            Session::put('logged_id', Auth::guard('pelanggan')->user()->id_pelanggan);
            Session::put('logged_in', true);
            Session::put('level', 2); // pelanggan
            return redirect()->route('pelanggan.index');
        }

        // Jika gagal login
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email / Password salah.');
    }

    public function logout()
    {
        Auth::guard('pelanggan')->logout();
        Session::flush();
        return redirect()->route('pelanggan.login');
    }
}
