<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'My Blog' }}</title>
    {{--@vite(['resources/css/app.css', 'resources/js/app.js'])--}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white text-gray-800 font-sans">
    <div class="max-w-7xl mx-auto px-4">
        @include('partials.nav')
        @include('components.hero')
        @include('components.article')
        @include('components.cta')
        @include('components.footer')

        {{-- Include the main content of the page --}}
        {{-- Main content --}}
        <main class="py-8">
            {{ $slot ?? '' }}
        </main>
       {{-- @include('partials.footer') --}}
    </div>
</body>
</html>
