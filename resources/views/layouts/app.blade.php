 <!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Photo Web')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0;
        }

        .home-page {
            padding: 40px;
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
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
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
            opacity: 0.9;
            transform: scale(1.02);
        }

        .article-featured-image {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
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
            font-size: 14px;
            line-height: 1.8;
        }

        .settings-content img {
            max-width: 100%;
            height: auto;
            margin: 15px 0;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
