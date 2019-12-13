<?php

namespace App\Console\Commands;

use App\Company;
use App\Http\Helpers\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class CommentStoredCompany extends Command
{

    const POSITION_PATTERN = '/\(.*\)/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawling:comment-stored';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawling stored comment company';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->info('Welcome to screen stored crawling comment company');
        $listFiles = Storage::allFiles('crawling_comment');
        if (!empty($listFiles) && is_array($listFiles)) {
            $listSlugCompany = [];
            foreach ($listFiles as $pathFile) {
//                $pathFile = 'crawling_comment/123tast/page1.txt';
                $arrList = explode('/', $pathFile);
                $listSlugCompany[] = $arrList[1]; // Data value slug company;
            }
            $listCompany = Company::whereIn('slug', $listSlugCompany)->pluck('id', 'slug')->toArray();
            $totalLoopCompany = $this->output->createProgressBar(count($listFiles));
            $totalLoopCompany->start();
            foreach ($listFiles as $pathFile) {
//                $pathFile = 'crawling_comment/123tast/page1.txt';
                $arrList = explode('/', $pathFile);
                $slugCompany = $arrList[1]; // Get company slug
                // Read file
                $content = Helper::readFileContent($pathFile);
                $companyId = $listCompany[$slugCompany] ?? 0;
                if (empty($content) || empty($companyId)) {
                    logger('File: ', [$pathFile]);
                    continue;
                }
                // Insert comment
                $this->handlerCrawling($content, $companyId);
                $totalLoopCompany->advance();
            }
            $totalLoopCompany->finish();
        }
    }

    private function handlerCrawling(string $content, int $companyId)
    {
        $crawler = new Crawler($content);
        $listComment = [];
        if ($crawler->filter('body div.review.card')->count() <= 0) {
            return $listComment;
        }
        $nodeComments = $crawler->filter('body div.review.card')->each(function (Crawler $node) {
            return $node;
        });
        foreach ($nodeComments as $nodeComment) {
            $nodeReviewer = $nodeComment->filter('.card-header > p');
            $contentReviewer = Helper::replaceWhiteSpace($nodeReviewer->text());
            $arrReviewer = preg_split(self::POSITION_PATTERN, $contentReviewer);
            if (!empty($arrReviewer[0])) {
                $reviewer = trim($arrReviewer[0]);
            }
            preg_match(self::POSITION_PATTERN, $contentReviewer, $matches);
            if (!empty($matches[0])) {
                $strPosition = str_replace('(', '', $matches[0]);
                $strPosition = str_replace(')', '', $strPosition);
                $position = trim($strPosition);
            }
            // Get content comment
            $nodeContentData = $nodeComment->filter('.card-content .content');
            // Get star
            $nodeStar    = $nodeComment->filter('.card-header .fas.fa-star');
            $commentData = [
                'company_id' => $companyId,
                'reviewer'   => $reviewer ?? 'Ẩn danh',
                'position'   => $position ?? '',
                'content'    => Helper::replaceWhiteSpace($nodeContentData->text()),
                'star'       => $nodeStar->count(),
                'status'     => 1
            ];
            event(new \App\Events\CrawlingCommentCompany($commentData));
        }
        return true;
    }
}
