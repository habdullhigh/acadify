<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/register');
    }
    /**
     * Show the registration page for students.
     */
    public function createStudent(): Response
    {
        return Inertia::render('auth/register-student');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'office_id' => $request->office_id,
            'user_type' => $request->user_type,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return to_route('dashboard');
    }
    /**
     * Handle an incoming registration request for students.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeStudent(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'matric_no' => 'required|string|min:9|max:10|unique:users',
            'email' => 'required|string|lowercase|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'matric_no' => $request->matric_no,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return to_route('dashboard');
    }
}
