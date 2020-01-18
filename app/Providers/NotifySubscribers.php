<?php

namespace App\Providers;

class NotifySubscribers
{
    /**
     * Handle the event.
     *
     * @param  ThreadRecievedNewReply  $event
     * @return void
     */
    public function handle(ThreadRecievedNewReply $event)
    {
        $thread = $event->reply->thread;
        $thread->subscriptions
        ->where('user_id', '!=', $event->reply->user_id)
        ->each
        ->notify($event->reply);
    }
}
