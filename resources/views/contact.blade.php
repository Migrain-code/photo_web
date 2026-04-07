@extends('layouts.app')

@section('title', $seoTitle ? $seoTitle->value : 'Contact')

@if($seoDescription)
@push('meta')
<meta name="description" content="{{ $seoDescription->value }}">
@endpush
@endif

@section('content')
<div class="contact-page">
    @include('partials.nav')
    <div class="contact-container">

        <div class="contact-info">
            @if($contactEmail || $contactPhone || $contactAddress)
                <div class="contact-details">
                    @if($contactEmail)
                        <p><strong>Email:</strong> <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></p>
                    @endif
                    @if($contactPhone)
                        <p><strong>Phone:</strong> {{ $contactPhone }}</p>
                    @endif
                    @if($contactAddress)
                        <p><strong>Address:</strong> {{ $contactAddress }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="contact-form-wrapper">
            <h2 class="contact-form-title">Get in touch</h2>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('contact') }}" method="POST" class="contact-form">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
                    @error('subject')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message')<span class="error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-submit">Send</button>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .contact-page { min-height: 100vh; background: #fff; }
    .contact-container { max-width: 800px; margin: 0 auto; padding: 60px 40px; }
    .contact-info { margin-bottom: 40px; }
    .contact-details p { margin-bottom: 10px; font-size: 16px; }
    .contact-details a { color: #333; }
    .contact-form-title { font-size: 24px; font-weight: 600; margin-bottom: 24px; }
    .alert-success { padding: 12px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 20px; }
    .contact-form { display: flex; flex-direction: column; gap: 20px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label { font-weight: 500; font-size: 14px; }
    .form-group input, .form-group textarea { padding: 10px 12px; font-size: 16px; border: 1px solid #ccc; border-radius: 6px; }
    .form-group .error { color: #dc3545; font-size: 13px; }
    .btn-submit { padding: 12px 24px; font-size: 16px; font-weight: 500; background: #333; color: #fff; border: none; border-radius: 6px; cursor: pointer; align-self: flex-start; }
    .btn-submit:hover { opacity: 0.9; }
</style>
@endpush
@endsection
