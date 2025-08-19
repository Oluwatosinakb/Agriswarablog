<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AIArticleController;  
use Illuminate\Support\Facades\Route;

// Homepage route
Route::get('/', function () {
    return view('layouts.app');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Article management route (must be before resource routes)
Route::get('/articles/manage', [ArticleController::class, 'manage'])->name('articles.manage');

// AI Article Generation
Route::get('/ai-articles/create', [AIArticleController::class, 'create'])->name('ai-articles.create');
Route::post('/ai-articles/generate', [AIArticleController::class, 'generate'])->name('ai-articles.generate');
Route::post('/ai-articles/save', [AIArticleController::class, 'save'])->name('ai-articles.save');
Route::get('/test-ai', [AIArticleController::class, 'testAPI']);
// Resource routes
Route::resource('/articles', ArticleController::class);
Route::resource('/categories', CategoryController::class);