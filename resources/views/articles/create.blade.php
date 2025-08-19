@extends('layouts.app')

@section('title', 'Create New Article')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with AI Option -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Create New Article</h1>
                    <p class="text-gray-600 mt-2">Share your thoughts and insights with the world</p>
                </div>
                <button 
                    id="aiGenerateBtn"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors"
                    onclick="toggleAIPanel()"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Generate with AI
                </button>
            </div>
        </div>

        <!-- AI Generation Panel (Initially Hidden) -->
        <div id="aiPanel" class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg shadow-sm p-6 mb-6 hidden">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">AI Article Generator</h2>
                <button 
                    onclick="toggleAIPanel()" 
                    class="text-gray-500 hover:text-gray-700"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="aiForm" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Topic</label>
                        <input 
                            type="text" 
                            id="ai_topic"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="e.g., Benefits of renewable energy"
                            required
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Writing Tone</label>
                        <select id="ai_tone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="professional">Professional</option>
                            <option value="casual">Casual</option>
                            <option value="academic">Academic</option>
                            <option value="creative">Creative</option>
                            <option value="informative">Informative</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Article Length</label>
                        <select id="ai_length" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="short">Short (300-500 words)</option>
                            <option value="medium" selected>Medium (500-800 words)</option>
                            <option value="long">Long (800-1200 words)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select id="ai_category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Additional Instructions (Optional)</label>
                    <textarea 
                        id="ai_instructions"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="Any specific points to include or style preferences..."
                    ></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        id="generateBtn"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition-colors"
                    >
                        <span id="generateBtnText">Generate Article</span>
                        <span id="generateBtnLoading" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Generating...
                        </span>
                    </button>
                    <button 
                        type="button" 
                        onclick="clearAIForm()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors"
                    >
                        Clear
                    </button>
                </div>
            </form>
        </div>

        <!-- Main Form -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Article Title *
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('title') border-red-500 @enderror"
                        placeholder="Enter an engaging title for your article"
                        required
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                        Excerpt (optional)
                    </label>
                    <textarea 
                        name="excerpt" 
                        id="excerpt" 
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('excerpt') border-red-500 @enderror"
                        placeholder="Brief summary of your article (will be auto-generated if left empty)"
                    >{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Category *
                    </label>
                    <select 
                        name="category_id" 
                        id="category_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('category_id') border-red-500 @enderror"
                        required
                    >
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Featured Image (optional)
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500">
                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                            <input id="image" name="image" type="file" class="hidden" accept="image/*">
                        </label>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="body" class="block text-sm font-medium text-gray-700 mb-2">
                        Article Content *
                    </label>
                    <textarea 
                        name="body" 
                        id="body" 
                        rows="15"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('body') border-red-500 @enderror"
                        placeholder="Write your article content here or use AI to generate content above."
                        required
                    >{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Publish Options -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="is_published" 
                            id="is_published" 
                            value="1"
                            {{ old('is_published') ? 'checked' : '' }}
                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                        >
                        <label for="is_published" class="ml-2 block text-sm text-gray-700">
                            Publish immediately
                        </label>
                    </div>

                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                            Or schedule for later (optional)
                        </label>
                        <input 
                            type="datetime-local" 
                            name="published_at" 
                            id="published_at" 
                            value="{{ old('published_at') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('published_at') border-red-500 @enderror"
                        >
                        @error('published_at')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-2">
                            Set a future date to schedule publication. Leave empty if "Publish immediately" is checked.
                        </p>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button 
                        type="submit" 
                        class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors font-medium"
                    >
                        Publish Article
                    </button>
                    <a 
                        href="{{ route('articles.index') }}" 
                        class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors font-medium text-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Toggle AI Panel
function toggleAIPanel() {
    const panel = document.getElementById('aiPanel');
    const btn = document.getElementById('aiGenerateBtn');
    
    if (panel.classList.contains('hidden')) {
        panel.classList.remove('hidden');
        btn.textContent = '× Close AI Generator';
        btn.classList.remove('bg-purple-600', 'hover:bg-purple-700');
        btn.classList.add('bg-red-600', 'hover:bg-red-700');
    } else {
        panel.classList.add('hidden');
        btn.innerHTML = `
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Generate with AI
        `;
        btn.classList.remove('bg-red-600', 'hover:bg-red-700');
        btn.classList.add('bg-purple-600', 'hover:bg-purple-700');
    }
}

// Clear AI Form
function clearAIForm() {
    document.getElementById('ai_topic').value = '';
    document.getElementById('ai_tone').value = 'professional';
    document.getElementById('ai_length').value = 'medium';
    document.getElementById('ai_category').value = '';
    document.getElementById('ai_instructions').value = '';
}

//AI Form Submission
document.getElementById('aiForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const generateBtn = document.getElementById('generateBtn');
    const generateBtnText = document.getElementById('generateBtnText');
    const generateBtnLoading = document.getElementById('generateBtnLoading');
    
    // Show loading state
    generateBtn.disabled = true;
    generateBtnText.classList.add('hidden');
    generateBtnLoading.classList.remove('hidden');
    
    try {
        // Get CSRF token from meta tag or form
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
                          || document.querySelector('input[name="_token"]')?.value;
        
        console.log('Using CSRF token:', csrfToken); // Debug log
        
        if (!csrfToken) {
            throw new Error('CSRF token not found');
        }
        
        // Create form data
        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('topic', document.getElementById('ai_topic').value);
        formData.append('tone', document.getElementById('ai_tone').value);
        formData.append('length', document.getElementById('ai_length').value);
        formData.append('category_id', document.getElementById('ai_category').value);
        formData.append('instructions', document.getElementById('ai_instructions').value);
        
        const response = await fetch('/ai-articles/generate', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin' // Important for CSRF
        });
        
        console.log('Response status:', response.status); // Debug log
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Response error:', errorText);
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Response data:', data); // Debug log
        
        if (data.success) {
            // Fill the main form with AI-generated content
            document.getElementById('title').value = data.title;
            document.getElementById('excerpt').value = data.excerpt;
            document.getElementById('body').value = data.content;
            
            // Set category if selected
            if (data.category_id) {
                document.getElementById('category_id').value = data.category_id;
            }
            
            // Close AI panel
            toggleAIPanel();
            
            // Show success message
            showMessage('Article generated successfully! You can now edit and publish it.', 'success');
            
            // Scroll to the generated content
            document.getElementById('body').scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            showMessage(data.message || 'Failed to generate article. Please try again.', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showMessage('An error occurred: ' + error.message, 'error');
    } finally {
        // Hide loading state
        generateBtn.disabled = false;
        generateBtnText.classList.remove('hidden');
        generateBtnLoading.classList.add('hidden');
    }
});


function showMessage(message, type) {
    
    const existingMessages = document.querySelectorAll('.flash-message');
    existingMessages.forEach(msg => msg.remove());
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `flash-message fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
    }`;
    messageDiv.textContent = message;
    
    document.body.appendChild(messageDiv);
    
    
    setTimeout(() => {
        messageDiv.remove();
    }, 5000);
}


document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('img');
            preview.src = e.target.result;
            preview.className = 'mt-4 max-w-xs rounded-lg shadow-md';
            
            
            const existingPreview = document.querySelector('.image-preview');
            if (existingPreview) {
                existingPreview.remove();
            }
            
           
            preview.className += ' image-preview';
            document.querySelector('label[for="image"]').parentNode.appendChild(preview);
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection