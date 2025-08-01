<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Blog')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white text-gray-800 font-sans">
    @include('partials.nav')
    
    <!-- Main content -->
    @yield('content')
    
    <!-- homepage components -->
    @if(request()->is('/'))
        @include('components.hero')
        @include('components.article')
        @include('components.cta')
    @endif
    
    @include('components.footer')
</body>
</html>