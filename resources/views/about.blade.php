@extends('layouts.app')

@section('title', $seoTitle ? $seoTitle->value : 'About')

@if($seoDescription)
@push('meta')
<meta name="description" content="{{ $seoDescription->value }}">
@endpush
@endif

@section('content')
<div class="about-page">
    @include('partials.nav')
    <div class="about-container">
        <div class="about-grid">
            <div class="about-left">
                <!-- Sol sütun boş -->
            </div>
            <div class="about-right">
                <div class="settings-content">
                    @if($content)
                        @php
                            $value = $content->value;
                            if ($content->type === 'image' && $value) {
                                $value = asset('storage/' . $value);
                            }
                        @endphp
                        <div class="setting-item" data-key="{{ $content->key }}">
                            @if($content->type === 'image' && $value)
                                <img src="{{ $value }}" alt="{{ $content->name }}" style="max-width: 100%; margin: 15px 0;">
                            @elseif($content->type === 'rich_editor')
                                <div>{!! $value !!}</div>
                            @elseif($content->type === 'textarea')
                                <div style="white-space: pre-wrap;">{{ $value }}</div>
                            @else
                                <div>{{ $value }}</div>
                            @endif
                        </div>
                    @else
                        <p>Henüz içerik bulunmamaktadır.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .about-page {
        min-height: 100vh;
        background: #fff;
    }

    .about-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 40px;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 50% 50%;
        gap: 40px;
    }

    .about-left {
        /* Sol sütun boş */
    }

    .about-right {
        /* Sağ sütun içerik */
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

    .page-title {
        font-size: 32px;
        font-weight: 600;
        margin-bottom: 40px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .settings-content {
        font-size: 16px;
        line-height: 1.8;
    }

    .settings-content img {
        max-width: 100%;
        height: auto;
        margin: 20px 0;
    }

    .setting-item {
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .about-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }
</style>
@endpush
@endsection
