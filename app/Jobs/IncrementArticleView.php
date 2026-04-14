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
        // Increment article views count
        Article::where('id', $this->articleId)->increment('views_count');
        
        // Increment daily views count
        $today = now()->format('Y-m-d');
        ArticleView::updateOrCreate(
            ['date' => $today],
            ['views_count' => \DB::raw('views_count + 1')]
        );
    }
}
