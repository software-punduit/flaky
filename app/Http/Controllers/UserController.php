<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUser;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\PutUser;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response|View
    {
        $user = Auth::user();
        $users = User::where('id', '!=', $user->id)->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response|View
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostUser $request): RedirectResponse
    {
        //Validate the request
        //Get the formdata
        //Create a new user record with the data

        $userData = $request->except('password');
        $userData = array_merge($userData, ['password' => Hash::make($request->password)]);

        $user = User::create($userData);

        $user->assignRole(User::ADMIN);

        //$user->profile()->create(['active' => Profile::ACTIVE]);

        //Dispatch the event by calling the function

        event(new Registered($user));

        return redirect(route('users.index'))->with([
            'status' => 'User Successfully Created'
        ]);
        
    }

    /**
     * Display the specified resource.
     * 
     * @param user $user
     * @return \Illuminate\Http\Response
     * 
     */
    public function show($id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response|View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PutUser $request, User $user): RedirectResponse
    {
        // Update User name
        // *1. Validate the name field of the form data
        // *2. Get the name from the request object
        // *3. Update the User's name with the new name

        $userData = $request->only('name');
        $user->update($userData);

        $profileData = $request->only('active');

        $profile = $user->profile;

        //if the profile doesn't exist
        if (is_null($profile)) {
            //create a new one
            $user->profile()->create($profileData);
        } else {
            //update the existing profile
            $profile->update($profileData);
        }

        return back()->with([
            'status' => 'Updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //
    }
}
