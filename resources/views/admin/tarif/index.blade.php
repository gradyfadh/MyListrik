@extends('admin.index')

@section('content')
    <div class="p-6 bg-white rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-4">Daftar Tarif Listrik</h2>
        <button onclick="openCreateModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
            + Tambah Tarif
        </button>
        @include('admin.tarif.create-modal')

        <!-- Include Alert Component dengan Fixed Position -->
        <div class="fixed top-4 right-4 z-50 max-w-md">
            @include('components.alert')
        </div>

        <table id="tarifTable" class="display nowrap w-full border text-sm">
            <thead>
                <tr>
                    <th class="border">#</th>
                    <th class="border">Kode</th>
                    <th class="border">Daya</th>
                    <th class="border">Tarif/KWh</th>
                    <th class="border">Deskripsi</th>
                    <th class="border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tarifs as $i => $tarif)
                    <tr>
                        <td class="border">{{ $i + 1 }}</td>
                        <td class="border">{{ $tarif->kode_tarif }}</td>
                        <td class="border">{{ $tarif->daya }}</td>
                        <td class="border">Rp {{ number_format($tarif->tarifperkwh, 2, ',', '.') }}</td>
                        <td class="border">{{ $tarif->deskripsi }}</td>
                        <td class="border">
                            <div class="flex gap-2 justify-center">
                                <!-- Tombol Edit -->
                                <button onclick="openEditModal(JSON.parse(this.getAttribute('data-tarif')));"
                                    class="bg-blue-200 text-blue-600 p-2 rounded-md flex items-center justify-center"
                                    data-tarif='@json($tarif)'>
                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('tarif.destroy', $tarif->id_tarif) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')"
                                        class="bg-red-200 text-red-600 p-2 rounded-md flex items-center justify-center">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <script>
            $(document).ready(function() {
                const table = $('#tarifTable').DataTable({
                    responsive: true,
                    dom: '<"flex justify-between items-center mb-4 mt-5"lfB>tip',
                    buttons: [{
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4] // tanpa kolom aksi
                            }
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
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

    @include('admin.tarif.edit-modal')

    <script>
        function openEditModal(data) {
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('edit_id_tarif').value = data.id_tarif;
            document.getElementById('edit_kode_tarif').value = data.kode_tarif;
            document.getElementById('edit_daya').value = data.daya;
            document.getElementById('edit_tarifperkwh').value = data.tarifperkwh;
            document.getElementById('edit_deskripsi').value = data.deskripsi;

            document.getElementById('editForm').action = `/admin/tarif/${data.id_tarif}`;
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>

    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            document.getElementById('createModal').classList.add('flex');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            document.getElementById('createModal').classList.remove('flex');
        }
    </script>
@endsection
