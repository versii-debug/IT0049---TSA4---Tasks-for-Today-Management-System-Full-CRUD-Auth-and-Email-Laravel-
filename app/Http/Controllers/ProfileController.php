<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('profile.index', ['user' => User::orderBy('id')->first()]);
    }
}
