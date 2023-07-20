<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostMenu;
use App\Models\Menu;
use App\Traits\UploadsPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
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
    public function index(): Response|View
    {
        $user = Auth::user();
        $menus = $user->menus;
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
    public function edit(Menu $menu): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        //
    }
}
