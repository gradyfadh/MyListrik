{{-- ===== Modal Konfirmasi Tagihan ===== --}}
<div id="modal-konfirmasi-{{ $tagihan->id_tagihan }}"
    class="fixed inset-0 z-50 hidden flex min-h-screen items-center justify-center bg-black/40">

    <div class="relative w-full max-w-lg bg-white rounded-lg shadow-lg p-6">
        {{-- judul --}}
        <h3 class="text-xl font-bold mb-4">Konfirmasi Pembayaran</h3>

        {{-- detail singkat --}}
        <div class="space-y-1 text-sm mb-6">
            <p><b>Periode:</b> {{ bulanIndo($tagihan->bulan) }} {{ $tagihan->tahun }}</p>
            <p><b>Pelanggan:</b> {{ $tagihan->pelanggan->nama_pelanggan }}</p>
            <p><b>Jumlah Meter:</b> {{ $tagihan->jumlah_meter }} kWh</p>
            @php
                $pembayaranTerbaru = $tagihan->pembayaran->sortByDesc('tanggal_pembayaran')->first();
            @endphp
            @if ($pembayaranTerbaru)
                <p><b>Metode Pembayaran:</b>
                    {{ $pembayaranTerbaru->metodePembayaran->nama ?? 'Tidak diketahui' }}
                </p>
                <p><b>Biaya Admin:</b>
                    Rp {{ number_format($pembayaranTerbaru->biaya_admin ?? 0, 0, ',', '.') }}
                </p>
                <p><b>Total Bayar:</b>
                    Rp {{ number_format($pembayaranTerbaru->total_bayar ?? 0, 0, ',', '.') }}
                </p>
                <p><b>Tanggal Upload:</b>
                    {{ $pembayaranTerbaru->created_at->format('d/m/Y H:i') }}
                </p>
            @else
                <p><b>Total Bayar:</b>
                    Rp
                    {{ number_format($tagihan->jumlah_meter * ($tagihan->pelanggan->tarif->tarifperkwh ?? 0) + 2500, 0, ',', '.') }}
                </p>
            @endif
        </div>

        {{-- bukti pembayaran --}}
        <div class="mb-6">
            <label class="block font-medium mb-2">Bukti Pembayaran</label>

            @if (
                $pembayaranTerbaru &&
                    $pembayaranTerbaru->bukti_pembayaran &&
                    Storage::disk('public')->exists($pembayaranTerbaru->bukti_pembayaran))
                <div class="flex justify-center">
                    <img class="max-w-full max-h-80 rounded object-contain border"
                        src="{{ Storage::disk('public')->url($pembayaranTerbaru->bukti_pembayaran) }}"
                        alt="Bukti pembayaran"
                        onclick="openImageModal('{{ Storage::disk('public')->url($pembayaranTerbaru->bukti_pembayaran) }}')"
                        style="cursor: pointer;">
                </div>
                <p class="text-xs text-gray-500 text-center mt-2">Klik gambar untuk memperbesar</p>
            @else
                <div class="bg-gray-100 text-gray-500 text-center py-8 rounded">
                    Belum ada bukti pembayaran
                </div>
            @endif
        </div>

        {{-- form konfirmasi --}}
        @if ($pembayaranTerbaru && $pembayaranTerbaru->id_pembayaran)
            <form action="{{ route('admin.pembayaran.verif', $pembayaranTerbaru->id_pembayaran) }}" method="POST"
                class="space-y-4">
                @csrf

                <div class="flex justify-end gap-2 pt-2">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Setujui Pembayaran
                    </button>
                    <button type="button" onclick="closeModal('{{ $tagihan->id_tagihan }}')"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                        Tutup
                    </button>
                </div>
            </form>
        @else
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                <p class="text-sm">
                    <strong>Peringatan:</strong> Belum ada data pembayaran untuk tagihan ini.
                    Pelanggan harus melakukan pembayaran terlebih dahulu sebelum verifikasi dapat dilakukan.
                </p>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('{{ $tagihan->id_tagihan }}')"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Tutup
                </button>
            </div>
        @endif

        {{-- tombol close X --}}
        <button type="button" onclick="closeModal('{{ $tagihan->id_tagihan }}')"
            class="absolute -top-2 -right-2 bg-grey text-gray-600 rounded-full w-8 h-8 shadow">
            &times;
        </button>
    </div>
</div>

{{-- helper JS --}}
<script>
    function openModal(id) {
        document.getElementById('modal-konfirmasi-' + id)?.classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById('modal-konfirmasi-' + id)?.classList.add('hidden');
    }
</script>
