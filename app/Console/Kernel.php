<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //TODO :Auto sync
        /****
         * Hours crawling data: 3:00
         *
         * 1. Crawling company
         * 2. Crawling image company
         * 3. Crawling comment
         * 4. Crawling sub comment
         */
        //Test scheduling
      /*  logger('1111111111111');
        $schedule->call(function () {
            DB::table('test')->insert([
                'id' => random_int(1, 1000),
                'content' => 'test conentent'
            ]);
        })->everyMinute();*/
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
