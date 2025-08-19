@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">AI Article Generator</h1>
                <p class="text-gray-600">Let AI help you create engaging articles for your blog</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('ai-articles.generate') }}" method="POST" id="aiForm">
                @csrf

                <!-- Topic -->
                <div class="mb-6">
                    <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">
                        Article Topic *
                    </label>
                    <input type="text" 
                           id="topic" 
                           name="topic" 
                           value="{{ old('topic') }}"
                           placeholder="e.g., Best practices for growing tomatoes in small spaces"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Be specific about what you want the article to cover</p>
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Category *
                    </label>
                    <select id="category_id" 
                            name="category_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tone Selection -->
                
                </div>

                <!-- Length Selection -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Article Length *</label>
                    <div class="flex space-x-4">
                        <label class="flex-1 flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="length" value="short" class="text-green-600 focus:ring-green-500 mr-2" {{ old('length') == 'short' ? 'checked' : '' }}>
                            <div class="text-center">
                                <div class="font-medium">Short</div>
                                <div class="text-sm text-gray-500">300-500 words</div>
                            </div>
                        </label>
                        <label class="flex-1 flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="length" value="medium" class="text-green-600 focus:ring-green-500 mr-2" {{ old('length') == 'medium' ? 'checked' : '' }}>
                            <div class="text-center">
                                <div class="font-medium">Medium</div>
                                <div class="text-sm text-gray-500">500-800 words</div>
                            </div>
                        </label>
                        <label class="flex-1 flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="length" value="long" class="text-green-600 focus:ring-green-500 mr-2" {{ old('length') == 'long' ? 'checked' : '' }}>
                            <div class="text-center">
                                <div class="font-medium">Long</div>
                                <div class="text-sm text-gray-500">800-1200 words</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Generate Button -->
                <div class="text-center">
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors"
                            id="generateBtn">
                        <svg class="w-5 h-5 mr-2 hidden" id="loadingIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <svg class="w-5 h-5 mr-2" id="magicIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"></path>
                        </svg>
                        <span id="btnText">Generate Article</span>
                    </button>
                    <p class="text-sm text-gray-500 mt-2">This may take 10-30 seconds</p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('aiForm').addEventListener('submit', function() {
    const btn = document.getElementById('generateBtn');
    const loadingIcon = document.getElementById('loadingIcon');
    const magicIcon = document.getElementById('magicIcon');
    const btnText = document.getElementById('btnText');
    
    btn.disabled = true;
    btn.classList.add('opacity-75');
    loadingIcon.classList.remove('hidden');
    loadingIcon.classList.add('animate-spin');
    magicIcon.classList.add('hidden');
    btnText.textContent = 'Generating...';
});
</script>
@endsection