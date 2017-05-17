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
  const MAX_BUILD_VERSION = 100;
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
  protected $signature = 'app:release:new {--r|release} {--dev} {--stable}';

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
    protected function createRelease($type){
      $version = $this->nextRelease($type, $this->current);
      if($version == $this->current || is_null($version)){
        return false;
      }
      $branch_name = GitBranch::createFromGitRootDir(base_path())->getName();
      if($branch_name != "master"){
        $this->error("You can only create a release on master");
        $this->info("please checkout on master all changes before rerunning this command");
        return false;
      }
      exec("git tag -a $version -m 'release $version'");
      exec("git push origin --tags");
      $data = json_decode(file_get_contents(base_path("composer.json")),true);
      $data["version"] = $version;
      file_put_contents(base_path("composer.json"),$data, JSON_PRETTY_PRINT);
      $this->info("saved version to composer.json");
    }

  /**
   * @param $type string The type of the new release
   * @param $current_version string
   * @return string
   */
    protected function nextRelease($type, $current_version){
      $regex = '/v(\d)\.(\d)\.(\d{1,'.(strlen(self::MAX_BUILD_VERSION)).'})(?:-rc)?(\d{1,'.(strlen(self::MAX_RC_VERSION)).'})?(?:-)?(beta|alpha)?$/';
      preg_match_all($regex, $current_version, $matches, PREG_SET_ORDER, 0);
      $isBeta = isset($array[5]) && $array[5] == "beta";
      $isAlpha = isset($array[5]) && $array[5] == "alpha";
      $major = $matches[1];
      $minor = $matches[2];
      $build = $matches[3];

      $isRc = isset($matches[4]); //array 4 contains rc version too
      function buildVersion($major, $minor, $build, $extra = ""){
        return "{$major}.{$minor}.{$build}{$extra}";
      }
      $next_version = buildVersion($major,$minor,$build);

      switch($type){
        case "beta":
          $extra = $isRc ? "-rc".$matches[4] : "-rc1" . "-beta";
          return buildVersion($major,$minor, $build,$extra);
          break;
        case "alpha":
          $extra = $isRc ? "-rc".$matches[4] : "-rc1" . "-alpha";
          return buildVersion($major,$minor, $build,$extra);
          break;
        case "release-candidate":
          $rc = $isRc ? $matches[4] : 1;
          if(self::MAX_RC_VERSION < $rc){
            $rc ++;
            $extra = "-rc".$rc;
            if($isBeta) $extra = $extra . "-beta";
            elseif($isAlpha) $extra = $extra."-alpha";

            return buildVersion($major,$minor, $build,$extra);
          }

          else{
            $this->error("Release candidates number exceeded");
            $this->info("please relaunch the command without --release-candidate argument");
          }
          break;
        case "release":
        default:
          if($build < self::MAX_BUILD_VERSION)
            $build ++;
          else{
            $build = 0;
            if($minor < self::MAX_MINOR_VERSION)
              $minor ++;
            else{
              $minor = 0;
              $major ++;
            }
          }
          return buildVersion($major,$minor,$build);
          break;
      }
      return null;
    }
    public function handle()
    {
      Artisan::call("app:release:info");
      $this->current = Artisan::output();
      
      $type = "release"; //default type is release

      if($this->option("alpha"))
        $type = "alpha";
      elseif($this->option("beta") && $type != "alpha")
        $type = "beta";
      else{
        $this->error("you can't have an alpha beta version... wth man");
        return false;
      }
      if($this->option("release")){
        $type = "release";
      }
      elseif($this->option("rc")){
        $type = "release-candidate";
      }
      elseif($this->confirm("Bump up version ?")){
        $type = "release";
      }
      elseif($this->confirm("Bump up release candidate version ? ")){
        $type = "release-candidate";
      }

      $this->createRelease($type);
    }
}
