<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class StoredCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawling:stored
                            {--queue= : Whether the job should be queued}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stored company';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('Process stored data');
        $baseUrl = "https://reviewcongty.com";
        $loop = 271;
        $totalLoopCompany = $this->output->createProgressBar($loop);
        $totalLoopCompany->start();
        for ($number = 1; $number <= $loop; $number++) {
            $strContent = $this->readFileContent($number);
            $this->handleCrawling($strContent, $baseUrl);
            $totalLoopCompany->advance();
        }
        $totalLoopCompany->finish();
    }


    private function readFileContent(int $number)
    {
        $path = "crawling_test/page{$number}.txt";
        return Storage::get($path);
    }

    private function handleCrawling($strContent, $baseUrl = '')
    {
        $crawler = new Crawler($strContent);
        $nodeCompanies = $crawler->filter('body div.company-item')->each(function (Crawler $node) {
            return $node;
        });
        $listCompany = [];
        if (empty($nodeCompanies) || !is_array($nodeCompanies)) {
            return $listCompany;
        }
        foreach ($nodeCompanies as $nodeCompany) {
            $nodeLogo    = $nodeCompany->filter('figure.company-info__logo > img')->attr('src');
            $nodeName    = $nodeCompany->filter('.company-info__detail h2 > a');
            $nodeAddress = $nodeCompany->filter('.company-info__detail .company-info__location');
            $nodeOther   = $nodeCompany->filter('.company-info__detail .company-info__other span')->each(function (Crawler $node) {
                if (!empty(trim($node->text()))) {
                    return $node;
                }
            });
            $type = 1;
            $size = '0-50';
            if (!empty($nodeOther)) {
                $nodeOther = array_filter($nodeOther); // fill element null
                $nodeOther = array_values($nodeOther); // Reset key array
                if (!empty($nodeOther)) {
                    $type = !empty($nodeOther[0]) ? $nodeOther[0]->text() : 1;
                    $size = !empty($nodeOther[1]) ? $nodeOther[1]->text() : '0-50';
                }
            }

            $type = !empty($type) && strtolower(trim($type)) === 'dịch vụ' ? 2 : 1;

            // Push to queue stored
            $companyData = [
                'logo'    => $baseUrl . $nodeLogo,
                'name'    => trim($nodeName->text()),
                'slug'    => Str::slug(trim($nodeName->text())),
                'address' => $this->replaceWhiteSpace($nodeAddress->text()),
                'type'    => $type,
                'size'    => trim($size)
            ];
            event(new \App\Events\CrawlingCompany($companyData));
        }
        return true;
    }

    private function replaceWhiteSpace(string $strData)
    {
        $strData = trim(preg_replace('/\s+/', ' ', $strData));
        $strData = str_replace("\n", '', $strData);
        return $strData;
    }
}
