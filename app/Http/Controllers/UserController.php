<?php

namespace App\Http\Controllers;

use App\CustomTracker;
use App\Forms\UserProfileForm;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class UserController extends Controller
{
    use FormBuilderTrait;

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

    public function allUsers (Request $request) {
        $user = $request->user();
        return $user->starred;
    }

    public function customItems (Request $request) {
        $user = $request->user ();
        return $user->custom;
    }

    public function profilePage (Request $request) {
        /** @var User $user */
        $user = $request->user();

        $form = $this->form(UserProfileForm::class, [
            'method' => 'POST',
            'action' => 'UserController@updateProfile',
            'model' => $user->toArray()
        ]);


        return view('user.profile', [
            'profileForm' => $form
        ]);
    }

    public function updateProfile (Request $request) {

        $form = $this->form(UserProfileForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        /** @var User $user */
        $user = $request->user();
        $user->update($request->all());
        $user->profile_saved = true;
        $user->save ();

        $form->redirectIfNotValid();

        \Session::flash('success', "Profile Saved!");

        return redirect()->action("UserController@profilePage");

    }

    public function removeStarred ($id, Request $request) {
        $user = $request->user();
        $user->starred()->detach([$id]);

        return [
            'success' => true
        ];
    }

    public function removeCustom ($id, Request $request) {

    }

    public function addCustomPage (Request $request) {
        $form = $this->form(UserProfileForm::class, [
            'method' => 'POST',
            'action' => 'UserController@addCustom'
        ]);

        return view('user.custom', [
            'form' => $form
        ]);
    }

    public function addCustom (Request $request) {
        $form = $this->form(UserProfileForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        /** @var User $user */
        $user = $request->user();
        $custom = new CustomTracker($request->all());
        $user->custom()->save($custom);

        \Session::flash('success', "Added custom item!");

        return redirect()->route("home");
    }
}
