<div id="content-cetak" class="tab-content fade-in max-w-7xl mx-auto">
    <div id="loading-overlay" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm hidden transition-opacity">
        <div class="w-14 h-14 border-4 border-gray-200 border-t-emerald-500 rounded-full animate-spin mb-4"></div>
        <h2 class="text-white text-xl font-semibold tracking-wide">Silahkan Tunggu...</h2>
        <p class="text-gray-200 text-sm mt-2">Sedang menyiapkan dokumen Excel Anda</p>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div class="text-left w-full md:w-auto">
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">
                REPORT N-POINT
            </h1>
            <p class="text-gray-500 text-sm mt-1">
                Kelola, cetak ulang, atau unduh laporan transaksi pasien.
            </p>
        </div>
    </div>

    <form id="filterForm">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end mb-4">
            <div class="md:col-span-5 flex items-center gap-2">
                <input type="date" name="dari" value="{{ request('dari') ?? \Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}" class="block w-full px-3 py-2.5 text-sm border rounded-lg bg-gray-50" />
                <span class="text-gray-400 text-sm">s/d</span>
                <input type="date" name="sampai" value="{{ request('sampai') ?? \Carbon\Carbon::now()->format('Y-m-d') }}" class="block w-full px-3 py-2.5 text-sm border rounded-lg bg-gray-50" />
            </div>
            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="bg-brand-primary hover:bg-emerald-600 text-white font-medium py-2.5 px-6 rounded-lg shadow-sm w-full transition-colors">
                    <i class="fa-solid fa-search"></i> Cari
                </button>
                <a href="{{ url('/') }}" class="block text-center bg-gray-500 hover:bg-gray-600 text-white font-medium py-2.5 px-6 rounded-lg shadow-sm w-full transition-colors">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </a>
            </div>

            <div class="md:col-span-4 flex gap-2 justify-end">
                <button type="button" onclick="openExportModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-2 px-3 rounded-md shadow-sm transition-all flex items-center gap-2">
                    <i class="fa-solid fa-file-excel text-xs"></i> Export Excel
                </button>
            </div>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto custom-scroll p-5">
            <table id="table-laporan" class="min-w-[900px] w-full text-sm text-left text-gray-700 p-3">
                <thead class="text-xs font-semibold uppercase bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-center no-export-col">No</th>
                        <th class="px-6 py-3">No Klaim</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Manfaat</th>
                        <th class="px-6 py-3">Rujukan</th>
                        <th class="px-6 py-3">Nama Peserta</th>
                        <th class="px-6 py-3">Tanggal Lahir</th>
                        <th class="px-6 py-3">Nama Perusahaan</th>
                        <th class="px-6 py-3">No Kartu</th>
                        <th class="px-6 py-3 text-right">Total Biaya</th>
                        <th class="px-6 py-3 text-right">Tgl Kunjungan</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Export Excel -->
    <div id="export-laporan-modal" class="fixed inset-0 z-[100] hidden bg-slate-900/40 backdrop-blur-sm flex justify-center items-center overflow-y-auto p-4 transition-opacity duration-300 opacity-0">
        <div id="export-modal-card" class="bg-white rounded-2xl shadow-xl w-full max-w-md transform transition-all duration-300 ease-out scale-95 translate-y-4 opacity-0 border border-gray-100">

            <div class="p-5 flex justify-between items-center border-b border-gray-50">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">Export Laporan Klaim</h3>
                <button onclick="closeExportModal()" class="w-8 h-8 flex items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="p-5">
                <form id="form-export-excel" onsubmit="handleExportExcel(event)">
                    <p class="text-[13px] text-gray-500 mb-4">Pilih kolom yang ingin disertakan dalam file Excel:</p>

                    <div class="space-y-3 mb-6 bg-gray-50/50 p-4 rounded-xl border border-gray-100 max-h-60 overflow-y-auto custom-scroll">
                        @php
                            $columns = [
                                'claim_no' => 'No Klaim',
                                'st_claim' => 'Status',
                                'nm_plan' => 'Manfaat',
                                'st_rujuk' => 'Rujukan',
                                'member_name' => 'Nama Peserta',
                                'birth_date' => 'Tanggal Lahir',
                                'nm_cus' => 'Nama Perusahaan',
                                'member_no' => 'No Kartu',
                                'ttl_paid' => 'Total Biaya',
                                'createddate' => 'Tanggal Kunjungan'
                            ];
                        @endphp

                        @foreach($columns as $key => $label)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="columns[]" value="{{ $key }}" checked class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                            <span class="text-sm text-gray-700 font-medium">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>

                    <div class="flex gap-3 justify-end">
                        <button type="button" onclick="closeExportModal()" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition-colors">Batal</button>
                        <button type="submit" id="btn-submit-export" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2">
                            <i class="fa-solid fa-download"></i> Download
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <style>
        @media print {
            .no-print,
            .no-export-col,
            header,
            aside,
            .sidebar {
                display: none !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #ddd !important;
                padding: 8px !important;
            }
        }
    </style>
    @endpush

    @push('script')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    @endpush

    @push('script')
    <script>
        let table = $('#table-laporan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dashboard.datatable') }}",
                data: function(d) {
                    d.dari = $('input[name=dari]').val();
                    d.sampai = $('input[name=sampai]').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: '', className: 'text-center', orderable: false, searchable: false },
                { data: 'claim_no', name: 'c.claim_no' },
                { data: 'st_claim', name: 'c.st_claim' },
                { data: 'nm_plan', name: 'p.nm_plan' },
                { data: 'st_rujuk', name: 'c.st_rujuk' },
                { data: 'member_name', name: 'm.member_name' },
                { data: 'birth_date', name: 'm.birth_date' },
                { data: 'nm_cus', name: 'cust.nm_cus' },
                { data: 'member_no', name: 'm.member_no' },
                { data: 'ttl_paid', name: 'cd.ttl_paid', className: 'text-right' },
                { data: 'createddate', name: 'c.createddate', className: 'text-right' },
            ],
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data"
            }
        });

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

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();

            const dariVal = $('input[name=dari]').val();
            const sampaiVal = $('input[name=sampai]').val();

            if (!dariVal || !sampaiVal) {
                showError('Tanggal harus diisi.');
                return;
            }

            const dari = new Date(dariVal);
            const sampai = new Date(sampaiVal);

            dari.setHours(0, 0, 0, 0);
            sampai.setHours(0, 0, 0, 0);

            if (sampai < dari) {
                showError('Tanggal akhir tidak boleh lebih kecil dari tanggal awal.');
                return;
            }

            const selisihHari = (sampai - dari) / (1000 * 60 * 60 * 24);

            if (selisihHari > 61) {
                showError('Rentang tanggal maksimal 60 hari.');
                return;
            }

            table.ajax.reload();
        });

        function exportExcel() {
            const dari = $('input[name=dari]').val();
            const sampai = $('input[name=sampai]').val();

            let url = "{{ route('dashboard.export') }}";

            if (dari && sampai) {
                url += `?dari=${dari}&sampai=${sampai}`;
            }

            const loader = $('#loading-overlay');
            loader.removeClass('hidden');
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan saat mengunduh file.');
                }
                return response.blob();
            })
            .then(blob => {
                const downloadUrl = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = downloadUrl;

                a.download = `Laporan_Klaim_${dari}_sampai_${sampai}.xlsx`;

                document.body.appendChild(a);
                a.click();

                window.URL.revokeObjectURL(downloadUrl);
                document.body.removeChild(a);
                Toastify({
                    text: "Gagal mengunduh Excel. Silahkan coba lagi.",
                })

            })
            .catch(error => {
                Toastify({
                    text: "Gagal mengunduh Excel. Silahkan coba lagi.",
                });
                console.log(error)
            })
            .finally(() => {
                loader.addClass('hidden');
                showSuccess("Unduhan Berhasil..");
            });
        }

        function openExportModal() {
            const modal = document.getElementById('export-laporan-modal');
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
            const modal = document.getElementById('export-laporan-modal');
            const card = document.getElementById('export-modal-card');

            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            card.classList.remove('scale-100', 'translate-y-0', 'opacity-100');
            card.classList.add('scale-95', 'translate-y-4', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function handleExportExcel(e) {
            e.preventDefault();

            const dari = $('input[name=dari]').val();
            const sampai = $('input[name=sampai]').val();

            const checkedColumns = [];
            $('input[name="columns[]"]:checked').each(function() {
                checkedColumns.push($(this).val());
            });

            if (checkedColumns.length === 0) {
                showError('Pilih minimal 1 kolom untuk diekspor.');
                return;
            }

            closeExportModal();
            const loader = $('#loading-overlay');
            loader.removeClass('hidden');

            let url = "{{ route('dashboard.export') }}";
            let params = new URLSearchParams();

            if (dari) params.append('dari', dari);
            if (sampai) params.append('sampai', sampai);

            checkedColumns.forEach(col => params.append('columns[]', col));

            url += '?' + params.toString();
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan saat mengunduh file.');
                }
                return response.blob();
            })
            .then(blob => {
                const downloadUrl = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = downloadUrl;
                a.download = `Laporan_Klaim_${dari}_sampai_${sampai}.xlsx`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(downloadUrl);
                document.body.removeChild(a);
                showSuccess("Unduhan Berhasil..");
            })
            .catch(error => {
                showError("Gagal mengunduh Excel. Silahkan coba lagi.");
                console.log(error);
            })
    .finally(() => {
        loader.addClass('hidden');
    });
}
    </script>
    @endpush
</div>
