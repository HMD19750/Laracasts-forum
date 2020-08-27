<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{

    use DatabaseMigrations;

    public function test_guest_cannot_favorite_anything()
    {
        $this->post('replies/1/favorites')
            ->assertRedirect('/login');
    }


    public function test_an_authorized_user_can_favor_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        // If I post to a "favarite"endpoint
        $this->post('replies/' . $reply->id . '/favorites');

        // It should be in the database
        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authorized_user_can_unfavor_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $reply->favorite();

        $this->delete('replies/' . $reply->id . '/favorites');

        // It should be in the database
        $this->assertCount(0, $reply->favorites);
    }

    public function test_an_authenticated_user_can_only_favor_a_reply_once()
    {
        $this->signIn();

        $reply = create('App\Reply');

        // If I post to a "favarite"endpoint
        try {
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to inserts same record twice.');
        }


        // It should be in the database
        $this->assertCount(1, $reply->favorites);
    }
}
