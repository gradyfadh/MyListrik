<?php

namespace App\Http\Controllers;

use App\Models\Penggunaan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PelangganDashboardController extends Controller
{
    public function index()
    {
        return view('pelanggan.index');
    }

    public function riwayatPenggunaan(Request $request)
    {
        // Ambil ID pelanggan yang sedang login
        $id_pelanggan = Session::get('logged_id');
        
        if (!$id_pelanggan) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Query data penggunaan
        $query = Penggunaan::with(['pelanggan.tarif'])
            ->where('id_pelanggan', $id_pelanggan);

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $penggunaans = $query->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('pelanggan.riwayat.riwayat-penggunaan', compact('penggunaans'));
    }

    public function riwayatPembayaran(Request $request)
    {
        // Ambil ID pelanggan yang sedang login
        $id_pelanggan = Session::get('logged_id');
        
        if (!$id_pelanggan) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Query data pembayaran
        $query = Pembayaran::with(['pelanggan', 'tagihan'])
            ->where('id_pelanggan', $id_pelanggan);

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->where('bulan_bayar', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pembayaran', $request->tahun);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->whereHas('tagihan', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $pembayarans = $query->orderBy('tanggal_pembayaran', 'desc')->get();

        return view('pelanggan.riwayat.riwayat-pembayaran', compact('pembayarans'));
    }
}
