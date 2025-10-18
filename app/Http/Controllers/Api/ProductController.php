<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{product, User};
use App\Jobs\SendCommunityEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use DB;



class ProductController extends Controller
{
    public function index(Request $request){
        try {
            
            $product = product::with('images', 'categories.sub_categories' , 'overview_sales', 'overview_home_tags', 'overview_home_icons', 'overview_comments'
            )->get();   

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
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    
    // Get Products By Category Id
     public function getindexbycategory($id){
        try {
            
            $product = product::with(['images', 'categories.sub_categories' , 'overview_sales', 'overview_home_tags', 'overview_home_icons', 'overview_comments'
            ])
            ->when($id, function($query) use ($id){
                $query->whereHas('categories', function($query) use ($id){
                    $query->where('id' , $id);
                });
            })
            ->get();   

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
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    
    // approveproduct
    public function approveproduct(Request $request){
            try {
            
            $product = product::where('id', $request->id)->first();   

            if($product){
                $product->is_approved = $request->is_approved;
                $product->save();
                return response()->json([
                    'status'=>200,
                    'message' => 'Updated Successfully',
                ], 200);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    
    // Filter By Home City
    public function home(Request $request, $id){
        try {
            
            $product = product::with('images', 'categories.sub_categories' , 'overview_sales', 'overview_home_tags', 'overview_home_icons', 'overview_comments'
            )->where('fliter_home_id', $id)->get();   

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
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    
    // Filter By Apartment City
    public function apartment(Request $request, $id){
        try {
            
            $product = product::with('images', 'categories.sub_categories' , 'overview_sales', 'overview_home_tags', 'overview_home_icons', 'overview_comments'
            )->where('fliter_apartment_id', $id)->get();   

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
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    
    // Filter By Rent City
    public function rent(Request $request, $id){
        try {
            
            $product = product::with('images', 'categories.sub_categories' , 'overview_sales', 'overview_home_tags', 'overview_home_icons', 'overview_comments'
            )->where('fliter_rent_id', $id)->get();   

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
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    
    
    public function getproducts(Request $request, $id){
        try {
            
            $product = product::with('images', 'categories.sub_categories' , 'overview_sales', 'overview_home_tags', 'overview_home_icons', 'overview_comments')->where('id', $id)->latest('id')->first();   

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
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    
    
    
    public function getallproducts(Request $request, $value){
        try {
            
            $product = product::with('images', 'categories.sub_categories' , 'overview_sales', 'overview_home_tags', 'overview_home_icons', 'overview_comments')
                       ->where('title', 'Like', '%'.$value.'%')
                       ->orWhere('price', 'Like', '%'.$value.'%')
                       ->orWhere('location', 'Like', '%'.$value.'%')
                       ->whereHas('categories', function($query) use($value){
                        $query->where('cat_title', 'Like', '%'.$value.'%'); 
                        });
                       
            $product =  $product->whereHas('categories.sub_categories', function($query) use($value){
                        $query->where('sub_title', 'Like', '%'.$value.'%'); 
                        })
                        ->get();

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
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    
    
    public function  getproductsbylocation($lang, $lat){
        try {
            
            $longitude = $lang;
            $latitude = $lat;
            $radius = 30; // fixed radius of 30 km

            // Use Haversine formula to find products within the 30 km radius
            $nearbyProductIds = DB::table('products')
                ->select('id', DB::raw("
                    ( 6371 * acos( cos( radians($latitude) ) *
                    cos( radians(latitude) ) *
                    cos( radians(longitude) - radians($longitude) ) +
                    sin( radians($latitude) ) *
                    sin( radians(latitude) ) ) ) AS distance
                "))
                ->having('distance', '<', $radius)
                ->orderBy('distance', 'asc')
                ->pluck('id'); // Get only the product IDs
                
            
        
            $products = Product::with('images', 'categories.sub_categories', 'overview_sales', 'overview_home_tags', 'overview_home_icons', 'overview_comments')
                        ->whereIn('id', $nearbyProductIds)
                        ->get(); 

            if($products){
                return response()->json([
                    'status'=>200,
                    'products'=>$products,
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
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }

    

    public function store(Request $request){
        try {
            
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'cat_id' => 'required|exists:categories,id',
                'filter_home_id' => 'exists:home_by_cities,id',
                'filter_apartment_id' => 'exists:appartment_by_cities,id',
                'filter_rent_id' => 'exists:rent_by_cities,id',
                'desc' => 'required|string',
                'location' => 'required',
                'price' => 'required',
                'map_url' => 'required|string',
                'status' => 'required|string',
                 'user_id' => 'nullable|exists:users,id',

            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
    
            $product = new product();
            $product->cat_id = $request->cat_id;
            $product->agent_id = $request->agent_id;
            $product->fliter_home_id = $request->filter_home_id;
            $product->fliter_apartment_id = $request->filter_apartment_id;
            $product->fliter_rent_id = $request->filter_rent_id;
            $product->title = $request->title;
            $product->desc = $request->desc;
            $product->location = $request->location;
            $product->longitude = $request->longitude;
            $product->latitude = $request->latitude;
            $product->status = $request->status;
            $product->price = $request->price;
            $product->map_url = $request->map_url;
            $product->user_id = $request->user_id; 
            $product->save();
            
            
            if($product){
                 $users = User::all();   
                if($users){

                if ($users->isEmpty()) {
                    return response()->json(['message' => 'No community users found.'], 404);
                }
        
                foreach ($users as $user) {
                
                    SendCommunityEmail::dispatch($user);
                    
                }
        
                return response()->json(['message' => 'Emails are being sent in the background.'], 200);
            }
            return response()->json([
                'status' => 200,
                'message'=>'Product Added Successfully!',
            ], 200);  
            }else{
            return response()->json([
                'status' => 400,
                'message'=>'Something Went Wrong!',
            ], 200);  
            }


        } catch (\Throwable $th) {

            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function update(Request $request, $id){
        try {
           
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'cat_id' => 'required|exists:categories,id',
                'filter_home_id' => 'exists:home_by_cities,id',
                'filter_apartment_id' => 'exists:appartment_by_cities,id',
                'filter_rent_id' => 'exists:rent_by_cities,id',
                'desc' => 'required|string',
                'location' => 'required',
                'price' => 'required',
                'map_url' => 'required',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $product =  product::find($id);

            if(!$product){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{

                $product->title = $request->title;
                $product->desc = $request->desc;
                $product->cat_id = $request->cat_id;
                $product->agent_id = $request->agent_id;
                $product->fliter_home_id = $request->filter_home_id;
                $product->fliter_apartment_id = $request->filter_apartment_id;
                $product->fliter_rent_id = $request->filter_rent_id;
                $product->location = $request->location;
                $product->longitude = $request->longitude;
                $product->latitude = $request->latitude;
                $product->price = $request->price;
                $product->map_url = $request->map_url;
                $product->status = $request->status;
                $product->is_approved = $request->is_approved;
                $product->save();

                return response()->json([
                    'status' => 200,
                    'message'=>'Product Upodate Successfully!',
                ], 200);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }


    public function destory(Request $request, $id){
        
        try {
            $product =  product::find($id);
       
        
            if($product){
                                
            $product->delete();

            return response()->json([
                'status' => 200,
            ], 200);
            
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    
    
    public function changestatus(Request $request){
        try {

            $validator = Validator::make($request->all(),  [
                'p_id' => 'required|exists:products,id',
                'status' => 'required|string',
            ]);


            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

        

            $product =  product::find($request->p_id);
       
        
            if($product){
                                
            $product->status = $request->status;
            $product->save();

            return response()->json([
                'status' => 200,
            ], 200);
            
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getmessage(),
                'status' => 400,
            ], 400);
        }
    }
    

}
