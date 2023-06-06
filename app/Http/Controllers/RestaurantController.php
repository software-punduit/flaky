<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRestaurant;
use App\Http\Requests\PutRestaurant;
use Illuminate\Http\RedirectResponse;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Restaurant::class, 'restaurant');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response|View
    {

        $user = Auth::user();
        $restaurants= $user->restaurants;
        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response|View
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRestaurant $request): RedirectResponse
    {
        //validate the request
        //get the data from the form request
        //store a new restaurant record using the new data

        $data = $request->validated();
        $user = Auth::user();
        $user->restaurants()->create($data);

        $user->assignRole(User::RESTUARANT_OWNER);

        return redirect(route('restaurants.index'))->with([
            'status' => 'Restaurant Successfully Created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant): Response|View
    {
        return view('restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PutRestaurant $request, Restaurant $restaurant): RedirectResponse
    {
        //validate the request
        //Get the data from the form request
        //update the restaurant with the new data

        $data = $request->validated();
        $restaurant->update($data);

        return Redirect(route('restaurants.index'))->with([
            'status' => 'Restaurant Successfully Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant): RedirectResponse
    {
        //
    }
}
