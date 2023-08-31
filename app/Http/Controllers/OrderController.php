<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\PostOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response|View
    {
        $user = Auth::user();
        $orders = collect([]);

        if ($user->hasRole(User::RESTUARANT_OWNER)) {
            $orders = $orders->concat($user->restaurantOwnerOrders);
        } elseif ($user->hasRole(User::RESTUARANT_STAFF)) {
            $orders = $orders->concat($user->restaurantStaffOrders);
        } else {
            $orders = $orders->concat($user->orders);
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response|View
    {
        $restaurants = Restaurant::active()->get();
        $restaurant = $restaurants->first();
        $menuItems = $restaurant->menuItems()->active()->get();
        return view('orders.create', compact('menuItems', 'restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostOrder $request): RedirectResponse
    {
        //validate the request
        //Get the data from the request
        //Store the data as a new record
        DB::beginTransaction();

        try {
            $productIds = $request->product_ids;
            $quantities = $request->product_quantities;
            $products = Menu::whereIn('id', $productIds)->get();
            $restaurant = Restaurant::find($request->restaurant_id);
            $userId = $request->user()->id;

            $orderData = [
                'user_id' => $userId,
                'restaurant_id' => $restaurant->id,
                'restaurant_owner_id' => $restaurant->user_id,
            ];
            $order = Order::create($orderData);
            $orderItems = [];
            $netTotal = 0;

            foreach ($quantities as $key => $quantity) {
                $productId = $productIds[$key];
                $product = $products->first(function ($value) use ($productId) {
                    return $value->id == $productId;
                });
                $subTotal = $quantity * $product->price;
                $netTotal += $subTotal;
                array_push($orderItems, [
                    //   'order_id' => $order->id,
                    'user_id' => $userId,
                    'menu_id' => $product->id,
                    'restaurant_id' => $product->restaurant_id,
                    'restaurant_owner_id' => $product->restaurant_owner_id,
                    'quantity' => $quantity,
                    'total' => $subTotal,
                ]);
            }
            $order->orderItems()->createMany($orderItems);
            $order->update([
                'sub_total' => $netTotal,
                'net_total' => $netTotal,
            ]);

            DB::commit();
            return redirect(route('orders.index'))->with([
                'status' => 'Order Created Successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        //
    }
}
