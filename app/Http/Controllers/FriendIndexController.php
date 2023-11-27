<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendIndexController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke(Request $request)
    {
        return view('friends.index', [
            'friends' => $request->user()->friends,
            'pendingFriends' => $request->user()->pendingFriendsOfMine,
            'requestingFriends' => $request->user()->pendingFriendsOf,
        ]);
    }
}
