@extends('admin.index')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-bold mb-4">📋 Daftar Pelanggan Aktif</h2>

        <!-- Include Alert Component dengan Fixed Position -->
        <div class="fixed top-4 right-4 z-50 max-w-md">
            @include('components.alert')
        </div>

        <div class="overflow-x-auto">
            <table id="pelangganTable" class="min-w-full text-sm border display nowrap">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="py-2 px-4 border">#</th>
                        <th class="py-2 px-4 border">No. KWH</th>
                        <th class="py-2 px-4 border">Nama</th>
                        <th class="py-2 px-4 border">Email</th>
                        <th class="py-2 px-4 border">No. Telp</th>
                        <th class="py-2 px-4 border">Alamat</th>
                        <th class="py-2 px-4 border">Tarif</th>
                        <th class="py-2 px-4 border">Status</th>
                        <th class="py-2 px-4 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $pelanggan)
                        <tr>
                            <td class="py-2 px-4 border">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border">{{ $pelanggan->nomor_kwh }}</td>
                            <td class="py-2 px-4 border">{{ $pelanggan->nama_pelanggan }}</td>
                            <td class="py-2 px-4 border">{{ $pelanggan->email }}</td>
                            <td class="py-2 px-4 border">{{ $pelanggan->no_telp_formatted }}</td>
                            <td class="py-2 px-4 border">{{ $pelanggan->alamat }}</td>
                            <td class="py-2 px-4 border">{{ $pelanggan->tarif->daya ?? '-' }} VA</td>
                            <td class="py-2 px-4 border">
                                <span class="text-green-600 font-semibold capitalize">{{ $pelanggan->status }}</span>
                            </td>
                            <td class="border align-middle">
                                <div class="flex flex-row gap-2 items-center justify-center">
                                    <!-- Tombol Edit -->
                                    <button onclick="openEditModal(JSON.parse(this.getAttribute('data-pelanggan')));"
                                        class="bg-blue-200 text-blue-600 p-2 rounded-md flex items-center justify-center"
                                        data-pelanggan='@json($pelanggan)' title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id_pelanggan) }}"
                                        method="POST" class="m-0 p-0">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus pelanggan ini?')"
                                            class="bg-red-200 text-red-600 p-2 rounded-md flex items-center justify-center"
                                            title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">Belum ada pelanggan aktif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <script>
                $(document).ready(function() {
                    const table = $('#pelangganTable').DataTable({
                        responsive: true,
                        dom: '<"flex justify-between items-center mb-4 mt-5"lfB>tip',
                        buttons: [{
                                extend: 'copy',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'csv',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'excel',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                }
                            }
                        ]
                    });

                    table.buttons().containers().addClass('flex gap-2');
                    table.buttons().nodes().each(function(value, index) {
                        $(this).removeClass('dt-button').addClass(
                            'bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition');
                    });
                });
            </script>
        </div>
    </div>
@endsection

@include('admin.pelanggan.edit-modal')

<script>
    function openEditModal(data) {
        const modal = document.getElementById('editModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.getElementById('edit_id_pelanggan').value = data.id_pelanggan;
        document.getElementById('edit_nama_pelanggan').value = data.nama_pelanggan;
        document.getElementById('edit_email').value = data.email;
        document.getElementById('edit_no_telp').value = data.no_telp;
        document.getElementById('edit_nomor_kwh').value = data.nomor_kwh;
        document.getElementById('edit_alamat').value = data.alamat;
        document.getElementById('edit_status').value = data.status;
        document.getElementById('edit_id_tarif').value = data.id_tarif;

        document.getElementById('editForm').action = `/admin/pelanggan/${data.id_pelanggan}`;
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
