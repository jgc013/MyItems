<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'user' => 'required|string|max:255|unique:' . User::class,
            'organizationName' => 'required|string|max:255|lowercase|unique:' . Organization::class,
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $userData = [
            'name' => $request->name,
            'user' => strtolower($request->user),
            'rol' => "admin",
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        $user = User::createWihtOrganization($userData, $request->organizationName);


        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard.admin', absolute: false));
    }
    public function storeUser(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'user' => 'required|string|lowercase|max:255|unique:' . User::class,
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $idOrganization =  Auth::user()->organization->id;
        $userData = [
            'name' => $request->name,
            'user' => strtolower($request->user),
            'rol' => "employee",
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_organization' => $idOrganization,
            'id_logistics_center' => $request->id
        ];

        $user = User::createUser($userData);


        event(new Registered($user));

        return redirect(route('logisticsCenterX.init', ['logisticsCenter' => $request->id]));
    }

    public function delete(Request $request): RedirectResponse
    {

        $user = User::where("id", $request->id)->first();
        $logisticsCenter = $user->logisticsCenter;
        $user->movements()->delete();
        $user->delete();
        return redirect(route('logisticsCenterX.init', ['logisticsCenter' => $logisticsCenter->id]));
    }
    public function edit(Request $request): RedirectResponse
    {
        $userData = [
            'password' => Hash::make($request->password),
            'id' => $request->id
        ];
        User::alterPass($userData);
        return redirect(route('logisticsCenterX.init', ['logisticsCenter' => User::find($request->id)->id_logistics_center]));
    }
}
