<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->latest()->get();
        return view('articles.index', compact('articles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'nullable|string',
            'body' => 'required',
            'image' => 'nullable|image',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images/articles', 'public');
        }

        return Article::create($validated);
    }

    public function show(Article $article)
    {
        $article->load('category');
        return view('articles.show', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'nullable|string',
            'body' => 'required',
            'image' => 'nullable|image',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images/articles', 'public');
        }

        $article->update($validated);
        return $article;
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['message' => 'Article deleted']);
    }
}