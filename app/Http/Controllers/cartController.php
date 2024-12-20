<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Log;

class cartController extends Controller
{
    public function addCart(Request $request)
    {
        try {
            // Log::info('entry');
            // Log::info($request);
            $cart = Cart::create([
                'user_id' => $request->userId,
                'product_id' => $request->productId,
                'quantity' => $request->quantity,
                'order_status' =>$request->status??'pending' ,
            ]);            
            return response()->json([
                'message' => 'Item added in Card successfully',
                'success' => true
            ], 200);
        } catch (\Throwable $th) {
            // Log::info('error-----'.$th);
            return response()->json([
                'message' => 'Item not added'
            ], 404);
        }
    }
    public function getCart($user_id){
        try{
            $total = 0;
            $status = 'pending';
            $cart_items = Cart::with(['user', 'product'])
            ->where('user_id', $user_id)
            ->where('order_status',$status)
            ->get();
            // Log::info($cart_items);
            if ($cart_items->isEmpty()) {
                return response()->json([
                    'message' => 'No items found in cart',
                    'cart_items' => [],
                    'cart_value' => $total
                ], 404);
            }
            $cart_items_with_price = $cart_items->map(function ($cart_item) use(&$total) {
                $cart_price =  $cart_item->quantity * $cart_item->product->price;
                $cart_item->product->cart_price = $cart_price;
                $total += $cart_price;
                return $cart_item;
            });
            // Log::info('cart_items_with_price--------'.$cart_items_with_price);
            return response()->json([
                'message' => 'items get successful',
                'cart_items' => $cart_items_with_price,
                'cart_value' => $total
            ], 200);
        }catch(\Throwable $th){
            // Log::info('errorr-----------'.$th);
            return response()->json([
                'message' => 'Item not found'
            ], 404);
        }
    }

    public function remove_item($item_id){
        try{
            $cart_item = Cart::find($item_id);
            if (!$cart_item) {
                return response()->json([
                    'message' => 'Item not found',
                    'success' => false
                ], 404);
            }
            $cart_item->delete();
            return response()->json([
                'message' => 'item removed successful',
                'success' => true
            ], 200);
        }catch(\Throwable $th){
            // Log::info('errorr-----------'.$th);
            return response()->json([
                'message' => 'Item not found'
            ], 404);
        }
    }
}
