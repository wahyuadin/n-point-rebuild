<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ ucwords(config('app.name')) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    @include('layout.style')
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased overflow-hidden">
    <div class="flex h-screen">
        @include('layout.sitebar')
        @yield('content')
    </div>

    @include('layout.script')
</body>
</html>
