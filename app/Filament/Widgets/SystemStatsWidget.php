<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\ContactSubmission;
use App\Models\ProjectSubmission;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalViews = \App\Models\ArticleView::sum('views_count');
        $mostViewedArticle = Article::orderBy('views_count', 'desc')->first();
        
        $mostViewedStat = Stat::make('En Çok Görüntülenen', $mostViewedArticle ? 'Makale #' . $mostViewedArticle->id : 'Henüz yok')
            ->description(number_format($mostViewedArticle?->views_count ?? 0) . ' görüntülenme')
            ->descriptionIcon('heroicon-m-star')
            ->color('warning');
        
        // Eğer makale varsa, düzenleme linkini ekle
        if ($mostViewedArticle) {
            $mostViewedStat->url(route('filament.admin.resources.articles.edit', ['record' => $mostViewedArticle->id]));
        }
        
        return [
            Stat::make('Toplam Makale', Article::count())
                ->description('Sistemdeki toplam makale sayısı')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            
            Stat::make('Toplam Görüntülenme', number_format($totalViews))
                ->description('Tüm makalelerin toplam görüntülenme sayısı')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),
            
            $mostViewedStat,
            
            Stat::make('İletişim Formları', ContactSubmission::count())
                ->description('Gelen iletişim formu sayısı')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('primary'),
            
            Stat::make('Proje Başvuruları', ProjectSubmission::count())
                ->description('Gelen proje başvuru sayısı')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('success'),
            
            Stat::make('Kullanıcılar', User::count())
                ->description('Sistemdeki kullanıcı sayısı')
                ->descriptionIcon('heroicon-m-users')
                ->color('gray'),
        ];
    }
}
