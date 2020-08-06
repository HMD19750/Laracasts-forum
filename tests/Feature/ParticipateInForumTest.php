<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForum extends TestCase
{
    use DatabaseMigrations;

    public function test_unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutExceptionHandling();


        $this->post('/threads/1/replies', []);
    }


    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have an authenticated user
        $user = create('App\User');
        $this->be($user);

        // And an existing thread
        $thread = create('App\Thread');

        // When teh user adds a reply to the thread
        $reply = make('App\Reply');
        $this->post($thread->path()  .  '/replies', $reply->toArray());

        //Then the reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
