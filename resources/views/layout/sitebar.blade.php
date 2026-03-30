<aside class="w-64 bg-brand-dark text-white flex-shrink-0 hidden md:flex flex-col shadow-2xl z-20">
    <div class="h-20 flex items-center px-6 border-b border-gray-700 bg-gray-900">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-infinity text-brand-primary text-2xl"></i>
            <span class="text-xl font-bold tracking-wide">{{ Str::upper(config('app.name')) }}</span>
        </div>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors
        {{ Route::is('dashboard') ? 'bg-brand-secondary text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <i class="fa-solid fa-home w-5"></i>
            N-POINT
        </a>

        <a href="{{ route('change-password.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors
        {{ Route::is('change-password.index') ? 'bg-brand-secondary text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <i class="fa-solid fa-key w-5"></i>
            GANTI PASSWORD
        </a>

        <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors
        {{ Route::is('users.index') ? 'bg-brand-secondary text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <i class="fa-solid fa-user w-5"></i>
            DATA USER
        </a>

        <a href="{{ url('logout') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors
        {{ Route::is('logout') ? 'bg-brand-secondary text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <i class="fa-solid fa-sign-out-alt w-5"></i>
            KELUAR
        </a>

        <div class="mt-8 bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-inner">
            <div class="flex items-center gap-2 mb-3 text-brand-primary">
                <i class="fa-solid fa-user-circle text-lg"></i>
                <h3 class="font-bold text-xs uppercase">User Information</h3>
            </div>
            <div class="space-y-3 text-xs text-gray-300">
                <p>
                    Hallo ! <span class="font-semibold text-white">{{ ucwords(Auth::user()->nama) }}</span>
                </p>
                <p>
                    Teminal :
                    @php
                    $provider = \DB::table('tbl_provider')->where('provider_code', Auth::user()->provider_code)->first();
                    @endphp
                    <span class="font-semibold text-white"> {{ Auth::user()->id }}</span>
                </p>
                <p class="font-semibold text-white">{{ Str::upper($provider->provider_name ?? '-') }}</p>
            </div>
        </div>
    </nav>
</aside>
