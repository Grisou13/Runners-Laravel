<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
//from http://stackoverflow.com/questions/7447472/how-could-i-display-the-current-git-branch-name-at-the-top-of-the-page-of-my-de
class GitBranch
{
  /**
   * @var string
   */
  private $branch;

  const MASTER = 'master';
  const DEVELOP = 'develop';

  const HOTFIX = 'hotfix';
  const FEATURE = 'feature';

  /**
   * @param \SplFileObject $gitHeadFile
   */
  public function __construct(\SplFileObject $gitHeadFile)
  {
    $ref = explode("/", $gitHeadFile->current(), 3);

    $this->branch = rtrim($ref[2]);
  }

  /**
   * @param string $dir
   *
   * @return static
   */
  public static function createFromGitRootDir($dir)
  {
    try {
      $gitHeadFile = new \SplFileObject($dir.'/.git/HEAD', 'r');
    } catch (\RuntimeException $e) {
      throw new \RuntimeException(sprintf('Directory "%s" is not a Git repository.', $dir));
    }

    return new static($gitHeadFile);
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->branch;
  }

  /**
   * @return boolean
   */
  public function isBasedOnMaster()
  {
    return $this->getFlowType() === self::HOTFIX || $this->getFlowType() === self::MASTER;
  }

  /**
   * @return boolean
   */
  public function isBasedOnDevelop()
  {
    return $this->getFlowType() === self::FEATURE || $this->getFlowType() === self::DEVELOP;
  }

  /**
   * @return string
   */
  private function getFlowType()
  {
    $name = explode('/', $this->branch);

    return $name[0];
  }
}
class Version{
  public function __construct($version)
  {
  }
  public function up()
  {

  }
  public function down()
  {

  }
}
class CreateAppRelease extends Command
{
  const MAX_MINOR_VERSION = 10;
  /**
   * Allows a build version of maximum 100
   */
  const MAX_BUILD_VERSION = 20;
  /**
   * Allow a maximum of 100 candidate releases
   */
  const MAX_RC_VERSION    = 100;
  public $current;
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:release:new {--r|release} {--dev} {--beta} {--stable} {-f|--force}';

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
    protected function merge($from, $to)
    {
      exec('git checkout ' . $to, $output, $ret);
      if($ret != 0) {
        $this->error(implode("\n",$output));
        return false;
      }
      $this->info(implode("\n",$output));
      exec('git merge --no-ff ' . $from, $output, $ret);
      if ($ret != 0) {
        $this->error(implode("\n",$output));
        return false;
      }
      $this->info(implode("\n",$output));
      return true;
    }
    protected function createRelease($type){
      $version = $this->nextRelease($this->current, $type);
      if($version == $this->current || is_null($version)){
        $this->error("Error creating version $version| $this->current");
        return false;
      }
      $branch_name = GitBranch::createFromGitRootDir(base_path())->getName();
      
      $branch_to = "master";
      switch($type){
        case "release":
          $branch_to = "master";
          break;
        case "dev":
          $branch_to = "develop";
          break;
        case "beta":
          $branch_to = "develop";
          break;
        default:
          $branch_to = "master";
          break;
      }
      $this->info("creating version $version. Previous : {$this->current}");
      if(!$this->merge($branch_name, $branch_to))
      {
        $this->error("Couldn't auto merge to branch for release");
        $this->error("please do it manually, and fix errors with merging");
        $this->info("after you can execute commands : ");
        $this->info("git tag -a {$version} -m '{$type} {$version}'");
        $this->info("git push origin --tags");
        $this->info("then replace composer.json version with : {$version}");
        return false;
      }
      
      exec("git tag -a $version -m '$type $version'");
      if($this->option("force") || $this->confirm("Should we push tags?"))
        exec("git push origin --tags");
      $data = json_decode(file_get_contents(base_path("composer.json")),true);
      $data["version"] = $version;
      file_put_contents(base_path("composer.json"),json_encode($data, JSON_PRETTY_PRINT));
      $this->info("saved version to composer.json");
    }

  /**
   * @param $type string The type of the new release
   * @param $current_version string
   * @return string
   */
    protected function nextRelease($current_version, $type = ""){
//      $regex = '/v(\d)\.(\d)\.(\d{1,'.(strlen(self::MAX_BUILD_VERSION)).'})(?:-rc)?(\d{1,'.(strlen(self::MAX_RC_VERSION)).'})?(?:-)?(beta|alpha)?$/';
      $regex = '/v?(\d)\.(\d)\.(\d)(?:-)?(beta|dev|stable)?$/';
      dump($regex);
      dump($current_version);
      preg_match_all($regex, $current_version, $matches, PREG_SET_ORDER, 0);
      if(!isset($matches[0]))
        return null;
      $major = $matches[0][1];
      $minor = $matches[0][2];
      $build = $matches[0][3];

      $isDev = isset($matches[0][4]); //array 4 contains rc version too
      function buildVersion($major, $minor, $build, $extra = ""){
        return "v{$major}.{$minor}.{$build}{$extra}";
      }
      if($build < self::MAX_BUILD_VERSION) {
        $build++;
      }
      else{
        $build = 0;
        if($minor < self::MAX_MINOR_VERSION)
          $minor ++;
        else {
          $minor = 0;
          $major ++;
        }
      }
      dump([$major, $minor, $build]);
      $extra = "";
      switch($type){
        case "beta":
          $extra = "-beta";
          break;
        case "dev":
          $extra = "-dev";
          break;
        case "release":
          $extra = "-stable";
          break;
      }
      return buildVersion($major,$minor,$build,$extra);
    }
    public function handle()
    {
//      Artisan::call("app:release:info");
      $this->current = app_version();
      
      $type = "release"; //default type is release

      if($this->option("dev"))
        $type = "dev";
      elseif($this->option("beta"))
        $type = "beta";
      
      $this->createRelease($type);
    }
}
