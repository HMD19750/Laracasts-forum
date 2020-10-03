<?php

namespace Tests\Unit;


use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp(): void
    {

        parent::setUp();

        $this->thread = create('App\Thread');
    }

    public function test_a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');

        $this->assertEquals(url('/threads') . '/' . $thread->channel->slug . '/' . $thread->id, $thread->path());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }


    public function test_a_user_can_subscribe_to_a_thread()
    {

        //Given we have a thread
        $thread = create('App\Thread');

        //When the user subscribes to the thread
        $thread->subscribe($userId = 1);

        //We should be able to fetch all the threads the user subscribed to
        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    public function test_a_thread_can_be_unsubscribed_from()
    {

        $thread = create('App\Thread');

        $thread->subscribe(1);

        $thread->unsubscribe(2);

        $this->assertEquals(1, $thread->subscriptions()->where('user_id', 1)->count());

        $thread->unsubscribe(1);

        $this->assertEquals(0, $thread->subscriptions()->where('user_id', 1)->count());
    }
}
