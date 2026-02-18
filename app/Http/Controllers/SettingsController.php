<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function account()
    {
        // Get authenticated user with branch relationship
        $user = Auth::user()->load('branch');

        return view('settings.account', compact('user'));
    }
}
