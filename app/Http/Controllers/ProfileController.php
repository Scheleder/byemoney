<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        info($request);
        if($request->theme){
            $configuration = Configuration::firstOrCreate(['user_id' => $request->user()->id]);
            if($request->theme == 'dark')$request->dark = '1';
            if($request->theme == 'light')$request->dark = '0';
            $configuration->dark = $request->dark;
            $configuration->save();
        }

        // Image Upload and resize
        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $configuration = Configuration::firstOrCreate(['user_id' => $request->user()->id]);
            if($configuration->image != 'foto.png'){
                unlink(public_path('img/users/').$configuration->image);
                }
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            //$requestImage->move(public_path('img/products'), $imageName);
            $configuration->image = $imageName;
            Image::make($requestImage)->resize(200, 200)->save(public_path('img/users/').$imageName, 60, 'jpg');
            info($imageName);
            $configuration->save();
        }



        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


}
