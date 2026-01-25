<nav class="nav-header" id="nav-header">
    <div class="nav-inner">
        @if(!empty($site_logo))
            <a href="/" class="logo-link">
                <img src="{{ $site_logo }}" alt="Logo" class="site-logo">
            </a>
        @else
            <a href="/" class="logo-link logo-text">Photo Web</a>
        @endif
        <button type="button" class="nav-toggle" id="nav-toggle" aria-label="Menüyü aç/kapat" aria-expanded="false">
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
        </button>
        <div class="nav-links" id="nav-links">
            <a href="{{ route('about') }}" class="nav-link">About</a>
            @if(!empty($instagram_url))
                <a href="{{ $instagram_url }}" target="_blank" rel="noopener noreferrer" class="nav-link">Instagram</a>
            @endif
            <a href="{{ route('contact') }}" class="nav-link">Contact</a>
            <a href="{{ route('start-a-project') }}" class="nav-link">Start a Project</a>
        </div>
    </div>
</nav>
