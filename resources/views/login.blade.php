<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - N-POINT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                    , colors: {
                        brand: {
                            dark: '#0f172a'
                            , primary: '#10b981', // Emerald 500
                            hover: '#059669', // Emerald 600
                        }
                    }
                    , animation: {
                        'fade-in-up': 'fadeInUp 0.5s ease-out'
                    , }
                    , keyframes: {
                        fadeInUp: {
                            '0%': {
                                opacity: '0'
                                , transform: 'translateY(10px)'
                            }
                            , '100%': {
                                opacity: '1'
                                , transform: 'translateY(0)'
                            }
                        , }
                    }
                }
            }
        }

    </script>
    <style>
        /* Background Pattern yang Modern */
        body {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
        }

    </style>
    @toastifyCss
</head>
<body class="h-screen w-full flex items-center justify-center p-4">
    @php
    $rememberDeviceDecoded = isset($rememberDevice) ? json_decode($rememberDevice) : null;
    @endphp
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden animate-fade-in-up relative">

        <div class="h-2 bg-brand-primary w-full"></div>

        <div class="p-8 sm:p-10">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-50 mb-4">
                    <i class="fa-solid fa-infinity text-brand-primary text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">N-POINT REPORT</h1>
                <p class="text-sm text-gray-500 mt-1">Silakan masuk ke akun Anda</p>
            </div>

            <form action="{{ route('login.store') }}" method="POST">
                <div class="space-y-5">
                    @csrf
                    <div>
                        <label for="username" class="block text-xs font-semibold text-gray-700 uppercase mb-1 ml-1">Username</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-user text-gray-400 group-focus-within:text-brand-primary transition-colors"></i>
                            </div>
                            <input type="text" value="{{ $rememberDeviceDecoded ? $rememberDeviceDecoded->username : '' }}" id="username" name="username" required class="block w-full pl-10 pr-4 py-3 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition-all outline-none placeholder-gray-400" placeholder="Masukkan ID Pengguna">
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1 ml-1">
                            <label for="password" class="block text-xs font-semibold text-gray-700 uppercase">Password</label>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400 group-focus-within:text-brand-primary transition-colors"></i>
                            </div>
                            <input type="password" id="password" value="{{ $rememberDeviceDecoded ? $rememberDeviceDecoded->password : '' }}" name="password" required class="block w-full pl-10 pr-10 py-3 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-primary focus:border-brand-primary focus:bg-white transition-all outline-none placeholder-gray-400" placeholder="••••••••">

                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i id="eye-icon" class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center">
                            <input id="remember-me" type="checkbox" value="1" name="remember_device" {{ $rememberDevice ? 'checked' : '' }} class="h-4 w-4 text-brand-primary focus:ring-brand-primary border-gray-300 rounded cursor-pointer">
                            <label for="remember-me" class="ml-2 block text-gray-600 cursor-pointer select-none">Ingat saya</label>
                        </div>
                        <a href="#" class="font-medium text-brand-primary hover:text-emerald-700 transition-colors">Lupa password?</a>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-brand-primary hover:bg-brand-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                        MASUK
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-500">
                &copy; 2025 Nayaka Era Husada. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        // 1. Fungsi Toggle Password
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

    </script>
    @toastifyJs
</body>
</html>
