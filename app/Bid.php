<?php


namespace App;


use Carbon\Carbon;

class Bid extends SuperModel
{
    /**
     * Get the bid's bidder
     * @return mixed
     */
    public function getBidder()
    {
        return User::oneWhere("id", $this->user_id);
    }

    /**
     * Get the bid's time
     * @return string
     */
    public function getTime()
    {
        return Carbon::parse($this->bid_datetime, "UTC")->setTimezone(config('timezone'))->toTimeString();
    }
}
