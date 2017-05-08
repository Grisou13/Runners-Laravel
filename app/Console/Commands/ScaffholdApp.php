<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Lib\Models\Setting;
use Lib\Models\Status;

class ScaffholdApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

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
        $this->createStatus();
        $this->createSettings();
    }
    protected function createStatus()
    {
      Status::all()->each->delete();
    }
    protected function createSettings()
    {
      Setting::all()->each->delete();
    }
}
