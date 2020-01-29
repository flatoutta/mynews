<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;

use App\Profile;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $profiles = Profile::all()->sortBy('id');
        
        if (count($profiles) == 0) {
            $profiles = null;
        }
        
        return view('profiles.index', ['profiles' => $profiles]);
    }
    
    public function show(Request $request)
    {
        $profile = Profile::where('user_id', $request->user_id)->first();
        return view('profiles.show', ['profile' => $profile]);
    }
}
