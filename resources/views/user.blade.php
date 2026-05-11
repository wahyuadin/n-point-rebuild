@extends('layout.app')

@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    .select2-container .select2-selection--single {
        height: 42px !important;
        border-radius: 0.75rem !important; /* rounded-xl */
        border: 1px solid #e5e7eb !important; /* border-gray-200 */
        background-color: #f9fafb !important; /* bg-gray-50 */
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #111827 !important; /* text-gray-900 */
        font-size: 0.875rem !important; /* text-sm */
        padding-left: 1rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 10px !important;
    }
    .select2-container--open .select2-selection--single,
    .select2-container--focus .select2-selection--single {
        background-color: #ffffff !important;
        border-color: #9ca3af !important; /* border-gray-400 */
        box-shadow: 0 0 0 2px rgba(17, 24, 39, 0.05) !important;
    }
    .select2-dropdown {
        border: 1px solid #e5e7eb !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
    }
    .select2-search__field {
        border-radius: 0.5rem !important;
        outline: none !important;
    }
    .select2-search__field:focus {
        border-color: #9ca3af !important;
        box-shadow: 0 0 0 2px rgba(17, 24, 39, 0.05) !important;
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
                <div class="flex w-full md:w-auto gap-3">
                    <button onclick="openImportModal()" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 px-5 rounded-xl shadow-sm hover:shadow-md transition-all flex justify-center items-center gap-2">
                        <i class="fa-solid fa-file-import"></i>
                        <span>Import</span>
                    </button>

                    <button onclick="openExportModal()" class="flex-1 md:flex-none bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-2.5 px-5 rounded-xl shadow-sm hover:shadow-md transition-all flex justify-center items-center gap-2">
                        <i class="fa-solid fa-file-excel"></i>
                        <span>Export</span>
                    </button>

                    <button onclick="openModal('create')" class="flex-1 md:flex-none bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium py-2.5 px-5 rounded-xl shadow-sm hover:shadow-md transition-all flex justify-center items-center gap-2">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah User</span>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] border border-gray-100 overflow-hidden">
                <div class="p-5 md:p-6 overflow-x-auto">
                    <table id="users-table" class="w-full text-sm text-left text-gray-600">
                        <thead class="text-[11px] text-gray-400 uppercase tracking-wider bg-transparent">
                            <tr>
                                <th scope="col" class="px-4 py-3 font-semibold pb-4">No</th>
                                <th scope="col" class="px-4 py-3 font-semibold pb-4">Nama Provider</th>
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
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Provider</label>
                        <select name="provider_code" id="provider_code" required class="block w-full">
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" placeholder="Masukan Nama Lengkap" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 focus:bg-white outline-none transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Username</label>
                        <input type="text" name="username" id="username" placeholder="Masukan Username" required class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 focus:bg-white outline-none transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" id="email" placeholder="Masukan Email" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 focus:bg-white outline-none transition-all">
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
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Masukan Password" class="block w-full px-4 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 focus:bg-white outline-none transition-all pr-10">
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                <i class="fa-solid fa-eye" id="toggle-password-icon"></i>
                            </button>
                        </div>
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

