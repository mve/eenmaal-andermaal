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
        return Carbon::parse($this->created_at)->toTimeString();
    }

    /**
     * Get the bid's time in custom format
     * @return string
     */
    public function getTimeForHumans()
    {
        $bidDateTime = Carbon::parse($this->created_at);
        $now = Carbon::now();
        return ($bidDateTime->diff($now)->days < 1) ? Carbon::parse($this->created_at)->format("H:i") : $bidDateTime->diffForHumans($now, true)." geleden";
    }
}
