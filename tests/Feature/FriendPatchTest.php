<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects unauthenticated users')
    ->expectGuest()->toBeRedirectedFor('/friends/1', 'patch');

it('accepts a friend request', function () {
    $user = User::factory()->create();
    $friend = User::factory()->create();

    $user->addFriend($friend);

    actingAs($friend)->patch('/friends/' . $user->id);

    $this->assertDatabaseHas('friends', [
        'user_id' => $user->id,
        'friend_id' => $friend->id,
        'accepted' => true
    ]);
});
