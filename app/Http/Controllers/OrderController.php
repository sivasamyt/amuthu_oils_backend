<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Cart;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;
use Log;
class OrderController extends Controller
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function orders_list()
    {
        return response()->json([
            'data' => $this->orderRepository->getAllOrders()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            Log::info('entry');
            Log::info('next step');
            Log::info('itemsitemsitems-------'.json_encode($request->cartIds));
            Log::info('totaltotaltotal----------'.$request->amount);
            Log::info('user_iduser_iduser_id------'.$request->userId);
            $order = Order::create([
                'user_id' => $request->userId,
                'cart_ids' => json_encode($request->cartIds),
                'order_status' => 'pending',
                'amount' => $request->amount,
            ]);
            Log::info('orderorderorder' . json_encode($order));
            if ($order) {
                $cartIds = json_decode($order->cart_ids, true);
                Cart::whereIn('id', $cartIds)->update(['order_status' => 'success']);
                return response()->json([
                    'message' => 'Order placed successfully',
                    'success' => true
                ], 200);
            }
        } catch (\Throwable $th) {
            Log::info('error-----'.$th);
            return response()->json([
                'message' => 'order not created'
            ], 404);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
