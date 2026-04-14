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
        return [
            Stat::make('Toplam Makale', Article::count())
                ->description('Sistemdeki toplam makale sayısı')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            
            Stat::make('Toplam Görüntülenme', Article::sum('views_count'))
                ->description('Tüm makalelerin toplam görüntülenme sayısı')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info'),
            
            Stat::make('En Çok Görüntülenen', Article::orderBy('views_count', 'desc')->first()?->title ?? 'Henüz yok')
                ->description(Article::orderBy('views_count', 'desc')->first()?->views_count . ' görüntülenme')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
            
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
