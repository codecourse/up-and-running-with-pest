<?php

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects unauthenticated users')
    ->expectGuest()->toBeRedirectedFor('/books/1', 'put');

it('fails if the book does not exist', function () {
    actingAs(User::factory()->create())
        ->put('/books/1')
        ->assertStatus(404);
});

it('validates the request details', function () {
    $user = User::factory()->create();

    $user->books()->attach($book = Book::factory()->create(), [
        'status' => 'WANT_TO_READ'
    ]);

    actingAs($user)
        ->put('/books/' . $book->id)
        ->assertSessionHasErrors(['title', 'author', 'status']);
});

it('fails if the user does not own the book', function () {
    $user = User::factory()->create();
    $anotherUser = User::factory()->create();

    $anotherUser->books()->attach($book = Book::factory()->create(), [
        'status' => 'READING'
    ]);

    actingAs($user)
        ->put('/books/' . $book->id, [
            'title' => 'New title',
            'author' => 'New author',
            'status' => 'WANT_TO_READ'
        ])
        ->assertStatus(403);
});

it('updates the book', function () {
    $user = User::factory()->create();

    $user->books()->attach($book = Book::factory()->create(), [
        'status' => 'READING'
    ]);

    actingAs($user)
        ->put('/books/' . $book->id, [
            'title' => 'Updated title',
            'author' => 'Updated author',
            'status' => 'WANT_TO_READ'
        ]);

    $this->assertDatabaseHas('books', [
        'id' => $book->id,
        'title' => 'Updated title',
        'author' => 'Updated author',
    ]);

    $this->assertDatabaseHas('book_user', [
        'book_id' => $book->id,
        'status' => 'WANT_TO_READ'
    ]);
});
