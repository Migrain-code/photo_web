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

        return view('home', [
            'site_logo' => $siteLogo,
            'seoTitle' => $seoTitle,
            'seoDescription' => $seoDescription,
        ]);
    }

    public function article($slug)
    {
        $article = Article::with('images')->where('slug', $slug)->firstOrFail();
        
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
