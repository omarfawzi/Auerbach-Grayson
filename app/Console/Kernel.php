<?php

namespace App\Console;

use App\Jobs\SendReportEmailJob;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Console\Commands\AssigningWeightAlgorithmCommand;
use App\Console\Commands\SendingReportCommand;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AssigningWeightAlgorithmCommand::class,
        SendingReportCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('assign:weight')->daily();
        $schedule->command('send:report')->daily();
    }




    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
