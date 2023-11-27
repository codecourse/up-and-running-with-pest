<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('greets the user if they are signed out', function () {
    get('/')
        ->assertSee('Bookfriends')
        ->assertSee('Sign up to get started.')
        ->assertDontSee(['Feed']);
});

it('shows authenticated menu items if the user is signed in', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/')
        ->assertSeeText(['Feed', 'My books', 'Add a book', 'Friend', $user->name]);
});

it('shows unauthenticated menu items if the user is not signed in', function () {
    get('/')
        ->assertSeeText(['Home', 'Login', 'Register']);
});
