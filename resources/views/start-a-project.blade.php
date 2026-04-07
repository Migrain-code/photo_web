@extends('layouts.app')

@section('title', 'Start a Project')

@section('content')
<div class="project-page">
    @include('partials.nav')
    <div class="project-container page-container">
        <div class="project-grid">
            <div class="project-left">
                <!-- Sol sütun boş -->
            </div>
            <div class="project-right">
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
    </div>
</div>

@endsection
