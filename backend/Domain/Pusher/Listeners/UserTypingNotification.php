<?php


namespace Domain\PusherListeners;

use Domain\Pusher\Events\UserTypingEvent;
use Domain\Pusher\WampServer as Pusher;

class UserTypingNotification
{

    /**
     * @param UserTypingEvent $event
     */
    public function handle(UserTypingEvent $event)
    {
        $idsOfUsers = $event->getUsersListIds();
        $user = $event->getUserTyping();
        foreach ($idsOfUsers as $user_id) {
            Pusher::sentDataToServer(['data' => $user, 'chatId' => $event->getChatId(), 'topic_id' => Pusher::channelForUser($user_id->user_id), 'event_type' => 'user.typing']);
        }
    }
}