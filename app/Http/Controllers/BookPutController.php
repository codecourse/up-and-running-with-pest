<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookPutRequest;
use App\Models\Book;
use App\Models\Pivot\BookUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookPutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke(Book $book, BookPutRequest $request)
    {
        $book->update($request->only('title', 'author'));

        $request->user()->books()->updateExistingPivot($book, [
            'status' => $request->status
        ]);

        return redirect('/');
    }
}
