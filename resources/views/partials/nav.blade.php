<nav class="nav-header" id="nav-header">
    <div class="nav-inner">
        <div class="nav-left">
            @if(!empty($site_logo))
                <a href="/" class="logo-link">
                    <img src="{{ $site_logo }}" alt="Logo" class="site-logo">
                </a>
            @else
                <a href="/" class="logo-link logo-text">Photo Web</a>
            @endif
        </div>
        <div class="nav-right">
            <div class="nav-links" id="nav-links">
                <a href="/" class="nav-link">Works</a>
                
                <a href="{{ route('about') }}" class="nav-link">About</a>
                <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                <a href="{{ route('start-a-project') }}" class="nav-link">Start a Project</a>
            </div>
            @if(!empty($instagram_url))
                <div class="nav-instagram" id="nav-instagram">
                    <a href="{{ $instagram_url }}" target="_blank" rel="noopener noreferrer" class="nav-link nav-link-instagram">Instagram <svg class="nav-instagram-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17L17 7"/><path d="M7 7h10v10"/></svg></a>
                </div>
            @endif
        </div>
        <button type="button" class="nav-toggle" id="nav-toggle" aria-label="Menüyü aç/kapat" aria-expanded="false">
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
        </button>
    </div>
</nav>
