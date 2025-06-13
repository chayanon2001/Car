<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Home</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-gray-900 text-gray-100 flex flex-col items-center p-6 lg:p-8 min-h-screen">

    <header class="w-full max-w-5xl mb-10 px-4 flex justify-end items-center">
       

        @if (Route::has('login'))
            <nav class="flex items-center gap-3 text-sm font-semibold">
                @guest
                    <a href="{{ route('login') }}"
                        class="px-6 py-2 border border-blue-700 text-blue-700 rounded-md hover:bg-blue-700 hover:text-white transition">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-2 px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                            Register
                        </a>
                    @endif
                @endguest
            </nav>
        @endif

    </header>

    <main class="flex flex-col lg:flex-row items-center justify-center w-full max-w-5xl gap-12 px-4 pt-10">
        <div class="lg:w-1/2 rounded-lg overflow-hidden">
            <img src="{{ asset('img/car.png') }}" alt="Car Image" class="w-full object-cover" />
        </div>


        <div class="lg:w-1/2 space-y-6">
            <p class="text-2xl font-semibold text-gray-900">
                รถยนต์คุณภาพ ราคาดี พร้อมบริการหลังการขาย
            </p>
            <p class="text-gray-300 leading-relaxed">
                ค้นหารถยนต์ที่ตรงใจคุณได้ง่ายๆ เรามีรถหลากหลายรุ่นและราคาที่คุณพอใจ
                พร้อมรับประกันคุณภาพและบริการอย่างมืออาชีพ
            </p>
        </div>
    </main>
</body>

</html>
