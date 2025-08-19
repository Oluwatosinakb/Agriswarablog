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
            <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
                Discover our latest insights on agriculture, gardening, and sustainable farming practices.
            </p>
            
            <!-- Write Article Button -->
            <div class="mt-8">
                <a href="{{ route('articles.create') }}" class="inline-flex items-center px-6 py-3 bg-lime-600 text-white font-medium rounded-lg hover:bg-lime-700 transition duration-150 ease-in-out shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Write New Article
                </a>
            </div>
        </div>
    </section>

    <!-- Success Message -->
    @if(session('success'))
        <div class="max-w-6xl mx-auto px-4 mb-8">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Articles Grid -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            @if($articles->count() > 0)
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($articles as $article)
                        <article class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition hover:bg-gray-50">
                            <a href="{{ route('articles.show', $article->slug) }}" class="block">
                               
                             
<div class="h-48 w-full overflow-hidden rounded-lg bg-gray-200">
    @if($article->image)
        <img src="{{ asset($article->image) }}" 
             alt="{{ $article->title }}" 
             class="w-full h-full object-cover">
    @else
        <div class="w-full h-full flex items-center justify-center">
            <span class="text-gray-500">No Image</span>
        </div>
    @endif
</div>
                                
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <p class="text-sm text-gray-500">
                                            @if($article->is_published && $article->published_at)
                                                {{ $article->published_at->format('F j, Y') }}
                                            @else
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">Draft</span>
                                            @endif
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
                                    
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center text-lime-600 text-sm font-medium">
                                            Read More 
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                        
                                        <!-- Edit/Delete buttons -->
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('articles.edit', $article) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($articles->hasPages())
                    <div class="mt-12">
                        {{ $articles->links() }}
                    </div>
                @endif
            @else
                <!-- No Articles Found -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No articles found</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Get started by creating your first article!
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('articles.create') }}" class="inline-flex items-center px-6 py-3 bg-lime-600 text-white font-medium rounded-lg hover:bg-lime-700 transition duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Write Your First Article
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