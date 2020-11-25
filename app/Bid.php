<?php


namespace App;


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
}
