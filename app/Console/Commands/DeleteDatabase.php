<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class DeleteDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:delete {--force}';

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
        if (!$this->option("force")&&!$this->confirm('CONFIRM DROP AL TABLES IN THE CURRENT DATABASE? [y|N]')) {
            exit('Drop Tables command aborted');
        }
        $dbname = config('database.connections.'.config('database.default').'.database');
        $colname = 'Tables_in_' . $dbname;

        $tables = DB::select('SHOW TABLES');
        $droplist = [];
        foreach($tables as $table) {

            $droplist[] = $table->$colname;

        }
        if(!count($droplist))
        {
            $this->info("no tables in your database. You could try and use the 'migrate' command");
            return;
        }
        $droplist = implode(',', $droplist);

        DB::beginTransaction();
        //turn off referential integrity
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement("DROP TABLE $droplist");
        //turn referential integrity back on
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        DB::commit();

        $this->comment("If no errors showed up, all tables were dropped");
    }
}
