<section class="py-12 bg-white">
  <div class="max-w-6xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Related Article</h2>
      <a href="{{ route('articles.index') }}" class="text-sm text-lime-700 border border-lime-700 px-4 py-2 rounded-full hover:bg-lime-50 transition">View all Articles</a>
    </div>

    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
      <!-- Article Card 1 -->
      <a href="{{ route('articles.show', 'achieving-high-productivity-from-your-own-home-garden') }}" class="block bg-gray-50 border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition hover:bg-gray-100">
        <img src="{{ asset('images/tomatoes.png') }}" alt="Home Garden" class="w-full h-48 object-cover">
        <div class="p-4">
          <p class="text-sm text-gray-500 mb-1">October 23, 2023</p>
          <h3 class="text-lg font-semibold text-gray-800">Achieving High Productivity from Your Own Home Garden.</h3>
          <p class="text-sm text-gray-600 mt-2">A Practical Guide to Achieving Satisfactory Results from Plants Grown in Your Home.</p>
        </div>
      </a>

      <!-- Article Card 2 -->
      <a href="{{ route('articles.show', 'the-best-guide-to-planting-seeds-with-optimal-results') }}" class="block bg-gray-50 border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition hover:bg-gray-100">
        <img src="{{ asset('images/planting.png') }}" alt="Planting Seeds" class="w-full h-48 object-cover">
        <div class="p-4">
          <p class="text-sm text-gray-500 mb-1">October 23, 2023</p>
          <h3 class="text-lg font-semibold text-gray-800">The Best Guide to Planting Seeds with Optimal Results.</h3>
          <p class="text-sm text-gray-600 mt-2">Effective Strategies and Techniques to Achieve Healthy and Productive Plant Growth.</p>
        </div>
      </a>

      <!-- Article Card 3 -->
      <a href="{{ route('articles.show', 'strategies-for-caring-for-your-garden-more-efficiently-and-productively') }}" class="block bg-gray-50 border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition hover:bg-gray-100">
        <img src="{{ asset('images/storage.png') }}" alt="Garden Storage" class="w-full h-48 object-cover">
        <div class="p-4">
          <p class="text-sm text-gray-500 mb-1">October 23, 2023</p>
          <h3 class="text-lg font-semibold text-gray-800">Strategies for Caring for Your Garden More Efficiently and Productively.</h3>
          <p class="text-sm text-gray-600 mt-2">An approach that improves plant performance and makes garden management easier.</p>
        </div>
      </a>
    </div>
  </div>
</section>