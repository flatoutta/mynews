<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

use App\Profilehistory;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
  public function add()
  {
    return view('admin.profile.create');
  }
  
  public function create(Request $request)
  {
// Varidationを行う
    $this->validate($request, Profile::$rules);
    
    $profile = new Profile;
    $form = $request->all();

// フォームから送信されてきた_tokenを削除する    
    unset($form['_token']);
    
    $profile->user_id = Auth::id();

// データベースに保存する    
    $profile->fill($form)->save();

    return redirect('admin/profile/create');
  }
  
  public function edit(Request $request)
  {
    $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);
      }
      return view('admin.profile.edit', ['profile_form' => $profile]);
  }
  
  public function update(Request $request)
  {
    $this->validate($request, Profile::$rules);
    $profile = Profile::find($request->id);
    $profile_form = $request->all();
    unset($profile_form['_token']);
    
    $profile->fill($profile_form)->save();
    
    $profilehistory = new Profilehistory;
    $profilehistory->profile_id = $profile->id;
    $profilehistory->edited_at = Carbon::now();
    $profilehistory->save();

    return view('admin.profile.edit', ['profile_form' => $profile]);
  }
  
  public function delete(Request $request)
  {
    $profile = Profile::find($request->id);
    $profile->delete();
    return redirect('admin/news/');
  }  
  
}