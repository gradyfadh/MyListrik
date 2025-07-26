{{--  resources/views/admin/metode/index.blade.php  --}}
@extends('admin.index')

@section('content')
    <!-- Wrapper -->
    <div class="bg-white shadow rounded-lg p-6 mb-5">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-1">Daftar Metode Pembayaran</h2>
                <p class="text-sm text-gray-500">Kelola metode pembayaran yang tersedia untuk pelanggan Anda.</p>
            </div>
            <a href="{{ route('metode.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                <i class="ti ti-plus mr-2"></i>Tambah Metode
            </a>
        </div>

        <!-- Include Alert Component dengan Fixed Position -->
        <div class="fixed top-4 right-4 z-50 max-w-md">
            @include('components.alert')
        </div>
    </div>

    <!-- Cards wrapper -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="cardsContainer">
        @forelse($metodePembayarans as $metode)
            <div class="metode-card bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200"
                data-nama="{{ strtolower($metode->nama) }}" data-kode="{{ strtolower($metode->kode) }}"
                data-atas-nama="{{ strtolower($metode->atas_nama) }}" data-status="{{ $metode->is_aktif ? '1' : '0' }}">
                <!-- Card Header -->
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $metode->logo_url }}" alt="Logo {{ $metode->nama }}"
                                class="w-10 h-10 object-contain rounded-md border border-gray-100">
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm">{{ $metode->nama }}</h3>
                                {{-- <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                        {{ $metode->kode }}
                                    </span> --}}
                            </div>
                        </div>
                        <div class="flex items-center space-x-1">
                            @if ($metode->is_aktif)
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Aktif</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-4 space-y-3">
                    <div class="grid grid-cols-1 gap-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Atas Nama:</span>
                            <span class="text-gray-900 font-medium">{{ $metode->atas_nama }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">No. Rekening:</span>
                            <span class="text-gray-900 font-medium">{{ $metode->nomor_rekening ?: '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Biaya Admin:</span>
                            <span class="text-gray-900 font-medium">{{ $metode->biaya_admin_format }}</span>
                        </div>
                    </div>

                    @if ($metode->deskripsi)
                        <div class="pt-2 border-t border-gray-100">
                            <p class="text-xs text-gray-600">{{ $metode->deskripsi }}</p>
                        </div>
                    @endif
                </div>

                <!-- Card Footer -->
                <div class="p-4 bg-gray-50 border-t border-gray-100 rounded-b-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">#{{ $loop->iteration }}</span>
                        <div class="flex items-center space-x-2">
                            <!-- Toggle Status -->
                            <form action="{{ route('metode.toggle-status', $metode) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="text-gray-600 hover:text-gray-800 p-1 rounded hover:bg-gray-200 transition-colors"
                                    title="{{ $metode->is_aktif ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="ti ti-toggle-{{ $metode->is_aktif ? 'right' : 'left' }} text-lg"></i>
                                </button>
                            </form>

                            <!-- Edit -->
                            <a href="{{ route('metode.edit', $metode) }}"
                                class="text-blue-600 hover:text-blue-800 p-1 rounded hover:bg-blue-50 transition-colors"
                                title="Edit">
                                <i class="ti ti-pencil text-lg"></i>
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('metode.destroy', $metode) }}" method="POST" class="inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus metode pembayaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors"
                                    title="Hapus">
                                    <i class="ti ti-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white border-2 border-dashed border-gray-200 rounded-lg p-12 text-center">
                    <i class="ti ti-credit-card-off text-6xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada metode pembayaran</h3>
                    <p class="text-sm text-gray-500 mb-6">Tambahkan metode pembayaran pertama Anda untuk mulai mengelola
                        transaksi.</p>
                    <a href="{{ route('metode.create') }}"
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg text-sm font-medium transition-colors">
                        <i class="ti ti-plus mr-2"></i>Tambah Metode Pembayaran
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if ($metodePembayarans->count() > 0)
        <div class="mt-6 text-sm text-gray-500">
            Total: {{ $metodePembayarans->count() }} metode pembayaran
        </div>
    @endif
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize tooltips for action buttons
            $('[title]').tooltip();

            // Search functionality
            $('#searchInput').on('keyup', function() {
                filterCards();
            });

            // Status filter functionality
            $('#statusFilter').on('change', function() {
                filterCards();
            });

            function filterCards() {
                const searchTerm = $('#searchInput').val().toLowerCase();
                const statusFilter = $('#statusFilter').val();
                let visibleCards = 0;

                $('.metode-card').each(function() {
                    const card = $(this);
                    const nama = card.data('nama');
                    const kode = card.data('kode');
                    const atasNama = card.data('atas-nama');
                    const status = card.data('status').toString();

                    // Check search term
                    const matchesSearch = searchTerm === '' ||
                        nama.includes(searchTerm) ||
                        kode.includes(searchTerm) ||
                        atasNama.includes(searchTerm);

                    // Check status filter
                    const matchesStatus = statusFilter === '' || status === statusFilter;

                    if (matchesSearch && matchesStatus) {
                        card.show();
                        visibleCards++;
                    } else {
                        card.hide();
                    }
                });

                // Show/hide no results message
                if (visibleCards === 0 && $('.metode-card').length > 0) {
                    if ($('#noResultsMessage').length === 0) {
                        $('#cardsContainer').append(`
                            <div id="noResultsMessage" class="col-span-full">
                                <div class="bg-white border-2 border-dashed border-gray-200 rounded-lg p-12 text-center">
                                    <i class="ti ti-search-off text-6xl text-gray-400 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada hasil ditemukan</h3>
                                    <p class="text-sm text-gray-500">Coba ubah kata kunci pencarian atau filter yang digunakan.</p>
                                </div>
                            </div>
                        `);
                    }
                } else {
                    $('#noResultsMessage').remove();
                }
            }
        });
    </script>
@endpush
