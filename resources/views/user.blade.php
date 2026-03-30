@extends('layout.app')

@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<style>
    /* 1. MEMPERBAIKI DROPDOWN (Tampil baris) YANG HITAM */
    .dataTables_wrapper .dataTables_length select {
        background-color: #ffffff !important;
        color: #374151 !important; /* text-gray-700 */
        border: 1px solid #e5e7eb !important; /* border-gray-200 */
        border-radius: 0.5rem !important;
        padding: 0.375rem 2rem 0.375rem 0.75rem !important;
        outline: none !important;
        box-shadow: none !important;
    }

    /* 2. MEMPERBAIKI INPUT SEARCH YANG HITAM */
    .dataTables_wrapper .dataTables_filter input {
        background-color: #f9fafb !important; /* bg-gray-50 */
        color: #111827 !important; /* text-gray-900 */
        border: 1px solid #e5e7eb !important; /* border-gray-200 */
        border-radius: 0.75rem !important;
        padding: 0.5rem 1rem !important;
        outline: none !important;
        box-shadow: none !important;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        background-color: #ffffff !important;
        border-color: #9ca3af !important; /* border-gray-400 */
        box-shadow: 0 0 0 2px rgba(17, 24, 39, 0.05) !important;
    }

    /* 3. MEMPERBAIKI HEADER TABEL YANG NGEBLOK ABU-ABU */
    table.dataTable thead th, table.dataTable thead td {
        background-color: #ffffff !important; /* Paksa background putih/transparan */
        color: #6b7280 !important; /* text-gray-500 */
        border-bottom: 1px solid #f3f4f6 !important; /* border-gray-100 */
        font-size: 0.65rem !important; /* Teks lebih kecil */
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }

    /* 4. MERAPIKAN PAGINASI & BORDER */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.25rem 0.75rem !important;
        margin-left: 0.25rem !important;
        border-radius: 0.5rem !important;
        border: 1px solid transparent !important;
        color: #6b7280 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #111827 !important; /* bg-gray-900 */
        color: #ffffff !important;
        border-color: #111827 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #f3f4f6 !important; /* bg-gray-100 */
        color: #111827 !important;
        border-color: transparent !important;
    }

    /* Menghilangkan border tebal bawaan datatable */
    table.dataTable.no-footer {
        border-bottom: 1px solid #f3f4f6 !important;
    }
    table.dataTable tbody td {
        border-top: none !important;
        border-bottom: 1px solid #f9fafb !important;
        color: #4b5563 !important;
    }
    table.dataTable tbody tr:hover td {
        background-color: #f9fafb !important;
    }
</style>
@endpush

