@toastifyJs
<script>
    function switchTab(tabName, btnElement) {
        // 1. Sembunyikan semua konten
        const contents = document.querySelectorAll(".tab-content");
        contents.forEach((content) => {
            content.classList.add("hidden");
        });

        // 2. Tampilkan konten yang dipilih
        const selectedContent = document.getElementById("content-" + tabName);
        if (selectedContent) {
            selectedContent.classList.remove("hidden");
        }

        // 3. Reset style tombol tab
        const buttons = document.querySelectorAll(".tab-btn");
        buttons.forEach((btn) => {
            // Reset ke style default (abu-abu, border transparent)
            btn.className =
                "tab-btn px-5 py-3 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 transition-colors whitespace-nowrap cursor-pointer";

            // Hapus background color khusus di dalam inner HTML icon jika ada (optional, tapi kita main di class parent saja)
        });

        // 4. Set style aktif ke tombol yang diklik (Hijau, Background light green, Border bottom)
        if (btnElement) {
            btnElement.className =
                "tab-btn active-tab px-6 py-3 text-sm font-bold text-brand-primary border-b-2 border-brand-primary bg-green-50 rounded-t-lg transition-colors whitespace-nowrap cursor-default";
        }
    }

    // Initialize: Show Cetak Ulang by default (sesuai request awal) or Pendaftaran
    // Mari kita default ke 'cetak' agar sesuai gambar referensi Anda
    switchTab('cetak', document.querySelector('button[onclick="switchTab(\'cetak\', this)"]'));

</script>
@stack('script')
