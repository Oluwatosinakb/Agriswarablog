<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Articles - Agriswara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    
    <!-- Navigation -->
    @include('partials.nav')
    
    <!-- Header Section -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">All Articles</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Discover our latest insights on agriculture, gardening, and sustainable farming practices.
            </p>
        </div>
    </section>

    <!-- Articles Grid -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            @if($articles->count() > 0)
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($articles as $article)
                        <article class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition hover:bg-gray-50">
                            <a href="{{ route('articles.show', $article->slug) }}" class="block">
                                @if($article->image_path)
                                    <img src="{{ asset($article->image_path) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <p class="text-sm text-gray-500">
                                            {{ $article->published_at->format('F j, Y') }}
                                        </p>
                                        @if($article->category)
                                            <span class="bg-lime-100 text-lime-800 px-2 py-1 rounded-full text-xs font-medium">
                                                {{ $article->category->name }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <h2 class="text-xl font-semibold text-gray-800 mb-3 line-clamp-2">
                                        {{ $article->title }}
                                    </h2>
                                    
                                    @if($article->excerpt)
                                        <p class="text-sm text-gray-600 line-clamp-3">
                                            {{ $article->excerpt }}
                                        </p>
                                    @endif
                                    
                                    <div class="mt-4 flex items-center text-lime-600 text-sm font-medium">
                                        Read More 
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            @else
                <!-- No Articles Found -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No articles found</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            There are no articles to display at the moment. Check back later!
                        </p>
                        <div class="mt-6">
                            <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-lime-600 hover:bg-lime-700">
                                Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Back to Home Section -->
    <section class="py-8 bg-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <a href="/" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-lime-600 hover:bg-lime-700 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
        </div>
    </section>

    <!-- Footer -->
    @include('components.footer')

</body>
</html>