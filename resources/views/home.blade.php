@extends('layouts.app')

@section('title', $seoTitle ? $seoTitle->value : 'Home')

@if($seoDescription)
@push('meta')
<meta name="description" content="{{ $seoDescription->value }}">
@endpush
@endif

@section('content')
<div class="home-page">
    @include('partials.nav')

    @if(!empty($heroTextLeft) || !empty($heroTextRight))
    <section class="home-hero">
        <div class="home-hero-inner">
            <div class="home-hero-left">
                @if(!empty($heroTextLeft))
                    <div class="home-hero-text">{!! nl2br(e($heroTextLeft)) !!}</div>
                @endif
            </div>
            <div class="home-hero-right">
                @if(!empty($heroTextRight))
                    <div class="home-hero-text">{!! nl2br(e($heroTextRight)) !!}</div>
                @endif
                @if(!empty($heroLinkUrl))
                    <a href="{{ $heroLinkUrl }}" class="home-hero-link">{{ 'More →' }}</a>
                @endif
            </div>
        </div>
    </section>
    @endif

    <div id="articles-container" class="articles-grid">
        <!-- Articles will be loaded here -->
        <div class="loading">
            <div class="loading-spinner"></div>
            <p>Makaleler yükleniyor...</p>
        </div>
    </div>
    <div id="loading-more" class="loading" style="display: none;">
        <div class="loading-spinner"></div>
        <p>Daha fazla yükleniyor...</p>
    </div>

    
</div>

@push('styles')
<style>
    .home-hero { margin-bottom: 40px; }
    .home-hero-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: start; max-width: 900px; }
    .home-hero-text { font-size: 16px; line-height: 1.7; color: #333; }
    .home-hero-link { display: inline-block; margin-top: 16px; color: #333; text-decoration: none; font-size: 16px; font-weight: 500; transition: opacity 0.3s; }
    .home-hero-link:hover { opacity: 0.7; }
    .home-video { margin-top: 40px; height: 100vh; }
    .home-video-inner { position: relative; width: 100%; height: 100%; background: #000; overflow: hidden; }
    .home-video-iframe { display: block; width: 100%; height: 100%; border: none; }
    .home-video-inner::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 160px;
        height: 56px;
        background: linear-gradient(135deg, transparent 25%, rgba(0,0,0,0.92) 60%);
        pointer-events: none;
    }
    @media (max-width: 768px) {
        .home-hero-inner { grid-template-columns: 1fr; gap: 24px; }
        .home-hero { margin-bottom: 24px; }
        .home-video { margin-top: 24px; }
    }
</style>
@endpush

@push('scripts')
<script>
    let currentPage = 1;
    let lastPage = 1;
    let isLoading = false;

    // Load articles
    async function loadArticles(page = 1) {
        if (isLoading) return;
        isLoading = true;

        try {
            const response = await fetch(`/api/articles?page=${page}&per_page=10`);
            const data = await response.json();

            lastPage = data.last_page;
            const container = document.getElementById('articles-container');
            const loadingMore = document.getElementById('loading-more');

            if (page === 1) {
                container.innerHTML = '';
            }

            if (data.data.length === 0 && page === 1) {
                container.innerHTML = '<p>Henüz makale bulunmamaktadır.</p>';
                return;
            }

            data.data.forEach(article => {
                const articleDiv = document.createElement('a');
                articleDiv.className = 'article-item';
                articleDiv.href = `/article/${article.slug || article.id}`;
                
                let imageUrl = article.featured_image;
                if (!imageUrl && article.images && article.images.length > 0) {
                    imageUrl = article.images[0].image_path;
                }
                const gifUrl = article.article_gif || null;

                let mediaHtml = '';
                if (imageUrl || gifUrl) {
                    mediaHtml = '<div class="article-item-media">';
                    if (imageUrl) {
                        mediaHtml += `<img src="${imageUrl}" alt="${article.title.replace(/"/g, '&quot;')}" class="article-featured-image">`;
                    }
                    if (gifUrl) {
                        if (imageUrl) {
                            mediaHtml += `<img src="${gifUrl}" alt="${article.title.replace(/"/g, '&quot;')}" class="article-gif">`;
                        } else {
                            mediaHtml += `<img src="${gifUrl}" alt="${article.title.replace(/"/g, '&quot;')}" class="article-featured-image">`;
                        }
                    }
                    mediaHtml += '</div>';
                }
                articleDiv.innerHTML = mediaHtml;

                container.appendChild(articleDiv);
            });

            if (page < lastPage) {
                loadingMore.style.display = 'block';
            } else {
                loadingMore.style.display = 'none';
            }

        } catch (error) {
            console.error('Error loading articles:', error);
        } finally {
            isLoading = false;
        }
    }

    // Infinite scroll
    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = window.innerHeight;

        if (scrollTop + clientHeight >= scrollHeight - 100 && currentPage < lastPage && !isLoading) {
            currentPage++;
            loadArticles(currentPage);
        }
    });

    // Initial load
    loadArticles(1);
</script>
@endpush
@endsection
