<div id="content-cetak" class="tab-content fade-in max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div class="text-left w-full md:w-auto">
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">
                REPORT N-POINT
            </h1>
            {{-- <h1 class="text-2xl font-bold text-gray-800 tracking-tight">
                CETAK ULANG STRUK
            </h1> --}}
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
                <button type="button" onclick="exportToExcel()" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-2 px-3 rounded-md shadow-sm transition-all flex items-center gap-2">
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
                    {{-- @foreach ($cetak_ulang as $index => $cetak_ulangItem)

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-center font-medium">{{ $index + 1 }}</td>
                    <td class="px-6 py-3 font-medium text-gray-800">{{ $cetak_ulangItem->claim_no ?? '-' }}</td>

                    <td class="px-6 py-3">
                        <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded border border-blue-200">
                            {{ $cetak_ulangItem->st_claim ?? '-' }}
                        </span>
                    </td>

                    <td class="px-6 py-3">
                        <span class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded border border-green-200 whitespace-nowrap overflow-hidden text-ellipsis inline-block">
                            {{ $cetak_ulangItem->nm_plan ?? '-' }}
                        </span>
                    </td>

                    <td class="px-6 py-3">
                        <span class="text-xs bg-yellow-50 text-yellow-700 px-2 py-1 rounded border border-yellow-200">
                            {{ $cetak_ulangItem->st_rujuk ?? '-' }}
                        </span>
                    </td>

                    <td class="px-6 py-3 font-medium text-gray-800">{{ $cetak_ulangItem->member_name ?? '-' }}</td>

                    <td class="px-6 py-3 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($cetak_ulangItem->birth_date)->format('Y-m-d') }}
                    </td>

                    <td class="px-6 py-3">{{ $cetak_ulangItem->nm_cus ?? '-' }}</td>
                    <td class="px-6 py-3 whitespace-nowrap">{{ $cetak_ulangItem->member_no ?? '-' }}</td>

                    <td class="px-6 py-3 text-right">
                        <span class="text-gray-800 px-2 py-1 rounded font-bold whitespace-nowrap">
                            Rp {{ number_format($cetak_ulangItem->ttl_paid ?? 0, 0, ',', '.') }}
                        </span>
                    </td>

                    <td class="px-6 py-3 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($cetak_ulangItem->createddate)->format('Y-m-d') }}
                    </td>
                    </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>


    @push('style')
    <!-- DataTables Styles -->
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
    <!-- jQuery WAJIB PALING ATAS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- DataTables jQuery -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script src="{{ asset('xlsx.full.min.js') }}"></script>
    @endpush

    @push('script')
    <script>
        let table = $('#table-laporan').DataTable({
            processing: true
            , serverSide: true
            , ajax: {
                // url: "https://api.sandbox-wahyuadinugroho.online/cetak-ulang"
                url: "{{ route('dashboard.datatable') }}"
                , data: function(d) {
                    d.dari = $('input[name=dari]').val();
                    d.sampai = $('input[name=sampai]').val();
                }
            }
            , columns: [{
                    data: 'DT_RowIndex'
                    , name: ''
                    , className: 'text-center'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'claim_no'
                    , name: 'c.claim_no'
                }
                , {
                    data: 'st_claim'
                    , name: 'c.st_claim'
                }
                , {
                    data: 'nm_plan'
                    , name: 'p.nm_plan'
                }
                , {
                    data: 'st_rujuk'
                    , name: 'c.st_rujuk'
                }
                , {
                    data: 'member_name'
                    , name: 'm.member_name'
                }
                , {
                    data: 'birth_date'
                    , name: 'm.birth_date'
                }
                , {
                    data: 'nm_cus'
                    , name: 'cust.nm_cus'
                }
                , {
                    data: 'member_no'
                    , name: 'm.member_no'
                }
                , {
                    data: 'ttl_paid'
                    , name: 'cd.ttl_paid'
                    , className: 'text-right'
                }
                , {
                    data: 'createddate'
                    , name: 'c.createddate'
                    , className: 'text-right'
                }
            , ]
            , responsive: true
            , paging: true
            , searching: true
            , ordering: true
            , lengthMenu: [
                [10, 25, 50, 100, -1]
                , [10, 25, 50, 100, "All"]
            ]
            , language: {
                search: "Cari:"
                , lengthMenu: "Tampilkan _MENU_ data"
            }
        });

        function diffDays(start, end) {
            const from = new Date(start);
            const to = new Date(end);
            const diffTime = to - from;
            return Math.floor(diffTime / (1000 * 60 * 60 * 24));
        }

        $('#filterForm').on('submit', function (e) {
            e.preventDefault();

            const dariVal = $('input[name=dari]').val();
            const sampaiVal = $('input[name=sampai]').val();

            const dari = new Date(dariVal + 'T00:00:00');
            const sampai = new Date(sampaiVal + 'T00:00:00');
            const hariIni = new Date();
            hariIni.setHours(0,0,0,0);

            const batas30Hari = new Date(hariIni);
            batas30Hari.setDate(batas30Hari.getDate() - 30);

            console.log({
                dari: dari.toISOString().slice(0,10),
                sampai: sampai.toISOString().slice(0,10),
                batas30Hari: batas30Hari.toISOString().slice(0,10),
            });

            if (dari < batas30Hari) {
                alert('Batas penarikan data hanya 60 hari kebelakang yang diizinkan.');
                return;
            }

            if (sampai > hariIni) {
                alert('Batas tidak boleh lebih dari hari ini');
                return;
            }

            if (sampai < dari) {
                alert('Date tidak diizinkan.');
                return;
            }

            table.ajax.reload();
        });

        function exportToExcel() {
            let tableElement = document.getElementById('table-laporan').cloneNode(true);
            tableElement.querySelectorAll('tr').forEach(row => {
                if (row.cells.length > 0) {
                    row.deleteCell(0);
                }
            });
            let ws = XLSX.utils.table_to_sheet(tableElement);
            const range = XLSX.utils.decode_range(ws['!ref']);
            const lastCol = range.e.c;
            Object.keys(ws).forEach(cell => {
                if (!cell.startsWith('!')) {
                    const cellObj = XLSX.utils.decode_cell(cell);
                    const dateColumns = [5, 9];

                    if (dateColumns.includes(cellObj.c) && ws[cell].v) {
                        let str = ws[cell].v.toString().substring(0, 10);
                        let parts = str.split('-');
                        if (parts.length === 3) {
                            let d = new Date(parts[0], parts[1] - 1, parts[2]);
                            ws[cell].t = 'n'
                            ws[cell].z = "yyyy-mm-dd"; // format Excel
                            ws[cell].v = Math.round((d.getTime() / 86400000) + 25569);
                        }
                    } else {
                        ws[cell].t = 's';
                    }
                }
            });

            let data = XLSX.utils.sheet_to_json(ws, {
                header: 1
            });
            let widths = [];
            data.forEach(row => {
                row.forEach((val, i) => {
                    let len = val ? val.toString().length : 10;
                    widths[i] = Math.max(widths[i] || 10, len);
                });
            });
            ws['!cols'] = widths.map(w => ({
                wch: w + 2
            }));
            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Laporan Klaim");
            XLSX.writeFile(wb, "Laporan_Klaim.xlsx");
        }

    </script>
    @endpush


</div>
