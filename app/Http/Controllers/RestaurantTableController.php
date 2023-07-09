<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UploadsPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RestaurantStaff;
use App\Models\RestaurantTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PostRestuarantTable;
use App\Http\Requests\PutRestaurantTable;

class RestaurantTableController extends Controller
{
    use UploadsPhoto;

    function __construct()
    {
        $this->authorizeResource(RestaurantTable::class, 'restaurant_table');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response|View
    {
        $user = Auth::user();
        if ($user->hasRole(User::RESTUARANT_OWNER)) {
            $restaurantTables = $user->restaurantTables;
        } else {
            $restaurantIds = RestaurantStaff::where('staff_id', $user->id)
                ->pluck('restaurant_id');
            $restaurantTables = RestaurantTable::whereHas(
                'restaurant',
                function ($query) use ($restaurantIds) {
                    $query->whereIn('restaurant_id', $restaurantIds);
                }
            )->get();
        }
        return view('restaurant-tables.index', compact('restaurantTables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response|View
    {
        $user = Auth::user();
        $restaurants = $user->restaurants;

        return view('restaurant-tables.create', compact('restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRestuarantTable $request): RedirectResponse
    {
        //Validate the form request
        //Get the data from the form request
        //Store the restaurant table record
        DB::beginTransaction();

        try {
            $restaurantTableData = $request->only([
                'name',
                'restaurant_id',
                'reservation_fee'
            ]);
            $restaurantTable = RestaurantTable::create($restaurantTableData);

            $this->uploadPhoto($request, 'photo', $restaurantTable, RestaurantTable::MEDIA_COLLECTION);
            DB::commit();
            return redirect(route('restaurant-tables.index'))->with([
                'status' => 'Restaurant Table Created Successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RestaurantTable $restaurantTable): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestaurantTable $restaurantTable): Response|View
    {

        $user = Auth::user();
        $restaurants = $user->restaurants;
        return view('restaurant-tables.edit', compact('restaurantTable', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PutRestaurantTable $request, RestaurantTable $restaurantTable): RedirectResponse
    {
        //validate the request
        //Get the data from the form request
        //Update the restaurant table 
        DB::beginTransaction();

        try {
            $restaurantTableData = $request->only([
                'active',
                'name',
                'reservation_fee',
                'restaurant_id'
            ]);
            $restaurantTable->update($restaurantTableData);
            $this->uploadPhoto($request, 'photo', $restaurantTable, RestaurantTable::MEDIA_COLLECTION);
            DB::commit();

            return redirect(route('restaurant-tables.index'))->with([
                'status' => 'Restaurant Table Updated Successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestaurantTable $restaurantTable): RedirectResponse
    {
        //
    }
}
