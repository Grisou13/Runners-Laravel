<?php

namespace App\Console\Commands;

use DirectoryIterator;
use Illuminate\Console\Command;
use DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Models\Car;
use Lib\Models\Comment;
use Lib\Models\Group;
use Lib\Models\Role;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Lib\Models\Schedule;
use Lib\Models\Setting;
use Lib\Models\User;
use Lib\Models\Waypoint;
use ReflectionClass;

class DeleteDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:delete {--force}';
    protected $models = [
      Run::class,
      RunSubscription::class,
      Car::class,
      Group::class,
      Comment::class,
      Role::class,
      Setting::class,
      User::class,
      Waypoint::class,
      Schedule::class
    ];
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
    protected function IsExtendsOrImplements( $search, $className ) {
      $class = new ReflectionClass( $className );
      if( false === $class ) {
        return false;
      }
      do {
        $name = $class->getName();
        if( $search == $name ) {
          return true;
        }
        $interfaces = $class->getInterfaceNames();
        if( is_array( $interfaces ) && in_array( $search, $interfaces )) {
          return true;
        }
        $class = $class->getParentClass();
      } while( false !== $class );
      return false;
    }
    public function force(){
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
  public function handle()
    {
        if (!$this->option("force")&&!$this->confirm('CONFIRM DROP AL TABLES IN THE CURRENT DATABASE? [y|N]')) {
            exit('Drop Tables command aborted');
        }
        return $this->force();
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

        //DB::beginTransaction();
        //turn off referential integrity
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        //DB::statement("DROP TABLE $droplist");
        //turn referential integrity back on
        foreach ($this->models as $mod) {
          $model = new $mod;
          $query = $model->newQuery();
          $query->get()->each(function($m){
            dump($m);
            $m->delete();
          });
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        //DB::commit();

        $this->comment("If no errors showed up, all tables were dropped");
    }
}
