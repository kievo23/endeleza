<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /** 
     * The Artisan commands provided by your application.
     * 
     * @var array
     */
    protected $commands = [
        //
        Commands\Reminders::class,
        Commands\Rollovers::class,
        Commands\WordOfTheDay::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //         ->hourly();
        $schedule->command('count_days:run')->hourlyAt(5);
        $schedule->command('rollovers:run')->dailyAt('22:35');
        //$schedule->command('word:day')->everyMinute();
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
