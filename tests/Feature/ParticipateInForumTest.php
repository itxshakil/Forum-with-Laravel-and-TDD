<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
    * @test
    */
    public function unauthenticated_user_may_not_add_replies()
    {
        $this->withExceptionHandling()
        ->post('/threads/some-channel/1/replies', [])
        ->assertRedirect('/login');
    }

    /**
    * @test
    */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be(factory(User::class)->create());

        $thread = factory(Thread::class)->create();

        $reply = factory(Reply::class)->make();

        $this->post("{$thread->path()}/replies", $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /**
    * @test
    */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->be(factory(User::class)->create());

        $thread = factory(Thread::class)->create();

        $reply = factory(Reply::class, ['body' => null])->make();

        $this->post("{$thread->path()}/replies", $reply->toArray())
        ->assertSessionHasErrors('body');
    }
}
