<?php

namespace App\Http\Controllers;

use App\Forms\AddTeamForm;
use App\Team;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class TeamController extends Controller
{
    use FormBuilderTrait;
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

//        Post::create($form->getFieldValues());
        return redirect('/home');
    }
}
