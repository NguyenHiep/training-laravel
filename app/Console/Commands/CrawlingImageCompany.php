<?php

namespace App\Console\Commands;

use App\Company;
use Illuminate\Console\Command;

class CrawlingImageCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawling:image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawling image, status enable';

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

        $companies = Company::all(['id', 'status', 'logo', 'slug']);
        if ($companies->count() <= 1) {
            return false;
        }
        $companiesProcess = $this->output->createProgressBar($companies->count());
        $companiesProcess->start();
        foreach ($companies->chunk(25) as $chuckCompanies) {
            foreach ($chuckCompanies as $company) {
                $imageName = 'companies/' . $company->slug . '.jpeg';
                $pathImage = storage_path('app/public/' . $imageName);
                $this->downloadImageServer($company->logo, $pathImage); // return true or false
                $company->logo = $imageName;
                $company->status = 1; // Enable companies
                $company->save();
                $companiesProcess->advance();
            }
        }
        $companiesProcess->finish();
    }

    /***
     * download image and save by patch
     * @param string $url
     * @param string $saveTo
     * @return bool|string
     */
    private function downloadImageServer(string $url, string $saveTo)
    {
        $fp = fopen($saveTo, 'w+');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        $result = curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return $result;
    }
}
