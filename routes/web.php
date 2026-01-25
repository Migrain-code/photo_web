<?php

use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/article/{slug}', [HomeController::class, 'article'])->name('article.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit']);

Route::get('/start-a-project', [ProjectController::class, 'show'])->name('start-a-project');
Route::post('/start-a-project', [ProjectController::class, 'submit']);

Route::prefix('api')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
});
