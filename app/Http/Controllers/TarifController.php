<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::all();
        return view('admin.tarif.index', compact('tarifs'));
    }

    public function showToPelanggan()
    {
        $tarifs = Tarif::all();
        return view('pelanggan.tarif.index', compact('tarifs'));
    }

    public function create()
    {
        return view('admin.tarif.create-modal');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_tarif' => 'required|unique:tarifs',
            'daya' => 'required|integer',
            'tarifperkwh' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        Tarif::create([
            'kode_tarif' => $request->kode_tarif,
            'daya' => $request->daya,
            'tarifperkwh' => $request->tarifperkwh,
            'deskripsi' => $request->deskripsi,
        ]);
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tarif = Tarif::findOrFail($id);
        return view('admin.tarif.edit-modal', compact('tarif'));
    }

    public function update(Request $request, $id)
    {
        $tarif = Tarif::findOrFail($id);

        $request->validate([
            'kode_tarif' => 'required|unique:tarifs,kode_tarif,' . $tarif->id_tarif . ',id_tarif',
            'daya' => 'required|integer',
            'tarifperkwh' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        $tarif->update([
            'kode_tarif' => $request->kode_tarif,
            'daya' => $request->daya,
            'tarifperkwh' => $request->tarifperkwh,
            'deskripsi' => $request->deskripsi,
        ]);
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Tarif::destroy($id);
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil dihapus.');
    }
}
