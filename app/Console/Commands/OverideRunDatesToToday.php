<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Lib\Models\Run;

class OverideRunDatesToToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runs:update_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all the runs to match current date. This allows easier development';

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
        Run::all()->each->update(["created_at"=>Carbon::today(), "planned_at"=>Carbon::today()->addHours(rand(3,20))]);
    }
}
