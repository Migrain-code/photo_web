@extends('layouts.app')

@section('title', 'Start a Project')

@section('content')
<div class="project-page">
    <div class="project-container">
        @include('partials.nav')

        <div class="project-form-wrapper">
            <h2 class="project-form-title">Start a Project</h2>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('start-a-project') }}" method="POST" class="project-form">
                @csrf
                <div class="form-group">
                    <label for="name">What's your name?</label>
                    <input type="text" id="name" name="name" placeholder="Name" value="{{ old('name') }}" required>
                    @error('name')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="email">What's your email?</label>
                    <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="phone_number">What's your phone number?</label>
                    <div class="phone-inputs">
                        <select name="phone_country" id="phone_country" required>
                            @foreach($countryCodes as $label => $code)
                                <option value="{{ $code }}" {{ old('phone_country', '+1') == $code ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <input type="text" id="phone_number" name="phone_number" placeholder="000 000 0000" value="{{ old('phone_number') }}" required>
                    </div>
                    @error('phone_country')<span class="error">{{ $message }}</span>@enderror
                    @error('phone_number')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Please tell us a bit more about your project</label>
                    <textarea name="message" rows="5" placeholder="What's the objective? Who's the audience? Discuss here...">{{ old('message') }}</textarea>
                    @error('message')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>What kind of services are you looking for?</label>
                    <div class="services-checkboxes">
                        @foreach($services as $service)
                            <label class="service-option">
                                <input type="checkbox" name="services[]" value="{{ $service }}" {{ in_array($service, old('services', [])) ? 'checked' : '' }}>
                                <span>{{ $service }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('services')<span class="error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .project-page { min-height: 100vh; padding: 60px 40px; background: #fff; }
    .project-container { max-width: 800px; margin: 0 auto; }
    .project-form-title { font-size: 24px; font-weight: 600; margin-bottom: 24px; }
    .alert-success { padding: 12px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 20px; }
    .project-form { display: flex; flex-direction: column; gap: 20px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label { font-weight: 500; font-size: 14px; }
    .form-group input, .form-group textarea, .form-group select { padding: 10px 12px; font-size: 16px; border: 1px solid #ccc; border-radius: 6px; }
    .phone-inputs { display: flex; gap: 12px; }
    .phone-inputs select { width: 120px; flex-shrink: 0; }
    .phone-inputs input { flex: 1; }
    .services-checkboxes { display: flex; flex-wrap: wrap; gap: 10px; }
    .service-option { display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border: 1px solid #ccc; border-radius: 8px; cursor: pointer; }
    .service-option input { margin: 0; }
    .service-option:has(input:checked) { background: #e8f5e9; border-color: #4caf50; }
    .form-group .error { color: #dc3545; font-size: 13px; }
    .btn-submit { padding: 12px 24px; font-size: 16px; font-weight: 500; background: #333; color: #fff; border: none; border-radius: 6px; cursor: pointer; align-self: flex-start; }
    .btn-submit:hover { opacity: 0.9; }
</style>
@endpush
@endsection
