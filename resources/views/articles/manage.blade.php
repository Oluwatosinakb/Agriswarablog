@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manage Articles</h1>
        <a href="{{ route('articles.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Article
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($articles as $article)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Article Image -->
                <div class="h-48 bg-gray-200 overflow-hidden">
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-300">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif
                </div>

                <!-- Article Content -->
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                            {{ $article->category->name ?? 'Uncategorized' }}
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ $article->created_at->format('M j, Y') }}
                        </span>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                        {{ $article->title }}
                    </h3>

                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{ $article->excerpt }}
                    </p>

                    <!-- Status Badge -->
                    <div class="mb-4">
                        @if($article->is_published)
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Published</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Draft</span>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <a href="{{ route('articles.show', $article) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded text-sm">
                            View
                        </a>
                        <a href="{{ route('articles.edit', $article) }}" 
                           class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white text-center py-2 px-3 rounded text-sm">
                            Edit
                        </a>
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this article?')"
                                    class="bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-500 mb-4">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-xl">No articles found</p>
                    <p class="text-sm">Create your first article to get started</p>
                </div>
                <a href="{{ route('articles.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                    Create Article
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection