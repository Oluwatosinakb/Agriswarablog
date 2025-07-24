@extends('layouts.app')

@section('content')

  {{-- Main content for the home page --}}
  <div class="max-w-4xl mx-auto py-10">
    <h1 class="text-4xl font-bold mb-4">Welcome to the Blog</h1>
    <p class="text-gray-600">This is the homepage where blog posts will be listed.</p>
  </div>

  {{-- CTA Section --}}
  <section class="relative bg-cover bg-center bg-no-repeat h-96 mt-16 rounded-lg overflow-hidden shadow-lg"
           style="background-image: url('{{ asset('images/farm-cta.jpg') }}')">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-center px-4">
      <div>
        <h2 class="text-white text-4xl md:text-5xl font-bold mb-6">
          Get involved in the <br class="hidden md:block"> agricultural uprising
        </h2>
        <form class="flex justify-center items-center max-w-md mx-auto">
          <input type="email" placeholder="Type your email address"
                 class="w-full px-4 py-2 rounded-l-full outline-none" required>
          <button type="submit"
                  class="bg-lime-400 hover:bg-lime-500 text-black font-semibold px-6 py-2 rounded-r-full flex items-center gap-2">
            Join Now
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
          </button>
        </form>
      </div>
    </div>
  </section>

@endsection
