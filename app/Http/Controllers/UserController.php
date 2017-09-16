<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function starred (Request $request) {
        $user = $request->user();
        return $user->starred->pluck('id');
    }

    public function toggleStar ($target_id, Request $request) {
        $target = User::findOrFail($target_id);
        $target_team_ids = $target->teams->pluck('id');
        $user = $request->user();
        $user_team_ids = $user->teams->pluck('id');

        // ensure there's atleast some overlap
        if(collect($user_team_ids)->intersect($target_team_ids)->count() === 0) {
            return abort(403);
        }

        $user->starred()->toggle([$target_id]);

        // reload the relation
        $user->load('starred');

        return $user->starred->pluck('id');
    }
}
