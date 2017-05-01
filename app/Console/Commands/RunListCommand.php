<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runs:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get list of all runs';

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
        $this->table(["id","name","planned_at","status"],\Lib\Models\Run::all(["id","name","planned_at","status"]));
    }
}
