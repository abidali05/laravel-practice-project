<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\UserProfile;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $userProfile = UserProfile::where('user_id',Auth::user()->id)->first();
        // dd($userProfile);
        return view('profile.edit',compact('userProfile'));
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_profile' => __('You are not allowed to change data for a default user.')]);
        }

        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_password' => __('You are not allowed to change the password for a default user.')]);
        }

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }

    public function profileUpdate(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $userId = Auth::user()->id;
    $userProfile = UserProfile::where('user_id', $userId)->first();

    if ($userProfile) {
        $userProfile->address = $request->input('address');

        if ($request->hasFile('photo')) {
            $imageName = time().'.'.$request->file('photo')->extension();
            $request->file('photo')->move(public_path('images'), $imageName);
            $userProfile->photo = $imageName;
        }

        $userProfile->save();
    } else {
        $userProfile = new UserProfile([
            'user_id' => $userId,
            'address' => $request->input('address'),
        ]);

        if ($request->hasFile('photo')) {
            $imageName = time().'.'.$request->file('photo')->extension();
            $request->file('photo')->move(public_path('images'), $imageName);
            $userProfile->photo = $imageName;
        }

        $userProfile->save();
    }

    return redirect()->back()->with('success', 'Profile Updated Successfully!');
}

}
