<div id="content-pendaftaran" class="tab-content hidden fade-in max-w-5xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Pendaftaran Pasien Baru
    </h2>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold uppercase text-gray-500 mb-4 border-b pb-2">
                Data Peserta
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nomor Kartu / NIK</label>
                    <div class="flex gap-2">
                        <input type="text" placeholder="Masukkan No Kartu..." class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary outline-none" />
                        <button class="bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Pasien</label>
                    <input type="text" value="Budi Santoso" readonly class="w-full px-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-500 cursor-not-allowed" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Lahir</label>
                    <input type="date" value="1985-04-12" readonly class="w-full px-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-500 cursor-not-allowed" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Jenis Kelamin</label>
                    <input type="text" value="Laki-laki" readonly class="w-full px-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-500 cursor-not-allowed" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Status Peserta</label>
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">AKTIF</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit">
            <h3 class="text-sm font-bold uppercase text-gray-500 mb-4 border-b pb-2">
                Detail Kunjungan
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Poli Tujuan</label>
                    <select class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-brand-primary outline-none">
                        <option>Poli Umum</option>
                        <option>Poli Gigi</option>
                        <option>Poli Anak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Dokter</label>
                    <select class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-brand-primary outline-none">
                        <option>dr. Andi Wijaya</option>
                        <option>dr. Siti Aminah</option>
                    </select>
                </div>
                <button class="w-full bg-brand-primary hover:bg-emerald-600 text-white font-bold py-3 rounded-lg shadow-lg shadow-emerald-200 transition-all mt-4">
                    <i class="fa-solid fa-save mr-2"></i> SIMPAN PENDAFTARAN
                </button>
            </div>
        </div>
    </div>
</div>
