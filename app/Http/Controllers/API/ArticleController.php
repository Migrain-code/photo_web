<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        
        $articles = Article::with('images')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $formattedArticles = $articles->getCollection()->map(function ($article) {
            return [
                'id' => $article->id,
                'slug' => $article->slug,
                'title' => $article->title,
                'seo_title' => $article->seo_title,
                'seo_description' => $article->seo_description,
                'content' => $article->content,
                'featured_image' => $article->featured_image ? asset('storage/' . $article->featured_image) : null,
                'images' => $article->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image_path' => asset('storage/' . $image->image_path),
                        'order' => $image->order,
                    ];
                })->toArray(),
                'created_at' => $article->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data' => $formattedArticles,
            'current_page' => $articles->currentPage(),
            'last_page' => $articles->lastPage(),
            'per_page' => $articles->perPage(),
            'total' => $articles->total(),
            'next_page_url' => $articles->nextPageUrl(),
            'prev_page_url' => $articles->previousPageUrl(),
        ]);
    }

    public function show($id)
    {
        $article = Article::with('images')->findOrFail($id);
        
        return response()->json([
            'data' => [
                'id' => $article->id,
                'title' => $article->title,
                'seo_title' => $article->seo_title,
                'seo_description' => $article->seo_description,
                'content' => $article->content,
                'featured_image' => $article->featured_image ? asset('storage/' . $article->featured_image) : null,
                'images' => $article->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image_path' => asset('storage/' . $image->image_path),
                        'order' => $image->order,
                    ];
                })->toArray(),
                'created_at' => $article->created_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
