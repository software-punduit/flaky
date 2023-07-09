<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Traits\UploadsPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\PostProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    use UploadsPhoto;

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
        DB::beginTransaction();

        try {

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

            $this->uploadPhoto($request, 'photo', $user, User::AVATAR_COLLECTION);

            DB::commit();

            return back()->with([
                'status' => 'Profile successfully updated'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
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
