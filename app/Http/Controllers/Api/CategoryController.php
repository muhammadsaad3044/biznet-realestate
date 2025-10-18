<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index(Request $request){
        try {
            
            $categories = Category::with('sub_categories')->get();  
            
            if($categories->isNotEmpty()){
                
                $categories->transform(function ($category) {
                    $category->slug = '/api/categories/' . Str::slug($category->cat_title) .'/'. $category->id;
                    return $category;
                });
                
                return response()->json([
                    'status'=>200,
                    'categories'=>$categories,
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
                'cat_title' => 'required|string|unique:categories',
            ]);
            
            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
    

            $category = new Category();
            $category->cat_title = $request->cat_title;
            $category->save();
            
            
            if($category){
            return response()->json([
                'status' => 200,
            ], 200);  
            }else{
            return response()->json([
                'status' => 400,
            ], 200);  
            }


        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }


    public function update(Request $request, $id){
        try {


            $category =  Category::find($id);
            
            if(!$category){
                return response()->json([
                    'status'=>404,
                    'message'=>'Record Not Found!',
                ], 404);  
            }else{
             
            $category->cat_title = $request->cat_title;
           
            $category->save();
    
            if($category){
                return response()->json([
                    'status' => 200,
                ], 200);
            }
            }
            

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }



    public function destory(Request $request, $id){
        try {
            
            $category =  Category::with('sub_categories')->find($id);
       
        
            if($category){
            $category->sub_categories();
            $category->delete();
            
            
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
                'error' => $th,
                'status' => 400,
            ], 400);
        }
    }
}
