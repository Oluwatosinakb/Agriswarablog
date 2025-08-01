<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    
    public function index()
    {
        $articles = Article::with('category')->latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    
    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        // Generate slug from title
        $validated['slug'] = Str::slug($validated['title']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images/articles', 'public');
        }

        // Set published_at if is_published is true and no published_at is set
        if ($request->is_published && !$request->published_at) {
            $validated['published_at'] = now();
        }

        // Generate excerpt if not provided
        if (!$validated['excerpt']) {
            $validated['excerpt'] = Str::limit(strip_tags($validated['body']), 150);
        }

        $article = Article::create($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article created successfully!');
    }

    public function show(Article $article)
    {
        $article->load('category');
        return view('articles.show', compact('article'));
    }

    
    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        
        if ($request->title !== $article->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

       
        if ($request->hasFile('image')) {
            
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            
            $validated['image'] = $request->file('image')->store('images/articles', 'public');
        }

        
        if ($request->is_published && !$article->published_at && !$request->published_at) {
            $validated['published_at'] = now();
        }

        
        if (!$validated['excerpt']) {
            $validated['excerpt'] = Str::limit(strip_tags($validated['body']), 150);
        }

        $article->update($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article updated successfully!');
    }

    
    public function destroy(Article $article)
    {
        
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully!');
    }

    public function manage()
    {
       $articles = Article::with('category')
                      ->orderBy('created_at', 'desc')
                      ->get();
    
        return view('articles.manage', compact('articles'));
    }
}