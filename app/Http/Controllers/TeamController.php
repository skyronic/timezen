<?php

namespace App\Http\Controllers;

use App\Forms\AddTeamForm;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class TeamController extends Controller
{
    use FormBuilderTrait;
    public function view(Team $team, Request $request) {
        $user = $request->user();
        $this->authorize('view', $team);

        $admins = $team->admins;


        return view('teams.view', [
            'team' => $team,
            'admins' => $admins
        ]);
    }

    public function listMembers(Team $team, Request $request) {
        $this->authorize('view', $team);

        return $team->users;
    }

    public function adminIds(Team $team, Request $request) {
        $this->authorize('admin', $team);

        return $team->admins->pluck('id');
    }

    /**
     * @param Team $team
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function toggleAdmin (Team $team, Request $request) {
        $this->authorize('admin', $team);

        $user_id = $request->get('user_id');
        /** @var User $user */
        $user = User::findOrFail($user_id);

        if($user->can('view', $team)) {
            $team->toggleAdmin ($user);
        }
        else {
            abort(500);
        }


        return $team->admins->pluck('id');
    }

    public function addTeamPage () {
        $form = $this->form(AddTeamForm::class, [
            'method' => 'POST',
            'route' => 'add_team'
        ]);

        return view('team.add_team', [
            'addForm' => $form
        ]);
    }

    public function addTeam (Request $request) {
        $form = $this->form(AddTeamForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $form->redirectIfNotValid();

        $team = new Team([
            'name' => $request->get('name'),
            'join_token' => str_random(6)
        ]);
        $team->save();

        $team->addUser ($request->user());
        $team->addAdmin ($request->user());
        $team->save ();

        return redirect()->route('team_view', $team);
    }
}
