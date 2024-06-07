<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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
        
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user = User::find(Auth::user()->id);
        $user->user = $request->user;
        $user->save();
        if ($request->organizationName) {
            $user->organization->organizationName = $request->organizationName; 
            $user->organization-> save();
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
        foreach ($user->organization->logisticsCenter as $value) {
            $value->movements()->delete();
            $value->items()->detach();

            foreach ($value->items as  $value2) {
                $value2->logisticsCenters()->delete();
                
            }
            $value->items()->delete();
            $value->users()->delete();
        }
        $user->organization->logisticsCenter()->delete();
        $user->organization->item()->delete();
        $user->organization->user()->delete();
        $user->organization()->delete();
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
