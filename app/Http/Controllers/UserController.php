<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function starred (Request $request) {
        $user = $request->user();
        return $user->starred->pluck(['id']);
    }
}
