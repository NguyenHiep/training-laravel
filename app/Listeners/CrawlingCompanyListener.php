<?php

namespace App\Listeners;

use App\Company;
use App\Events\CrawlingCompany;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CrawlingCompanyListener implements ShouldQueue
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
     * @param  CrawlingCompany  $event
     * @return void
     */
    public function handle(CrawlingCompany $event)
    {
        $this->delete();
        $companyData = $event->data;
        // Insert db
        Company::updateOrCreate([
            'name'    => $companyData['name'],
            'address' => $companyData['address']
        ], $companyData);
    }


    /**
     * Handle a job failure.
     *
     * @param  \App\Events\CrawlingCompany  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(CrawlingCompany $event, $exception)
    {
        //
    }
}
