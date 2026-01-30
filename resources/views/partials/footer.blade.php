<footer class="site-footer">
    <div class="site-footer-inner">
        <div class="site-footer-copyright">Grapen &copy; {{ date('Y') }}</div>
        @if(!empty($contact_address))
            <div class="site-footer-address">{!! nl2br(e($contact_address)) !!}</div>
        @endif
        @if(!empty($contact_email))
            <a href="mailto:{{ $contact_email }}" class="site-footer-email">{{ $contact_email }}</a>
        @endif
        @if(!empty($instagram_url))
            <a href="{{ $instagram_url }}" target="_blank" rel="noopener noreferrer" class="site-footer-instagram">Instagram <svg class="site-footer-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17L17 7"/><path d="M7 7h10v10"/></svg></a>
        @endif
    </div>
</footer>
