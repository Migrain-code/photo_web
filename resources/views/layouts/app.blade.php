 <!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Photo Web')</title>
    @if(!empty($site_favicon))
    <link rel="icon" href="{{ $site_favicon }}" type="image/x-icon">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        :root {
            --spacer: .75rem;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
            overflow-x: hidden;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0;
        }

        .page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 52px 60px 52px;
        }

        @media (max-width: 768px) {
            .page-container {
                padding: 0 25px 40px 25px;
            }
        }

        .home-page {
            padding: 0px;
            min-height: 100vh;
        }

        .home-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .logo-link {
            display: inline-block;
            text-decoration: none;
        }

        .site-logo {
            max-height: 40px;
            width: auto;
            display: block;
        }

        @media (max-width: 768px) {
            .site-logo {
                max-height: 30px;
            }
            .home-page {
                padding: 10px;
            }
            .about-page{
                padding: 10px;
            }
            .contact-page{
                padding: 10px;
            }
        }

        .about-link {
            color: #333;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .about-link:hover {
            opacity: 0.7;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .articles-grid {
            padding: 3rem var(--spacer) 0;
            display: grid;
            grid-auto-flow: dense;
            grid-gap: var(--spacer);
            margin-top: 10px;
            grid-template-columns: repeat(2, 1fr);
        }

        @media (min-width: 1800px) {
            .articles-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 768px) {
            .articles-grid {
                grid-template-columns: 1fr;
            }
        }

        .article-item {
            display: block;
            text-decoration: none;
            color: inherit;
            margin-bottom: 0;
            cursor: pointer;
            transition: opacity 0.3s, transform 0.3s;
            overflow: hidden;
        }

        .article-item:hover {
            opacity: 0.8;
           /* transform: scale(1.02); */
        }

        .article-item-media {
            position: relative;
            overflow: hidden;
        }

        .article-featured-image {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .article-gif {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        .article-item:hover .article-gif {
            opacity: 1;
        }

        .article-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .article-content {
            font-size: 14px;
            color: #666;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .article-images {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .article-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #999;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #333;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .settings-content {
            font-size: 18px;
            line-height: 1.8;
        }

        .settings-content img {
            max-width: 100%;
            height: auto;
            margin: 15px 0;
        }
        .home-hero.hero-default {
            padding-top: 155px;
            margin-bottom: 116px;
            width: 100%;
        }
        .home-hero-inner {
            width: 100%;
            max-width: 100%;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1.5fr);
            gap: 0 4vw;
            align-items: start;
        }
        .home-hero-title {
            font-size: 1.4vw;
            line-height: 1.75vw;
            color: #333;
        }
        .home-hero-description {
            font-size: 1.4vw;
            line-height: 1.75vw;
            color: #333;
        }
        .home-hero-description p {
            margin: 0 0 0.5em;
        }
        .home-hero-description p:last-child {
            margin-bottom: 0;
        }
        .home-hero-link {
            display: inline-block;
            margin-top: 1.5vw;
            color: #333;
            text-decoration: none;
            font-size: 1.4vw;
            line-height: 1.75vw;
            font-weight: 500;
            transition: opacity 0.3s;
        }
        .home-hero-link:hover {
            opacity: 0.7;
        }
        @media only screen and (min-width: 992px) {
            .home-hero.hero-default {
                padding-top: 9.042vw;
            }
        }
        @media (max-width: 991px) {
            .home-hero-title,
            .home-hero-description,
            .home-hero-link {
                font-size: 2.5vw;
                line-height: 1.4;
            }
        }
        @media (max-width: 768px) {
            .home-hero.hero-default {
                padding-top: 65px;
                margin-bottom: 40px;
            }
            .home-hero-inner {
                grid-template-columns: 1fr;
            }
            .home-hero-title,
            .home-hero-description,
            .home-hero-link {
                font-size: 16px;
                line-height: 1.5;
            }
        }


        .nav-header { margin-bottom: 0px; }
        .nav-inner {
            display: grid;
            grid-template-columns: 51% 48.67%;
            gap: 0;
            align-items: center;
            padding: 25px 52px;
        }
        .nav-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .nav-right {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
        }
        .nav-links { display: flex; gap: 60px; align-items: center; }
        .nav-instagram { display: flex; }
        .nav-link { color: #333; text-decoration: none; font-size: 16px; font-weight: 500; transition: opacity 0.3s; }
        .nav-link:hover { opacity: 0.7; }
        .nav-link-instagram { display: inline-flex; align-items: center; gap: 6px; }
        .nav-instagram-arrow { flex-shrink: 0; vertical-align: middle; }
        .logo-text { font-weight: 600; font-size: 18px; }

        .nav-toggle { display: none; background: none; border: none; padding: 8px; cursor: pointer; flex-direction: column; justify-content: center; gap: 7px; outline: none; }
        .nav-toggle-bar { display: block; width: 22px; height: 2px; background: #333; transition: transform 0.3s, opacity 0.3s; }

        @media (max-width: 768px) {
            .nav-inner {
                display: flex;
                justify-content: space-between;
                padding-left: 25px;
                padding-right: 25px;
            }
            .nav-right { justify-content: flex-start; }
            .nav-toggle { display: flex; }
            .nav-header { margin-bottom: 5px; }
            .nav-header.nav-open .nav-toggle-bar { background: #fff; }
            .nav-right {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #fff;
                flex-direction: column;
                gap: 0;
                padding: 16px 0;
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                z-index: 100;
            }
            .nav-header { position: relative; }
            .nav-inner { width: 100%; }
            .nav-header.nav-open .nav-right { display: flex; }
            .nav-link { padding: 12px 24px; width: 100%; font-size: 15px; }

            .nav-header.nav-open {
                position: fixed;
                inset: 0;
                width: 100%;
                height: 100%;
                background: #000;
                z-index: 9999;
                margin-bottom: 0;
                border: none;
                outline: none;
                display: flex;
                flex-direction: column;
            }
            .nav-header.nav-open .nav-inner {
                display: grid;
                grid-template-rows: auto 1fr;
                grid-template-columns: 1fr auto;
                width: 100%;
                height: 100%;
                padding: 32px 32px 0;
                align-items: start;
                gap: 0;
            }
            .nav-header.nav-open .nav-inner .logo-link { grid-column: 1; grid-row: 1; }
            .nav-header.nav-open .nav-inner .nav-toggle { grid-column: 2; grid-row: 1; justify-self: end; }
            .nav-header.nav-open .nav-right {
                grid-column: 1 / -1;
                grid-row: 2;
                display: flex;
                flex-direction: column;
                min-height: 0;
                position: static;
                top: auto;
                left: auto;
                right: auto;
                background: transparent;
                box-shadow: none;
                padding: 24px 0 32px;
                gap: 0;
                justify-content: flex-start;
                align-items: stretch;
                width: 100%;
            }
            .nav-header.nav-open .nav-links {
                display: flex;
                flex-direction: column;
                flex: 1;
                justify-content: center;
                align-items: start;
                gap: 0;
                padding: 0;
                
            }
            .nav-header.nav-open .nav-link {
                color: #fff;
                padding: 14px 0;
                font-size: 30px;
                width: auto;
                font-weight: 300;
            }
            .nav-header.nav-open .nav-link:hover { opacity: 0.8; }
            .nav-header.nav-open .nav-instagram {
                margin-top: auto;
                padding-top: 24px;
                position: absolute;
                bottom: 20px;
                
            }
            .home-hero-left{
                display: none;
            }
            .nav-header.nav-open .nav-instagram .nav-link {
                padding: 12px 0;
                font-size: 16px;
            }
            .nav-header.nav-open .site-logo,
            .nav-header.nav-open .logo-text { filter: brightness(0) invert(1); }
            .nav-toggle[aria-expanded="true"] .nav-toggle-bar:nth-child(1) { transform: translateY(4.5px) rotate(45deg); }
            .nav-toggle[aria-expanded="true"] .nav-toggle-bar:nth-child(2) { transform: translateY(-4.5px) rotate(-45deg); }
        }

        .preloader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 1s ease, transform 1s ease;
        }
        .preloader--hidden {
            opacity: 0;
            transform: translateY(-100%);
            pointer-events: none;
        }
        .preloader-logo {
            max-width: 120px;
            max-height: 60px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .site-footer {
            background: #000;
            color: #fff;
            padding: 2rem 52px;
        }
        .site-footer-inner {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }
        .site-footer-copyright,
        .site-footer-address,
        .site-footer-email,
        .site-footer-instagram {
            font-size: 14px;
        }
        .site-footer-address {
            white-space: pre-line;
        }
        .site-footer-email,
        .site-footer-instagram {
            color: #fff;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        .site-footer-email:hover,
        .site-footer-instagram:hover {
            opacity: 0.7;
        }
        .site-footer-instagram {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .site-footer-icon {
            flex-shrink: 0;
        }
        @media (max-width: 768px) {
            .site-footer {
                padding: 1.5rem 25px;
            }
            .site-footer-inner {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
                align-items: flex-start;
            }
        }

        /* Home Page Styles */
        .home-hero-inner { display: grid; grid-template-columns: 50% 50%; gap: 18px; }
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

        /* About Page Styles */
        .about-page { min-height: 100vh; background: #fff; }
        .about-container { max-width: 1200px; margin: 0 auto; }
        .about-grid { display: grid; grid-template-columns: 50% 50%; gap: 18px; }
        .about-left { /* Sol sütun boş */ }
        .about-right { /* Sağ sütun içerik */ }
        .back-link { display: inline-block; margin-bottom: 30px; color: #666; text-decoration: none; font-size: 14px; transition: color 0.3s; }
        .back-link:hover { color: #333; }
        .page-title { font-size: 32px; font-weight: 600; margin-bottom: 40px; text-transform: uppercase; letter-spacing: 1px; }
        .settings-content ul { padding-left: 20px; margin: 20px 0; }
        .settings-content li { margin-bottom: 8px; }
        .setting-item { margin-bottom: 30px; }

        /* Contact Page Styles */
        .contact-page { min-height: 100vh; background: #fff; }
        .contact-container { max-width: 1200px; margin: 0 auto; }
        .contact-grid { display: grid; grid-template-columns: 50% 50%; gap: 40px; }
        .contact-left { /* Sol sütun boş */ }
        .contact-right { /* Sağ sütun form */ }
        .contact-info { margin-bottom: 40px; }
        .contact-details p { margin-bottom: 10px; font-size: 16px; }
        .contact-details a { color: #333; }
        .contact-form-title { font-size: 24px; font-weight: 600; margin-bottom: 24px; }
        .alert-success { padding: 12px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 20px; }
        .contact-form { display: flex; flex-direction: column; gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-weight: 500; font-size: 14px; }
        .form-group input, .form-group textarea, .form-group select { padding: 10px 12px; font-size: 16px; border: 1px solid #ccc; border-radius: 6px; width: 100%; box-sizing: border-box; }
        .form-group .error { color: #dc3545; font-size: 13px; }
        .btn-submit { padding: 12px 24px; font-size: 16px; font-weight: 500; background: #333; color: #fff; border: none; border-radius: 6px; cursor: pointer; align-self: flex-start; }
        .btn-submit:hover { opacity: 0.9; }

        /* Project Page Styles */
        .project-page { min-height: 100vh; background: #fff; }
        .project-container { max-width: 1200px; margin: 0 auto; }
        .project-grid { display: grid; grid-template-columns: 50% 50%; gap: 18px; }
        .project-left { /* Sol sütun boş */ }
        .project-right { /* Sağ sütun form */ }
        .project-form-title { font-size: 24px; font-weight: 600; margin-bottom: 24px; }
        .project-form { display: flex; flex-direction: column; gap: 20px; }
        .phone-inputs { display: flex; gap: 12px; }
        .phone-inputs select { width: 120px; flex-shrink: 0; }
        .phone-inputs input { flex: 1; }
        .services-checkboxes { display: flex; flex-wrap: wrap; gap: 10px; }
        .service-option { display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border: 1px solid #ccc; border-radius: 8px; cursor: pointer; width: auto; }
        .service-option input { margin: 0; width: auto; }
        .service-option:has(input:checked) { background: #e8f5e9; border-color: #4caf50; }

        @media (max-width: 768px) {
            .home-hero-inner { grid-template-columns: 1fr; gap: 24px; }
            .home-hero { margin-bottom: 24px; }
            .home-video { margin-top: 24px; }
            .about-grid { grid-template-columns: 1fr; gap: 24px; }
            .about-left { display: none; }
            .about-right { max-width: 100%; }
            .contact-grid { grid-template-columns: 1fr; gap: 24px; }
            .contact-left { display: none; }
            .contact-right { max-width: 100%; }
            .project-grid { grid-template-columns: 1fr; gap: 24px; }
            .project-left { display: none; }
            .project-right { max-width: 100%; }
            .articles-grid { padding: 3rem 0 0; }
            .phone-inputs { flex-wrap: wrap; }
            .phone-inputs select { width: 100%; max-width: 120px; }
            .phone-inputs input { width: 100%; min-width: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="preloader" class="preloader" aria-hidden="true">
        @if(!empty($site_logo))
            <img src="{{ $site_logo }}" alt="" class="preloader-logo">
        @endif
    </div>
    <div class="container">
        @yield('content')
    </div>
    @include('partials.footer')
    @stack('scripts')
    <script>
        (function() {
            var t = document.getElementById('nav-toggle');
            var h = document.getElementById('nav-header');
            if (!t || !h) return;
            t.addEventListener('click', function() {
                var open = h.classList.toggle('nav-open');
                t.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
            h.querySelectorAll('.nav-link').forEach(function(a) {
                a.addEventListener('click', function() {
                    h.classList.remove('nav-open');
                    t.setAttribute('aria-expanded', 'false');
                });
            });
        })();
        (function() {
            var preloader = document.getElementById('preloader');
            if (!preloader) return;
            function hidePreloader() {
                preloader.classList.add('preloader--hidden');
                preloader.addEventListener('transitionend', function onEnd() {
                    preloader.removeEventListener('transitionend', onEnd);
                    preloader.style.display = 'none';
                });
            }
            if (document.readyState === 'complete') {
                setTimeout(hidePreloader, 100);
            } else {
                window.addEventListener('load', function() {
                    setTimeout(hidePreloader, 100);
                });
            }
        })();
    </script>
</body>
</html>
