<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('shows the login page')
    ->get('/auth/login')
    ->assertOk();

it('redirects authenticated user', function () {
    expect(User::factory()->create())->toBeRedirectedFor('/auth/login');
});

it('shows an errors if the details are not provided')
    ->post('/login')
    ->assertSessionHasErrors(['email', 'password']);

it('logs the user in', function () {
    $user = User::factory()->create([
        'password' => bcrypt('meowimacat')
    ]);

    post('/login', [
        'email' => $user->email,
        'password' => 'meowimacat'
    ])
        ->assertRedirect('/');

    $this->assertAuthenticated();
});
