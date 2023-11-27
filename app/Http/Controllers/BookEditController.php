<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookEditController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke(Book $book, Request $request)
    {
        $this->authorize('update', $book);

        $book = $request->user()->books->find($book->id);

        return view('books.edit', [
            'book' => $book
        ]);
    }
}
