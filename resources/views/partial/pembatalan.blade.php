<div id="content-pembatalan" class="tab-content hidden fade-in max-w-6xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-red-600">
        Pembatalan Transaksi
    </h2>

    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-4 flex gap-3">
        <input type="text" placeholder="Cari No Klaim / Nama..." class="flex-1 px-4 py-2 text-sm border border-gray-300 rounded-lg" />
        <button class="bg-gray-800 text-white px-6 rounded-lg text-sm">
            Cari
        </button>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-6 py-3">No Klaim</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Pasien</th>
                    <th class="px-6 py-3">Poli</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="px-6 py-4">25112800018710</td>
                    <td class="px-6 py-4">2025-11-28</td>
                    <td class="px-6 py-4 font-bold">Diana Prince</td>
                    <td class="px-6 py-4">Poli Gigi</td>
                    <td class="px-6 py-4 text-green-600 font-bold">
                        Terdaftar
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-red-500 hover:text-red-700 border border-red-200 bg-red-50 px-3 py-1 rounded text-xs font-bold">
                            <i class="fa-solid fa-times-circle mr-1"></i> Batalkan
                        </button>
                    </td>
                </tr>
                <tr class="border-b bg-gray-50 opacity-70">
                    <td class="px-6 py-4 decoration-slice line-through">
                        25112800018705
                    </td>
                    <td class="px-6 py-4">2025-11-27</td>
                    <td class="px-6 py-4">Bruce Wayne</td>
                    <td class="px-6 py-4">Poli Saraf</td>
                    <td class="px-6 py-4 text-red-600 font-bold">DIBATALKAN</td>
                    <td class="px-6 py-4 text-center text-xs text-gray-400">
                        by Admin
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
