<?php


namespace App;


class AuctionHit extends SuperModel
{
    protected $attributes = [
        'id',
        'auction_id',
        'user_id',
        'ip',
        'hit_datetime'
    ];
}
