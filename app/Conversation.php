<?php

namespace App;

class Conversation extends SuperModel
{
    static function get($auctionId, $userId)
    {
        return Conversation::resultArrayToClassArray(DB::select(
            'SELECT *
            FROM auction_conversations 
            WHERE auction_id =:auction_id 
                AND user_id =:user_id',
            ['auction_id' => $auctionId, 'user_id' => $userId]
        ));
    }

    public static function getOrCreate($auctionId, $userId)
    {
        $conv = self::get($auctionId, $userId);

        if ($conv) {
            return $conv[0];
        }

        $insert = DB::insertOne(
            'INSERT INTO auction_conversations (auction_id, user_id) 
            VALUES ( ' . $auctionId . ', ' . $userId . ')',
            []
        );

        return (self::get($auctionId, $userId))[0];
    }
}
