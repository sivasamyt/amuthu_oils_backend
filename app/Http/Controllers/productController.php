<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Log;

class productController extends Controller
{
    public function createProduct(Request $request)
    {
        try {
            // Log::info('entry');
            // Log::info(json_encode($request));
            Product::create([
                'name' => $request->productName,
                'description' => $request->Description,
                'quantity' => $request->Quantity,
                'image_name' => $request->imageName,
                'image' => $request->image
            ]);
            // Log::info('entry2');
            return response()->json(['message' => 'Image uploaded successfully']);


        } catch (\Throwable $th) {
            // Log::info('error'.$th);
            return response()->json(['message' => 'No image uploaded'], 400);
        }

    }
    public function view($product_id = ''){
        // $products = Product::query();
        // Log::info('product_id----'.$product_id);
        if (!empty($product_id)) {
        // Log::info('if entry----'.$product_id);

            $products = Product::find($product_id);
        }else{
        // Log::info('elase entry----'.$product_id);
            $products=Product::all();
        }
        return $products;
    }
}
