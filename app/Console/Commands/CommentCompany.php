<?php

namespace App\Console\Commands;

use App\Company;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class CommentCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawling:comment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawling comment company';

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {

        $this->info('Welcome to screen crawling comment company');
        $companies = Company::all(['id', 'slug']);
        $totalCompany = $companies->count();
        if ($totalCompany <= 0) {
            return false;
        }
        $companiesProcess = $this->output->createProgressBar($totalCompany);
        $companiesProcess->start();

        $baseUrl = "https://reviewcongty.com";
        $client = new Client();
        foreach ($companies->chunk(25) as $chuckCompanies) {
            foreach ($chuckCompanies as $company) {
                $companyName = trim($company->slug);
                $companyUrl = $baseUrl . '/companies/' . $companyName;
                try {
                    $response = $client->request('GET', $companyUrl, [
                        'headers' => [
                            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                        ]
                    ]);
                    // Content company
                    $responseContent = $response->getBody()->getContents();
                } catch (\Exception $ex) {
                    logger([
                        'id'   => $company->id,
                        'slug' => $companyName
                    ]);
                    continue;
                }

                // Get total page
                $totalPage = $this->getTotalPageComment($responseContent);

                // Process write data in file

                // Save data page 1
                $path = "crawling_comment/{$companyName}/page1.txt";
                Storage::put($path, $responseContent);
                if ($totalPage > 0) {
                    $count = 2; // Start page 2, page 1 has crawling data
                    while ($count <= $totalPage) {
                        $response = $client->request('GET', $companyUrl . '?page=' . $count, [
                            'headers' => [
                                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                            ]
                        ]);
                        $path = "crawling_comment/{$companyName}/page{$count}.txt";
                        Storage::put($path, $response->getBody()->getContents());
                        $count++;
                        $companiesProcess->advance();
                    }
                }

                $companiesProcess->advance();

            }
        }

        $companiesProcess->finish();
    }

    /***
     * @param $strContent
     * @return int
     */
    private function getTotalPageComment($strContent)
    {
        $crawler = new Crawler($strContent);
        if ($crawler->filter('ul.pagination-list')->count() > 0) {
            return $crawler->filter('ul.pagination-list')->first()->children('li')->count();
        }
        return 0;
    }
}
