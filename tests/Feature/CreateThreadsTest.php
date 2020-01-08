<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
    * @test
    */
    public function guests_may_not_create_threads()
    {
        $this->expectException(AuthenticationException::class);

        $thread = factory(Thread::class)->make();

        $this->post('/threads',$thread->toArray());
    }

    /**
    * @test
    */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->make();

        $this->post('/threads',$thread->toArray());

        $this->get('/threads/'.$thread->id)
        ->assertSee($thread->title)
        ->assertSee($thread->body);
    }
}
