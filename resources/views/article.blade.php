@extends('layouts.app')

@section('title', $article->seo_title ?? $article->title)

@push('meta')
@php
    $seo_title = $article->seo_title ?? $article->title;
    $seo_description = $article->seo_description ?? strip_tags(substr($article->content, 0, 160));
    $og_image = $article->featured_image ? asset('storage/' . $article->featured_image) : null;
@endphp
<meta name="title" content="{{ $seo_title }}">
@if($seo_description)
<meta name="description" content="{{ $seo_description }}">
<meta property="og:description" content="{{ $seo_description }}">
@endif
<meta property="og:title" content="{{ $seo_title }}">
@if($og_image)
<meta property="og:image" content="{{ $og_image }}">
@endif
@endpush

@section('content')
<div class="article-detail-layout">
    <!-- Left Section: Article Content -->
    <div class="article-content-section">
        @include('partials.nav')
        <h1 class="article-detail-title">{{ $article->title }}</h1>
        <div class="article-detail-content">
            {!! $article->content !!}
        </div>
        
        
    </div>

    <!-- Right Section: Article Images -->
    <div class="article-images-section">
        @if($article->images && $article->images->count() > 0)
            <div class="article-images-list">
                @foreach($article->images as $image)
                    <div class="article-image-item">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $article->title }} - Görsel {{ $loop->iteration }}">
                    </div>
                @endforeach
            </div>
        @else
            <p class="no-images">Bu makale için görsel bulunmamaktadır.</p>
        @endif
    </div>
</div>

@push('styles')
<style>
    .article-detail-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
        gap: 0;
    }

    @media (max-width: 768px) {
        .article-detail-layout {
            grid-template-columns: 1fr;
        }
    }

    .article-content-section {
        padding: 60px 40px;
        overflow-y: auto;
        height: auto;
        background: #fff;
    }

    .article-images-section {
        padding: 60px 40px;
        overflow-y: auto;
        max-height: 1400px;
        background: #f8f9fa;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 30px;
        color: #666;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
    }

    .back-link:hover {
        color: #333;
    }

    .article-detail-title {
        font-size: 32px;
        font-weight: 600;
        margin-bottom: 30px;
        line-height: 1.3;
    }

    .article-detail-content {
        font-size: 16px;
        line-height: 1.8;
        color: #333;
        margin-bottom: 40px;
    }

    .article-detail-content p {
        margin-bottom: 20px;
    }

    .article-detail-content img {
        max-width: 100%;
        height: auto;
        margin: 20px 0;
    }

    .images-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 30px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .article-images-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .article-image-item {
        width: 100%;
    }

    .article-image-item img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    .no-images {
        color: #999;
        font-style: italic;
    }

    .seo-info {
        margin-top: 40px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        font-size: 14px;
    }

    .seo-info h3 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
    }

    .seo-info p {
        margin-bottom: 10px;
        color: #666;
    }
</style>
@endpush
@endsection
