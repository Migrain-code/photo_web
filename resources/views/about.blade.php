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
    <div class="about-container page-container">
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
@endsection
