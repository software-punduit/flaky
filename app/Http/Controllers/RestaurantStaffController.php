<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RestaurantStaff;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RestaurantStaffController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(RestaurantStaff::class, 'restaurant_staff');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response|View
    {
        $user = Auth::user();
        $staffMembers = $user->restaurantStaff;
        return view('restaurant-staff.index', compact('staffMembers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response|View
    {
        $user = Auth::user();
        $restaurants = $user->restaurants;

        return view('restaurant-staff.create', compact('restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //Validate the request
        //get the data
        //Store a new record of the restaurant staff
        //Assign restaurant staff role to the new restaurant staff
        //Redirect to the restaurant-staff.index route with a success message

        DB::beginTransaction();
        try {
            $staffData = $request->except([
                'restaurant_id',
                'password'
            ]);
            $staffData = array_merge($staffData, [
                'password' => Hash::make($request->password)
            ]);
            $staff = User::create($staffData);
            event(new Registered($staff));

            $restaurantStaffData = [
                'staff_id' => $staff->id,
                'restaurant_id' => $request->restaurant_id,
            ];
            RestaurantStaff::create($restaurantStaffData);
            $staff->assignRole(User::RESTUARANT_STAFF);

            DB::commit();
            return redirect(route('restaurant-staff.index'))->with([
                'status' => 'Restaurant Staff created successfully' 
            ]);
    
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RestaurantStaff $restaurantStaff): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestaurantStaff $restaurantStaff): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RestaurantStaff $restaurantStaff): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestaurantStaff $restaurantStaff): RedirectResponse
    {
        //
    }
}
