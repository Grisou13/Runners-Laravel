<?php

namespace App\Console;

use App\Console\Commands\CheckRunsBeforePlanned;
use App\Console\Commands\DeleteDatabase;
use App\Console\Commands\EchoTest;
use App\Console\Commands\OverideRunDatesToToday;
use App\Console\Commands\ResetDatabase;
use App\Console\Commands\RunListCommand;
use App\Console\Commands\ScaffholdApp;
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
        ResetDatabase::class,
        ScaffholdApp::class,
        DeleteDatabase::class,
        OverideRunDatesToToday::class,
        EchoTest::class,
        RunListCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      if((bool)env("APP_DEBUG"))
        $schedule->command("runs:update_date")->hourly();
        // $schedule->command('inspire')
        //          ->hourly();
      $schedule->command(CheckRunsBeforePlanned::class)->evenInMaintenanceMode();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
