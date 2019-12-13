<?php

namespace App\Listeners;

use App\Comment;
use App\Events\CrawlingCommentCompany;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CrawlingCommentCompanyListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CrawlingCommentCompany $event
     * @return void
     */
    public function handle(CrawlingCommentCompany $event)
    {
        $this->delete();
        $commentData = $event->data;
        // Insert db
        Comment::updateOrCreate([
            'company_id' => $commentData['company_id'],
            'content'    => $commentData['content'],
        ], $commentData);
    }

    /**
     * Handle a job failure.
     *
     * @param CrawlingCommentCompany $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(CrawlingCommentCompany $event, $exception)
    {
        //
    }
}
