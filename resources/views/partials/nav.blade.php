<nav x-data="{ open: false }" class="flex items-center justify-between px-8 py-6 max-w-7xl mx-auto">
  <!-- Left: Logo + Nav Links -->
  <div class="flex items-center gap-16 items-center">

    <!-- Logo -->
    <div class="flex-shrink-0">
      <a href="/">
        <img src="{{ asset('images/Agriswara-logo.png') }}" alt="Logo" class="h-28 w-auto">
      </a>
    </div>

    <!-- Desktop Nav Links -->
    <ul class="hidden md:flex items-center gap-10 text-sm font-medium text-gray-700 list-none">
      <!-- Services Dropdown -->
      <li class="relative group flex items-center gap-1">
        <a href="#" class="hover:text-black flex items-center gap-1">
          Services
          <svg class="w-4 h-4 transform group-hover:rotate-180 transition duration-300" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </a>
        <ul class="absolute left-0 mt-3 top-full w-40 bg-white shadow-md rounded-md opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 z-50">
          <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Consulting</a></li>
          <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Training</a></li>
          <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Advisory</a></li>
        </ul>
      </li>

      <!-- Category Dropdown -->
      <li class="relative group flex items-center gap-1">
        <a href="#" class="hover:text-black flex items-center gap-1">
          Category
          <svg class="w-4 h-4 transform group-hover:rotate-180 transition duration-300" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </a>
        <ul class="absolute left-0 mt-3 top-full w-40 bg-white shadow-md rounded-md opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 z-50">
          <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Farming</a></li>
          <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Technology</a></li>
          <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Finance</a></li>
        </ul>
      </li>

      <!-- Other Links -->
      <li><a href="{{ route('articles.index') }}" class="hover:text-black">Article</a></li>
      <li><a href="#" class="hover:text-black">About Us</a></li>
      <li><a href="#" class="hover:text-black">Contact</a></li>
    </ul>
  </div>

  <!-- Right: Auth Buttons (Desktop) -->
  <div class="hidden md:flex items-center space-x-3">
    @auth
      <!-- Logged in user -->
      <span class="text-sm text-gray-600">Welcome, {{ Auth::user()->name }}!</span>
      <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" class="text-sm font-medium text-gray-700 hover:text-black">
          Logout
        </button>
      </form>
    @else
      <!-- Guest user -->
      <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-black">Sign In</a>
      <a href="{{ route('register') }}" class="border border-gray-800 rounded-full px-4 py-1 text-sm font-medium hover:bg-gray-800 hover:text-white transition">Sign Up</a>
    @endauth
  </div>

  <!-- Hamburger (Mobile) -->
  <button @click="open = !open" class="md:hidden text-gray-700 focus:outline-none">
    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M4 6h16M4 12h16M4 18h16" />
    </svg>
    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>

  <!-- Mobile Menu -->
  <div x-show="open" x-transition class="md:hidden fixed top-28 left-0 w-full bg-white px-8 py-6 space-y-4 shadow z-50">
    <ul class="space-y-4 text-sm font-medium text-gray-700">
      <li>
        <details class="group">
          <summary class="cursor-pointer hover:text-black">Services</summary>
          <ul class="pl-4 mt-2 space-y-1">
            <li><a href="#" class="block hover:text-black">Consulting</a></li>
            <li><a href="#" class="block hover:text-black">Training</a></li>
            <li><a href="#" class="block hover:text-black">Advisory</a></li>
          </ul>
        </details>
      </li>

      <li>
        <details class="group">
          <summary class="cursor-pointer hover:text-black">Category</summary>
          <ul class="pl-4 mt-2 space-y-1">
            <li><a href="#" class="block hover:text-black">Farming</a></li>
            <li><a href="#" class="block hover:text-black">Technology</a></li>
            <li><a href="#" class="block hover:text-black">Finance</a></li>
          </ul>
        </details>
      </li>

      <li><a href="{{ route('articles.index') }}" class="hover:text-black">Article</a></li>
      <li><a href="#" class="hover:text-black">About Us</a></li>
      <li><a href="#" class="hover:text-black">Contact</a></li>
      
      @auth
        <!-- Mobile logged in user -->
        <li class="pt-2 border-t border-gray-200">
          <span class="text-sm text-gray-600">Welcome, {{ Auth::user()->name }}!</span>
        </li>
        <li>
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="block hover:text-black w-full text-left">
              Logout
            </button>
          </form>
        </li>
      @else
        <!-- Mobile guest user -->
        <li><a href="{{ route('login') }}" class="block hover:text-black">Sign In</a></li>
        <li><a href="{{ route('register') }}" class="block border border-gray-800 rounded-full px-4 py-1 text-sm font-medium hover:bg-gray-800 hover:text-white transition">Sign Up</a></li>
      @endauth
    </ul>
  </div>
</nav>