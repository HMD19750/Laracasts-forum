<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;


    public function test_a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        // Given we have a thread
        $thread = create('App\Thread');

        //An d the user subscribes to the thread
        $this->post($thread->path() . '/subscriptions');

        //Then each time a reply is left
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);

        //A notification should be prepared for the user

        // $this->assertCount(1, $thread->subscriptions);
    }
}
