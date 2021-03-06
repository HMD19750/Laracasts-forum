<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;


    public function test_guests_may_not_create_threads()
    {
        $this->post('/threads')
            ->assertRedirect('/login');
    }

    public function test_guests_cannot_see_the_create_thread_page()
    {
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_create_new_forum_threads()
    {
        // Given we have an authenticated user
        $this->signIn();

        // When we hit the endpoint to create a new thread
        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        // Then when we visit the threads page
        // We should see the new thread
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function test_a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function test_a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function  publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }

    //  public function test_a_thread_can_be_deleted()
    //  {
    //      $this->signIn();

    //      $thread = create('App\Thread');
    //      $reply = create('App\Reply', ['thread_id' => $thread->id]);

    //      $response = $this->json('DELETE', $thread->path());

    //      $response->assertStatus(204);

    //      $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
    //      $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    //  }


    public function test_authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->id,
            'subject_type' => get_class($reply)
        ]);
    }


    public function test_unauthorized_users_cannot_delete_threads()
    {
        $thread = create('App\Thread');

        $response = $this->json('DELETE', $thread->path());

        //  $response->assertRedirect('/login');

        $response->assertStatus(401);

        $this->signIn();
        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(403);
    }


    public function test_guests_cannot_delete_threads()
    {

        $thread = create('App\Thread');

        $this->delete($thread->path())
            ->assertRedirect('/login');
    }
}
