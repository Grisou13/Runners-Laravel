<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Lib\Models\Waypoint;

class ProcessWaypoint implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  public $waypoint;

  /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Waypoint $point)
    {
      $this->waypoint = $point;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $url = "https://maps.googleapis.com/maps/api/geocode/json?key".env("GOOGLE_API_KEY","")."&region=CH&address=".urlencode($this->waypoint->name);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('GET', $url);
      if($res->getStatusCode() != 200)
        return false;
      $body = json_decode($res->getBody(),true);
      $this->waypoint->geo = $body["results"][0];
      $this->waypoint->save();
    }
}
