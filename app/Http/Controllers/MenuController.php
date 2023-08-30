<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Restaurant;
use App\Traits\UploadsPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\PutMenu;
use App\Http\Requests\PostMenu;
use App\Models\RestaurantStaff;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class MenuController extends Controller
{
    use UploadsPhoto;

    public function __construct()
    {
        $this->authorizeResource(Menu::class, 'menu');
    }
    /**
     * Display a listing of the resource.
     */
    // public function index(): Response|View
    // {
    //     $user = Auth::user();
    //     if ($user->hasRole(User::RESTUARANT_OWNER)) {
    //         $menus = $user->menus;
    //     } else {
    //         $restaurantIds = RestaurantStaff::where('staff_id', $user->id)
    //             ->pluck('restaurant_id');
    //         $menus = Menu::whereHas('restaurant', function ($query) use ($restaurantIds) {

    //             $query->whereIn('restaurant_id', $restaurantIds);
    //         })->get();
    //     }

    //         return view('menus.index', compact('menus'));
    //  }

    public function index(Request $request): Response|View|JsonResponse
    {
        $user = Auth::user();
        if($request->has('restaurant')) {
            $restaurant = Restaurant::find($request->restaurant);
            $menus = $restaurant->menuItems()->with(['restaurant'])->get();
            return response()->json($menus);
        }
        elseif ($user->hasRole(User::RESTUARANT_OWNER)){
                $menus = $user->menus;
            }else {
            $restaurantIds = RestaurantStaff::where('staff_id', $user->id)->pluck('restaurant_id');
            $menus = Menu::whereHas('restaurant', function($query) use ($restaurantIds){
                $query->whereIn('restaurant_id', $restaurantIds);
            })->get();
        }
        return view('menus.index', compact('menus'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response|View
    {
        $user = Auth::user();
        $restaurants = $user->restaurants;
        return view('menus.create', compact('restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostMenu $request): RedirectResponse
    {
        //validate the form request
        //Get the data form
        //store the menu data

        DB::beginTransaction();

        try {
            $menuData = $request->validated();
            $user = Auth::user();
            $menu = $user->menus()->create($menuData);
            $this->uploadPhoto($request, 'photo', $menu, MENU::MEDIA_COLLECTION);

            DB::commit();

            return redirect(route('menus.index'))->with([
                'status' => 'Menu Item Created Successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu): Response|View
    {
        $restaurants = Auth::user()->restaurants;

        return view('menus.edit', compact('menu', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PutMenu $request, Menu $menu): RedirectResponse
    {
        //validate the request
        //Get the form data
        //update the menu data
        DB::beginTransaction();

        try {
            $menuData = $request->only([
                'name',
                'price',
                'restaurant_id',
                'photo',
                'active'
            ]);
            $menu->update($menuData);
            $this->uploadPhoto($request, 'photo', $menu, Menu::MEDIA_COLLECTION);

            DB::commit();

            return redirect(route('menus.index'))->with([
                'status' => 'Menu Updated Successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        //
    }
}
