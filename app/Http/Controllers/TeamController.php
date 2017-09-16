<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function view(Team $team, Request $request) {
        $user = $request->user();
        $this->authorize('view', $team);


        return view('teams.view', [
            'team' => $team
        ]);
    }

    public function listMembers(Team $team, Request $request) {
        $this->authorize('view', $team);

        return $team->users;
    }
}
