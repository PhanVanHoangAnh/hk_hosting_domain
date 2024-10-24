<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Role;

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
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => User::STATUS_ACTIVE, // Set default status value
        ]);
        
        // default account. Quy ước: user thì phải luôn có 1 account tương ứng
        $user->createDefaultAccount();


        // send welcom message
        $user->notify(new \App\Notifications\SalesWelcomeNewAccount($user));

        // 
        Auth::login($user);
        
        return view('hk.frontend.show');
    }

    /**
     * Display the create new user view
     * 
     * @return View
     */
    public function createNewStudent(Request $request): View
    {
        return view('auth.create_user_popup');
    }
}
