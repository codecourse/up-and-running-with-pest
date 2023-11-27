<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedIndexController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke(Request $request)
    {
        return view('feed.index', [
            'books' => $request->user()->booksOfFriends
        ]);
    }
}
