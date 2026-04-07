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
    <div class="contact-container page-container">
        <div class="contact-grid">
            <div class="contact-left">
                <!-- Sol sütun boş -->
            </div>
            <div class="contact-right">
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
    </div>
</div>

@endsection
