<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MetodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metodePembayarans = MetodePembayaran::orderBy('nama', 'asc')->get();

        return view('admin.metode.index', compact('metodePembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.metode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:10|unique:metode_pembayaran,kode',
            'atas_nama' => 'required|string|max:255',
            'nomor_rekening' => 'nullable|string|max:50',
            'biaya_admin' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_aktif' => 'boolean',
        ]);

        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('images/metode-pembayaran', 'public');
            $data['logo'] = $logoPath;
        }

        $data['is_aktif'] = $request->has('is_aktif');

        MetodePembayaran::create($data);

        return redirect()->route('metode.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MetodePembayaran $metode)
    {
        return view('admin.metode.show', compact('metode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MetodePembayaran $metode)
    {
        return view('admin.metode.edit', compact('metode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MetodePembayaran $metode)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:10|unique:metode_pembayaran,kode,' . $metode->id,
            'atas_nama' => 'required|string|max:255',
            'nomor_rekening' => 'nullable|string|max:50',
            'biaya_admin' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_aktif' => 'boolean',
        ]);

        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($metode->logo) {
                Storage::disk('public')->delete($metode->logo);
            }

            $logoPath = $request->file('logo')->store('images/metode-pembayaran', 'public');
            $data['logo'] = $logoPath;
        }

        $data['is_aktif'] = $request->has('is_aktif');

        $metode->update($data);

        return redirect()->route('metode.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MetodePembayaran $metode)
    {
        // Delete logo file
        if ($metode->logo) {
            Storage::disk('public')->delete($metode->logo);
        }

        $metode->delete();

        return redirect()->route('metode.index')
            ->with('success', 'Metode pembayaran berhasil dihapus.');
    }

    /**
     * Toggle status aktif/nonaktif
     */
    public function toggleStatus(MetodePembayaran $metode)
    {
        $metode->update([
            'is_aktif' => !$metode->is_aktif
        ]);

        $status = $metode->is_aktif ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('metode.index')
            ->with('success', "Metode pembayaran berhasil {$status}.");
    }
}
