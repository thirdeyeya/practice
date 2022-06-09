<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Profile;

class ProfileController extends Controller
{
   
  public function add()
  {
      return view('admin.profile.create');
  }
  
  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          $posts = Profile::where('title', $cond_title)->get();
      } else {
          $posts = Profile::all();
      }    
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
  
  
  public function edit()
  {
      return view('admin.profile.edit');
  }
  
  public function create(Request $request)
  {
  
      $this->validate($request, Profile:$rules);
      $profile = new Profile;
      $form = $request->all();
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $profile->image_path = basename($path);
      } else {
          $profile->image_path = null;
      }
      unset($form['_token']);
      unset($form['image']);
      $profile->fill($form);
      $profile->save();
      return redirect('admin/profile/create');
  }

  public function update()
  {
    
      return redirect('admin/profile/edit');
  }
}