@section('content')
<div class="flex-1 flex flex-col h-screen overflow-hidden relative bg-slate-50">
    <main class="flex-1 overflow-y-auto p-4 md:p-8 flex flex-col">
        <div class="w-full max-w-7xl mx-auto space-y-6">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-transparent mb-2">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Manajemen User</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola hak akses dan data pengguna sistem.</p>
                </div>
                <button onclick="openModal('create')" class="w-full md:w-auto bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium py-2.5 px-5 rounded-xl shadow-sm hover:shadow-md transition-all flex justify-center items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah User</span>
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] border border-gray-100 overflow-hidden">
                <div class="p-5 md:p-6 overflow-x-auto">
                    <table id="users-table" class="w-full text-sm text-left text-gray-600">
                        <thead class="text-[11px] text-gray-400 uppercase tracking-wider bg-transparent">
                            <tr>
                                <th scope="col" class="px-4 py-3 font-semibold pb-4">No</th>
                                <th scope="col" class="px-4 py-3 font-semibold pb-4">Nama Lengkap</th>
                                <th scope="col" class="px-4 py-3 font-semibold pb-4">Username</th>
                                <th scope="col" class="px-4 py-3 font-semibold pb-4">Role</th>
                                <th scope="col" class="px-4 py-3 font-semibold pb-4">Status</th>
                                <th scope="col" class="px-4 py-3 font-semibold pb-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<div id="user-modal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex justify-center items-center overflow-y-auto p-4 transition-opacity duration-300 opacity-0">
    <div id="modal-card" class="bg-white rounded-2xl shadow-xl w-full max-w-2xl transform transition-all duration-300 ease-out scale-95 translate-y-4 opacity-0 border border-gray-100">

        <div class="p-6 flex justify-between items-center border-b border-gray-50">
            <h3 id="modal-title" class="text-lg font-bold text-gray-900 tracking-tight">Tambah User</h3>
            <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="p-6">
            <form id="form-user" onsubmit="return handleSave(event)" class="space-y-5">
                @csrf
                <input type="hidden" name="id" id="user_id">
                <input type="hidden" name="_method" id="form_method" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Provider Code</label>
                        <input type="text" name="provider_code" id="provider_code" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 focus:bg-white outline-none transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 focus:bg-white outline-none transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Username</label>
                        <input type="text" name="username" id="username" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 focus:bg-white outline-none transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" id="email" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 focus:bg-white outline-none transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Role</label>
                        <select name="role" id="role" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 focus:bg-white outline-none transition-all cursor-pointer">
                            <option value="provider">Provider</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Status</label>
                        <select name="is_active" id="is_active" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 focus:bg-white outline-none transition-all cursor-pointer">
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>

                    <div class="space-y-1.5 md:col-span-2" id="password_container">
                        <div class="flex justify-between items-end">
                            <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Password</label>
                            <span class="text-[10px] text-gray-400" id="password_help">Opsional saat edit</span>
                        </div>
                        <input type="password" name="password" id="password" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 focus:bg-white outline-none transition-all">
                    </div>
                </div>

                <div class="pt-4 flex gap-3 mt-4">
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition-colors">Batal</button>
                    <button type="submit" id="save-btn" class="flex-1 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium py-2.5 px-4 rounded-xl shadow-sm transition-all flex justify-center items-center gap-2">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="toast-success" class="fixed bottom-5 right-5 z-[60] hidden bg-gray-900 text-white px-5 py-3 rounded-xl shadow-xl flex items-center gap-3 transition-all transform translate-y-0 text-sm font-medium">
    <i class="fa-solid fa-check text-emerald-400"></i> <span id="success-message">Disimpan</span>
