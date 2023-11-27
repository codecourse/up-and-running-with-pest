<?php

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('shows books with the correct status', function ($status, $heading) {
    $this->user->books()->attach($book = Book::factory()->create(), [
        'status' => $status
    ]);

    actingAs($this->user)
        ->get('/')
        ->assertSeeInOrder([$heading, $book->title]);
})
    ->with([
        ['status' => 'WANT_TO_READ', 'heading' => 'Want to read'],
        ['status' => 'READING', 'heading' => 'Reading'],
        ['status' => 'READ', 'heading' => 'Read'],
    ]);
