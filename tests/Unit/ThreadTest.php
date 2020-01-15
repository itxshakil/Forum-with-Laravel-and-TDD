<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }

    /**
     * @test
     */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /**
    * @test
    */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /**
    * @test
    */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);
        $this->assertCount(1, $this->thread->replies);
    }

    /**
    * @test
    */
    public function a_thread_can_make_a_string_path()
    {
        $this->assertEquals("/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path());
    }

    /**
    * @test
    */
    public function a_thread_can_be_subscribed()
    {
        $thread = factory(Thread::class)->create();

        $thread->subscribe($userId = 1);

        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /**
     * @test
     */
    public function a_thread_can_be_unsubscribed()
    {
        $thread = factory(Thread::class)->create();

        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertEquals(0, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /**
    * @test
    */
    public function a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf(Channel::class, $this->thread->channel);
    }
}
