<?php

use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/article/{slug}', [HomeController::class, 'article'])->name('article.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::prefix('api')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
});
