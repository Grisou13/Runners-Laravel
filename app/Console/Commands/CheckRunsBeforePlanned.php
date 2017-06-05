<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Lib\Models\Run;

class CheckRunsBeforePlanned extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runs:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $runs = Run::where("planned_at","<",Carbon::now("+15min"))->notOfStatus(["finished","gone"])->get();
        $runs->each(function(Run $r){
          $r->touch();//resave the runs, this will trigger every needed observer
        });
    }
}
