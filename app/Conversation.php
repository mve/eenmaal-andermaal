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

	public static function getAllMessagesForUser($userId)
	{
		return Conversation::resultArrayToClassArray(DB::select(
			'
			SELECT a.title, m.user_id, m.auction_conversation_id, c.auction_id, c.is_closed, m.id AS message_id, m.message, m.is_read, m.created_at
			FROM auction_conversations AS c
			INNER JOIN auction_messages AS m
				ON c.id = m.auction_conversation_id
				AND m.auction_conversation_id = c.id
			INNER JOIN auctions AS a
				ON a.id = c.auction_id
				AND (a.user_id = :user_id OR c.user_id = :user_id1)
			ORDER BY m.created_at ASC',
			[
			    'user_id' => $userId,
			    'user_id1' => $userId
            ]
		));
	}
}
