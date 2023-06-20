<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\PostProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostProfile $request): RedirectResponse
    {
        $user = Auth::user();
        $profile = $user->profile;
        $profileData = $request->only(['address', 'phone']);
        $userData = $request->only('name');
        $user->update($userData);
        if ($profile === null) {
            $user->profile()->create($profileData);
        } else {
            $profile->update($profileData);
        }

        if ($request->has('photo')) {
            if ($request->file('photo')->isValid()) {
                $disk = config('filesystems.default');
                $path = $request->photo->store('', $disk);
                $user->addMediaFromDisk($path, $disk)
                    ->toMediaCollection(User::AVATAR_COLLECTION);
            }
        }
        
        return back()->with([
            'status' => 'Profile successfully updated'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile): RedirectResponse
    {
        //
    }
}
