<?php

namespace Domain\Pusher\Http\Resources\Chat;

use Domain\Pusher\Http\Resources\Chat\AttendeesCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChatCollection extends ResourceCollection
{

    /**
     * @var int
     */
    public $user_id;

    public function __construct($resource, int $user_id)
    {
        $this->user_id = $user_id;
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'list' => $this->collection->map(function ($chat) {
                return [
                    'id' => $chat->id,
                    'name' => $chat->name,
                    'lastMessageText' => $chat->last_message_body,
                    'lastMessageDT' => $chat->last_message_time,
                    'isRead' => (bool)$chat->last_is_read,
                    'isLastFromMe' => ($this->user_id == $chat->last_user_id),
                    'attendees' => new AttendeesCollection($chat->attendees, $this->user_id)
                ];
            })
        ];
    }
}