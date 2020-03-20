<?php

namespace App\Jobs;

use App\Mail\NewArticlePublished;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class NotifySubscribers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emails;
    protected $article;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emails,$article)
    {
        $this->emails = $emails;
        $this->article = $article;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // dd($this->emails);
        echo "hi";
        foreach ($this->emails as $e) {
            Mail::to($e)->send(new NewArticlePublished($this->article));
        }
    }
}
