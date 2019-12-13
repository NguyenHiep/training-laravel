<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CrawlingCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawling:company
                            {--queue= : Whether the job should be queued}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect company data from various sources';

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
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $this->info('Welcome to screen crawling company');
        $loop = 0;
        while ((int)$loop <= 0) {
            $loop = $this->ask('Enter loop crawling company');
        }
        $baseUrl = "https://reviewcongty.com";
        $url     = $baseUrl . "/?tab=latest&page=";
        $client  = new Client();

        $count = 1;
        $crawlingData = $this->output->createProgressBar($loop);
        $crawlingData->start();
        while ($count < $loop) {
            $response = $client->request('GET', $url . $count, [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                ]
            ]);
            $path = "crawling_test/page{$count}.txt";
            Storage::put($path, $response->getBody()->getContents());
            $count++;
            $crawlingData->advance();
        }
        $crawlingData->finish();
    }
}
