<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profiles;

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
    $this->validate($request, Profiles::$rules);
    
    $profile = new Profiles;
    $form = $request->all();

// フォームから送信されてきた_tokenを削除する    
    unset($form['_token']);

// データベースに保存する    
    $profile->fill($form)->save();

    return redirect('admin/profile/create');
  }
  
  public function edit(Request $request)
  {
    $profile = Profiles::find($request->id);
      if (empty($profile)) {
        abort(404);
      }
      return view('admin.profile.edit', ['profile_form' => $profile]);
  }
  
  public function update(Request $request)
  {
    $this->validate($request, Profiles::$rules);
    $profile = Profiles::find($request->id);
    $profile_form = $request->all();
    unset($profile_form['_token']);
    
    $profile->fill($profile_form)->save();

    return redirect('/home');
  }
  
    public function delete(Request $request)
  {
      $profile = Profiles::find($request->id);
      $profile->delete();
      return redirect('admin/news/');
  }  

}