</div>
<div id="toast-error" class="fixed bottom-5 right-5 z-[60] hidden bg-rose-50 border border-rose-200 text-rose-700 px-5 py-3 rounded-xl shadow-xl flex items-center gap-3 transition-all text-sm font-medium">
    <i class="fa-solid fa-circle-exclamation text-rose-500"></i> <span id="error-message">Error</span>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<script>
    let table;

    $(document).ready(function() {
        table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('users.index') }}",
            dom: '<"flex flex-col md:flex-row justify-between items-center pb-4 gap-4"lf>rt<"flex flex-col md:flex-row justify-between items-center pt-4 gap-4"ip>',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'px-4 py-4 text-gray-500' },
                { data: 'nama', name: 'nama', className: 'px-4 py-4 font-medium text-gray-900' },
                { data: 'username', name: 'username', className: 'px-4 py-4' },
                {
                  data: 'role', name: 'role', className: 'px-4 py-4',
                  render: function(data) {
                      return data === 'admin'
                        ? `<span class="inline-flex items-center px-2 py-1 rounded-md bg-violet-50 text-violet-700 text-[11px] font-semibold uppercase tracking-wider border border-violet-100/50">Admin</span>`
                        : `<span class="inline-flex items-center px-2 py-1 rounded-md bg-sky-50 text-sky-700 text-[11px] font-semibold uppercase tracking-wider border border-sky-100/50">Provider</span>`;
                  }
                },
                {
                  data: 'is_active', name: 'is_active', className: 'px-4 py-4',
                  render: function(data) {
                      return data == 1
                        ? `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-medium border border-emerald-100/50"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span>`
                        : `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-rose-50 text-rose-700 text-xs font-medium border border-rose-100/50"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Non-Aktif</span>`;
                  }
                },
                {
                  data: 'action', name: 'action', orderable: false, searchable: false, className: 'px-4 py-4 text-right'
                }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari data...",
                lengthMenu: "Tampil _MENU_ baris",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_",
                infoEmpty: "Tidak ada data",
                paginate: { previous: "<i class='fa-solid fa-chevron-left text-xs'></i>", next: "<i class='fa-solid fa-chevron-right text-xs'></i>" }
            }
        });
    });

    function openModal(type, data = null) {
        const modal = document.getElementById('user-modal');
        const card = document.getElementById('modal-card');
        const form = document.getElementById('form-user');
        const title = document.getElementById('modal-title');
        const methodInput = document.getElementById('form_method');
        const passHelp = document.getElementById('password_help');
        const passwordInput = document.getElementById('password');

        form.reset();

        if (type === 'create') {
            title.innerText = 'Tambah User';
            methodInput.value = 'POST';
            document.getElementById('user_id').value = '';
            passHelp.classList.add('hidden');
            passwordInput.required = true;
        } else if (type === 'edit') {
            title.innerText = 'Edit User';
            methodInput.value = 'PUT';
            passHelp.classList.remove('hidden');
            passwordInput.required = false;

            document.getElementById('user_id').value = data.id;
            document.getElementById('provider_code').value = data.provider_code;
            document.getElementById('nama').value = data.nama;
            document.getElementById('username').value = data.username;
            document.getElementById('email').value = data.email || '';
            document.getElementById('role').value = data.role;
            document.getElementById('is_active').value = data.is_active;
        }

        modal.classList.remove('hidden');

        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');

            card.classList.remove('scale-95', 'translate-y-4', 'opacity-0');
            card.classList.add('scale-100', 'translate-y-0', 'opacity-100');
        });
    }

    function closeModal() {
        const modal = document.getElementById('user-modal');
        const card = document.getElementById('modal-card');

        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');

        card.classList.remove('scale-100', 'translate-y-0', 'opacity-100');
        card.classList.add('scale-95', 'translate-y-4', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function handleSave(e) {
        e.preventDefault();

        const btn = document.getElementById('save-btn');
        const form = document.getElementById('form-user');
        const formData = new FormData(form);
        const method = document.getElementById('form_method').value;
        const id = document.getElementById('user_id').value;

        const url = method === 'POST' ? "{{ route('users.store') }}" : `/users/${id}`;

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
            body: formData
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) throw data;

            showSuccess(data.message || 'Data disimpan');
            closeModal();
            table.ajax.reload(null, false);
        })
        .catch(err => {
            let msg = 'Terjadi kesalahan sistem';
            if (err.errors) msg = Object.values(err.errors)[0][0];
            else if (err.message) msg = err.message;
            showError(msg);
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = 'Simpan Data';
        });

        return false;
    }

    function deleteData(id) {
        if(confirm('Hapus user ini secara permanen?')) {
            fetch(`/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json'
                }
            })
            .then(async res => {
                if (!res.ok) throw await res.json();
                showSuccess('Data dihapus');
                table.ajax.reload(null, false);
            })
            .catch(err => showError(err.message || 'Gagal menghapus'));
        }
    }

    function showSuccess(msg) {
        const el = document.getElementById('toast-success');
        document.getElementById('success-message').innerText = msg;
        el.classList.remove('hidden');
        setTimeout(() => el.classList.add('hidden'), 3000);
    }

    function showError(msg) {
        const el = document.getElementById('toast-error');
        document.getElementById('error-message').innerText = msg;
        el.classList.remove('hidden');
        setTimeout(() => el.classList.add('hidden'), 3000);
    }
</script>
@endpush
