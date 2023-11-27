<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FriendStoreController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'exists:users,email', Rule::notIn([$request->user()->email])]
        ]);

        $request->user()->addFriend(User::whereEmail($request->email)->first());

        return back();
    }
}
