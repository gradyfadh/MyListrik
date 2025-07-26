<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tagihan::with(['pelanggan', 'pembayaran']);

        if ($request->filled('nomor_kwh')) {
            $query->whereHas('pelanggan', function ($q) use ($request) {
                $q->where('nomor_kwh', 'like', '%' . $request->nomor_kwh . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tagihans = $query->get();

        return view('admin.tagihan.index', compact('tagihans'));
    }

    public function pelangganIndex(Request $request)
    {
        $pelangganId = session('logged_id');

        $query = Tagihan::with(['pelanggan.tarif'])
            ->where('id_pelanggan', $pelangganId)
            ->whereIn('status', ['Belum Lunas', 'Menunggu Verifikasi'])
            ->orderByDesc('tahun')
            ->orderByDesc('bulan');

        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', $request->status);
        }

        $tagihans        = $query->get();
        $selectedStatus  = $request->status ?? 'Semua';

        return view(
            'pelanggan.tagihan.index',
            compact('tagihans', 'selectedStatus')
        );
    }

    public function konfirmasi($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->status = 'Sudah Lunas';
        $tagihan->save();

        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil dikonfirmasi.');
    }

    public function preview($id)
    {
        $tagihan = Tagihan::with(['pelanggan.tarif', 'pembayaranTerbaru.metodePembayaran'])->findOrFail($id);
        $pembayaran = $tagihan->pembayaranTerbaru;
        return view('admin.tagihan.struk', compact('tagihan', 'pembayaran'));
    }

    public function print($id)
    {
        $tagihan = Tagihan::with(['pelanggan.tarif', 'pembayaranTerbaru.metodePembayaran'])->findOrFail($id);
        $pembayaran = $tagihan->pembayaranTerbaru;
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.tagihan.struk', compact('tagihan', 'pembayaran'));
        $pdf->setPaper('A5', 'portrait');
        return $pdf->stream('struk-tagihan-' . $tagihan->id_tagihan . '.pdf');
    }

    public function exportPdf(Request $request)
    {
        $query = Tagihan::with('pelanggan');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('nomor_kwh')) {
            $query->whereHas('pelanggan', function ($q) use ($request) {
                $q->where('nomor_kwh', 'like', '%' . $request->nomor_kwh . '%');
            });
        }

        $tagihans = $query->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        $pdf = PDF::loadView('admin.tagihan.laporan', compact('tagihans'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-tagihan.pdf');
    }

    public function bayar($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->status = 'Menunggu Verifikasi';
        $tagihan->save();

        return redirect()->route('admin.tagihan.index')->with('success', 'Status tagihan berubah ke Menunggu Verifikasi.');
    }

    public function destroy($id)
    {
        Tagihan::destroy($id);
        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }

    public function strukPelanggan($id)
    {
        $tagihan = Tagihan::with(['pelanggan.tarif', 'pembayaranTerbaru.metodePembayaran'])->findOrFail($id);

        // Pastikan tagihan ini milik pelanggan yang sedang login
        $pelangganId = session('logged_id');
        if ($tagihan->id_pelanggan != $pelangganId) {
            abort(403, 'Unauthorized access');
        }

        // Gunakan pembayaran terbaru jika ada
        $pembayaran = $tagihan->pembayaranTerbaru;

        return view('admin.tagihan.struk', compact('tagihan', 'pembayaran'));
    }
}
