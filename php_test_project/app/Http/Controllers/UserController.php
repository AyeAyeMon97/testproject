<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
use Cache;

class UserController extends Controller
{
    public function profile()
    {
        // $user = Auth::user();
        $user = Cache::remember('user', 10, function () {
            return Auth::user();
        });
        return view('auth.profile',compact('user',$user));
    }

    public function update_avatar(Request $request){
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;

        if($request->hasFile('avatar')){
            $request->validate([
                'avatar' => 'required|image|mimes:png|max:2048',
            ]);
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(400, 400)->save( public_path('/uploads/avatars/' . $filename ) );
            
            $user->avatar = $filename;
        }
        $user->save();

        return back();
   
        // return back()
        //     ->with('success','You have successful');

    }
}
