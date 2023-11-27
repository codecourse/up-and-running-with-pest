<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FriendPatchController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke(Request $request, User $friend)
    {
        $request->user()->pendingFriendsOf()->updateExistingPivot($friend, [
            'accepted' => true
        ]);

        return back();
    }
}
