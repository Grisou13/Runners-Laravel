<?php

namespace App\Console\Commands;

use App\Events\EchoTestNotification;
use App\Events\RunStartedEvent;
use App\Events\RunUpdatedEvent;
use Illuminate\Console\Command;

class EchoTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'echo:test';

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
      broadcast(new RunUpdatedEvent(\Lib\Models\Run::find(1)));
      broadcast(new RunStartedEvent(\Lib\Models\Run::find(1)));
    }
}
