<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class IncrementArticleView implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $articleId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $today = now()->format('Y-m-d');
        
        // Günlük makale görüntülenmesini kaydet/güncelle
        ArticleView::updateOrCreate(
            [
                'article_id' => $this->articleId,
                'date' => $today
            ],
            ['views_count' => \DB::raw('views_count + 1')]
        );
        
        // Makalenin toplam görüntülenme sayısını güncelle
        $totalViews = ArticleView::where('article_id', $this->articleId)->sum('views_count');
        Article::where('id', $this->articleId)->update(['views_count' => $totalViews]);
    }
}
