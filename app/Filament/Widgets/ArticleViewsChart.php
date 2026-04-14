<?php

namespace App\Filament\Widgets;

use App\Models\ArticleView;
use Filament\Widgets\ChartWidget;

class ArticleViewsChart extends ChartWidget
{
    protected static ?string $heading = 'Günlük Makale Görüntülenmeleri';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Son 30 günün tarihlerini oluştur
        $dates = collect();
        for ($i = 29; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        // Veritabanından günlük görüntülenme verilerini al
        $views = ArticleView::whereIn('date', $dates->toArray())
            ->pluck('views_count', 'date');

        // Her tarih için veri oluştur (yoksa 0)
        $data = $dates->map(function ($date) use ($views) {
            return $views->get($date, 0);
        });

        return [
            'datasets' => [
                [
                    'label' => 'Görüntülenme',
                    'data' => $data->toArray(),
                    'borderColor' => 'rgb(139, 92, 246)',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointRadius' => 3,
                    'pointHoverRadius' => 5,
                ],
            ],
            'labels' => $dates->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('d M');
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'interaction' => [
                'intersect' => false,
                'mode' => 'index',
            ],
        ];
    }
}
