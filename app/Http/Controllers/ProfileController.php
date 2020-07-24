<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index($user)
    {
        $user = User::findOrFail($user);
        $this->middleware(['auth' => 'verified']);
        return view('profile.profile', compact('user'));
    }

    public function edit()
    {
        if (Auth::user()) {
            $user = User::findOrFail(Auth::user()->username);

            return view('profile.edit')->withUser($user);
        } else {
            return redirect()->back();
        }
    }

    public function update(Request $request, User $user)
    {
        //Updates user info
        if ($request->has('update_profile')) {

            $userData = request()->validate([
                'email' => 'required|email|max:255', Rule::unique('users')->ignore($user->id),
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
            ]);

            $addressData = request()->validate([
                'country' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'zip' => 'nullable|integer|max:9999',
                'line_1' => 'required|string|max:255',
                'line_2' => 'nullable|string|max:255',
            ]);

            auth()->user()->update($userData);
            auth()->user()->address->update($addressData);

            return back()->with('success', 'You have successfully updated you profile!');
        }
        
        //update profile picture
        if ($request->has('update_image_profile')) {

            $userImage = request()->validate([
                'image' => '',
            ]);

            $image_path = $request->file('image');//->store('profile', 'public');
           // $destination = 'images/Foldername'.'/';
            $filename = time() . "." . $image_path->getClientOriginalExtension();
            //Image::make($image_path)->resize(300, 300)->save(public_path('' . $filename ));
            //$image = Image::make(public_path("storage/{$image_path}"))->fit(1000, 1000);
            Image::make($image_path)->save(public_path('' . $filename));

            //auth()->user()->update($userImage);
            $user=Auth::user();
            $user->image=$filename;
            $user->save();
            return back()->with('success', 'You have successfully updated you profile image!');
        }

        //Updates user password
        if ($request->has('update_password')) {

            $userPassword = request()->validate([
                'password' => 'required|string|between:8,255',
                'new_password' => 'required|string|confirmed|between:8,255|different:password',
            ]);

            if (!Hash::check($userPassword['password'], auth()->user()->password)) {
                return back()->with('error', 'You have entered wrong password');
            } else {
                auth()->user()->update(["password" => Hash::make($userPassword['new_password'])]);
                return back()->with('success', 'Password changed successfully!');
            }
        }
    }
}
