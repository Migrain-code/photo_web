<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService
    ) {}

    public function index()
    {
        $siteLogo = $this->settingsService->getValue('site_logo');
        $seoTitle = $this->settingsService->getSetting('main_page_seo_title');
        $seoDescription = $this->settingsService->getSetting('main_page_seo_description');
        $heroTextLeft = $this->settingsService->getValue('main_page_hero_text_left');
        $heroTextRight = $this->settingsService->getValue('main_page_hero_text_right');
        $heroLinkUrl = $this->settingsService->getValue('main_page_hero_link_url');
        $heroLinkText = $this->settingsService->getValue('main_page_hero_link_text');
        $videoEmbed = $this->settingsService->getValue('main_page_video_embed');
        $videoEmbedUrl = $this->videoEmbedUrlWithParams($videoEmbed);

        return view('home', [
            'site_logo' => $siteLogo,
            'seoTitle' => $seoTitle,
            'seoDescription' => $seoDescription,
            'heroTextLeft' => $heroTextLeft,
            'heroTextRight' => $heroTextRight,
            'heroLinkUrl' => $heroLinkUrl,
            'heroLinkText' => $heroLinkText,
            'videoEmbed' => $videoEmbed,
            'videoEmbedUrl' => $videoEmbedUrl,
        ]);
    }

    /**
     * Embed linkini alır; YouTube/Vimeo için oynatıcı parametreleri ekleyip döner.
     */
    private function videoEmbedUrlWithParams(?string $url): ?string
    {
        if (!$url || !is_string($url)) {
            return null;
        }
        $url = trim($url);
        if ($url === '') {
            return null;
        }

        $separator = str_contains($url, '?') ? '&' : '?';

        if (str_contains($url, 'youtube.com/embed/') || str_contains($url, 'youtube-nocookie.com/embed/')) {
            $url = str_replace('www.youtube.com/', 'www.youtube-nocookie.com/', $url);
            $params = [
                'modestbranding' => 1,
                'rel' => 0,
                'controls' => 1,
                'autoplay' => 1,
                'mute' => 1,
                'enablejsapi' => 1,
                'iv_load_policy' => 3,
                'disablekb' => 0,
                'fs' => 1,
            ];
            return $url . $separator . http_build_query($params);
        }

        if (str_contains($url, 'vimeo.com/video/') || str_contains($url, 'player.vimeo.com/video/')) {
            $params = ['dnt' => 1, 'title' => 1, 'byline' => 0, 'portrait' => 0, 'autoplay' => 1, 'muted' => 1];
            return $url . $separator . http_build_query($params);
        }

        return $url;
    }

    public function article($slug)
    {
        $article = Article::with('images')->where('slug', $slug)->firstOrFail();
        
        // Dispatch job to increment view count
        \App\Jobs\IncrementArticleView::dispatch($article->id);
        
        return view('article', [
            'article' => $article,
        ]);
    }

    public function about()
    {
        $seoTitle = $this->settingsService->getSetting('about_page_seo_title');
        $seoDescription = $this->settingsService->getSetting('about_page_seo_description');
        $content = $this->settingsService->getSetting('about_page_content');
        
        return view('about', [
            'seoTitle' => $seoTitle,
            'seoDescription' => $seoDescription,
            'content' => $content,
        ]);
    }
}
