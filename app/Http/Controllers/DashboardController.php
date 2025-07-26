<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahMenunggu = Pelanggan::where('status', 'waiting')->count();
        $jumlahAktif = Pelanggan::where('status', 'aktif')->count();
        $jumlahTarif = Tarif::count();

        return view('admin.dashboard.index', compact('jumlahMenunggu', 'jumlahAktif', 'jumlahTarif'));
    }
}
