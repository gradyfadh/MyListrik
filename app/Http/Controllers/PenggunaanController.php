<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class PenggunaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penggunaan::with('pelanggan');

        if ($request->filled('nomor_kwh')) {
            $query->whereHas('pelanggan', function ($q) use ($request) {
                $q->where('nomor_kwh', 'like', '%' . $request->nomor_kwh . '%');
            });
        }

        if ($request->filled('status')) {
            $query->whereHas('pelanggan', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $penggunaans = $query->get();
        $pelanggans = Pelanggan::where('status', 'aktif')->get();

        return view('admin.penggunaan.index', compact('penggunaans', 'pelanggans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::where('status', 'aktif')->get();
        return view('admin.penggunaan.create-modal', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
            'meter_awal' => 'required|integer|min:0',
            'meter_akhir' => 'required|integer|gte:meter_awal',
        ], [
            'meter_akhir.gte' => 'Meter akhir harus lebih besar atau sama dengan meter awal.',
            'meter_akhir.required' => 'Meter akhir wajib diisi.',
            'meter_akhir.integer' => 'Meter akhir harus berupa angka.',
            'meter_awal.required' => 'Meter awal wajib diisi.',
            'meter_awal.integer' => 'Meter awal harus berupa angka.',
            'meter_awal.min' => 'Meter awal tidak boleh negatif.',
        ]);

        $exists = Penggunaan::where('id_pelanggan', $request->id_pelanggan)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Data penggunaan sudah ada untuk pelanggan dan periode ini.')->withInput();
        }

        $penggunaan = Penggunaan::create([
            'id_pelanggan' => $request->id_pelanggan,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'meter_awal' => $request->meter_awal,
            'meter_akhir' => $request->meter_akhir,
        ]);

        $jumlah_meter = $request->meter_akhir - $request->meter_awal;
        $pelanggan = Pelanggan::with('tarif')->find($request->id_pelanggan);
        $tarif_per_kwh = $pelanggan->tarif->tarif_perkwh;

        $tagihan = Tagihan::create([
            'id_pelanggan' => $request->id_pelanggan,
            'id_penggunaan' => $penggunaan->id_penggunaan,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah_meter' => $jumlah_meter,
            'total_tagihan' => $jumlah_meter * $tarif_per_kwh,
            'status' => 'Belum Lunas',
        ]);

        return redirect()->route('admin.penggunaan.index')->with('success', 'Data penggunaan dan tagihan berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $penggunaan = Penggunaan::findOrFail($id);
        $pelanggans = Pelanggan::where('status', 'aktif')->get();
        return view('admin.penggunaan.index', compact('penggunaans', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $penggunaan = Penggunaan::findOrFail($id);

        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|digits:4',
            'meter_awal' => 'required|numeric|min:0',
            'meter_akhir' => 'required|numeric|min:0|gte:meter_awal',
        ], [
            'meter_akhir.gte' => 'Meter akhir harus lebih besar atau sama dengan meter awal.',
            'meter_akhir.required' => 'Meter akhir wajib diisi.',
            'meter_akhir.numeric' => 'Meter akhir harus berupa angka.',
            'meter_awal.required' => 'Meter awal wajib diisi.',
            'meter_awal.numeric' => 'Meter awal harus berupa angka.',
            'meter_awal.min' => 'Meter awal tidak boleh negatif.',
        ]);

        // Cek apakah ada perubahan pada periode yang sama untuk pelanggan lain
        $exists = Penggunaan::where('id_pelanggan', $request->id_pelanggan)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('id_penggunaan', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Data penggunaan sudah ada untuk pelanggan dan periode ini.')->withInput();
        }

        try {
            // Update penggunaan
            $penggunaan->update([
                'id_pelanggan' => $request->id_pelanggan,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'meter_awal' => $request->meter_awal,
                'meter_akhir' => $request->meter_akhir,
            ]);

            // Hitung ulang tagihan jika ada
            $tagihan = Tagihan::where('id_penggunaan', $id)->first();
            if ($tagihan) {
                $jumlah_meter = $request->meter_akhir - $request->meter_awal;
                $pelanggan = Pelanggan::with('tarif')->find($request->id_pelanggan);
                $tarif_per_kwh = $pelanggan->tarif->tarif_perkwh;

                $tagihan->update([
                    'id_pelanggan' => $request->id_pelanggan,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'jumlah_meter' => $jumlah_meter,
                    'total_tagihan' => $jumlah_meter * $tarif_per_kwh,
                ]);
            }

            return redirect()->route('admin.penggunaan.index')->with('success', 'Penggunaan dan tagihan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $penggunaan = Penggunaan::findOrFail($id);

            // Hapus tagihan terkait terlebih dahulu
            Tagihan::where('id_penggunaan', $id)->delete();

            // Kemudian hapus penggunaan
            $penggunaan->delete();

            return redirect()->route('admin.penggunaan.index')->with('success', 'Penggunaan dan tagihan terkait berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.penggunaan.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
