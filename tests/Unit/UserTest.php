<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function a_user_can_fetch_thier_most_recent_reply()
    {
        $user = factory(User::class)->create();

        $reply = factory(Reply::class)->create(['user_id' => $user->id]);

        $this->assertEquals($user->lastReply->id, $reply->id);
    }


    /**
    * @test
    */
    public function a_user_can_determine_their_avatar_path()
    {
        $user = factory(User::class)->create();

        $this->assertEquals('/storage/avatars/default.jpg', $user->avatar_path);
        $user = factory(User::class)->create(['avatar_path' => 'avatars/me.jpg']);

        $this->assertEquals('/storage/avatars/me.jpg', $user->avatar_path);
    }
}