<div id="import-modal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex justify-center items-center overflow-y-auto p-4 transition-opacity duration-300 opacity-0">
    <div id="import-modal-card" class="bg-white rounded-2xl shadow-xl w-full max-w-2xl transform transition-all duration-300 ease-out scale-95 translate-y-4 opacity-0 border border-gray-100">

        <div class="p-6 flex justify-between items-center border-b border-gray-50">
            <h3 class="text-lg font-bold text-gray-900 tracking-tight">Import Data User</h3>
            <button onclick="closeImportModal()" class="w-8 h-8 flex items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="p-6">
            <form id="form-upload-excel" onsubmit="return handlePreview(event)">
                <div class="space-y-4">

                    <div class="flex justify-between items-end mb-1">
                        <label class="block text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Pilih File Excel (.xlsx, .csv)</label>
                        <a href="{{ route('users.template') }}" class="text-[12px] font-medium text-blue-600 hover:text-blue-700 underline underline-offset-2 flex items-center gap-1 transition-colors">
                            <i class="fa-solid fa-download"></i> Template
                        </a>
                    </div>
                    <div class="flex flex-col md:flex-row items-center gap-3">
                        <input type="file" id="file_excel" name="file" accept=".xlsx, .xls, .csv" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all border border-gray-200 rounded-xl cursor-pointer bg-gray-50/50">
                        <button type="submit" id="btn-preview" class="w-full md:w-auto bg-gray-900 hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium shadow-sm whitespace-nowrap transition-all">
                            Baca Kolom
                        </button>
                    </div>
                </div>
            </form>

            <form id="form-import-data" onsubmit="return handleImport(event)" class="hidden mt-8 pt-6 border-t border-gray-100 space-y-5">
                <input type="hidden" name="file_name" id="file_name">

                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-1">Pencocokan Kolom (Mapping)</h4>
                    <p class="text-[13px] text-gray-500 mb-4">Pilih header Excel yang sesuai dengan field database berikut.</p>

                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-[11px] text-gray-500 uppercase tracking-wider bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 w-1/2">Field Database</th>
                                    <th class="px-4 py-3 w-1/2">Kolom Excel</th>
                                </tr>
                            </thead>
                            <tbody id="mapping-tbody" class="divide-y divide-gray-100">
                                </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex gap-3 justify-end pt-4">
                    <button type="button" onclick="closeImportModal()" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition-colors">Batal</button>
                    <button type="submit" id="btn-import" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-file-import"></i> Jalankan Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="export-modal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex justify-center items-center overflow-y-auto p-4 transition-opacity duration-300 opacity-0">
    <div id="export-modal-card" class="bg-white rounded-2xl shadow-xl w-full max-w-sm transform transition-all duration-300 ease-out scale-95 translate-y-4 opacity-0 border border-gray-100">

        <div class="p-5 flex justify-between items-center border-b border-gray-50">
            <h3 class="text-lg font-bold text-gray-900 tracking-tight">Export Data</h3>
            <button onclick="closeExportModal()" class="w-8 h-8 flex items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="p-5">
            <form action="{{ route('users.export') }}" method="GET" target="_blank" onsubmit="closeExportModal()">
                <p class="text-[13px] text-gray-500 mb-4">Pilih kolom yang ingin disertakan dalam file Excel:</p>

                <div class="space-y-3 mb-6 bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="columns[]" value="provider_code" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="text-sm text-gray-700 font-medium">Provider Code</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="columns[]" value="nama" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="text-sm text-gray-700 font-medium">Nama Lengkap</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="columns[]" value="username" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="text-sm text-gray-700 font-medium">Username</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="columns[]" value="email" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="text-sm text-gray-700 font-medium">Email</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="columns[]" value="role" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="text-sm text-gray-700 font-medium">Role</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="columns[]" value="is_active" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="text-sm text-gray-700 font-medium">Status Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="columns[]" value="created_at" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="text-sm text-gray-700 font-medium">Tanggal Dibuat</span>
                    </label>
                </div>

                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeExportModal()" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-download"></i> Download
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let table;

    $(document).ready(function() {
        $('#provider_code').select2({
            placeholder: "-- Cari & Pilih Provider --",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#user-modal'),
            ajax: {
                url: "{{ route('user.providers') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            },
        });

        table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('user.index') }}",
            dom: '<"flex flex-col md:flex-row justify-between items-center pb-4 gap-4"lf>rt<"flex flex-col md:flex-row justify-between items-center pt-4 gap-4"ip>',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'px-4 py-4 text-gray-500' },
                { data: 'nama', name: 'nama', className: 'px-4 py-4 font-medium text-gray-900' },
                { data: 'provider_code', name: 'provider_code', className: 'px-4 py-4' },
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
        const passwordIcon = document.getElementById('toggle-password-icon');

        form.reset();
        passwordInput.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');

        if (type === 'create') {
            title.innerText = 'Tambah User';
            methodInput.value = 'POST';
            document.getElementById('user_id').value = '';
            passHelp.classList.add('hidden');
            passwordInput.required = true;
            $('#provider_code').val(null).trigger('change');

        } else if (type === 'edit') {
            title.innerText = 'Edit User';
            methodInput.value = 'PUT';
            passHelp.classList.remove('hidden');
            passwordInput.required = false;

            document.getElementById('user_id').value = data.id;
            document.getElementById('nama').value = data.nama;
            document.getElementById('username').value = data.username;
            document.getElementById('email').value = data.email || '';
            document.getElementById('role').value = data.role;
            document.getElementById('is_active').value = data.is_active;

            let providerText = data.provider_code + ' - ' + (data.provider_name || 'Nama tidak ditemukan');
            let option = new Option(providerText, data.provider_code, true, true);
            $('#provider_code').empty().append(option).trigger('change');
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

        const url = method === 'POST' ? "{{ route('user.store') }}" : `/user/${id}`;

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

    function openImportModal() {
        const modal = document.getElementById('import-modal');
        const card = document.getElementById('import-modal-card');

        // Reset form saat dibuka
        document.getElementById('form-upload-excel').reset();
        document.getElementById('form-import-data').classList.add('hidden');
        document.getElementById('mapping-tbody').innerHTML = '';

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            card.classList.remove('scale-95', 'translate-y-4', 'opacity-0');
            card.classList.add('scale-100', 'translate-y-0', 'opacity-100');
        });
    }

    function closeImportModal() {
        const modal = document.getElementById('import-modal');
        const card = document.getElementById('import-modal-card');

        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        card.classList.remove('scale-100', 'translate-y-0', 'opacity-100');
        card.classList.add('scale-95', 'translate-y-4', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openExportModal() {
        const modal = document.getElementById('export-modal');
        const card = document.getElementById('export-modal-card');

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            card.classList.remove('scale-95', 'translate-y-4', 'opacity-0');
            card.classList.add('scale-100', 'translate-y-0', 'opacity-100');
        });
    }

    function closeExportModal() {
        const modal = document.getElementById('export-modal');
        const card = document.getElementById('export-modal-card');

        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        card.classList.remove('scale-100', 'translate-y-0', 'opacity-100');
        card.classList.add('scale-95', 'translate-y-4', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function handlePreview(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-preview');
        const formData = new FormData(document.getElementById('form-upload-excel'));

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

        fetch("{{ route('users.import.preview') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
            body: formData
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) throw data;
            return data;
        })
        .then(data => {
            if (data.headings) {
                const tbody = document.getElementById('mapping-tbody');
                const fileInputHidden = document.getElementById('file_name');
                fileInputHidden.value = data.file_path;

                const dbFields = [
                    { id: 'provider_code', label: 'Provider Code' },
                    { id: 'nama', label: 'Nama Lengkap' },
                    { id: 'username', label: 'Username' },
                    { id: 'email', label: 'Email' },
                    { id: 'role', label: 'Role' },
                    { id: 'is_active', label: 'Status Aktif (1/0)' },
                    { id: 'password', label: 'Password' },
                ];

                let html = '';
                dbFields.forEach(field => {
                    let options = '<option value="">-- Abaikan --</option>';
                    data.headings.forEach(head => {
                        let selected = head.toLowerCase() === field.id.toLowerCase() ? 'selected' : '';
                        options += `<option value="${head}" ${selected}>${head}</option>`;
                    });

                    html += `
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-700">${field.label}</td>
                            <td class="px-4 py-3">
                                <select name="mapping[${field.id}]" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg outline-none focus:border-blue-400">
                                    ${options}
                                </select>
                            </td>
                        </tr>
                    `;
                });

                tbody.innerHTML = html;
                document.getElementById('form-import-data').classList.remove('hidden');
            }
        })
        .catch(err => {
            let msg = err.message || 'Gagal membaca file Excel';
            if (err.errors) msg = Object.values(err.errors)[0][0];
            showError(msg);
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = 'Baca Kolom';
        });
    }

    function handleImport(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-import');
        const formData = new FormData(document.getElementById('form-import-data'));
        formData.append('file_path', document.getElementById('file_name').value);

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

        fetch("{{ route('users.import') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
            body: formData
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) throw data;
            return data;
        })
        .then(data => {
            showSuccess(data.message || 'Data berhasil diimport');
            closeImportModal();
            table.ajax.reload(null, false);
        })
        .catch(err => {
            let msg = err.message || 'Terjadi kesalahan saat import';
            showError(msg);
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-file-import"></i> Jalankan Import';
        });
    }

    function showError(message) {
        Toastify({
            text: message,
            duration: 1500,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                color: "#fff",
                background: "#d63939",
                borderRadius: "0.5rem",
                boxShadow: "0 0 10px rgba(214, 57, 57, 0.5)",
            },
        }).showToast();
    }

    function showSuccess(message) {
        Toastify({
            text : message,
            duration: 2000,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                color: "#fff",
                background: "linear-gradient(to right, #00b09b, #96c93d)",
                borderRadius: "0.5rem",
            },
        }).showToast();
    }

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('toggle-password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
