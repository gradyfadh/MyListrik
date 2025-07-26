<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['tagihan', 'pelanggan', 'admin', 'metodePembayaran'])
            ->whereHas('tagihan', function ($q) {
                $q->where('status', 'Sudah Lunas');
            })
            ->latest('tanggal_pembayaran');

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->where('bulan_bayar', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pembayaran', $request->tahun);
        }

        $pembayarans = $query->paginate(10);

        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    public function create($tagihanId)
    {
        $tagihan = Tagihan::with('pelanggan.tarif')->findOrFail($tagihanId);

        if ($tagihan->status === 'Sudah Lunas') {
            return redirect()->route('pelanggan.tagihan')->with('error', 'Tagihan sudah lunas.');
        }

        // Hitung total bayar untuk konsistensi
        $biayaAdmin = 2500;
        $totalBayar = $tagihan->jumlah_meter * $tagihan->pelanggan->tarif->tarifperkwh + $biayaAdmin;
        $tagihan->total_bayar = $totalBayar;

        // Jika ada parameter step=upload, tampilkan halaman upload
        if (request('step') === 'upload') {
            return view('pelanggan.pembayaran.upload', compact('tagihan'));
        }

        // Default tampilkan halaman detail tagihan
        return view('pelanggan.pembayaran.index', compact('tagihan'));
    }

    public function metodePembayaran($tagihanId)
    {
        $tagihan = Tagihan::with('pelanggan.tarif')->findOrFail($tagihanId);

        if ($tagihan->status === 'Sudah Lunas') {
            return redirect()->route('pelanggan.tagihan')->with('error', 'Tagihan sudah lunas.');
        }

        // Hitung total bayar (tarif + biaya admin)
        $biayaAdmin = 2500;
        $totalBayar = $tagihan->jumlah_meter * $tagihan->pelanggan->tarif->tarifperkwh + $biayaAdmin;
        $tagihan->total_bayar = $totalBayar;

        return view('pelanggan.pembayaran.metode-pembayaran', compact('tagihan'));
    }

    public function store(Request $r, $tagihanId)
    {
        try {
            $tagihan = Tagihan::with('pelanggan')->findOrFail($tagihanId);

            // Debug logging
            Log::info('Payment submission started', [
                'tagihan_id' => $tagihanId,
                'request_data' => $r->all(),
                'has_file' => $r->hasFile('bukti_pembayaran')
            ]);

            $r->validate([
                'bukti_pembayaran' => 'required|image|max:2048',
                'metode_pembayaran_id' => 'required|exists:metode_pembayaran,id',
            ]);

            $path = $r->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

            // Get admin fee from selected payment method
            $metodePembayaran = \App\Models\MetodePembayaran::findOrFail($r->metode_pembayaran_id);
            $biayaAdmin = $metodePembayaran->biaya_admin;
            $total      = $tagihan->jumlah_meter * $tagihan->pelanggan->tarif->tarifperkwh + $biayaAdmin;

            $pembayaran = Pembayaran::create([
                'id_tagihan'        => $tagihan->id_tagihan,
                'id_pelanggan'      => $tagihan->id_pelanggan,
                'tanggal_pembayaran' => now()->toDateString(),
                'bulan_bayar'       => $tagihan->bulan,
                'metode_pembayaran_id' => $r->metode_pembayaran_id,
                'biaya_admin'       => $biayaAdmin,
                'total_bayar'       => $total,
                'id'          => null,
                'bukti_pembayaran'  => $path,
            ]);

            $tagihan->update(['status' => 'Menunggu Verifikasi']);

            Log::info('Payment submission successful', [
                'payment_id' => $pembayaran->id_pembayaran
            ]);

            return redirect()->route('pelanggan.tagihan')
                ->with('success', 'Bukti pembayaran diunggah, menunggu verifikasi.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Payment validation failed', [
                'errors' => $e->errors(),
                'request_data' => $r->all()
            ]);
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            Log::error('Payment submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Terjadi kesalahan saat mengunggah pembayaran. Silakan coba lagi.');
        }
    }

    public function verifikasi($pembayaranId)
    {
        $pembayaran = Pembayaran::with('tagihan')->findOrFail($pembayaranId);

        $pembayaran->update([
            'id'           => Auth::id(),
            'tanggal_pembayaran' => now()->toDateString(),
        ]);

        $pembayaran->tagihan->update(['status' => 'Sudah Lunas']);

        return back()->with('success', 'Pembayaran telah diverifikasi.');
    }

    public function downloadBukti($pembayaranId)
    {
        $pembayaran = Pembayaran::findOrFail($pembayaranId);
        return response()->download(storage_path('app/public/' . $pembayaran->bukti_pembayaran));
    }

    public function riwayatPembayaran(Request $request)
    {
        $pelangganId = session('logged_id'); // Using session instead of Auth guard

        if (!$pelangganId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $query = Pembayaran::with(['tagihan.pelanggan.tarif', 'admin'])
            ->where('id_pelanggan', $pelangganId)
            ->whereHas('tagihan', function ($q) {
                $q->where('status', 'Sudah Lunas');
            })
            ->latest('tanggal_pembayaran');

        // Filter berdasarkan bulan
        if ($request->filled('bulan') && $request->bulan !== 'all') {
            $query->where('bulan_bayar', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun') && $request->tahun !== 'all') {
            $query->whereYear('tanggal_pembayaran', $request->tahun);
        }

        $pembayarans = $query->paginate(5);

        // Data untuk filter dropdown - only from paid bills
        $availableMonths = Pembayaran::where('id_pelanggan', $pelangganId)
            ->whereHas('tagihan', function ($q) {
                $q->where('status', 'Sudah Lunas');
            })
            ->selectRaw('DISTINCT bulan_bayar')
            ->orderBy('bulan_bayar')
            ->pluck('bulan_bayar');

        $availableYears = Pembayaran::where('id_pelanggan', $pelangganId)
            ->whereHas('tagihan', function ($q) {
                $q->where('status', 'Sudah Lunas');
            })
            ->selectRaw('DISTINCT YEAR(tanggal_pembayaran) as year')
            ->orderByDesc('year')
            ->pluck('year');

        return view('pelanggan.riwayat.riwayat-pembayaran', compact('pembayarans', 'availableMonths', 'availableYears'));
    }

    public function printStruk($pembayaranId)
    {
        $pembayaran = Pembayaran::with(['tagihan.pelanggan.tarif', 'admin', 'metodePembayaran'])->findOrFail($pembayaranId);

        // Pastikan pembayaran ini milik pelanggan yang sedang login
        $pelangganId = session('logged_id');
        if ($pembayaran->id_pelanggan != $pelangganId) {
            abort(403, 'Unauthorized access');
        }

        // Gunakan data tagihan dari pembayaran untuk kompatibilitas dengan view yang ada
        $tagihan = $pembayaran->tagihan;

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.tagihan.struk', compact('tagihan', 'pembayaran'));
        $pdf->setPaper('A5', 'portrait');
        return $pdf->stream('struk-pembayaran-' . $pembayaran->id_pembayaran . '.pdf');
    }
}
