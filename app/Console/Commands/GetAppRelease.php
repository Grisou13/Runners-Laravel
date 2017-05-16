<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetAppRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:release:info';

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
      $version = "";
      $version_composer = json_decode(file_get_contents(base_path("composer.json")), true);
      if(array_key_exists("version", $version_composer))
        $version = $version.$version_composer;
      else
        $version = $version."0.0.1-rc0";
      return $version;

    }
}
