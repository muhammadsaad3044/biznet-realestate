<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{product};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ProductFiltersController extends Controller
{
     
    public function getrecentindex(Request $request){
        try {
            
            $product = product::with('images')->latest('id')->take(6)->get();   

            if($product){
                return response()->json([
                    'status'=>200,
                    'products'=>$product,
                    'imagePath'=>url('/uploads/products/'),
                ], 200);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }

    public function getsoldindex(Request $request){

        try {
            
            $product = product::with('images')->where('status', 'sold')->get();   

            if($product){
                return response()->json([
                    'status'=>200,
                    'products'=>$product,
                    'imagePath'=>url('/uploads/products/'),
                ], 200);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }

    }


    public function getsalesindex(Request $request){

        try {
            
            $product = product::with('images')->where('status', 'sale')->get();   

            if($product){
                return response()->json([
                    'status'=>200,
                    'products'=>$product,
                    'imagePath'=>url('/uploads/products/'),
                ], 200);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }

    }
    
    
    public function getsearchindex(Request $request, $search)
{
    try {
        // Fetch products with optional search filters
        $products = Product::with('images')
            ->when(!empty($search), function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('desc', 'LIKE', '%' . $search . '%')
                    ->orWhere('location', 'LIKE', '%' . $search . '%')
                    ->orWhere('price', 'LIKE', '%' . $search . '%')
                    ->orWhere('map_url', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%');
            })
            ->get();

        // Check if results are empty
        if ($products->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No products found matching your search.',
            ], 404);
        }

        // Return the search results
        return response()->json([
            'status' => 200,
            'products' => $products,
            'imagePath' => url('/uploads/products/'),
        ], 200);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => 400,
            'error' => $th->getMessage(),
        ], 400);
    }
}

    
}
