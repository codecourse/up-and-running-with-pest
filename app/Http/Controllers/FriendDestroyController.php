<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FriendDestroyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke(Request $request, User $friend)
    {
        $request->user()->removeFriend($friend);

        return back();
    }
}
