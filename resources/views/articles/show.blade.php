<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Article Header -->
            <div class="p-8">
                <div class="mb-4">
                    <a href="/" class="text-lime-700 hover:text-lime-800 text-sm font-medium">← Back to Home</a>
                </div>
                
                <header class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $article->title }}</h1>
                    
                    <div class="flex items-center text-gray-600 text-sm mb-6">
                        @if($article->is_published && $article->published_at)
                            <span>Published on {{ $article->published_at->format('F j, Y') }}</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">Draft</span>
                            <span class="mx-2">•</span>
                            <span>Created on {{ $article->created_at->format('F j, Y') }}</span>
                        @endif
                        @if($article->category)
                            <span class="mx-2">•</span>
                            <span class="bg-lime-100 text-lime-800 px-3 py-1 rounded-full text-xs font-medium">{{ $article->category->name }}</span>
                        @endif
                    </div>
                    
                    @if($article->image_path)
                        <img src="{{ asset($article->image_path) }}" alt="{{ $article->title }}" class="w-full h-64 object-cover rounded-lg mb-6">
                    @endif
                    
                    @if($article->excerpt)
                        <div class="bg-lime-50 border-l-4 border-lime-400 p-4 mb-6">
                            <p class="text-lg text-gray-700 italic">{{ $article->excerpt }}</p>
                        </div>
                    @endif
                </header>
                
                <!-- Article Content -->
                <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                    {!! nl2br(e($article->body)) !!}
                </div>
            </div>
        </article>
        
        <!-- Back to Home Button -->
        <div class="mt-8 text-center">
            <a href="/" class="inline-block bg-lime-700 text-white px-6 py-3 rounded-lg hover:bg-lime-800 transition duration-200">
                Back to Home
            </a>
        </div>
    </div>
</body>
</html>