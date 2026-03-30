@extends('layout.app')

@section('content')
<div class="flex-1 flex flex-col h-screen overflow-hidden relative bg-grid-pattern">

    <main class="flex-1 overflow-y-auto p-4 md:p-10 flex flex-col justify-center items-center">
        <div class="w-full max-w-4xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 bg-white rounded-3xl shadow-xl border overflow-hidden">

                <div class="lg:col-span-2 bg-gradient-to-br from-slate-50 to-blue-50/50 p-8 flex flex-col justify-between border-r border-gray-100">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Amankan Akun Anda</h2>
                        <p class="text-sm text-gray-500 leading-relaxed">Password yang kuat adalah kunci pertahanan pertama data pasien Anda.</p>
                    </div>

                    <div class="mt-8 space-y-6">
                        <div class="flex gap-4 items-start">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">Unik & Kompleks</h4>
                                <p class="text-xs text-gray-500 mt-1">Gunakan kombinasi simbol, angka, dan huruf kapital.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fa-solid fa-calendar-check text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">Ganti Berkala</h4>
                                <p class="text-xs text-gray-500 mt-1">Disarankan memperbarui password setiap 90 hari.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Terakhir diubah</p>
                        <p class="text-sm font-medium text-gray-700 mt-1">{{ \Carbon\Carbon::parse($data->updated_at)
                            ->timezone('Asia/Jakarta')
                            ->locale('id')
                            ->translatedFormat('d F Y \P\u\k\u\l H:i') . ' WIB' }}</p>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="lg:col-span-3 p-8">

                    <form id="form-password" onsubmit="return handleSave(event)" class="space-y-6">
                        @csrf

                        <!-- CURRENT -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2 group-focus-within:text-brand-secondary transition-colors">Password Saat Ini</label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current-pass" required class="block w-full px-4 py-3.5 text-sm font-medium text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-brand-secondary focus:bg-white outline-none transition-all placeholder-gray-400" placeholder="Masukkan password lama Anda">
                                <button type="button" onclick="toggleVisibility('current-pass', this)" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- NEW -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2 group-focus-within:text-brand-secondary transition-colors">Password Baru</label>
                            <div class="relative mb-3">
                                <input type="password" name="new_password" id="new-pass" required oninput="checkStrength()" class="block w-full px-4 py-3.5 text-sm font-medium text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-brand-secondary focus:bg-white outline-none transition-all placeholder-gray-400" placeholder="Buat password baru">
                                <button type="button" onclick="toggleVisibility('new-pass', this)" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>

                            <!-- Modern Progress Bar Strength Meter -->
                            <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                <div id="strength-bar" class="h-full w-0 bg-red-500 progress-bar rounded-full"></div>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <p class="text-[10px] text-gray-400 font-medium">Kekuatan Password</p>
                                <p id="strength-text" class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">-</p>
                            </div>
                        </div>

                        <!-- CONFIRM -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2 group-focus-within:text-brand-secondary transition-colors">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" name="new_password_confirmation" id="confirm-pass" required oninput="checkMatch()" class="block w-full px-4 py-3.5 text-sm font-medium text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-brand-secondary focus:bg-white outline-none transition-all placeholder-gray-400" placeholder="Ketik ulang password baru">

                                <!-- Match Icon Indicator -->
                                <div id="match-indicator" class="absolute inset-y-0 right-0 pr-4 flex items-center opacity-0 transition-opacity duration-300">
                                    <i class="fa-solid fa-check-circle text-green-500 text-lg"></i>
                                </div>
                                {{-- <button type="button" onclick="toggleVisibility('confirm-pass', this)" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                                    <i class="fa-regular fa-eye"></i>
                                </button> --}}
                            </div>
                        </div>

                        <!-- BUTTON -->
                        <div class="pt-4 flex items-center gap-4">
                            <button type="submit" id="save-btn" class="flex-1 bg-brand-dark hover:bg-gray-900 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-xl shadow-gray-900/10 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex justify-center items-center gap-2">
                                <span>Update Password</span>
                                <i class="fa-solid fa-arrow-right text-xs opacity-70"></i>
                            </button>
                            <button type="button" onclick="window.location.href='/'" class="px-6 py-3.5 text-sm font-bold text-gray-500 hover:text-gray-800 hover:bg-gray-50 rounded-xl transition-colors">
                                Batal
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>
</div>

<!-- TOAST SUCCESS -->
<div id="toast-success" class="fixed top-5 right-5 hidden bg-green-500 text-white px-4 py-3 rounded-lg shadow">
    Password berhasil diperbarui
</div>

<!-- TOAST ERROR -->
<div id="toast-error" class="fixed top-16 right-5 hidden bg-red-500 text-white px-4 py-3 rounded-lg shadow">
    <span id="error-message"></span>
</div>

@endsection

@push('script')
<script>
function handleSave(e) {
    e.preventDefault();

    const btn = document.getElementById('save-btn');
    const form = document.getElementById('form-password');
    const formData = new FormData(form);

    btn.disabled = true;
    btn.innerHTML = 'Loading...';

    fetch("{{ route('change-password.store') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw data;

        showSuccess();

        form.reset();
        resetStrength();

    })
    .catch(err => {
        let msg = 'Terjadi kesalahan';

        if (err.message && typeof err.message === 'string') {
            msg = err.message;
        } else if (typeof err.message === 'object') {
            msg = Object.values(err.message)[0][0];
        }

        showError(msg);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = 'Update Password';
    });

    return false;
}

function toggleVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

function showSuccess() {
    const el = document.getElementById('toast-success');
    el.classList.remove('hidden');

    setTimeout(() => el.classList.add('hidden'), 3000);
}

function showError(msg) {
    const el = document.getElementById('toast-error');
    document.getElementById('error-message').innerText = msg;

    el.classList.remove('hidden');

    setTimeout(() => el.classList.add('hidden'), 3000);
}

function checkStrength() {
    const password = document.getElementById('new-pass').value;
    const bar = document.getElementById('strength-bar');
    const text = document.getElementById('strength-text');

    let strength = 0;

    if (password.length >= 8) strength += 25;
    if (/[A-Z]/.test(password)) strength += 25;
    if (/[0-9]/.test(password)) strength += 25;
    if (/[^A-Za-z0-9]/.test(password)) strength += 25;

    bar.style.width = strength + '%';

    if (strength <= 25) {
        bar.className = 'h-full bg-red-500';
        text.innerText = 'Lemah';
    } else if (strength <= 50) {
        bar.className = 'h-full bg-yellow-500';
        text.innerText = 'Cukup';
    } else if (strength <= 75) {
        bar.className = 'h-full bg-blue-500';
        text.innerText = 'Kuat';
    } else {
        bar.className = 'h-full bg-green-500';
        text.innerText = 'Sangat Kuat';
    }

    if (!password) {
        resetStrength();
    }
}

function resetStrength() {
    document.getElementById('strength-bar').style.width = '0%';
    document.getElementById('strength-text').innerText = '-';
}

function checkMatch() {
    const p1 = document.getElementById('new-pass').value;
    const p2 = document.getElementById('confirm-pass').value;
    const indicator = document.getElementById('match-indicator');

    if (p2 && p1 !== p2) {
        document.getElementById('confirm-pass').classList.add('border-red-500');
        indicator.classList.add('opacity-0');
    } else {
        document.getElementById('confirm-pass').classList.remove('border-red-500');
        indicator.classList.remove('opacity-0');
    }
}
</script>
@endpush
