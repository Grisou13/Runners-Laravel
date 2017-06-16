<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Lib\Models\Run;
use Carbon\Carbon;

class CheckRunsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $date = Carbon::now();
      $date->addMinutes(15);
      $runs = Run::where("planned_at","<=",$date)->notOfStatus(["finished"])->get();
      $runs->each(function(Run $r){
        $r->touch();//resave the runs, this will trigger every needed observer
      });
    }
}
